<?php

use Webkul\User\Models\User;

it('renders the help and resources page with github profile links', function () {
    $user = User::first();

    $this->actingAs($user, 'user')
        ->get(route('admin.help.index'))
        ->assertOk()
        ->assertSee('https://github.com/Isuru-CodeX')
        ->assertSee('https://github.com/Isuru-CodeX/NoxusCRM')
        ->assertDontSee('https://krayincrm.com')
        ->assertDontSee('https://docs.krayincrm.com');
});
