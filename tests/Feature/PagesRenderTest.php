<?php

use Webkul\Contact\Models\Organization;
use Webkul\Contact\Models\Person;
use Webkul\Lead\Models\Lead;
use Webkul\Product\Models\Product;
use Webkul\Quote\Models\Quote;

it('renders key edit pages with status 200', function () {
    $admin = getDefaultAdmin();

    $lead = Lead::first();
    $person = Person::first();
    $organization = Organization::first();
    $product = Product::first();
    $quote = Quote::first();

    if ($lead) {
        test()->actingAs($admin)
            ->get(route('admin.leads.edit', $lead->id))
            ->assertOk();
    }

    if ($person) {
        test()->actingAs($admin)
            ->get(route('admin.contacts.persons.edit', $person->id))
            ->assertOk();
    }

    if ($organization) {
        test()->actingAs($admin)
            ->get(route('admin.contacts.organizations.edit', $organization->id))
            ->assertOk();
    }

    if ($product) {
        test()->actingAs($admin)
            ->get(route('admin.products.edit', $product->id))
            ->assertOk();
    }

    if ($quote) {
        test()->actingAs($admin)
            ->get(route('admin.quotes.edit', $quote->id))
            ->assertOk();
    }
});

it('renders key view pages with status 200', function () {
    $admin = getDefaultAdmin();

    $lead = Lead::first();
    $person = Person::first();
    $product = Product::first();

    if ($lead) {
        test()->actingAs($admin)
            ->get(route('admin.leads.view', $lead->id))
            ->assertOk();
    }

    if ($person) {
        test()->actingAs($admin)
            ->get(route('admin.contacts.persons.view', $person->id))
            ->assertOk();
    }

    if ($product) {
        test()->actingAs($admin)
            ->get(route('admin.products.view', $product->id))
            ->assertOk();
    }
});
