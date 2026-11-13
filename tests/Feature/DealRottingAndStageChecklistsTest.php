<?php

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Webkul\Contact\Models\Person;
use Webkul\Lead\Models\Lead;
use Webkul\Lead\Models\Pipeline;
use Webkul\Lead\Models\Source;
use Webkul\Lead\Models\Stage;
use Webkul\Lead\Models\StageChecklist;
use Webkul\Lead\Models\Type;

uses(DatabaseTransactions::class);

function createTestLead(Stage $stage, ?Carbon $stageUpdatedAt = null): Lead
{
    $admin = getDefaultAdmin();

    $person = Person::query()->firstOrCreate(
        ['emails' => [['value' => 'john.doe@example.com', 'label' => 'work']]],
        ['name' => 'John Doe', 'user_id' => $admin->id]
    );

    $type = Type::query()->firstOrCreate(['name' => 'Existing Business']);
    $source = Source::query()->firstOrCreate(['name' => 'Website']);

    return Lead::create([
        'title' => 'Test Enterprise CRM Deal',
        'lead_value' => 25000,
        'user_id' => $admin->id,
        'person_id' => $person->id,
        'lead_type_id' => $type->id,
        'lead_source_id' => $source->id,
        'lead_pipeline_id' => $stage->lead_pipeline_id,
        'lead_pipeline_stage_id' => $stage->id,
        'stage_updated_at' => $stageUpdatedAt ?? Carbon::now(),
    ]);
}

it('calculates stage-specific deal rotting days accurately based on stage duration', function () {
    $pipeline = Pipeline::query()->first() ?? Pipeline::create(['name' => 'Default Pipeline', 'rotten_days' => 30]);

    $stage = Stage::create([
        'code' => 'custom-stage-'.uniqid(),
        'name' => 'Custom Discovery',
        'probability' => 40,
        'sort_order' => 99,
        'rotten_days' => 4, // Rots in 4 days
        'lead_pipeline_id' => $pipeline->id,
    ]);

    // 1. Fresh lead created today -> not rotten (0 days)
    $freshLead = createTestLead($stage, Carbon::now());
    expect($freshLead->rotten_days)->toBe(0);
    expect($freshLead->is_rotten)->toBeFalse();
    expect($freshLead->days_in_stage)->toBe(0);

    // 2. Lead sitting in stage for 6 days -> rotten for (6 - 4 + 1) = 3 days
    $rottenLead = createTestLead($stage, Carbon::now()->subDays(6));
    expect($rottenLead->days_in_stage)->toBe(6);
    expect($rottenLead->rotten_days)->toBe(3);
    expect($rottenLead->is_rotten)->toBeTrue();

    // 3. Lead in 'won' stage -> never rots regardless of days elapsed
    $wonStage = Stage::query()->where('code', 'won')->first();
    if ($wonStage) {
        $wonLead = createTestLead($wonStage, Carbon::now()->subDays(50));
        expect($wonLead->rotten_days)->toBe(0);
        expect($wonLead->is_rotten)->toBeFalse();
    }
});

it('calculates checklist progress and enforces required gatekeeping before advancing stages', function () {
    $admin = getDefaultAdmin();

    $pipeline = Pipeline::query()->first();
    $stage = Stage::create([
        'code' => 'gate-test-'.uniqid(),
        'name' => 'Gate Test Stage',
        'probability' => 50,
        'sort_order' => 101,
        'lead_pipeline_id' => $pipeline->id,
    ]);

    $nextStage = Stage::create([
        'code' => 'gate-next-'.uniqid(),
        'name' => 'Gate Next Stage',
        'probability' => 75,
        'sort_order' => 102,
        'lead_pipeline_id' => $pipeline->id,
    ]);

    // Add a mandatory checklist item and an optional checklist item
    $requiredItem = StageChecklist::create([
        'lead_pipeline_stage_id' => $stage->id,
        'name' => 'Mandatory Security Review',
        'is_required' => true,
        'sort_order' => 1,
    ]);

    $optionalItem = StageChecklist::create([
        'lead_pipeline_stage_id' => $stage->id,
        'name' => 'Optional Demo Notes',
        'is_required' => false,
        'sort_order' => 2,
    ]);

    $lead = createTestLead($stage);

    // Initial state: 0/2 completed, required pending, cannot advance
    $summary = $lead->checklists_summary;
    expect($summary['total'])->toBe(2);
    expect($summary['completed'])->toBe(0);
    expect($summary['required_total'])->toBe(1);
    expect($summary['required_completed'])->toBe(0);
    expect($summary['can_advance'])->toBeFalse();
    expect($lead->hasPendingRequiredChecklists())->toBeTrue();

    // Attempting to move stage via API with enforce_checklists without completing required checklist -> blocked (422)
    test()->actingAs($admin)
        ->putJson(route('admin.leads.stage.update', $lead->id), [
            'lead_pipeline_stage_id' => $nextStage->id,
            'enforce_checklists' => true,
        ])
        ->assertStatus(422)
        ->assertJson([
            'error' => 'stage_checklists_required',
        ]);

    // Complete the required checklist item via toggle endpoint
    test()->actingAs($admin)
        ->postJson(route('admin.leads.checklists.toggle', ['id' => $lead->id, 'checklist_id' => $requiredItem->id]))
        ->assertOk()
        ->assertJsonPath('completion.is_completed', true);

    // Refresh lead and verify can advance
    $lead->refresh();
    expect($lead->checklists_summary['required_completed'])->toBe(1);
    expect($lead->checklists_summary['can_advance'])->toBeTrue();
    expect($lead->hasPendingRequiredChecklists())->toBeFalse();

    // Now moving to the next stage succeeds (200)
    test()->actingAs($admin)
        ->putJson(route('admin.leads.stage.update', $lead->id), [
            'lead_pipeline_stage_id' => $nextStage->id,
        ])
        ->assertOk();

    $lead->refresh();
    expect($lead->lead_pipeline_stage_id)->toBe($nextStage->id);
});

it('can fetch checklists for a lead via API', function () {
    $admin = getDefaultAdmin();
    $pipeline = Pipeline::query()->first();

    $stage = Stage::create([
        'code' => 'fetch-test-'.uniqid(),
        'name' => 'Fetch Test Stage',
        'probability' => 60,
        'sort_order' => 105,
        'lead_pipeline_id' => $pipeline->id,
    ]);

    $checklist = StageChecklist::create([
        'lead_pipeline_stage_id' => $stage->id,
        'name' => 'Discovery Call Completed',
        'is_required' => true,
        'sort_order' => 1,
    ]);

    $lead = createTestLead($stage);

    test()->actingAs($admin)
        ->getJson(route('admin.leads.checklists.get', $lead->id))
        ->assertOk()
        ->assertJsonStructure([
            'stage_id',
            'stage_name',
            'checklists' => [
                '*' => ['id', 'name', 'is_required', 'is_completed'],
            ],
            'checklists_summary',
        ])
        ->assertJsonPath('checklists.0.name', 'Discovery Call Completed')
        ->assertJsonPath('checklists.0.is_completed', false);
});
