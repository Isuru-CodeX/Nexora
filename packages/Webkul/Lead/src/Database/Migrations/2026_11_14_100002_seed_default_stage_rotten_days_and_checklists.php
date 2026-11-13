<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $now = Carbon::now();

        // 1. Set realistic rotting days on default stages
        DB::table('lead_pipeline_stages')->where('code', 'new')->update(['rotten_days' => 3]);
        DB::table('lead_pipeline_stages')->where('code', 'follow-up')->update(['rotten_days' => 5]);
        DB::table('lead_pipeline_stages')->where('code', 'prospect')->update(['rotten_days' => 7]);
        DB::table('lead_pipeline_stages')->where('code', 'negotiation')->update(['rotten_days' => 14]);

        // 2. Fetch stage IDs
        $stages = DB::table('lead_pipeline_stages')
            ->whereIn('code', ['new', 'follow-up', 'prospect', 'negotiation'])
            ->pluck('id', 'code');

        $checklists = [];

        if (isset($stages['new'])) {
            $checklists[] = [
                'lead_pipeline_stage_id' => $stages['new'],
                'name' => 'Verify Contact Email & Phone Number',
                'description' => 'Ensure direct contact details are valid and reachable.',
                'is_required' => true,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $checklists[] = [
                'lead_pipeline_stage_id' => $stages['new'],
                'name' => 'Research Account Background & Company Size',
                'description' => 'Check company website, employee headcount, and tech stack.',
                'is_required' => false,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (isset($stages['follow-up'])) {
            $checklists[] = [
                'lead_pipeline_stage_id' => $stages['follow-up'],
                'name' => 'Introductory Discovery Call Completed',
                'description' => 'Initial qualification conversation held with the prospect.',
                'is_required' => true,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $checklists[] = [
                'lead_pipeline_stage_id' => $stages['follow-up'],
                'name' => 'Primary Pain Points & Requirements Logged',
                'description' => 'Record core business challenges in lead notes.',
                'is_required' => false,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (isset($stages['prospect'])) {
            $checklists[] = [
                'lead_pipeline_stage_id' => $stages['prospect'],
                'name' => 'BANT Qualification Confirmed (Budget & Timeline)',
                'description' => 'Validate budget allocation, authority, need, and estimated purchase date.',
                'is_required' => true,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $checklists[] = [
                'lead_pipeline_stage_id' => $stages['prospect'],
                'name' => 'Key Decision Makers & Influencers Identified',
                'description' => 'Add executive decision makers as linked contact persons.',
                'is_required' => true,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $checklists[] = [
                'lead_pipeline_stage_id' => $stages['prospect'],
                'name' => 'Product Solution Demo Presented',
                'description' => 'Live product walkthrough tailored to client use case.',
                'is_required' => false,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (isset($stages['negotiation'])) {
            $checklists[] = [
                'lead_pipeline_stage_id' => $stages['negotiation'],
                'name' => 'Official Proposal / Commercial Quote Dispatched',
                'description' => 'Dynamic PDF quote generated and delivered to decision makers.',
                'is_required' => true,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $checklists[] = [
                'lead_pipeline_stage_id' => $stages['negotiation'],
                'name' => 'Legal Terms & Security Review Approved',
                'description' => 'Mutual agreement on MSAs, privacy rules, and SLAs.',
                'is_required' => true,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $checklists[] = [
                'lead_pipeline_stage_id' => $stages['negotiation'],
                'name' => 'Final Commercial Pricing & Discounts Agreed',
                'description' => 'Close deal terms and obtain verbal approval.',
                'is_required' => false,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (! empty($checklists)) {
            DB::table('lead_stage_checklists')->insert($checklists);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('lead_stage_checklists')->truncate();
    }
};
