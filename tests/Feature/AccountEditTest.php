<?php

use Webkul\User\Models\User;

it('renders the modern redesigned my account page with 200 OK', function () {
    $user = User::first();

    $this->actingAs($user, 'user')
        ->get(route('admin.user.account.edit'))
        ->assertOk()
        ->assertSee('v-account-settings')
        ->assertSee('name="name"', false)
        ->assertSee('name="email"', false)
        ->assertSee('name="current_password"', false)
        ->assertSee('name="password"', false)
        ->assertSee('name="password_confirmation"', false);
});
