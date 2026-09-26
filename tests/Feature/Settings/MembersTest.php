<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function (): void {
    $response = $this->get('/settings/members');
    $response->assertRedirect('/login');
});

test('authenticated users can see the members list', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/settings/members');
    $response->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('settings/Members')
            ->has('members', 11, fn (Assert $member): Assert => $member
                ->hasAll(['name', 'username', 'role'])
            )
        );
});
