<?php

it('exports dashboard pdf with signature brand theme and logo', function () {
    $admin = getDefaultAdmin();

    $response = test()->actingAs($admin)
        ->get(route('admin.dashboard.export_pdf'))
        ->assertOk();

    expect($response->headers->get('content-type'))->toBe('application/pdf');
    expect($response->getContent())->toContain('%PDF-');
});
