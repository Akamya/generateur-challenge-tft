<?php

use App\Models\User;

test('profile information can be updated', function () {
    $this->actingAs($user = User::factory()->create());

    $this->put('/user/profile-information', [
        'username' => 'Test Name',
        'riot_username' => 'Test Riot Name',
        'email' => 'test@example.com',
    ]);

    expect($user->fresh())
        ->username->toEqual('Test Name')
        ->riot_username->toEqual('Test Riot Name')
        ->email->toEqual('test@example.com');
});
