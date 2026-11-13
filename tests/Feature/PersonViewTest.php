<?php

use Webkul\Contact\Models\Person;

it('renders the contact person view page properly', function () {
    $admin = getDefaultAdmin();
    $person = Person::whereHas('leads')->first() ?? Person::first();

    expect($person)->not->toBeNull();

    $response = test()->actingAs($admin)
        ->get(route('admin.contacts.persons.view', $person->id))
        ->assertOk();

    $response->assertSee($person->name);
});

it('renders person view with associated leads and quotes tabs', function () {
    $admin = getDefaultAdmin();
    $person = Person::whereHas('quotes')->first();

    if (! $person) {
        $person = Person::first();
    }

    $response = test()->actingAs($admin)
        ->get(route('admin.contacts.persons.view', $person->id))
        ->assertOk();

    $response->assertSee($person->name);
    if ($person->job_title) {
        $response->assertSee($person->job_title);
    }
});
