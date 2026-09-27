<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function (): void {
    $response = $this->get('/profile');
    $response->assertRedirect('/login');
});

test('authenticated users can see their profile', function (): void {
    $user = User::factory()->withoutTwoFactor()->create();
    $this->actingAs($user);

    $response = $this->get('/profile');
    $response->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('Profile')
            ->where('twoFactorEnabled', false)
            ->where('auth.user.email', $user->email)
        );
});

test('profile shows when two-factor authentication is enabled', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/profile');
    $response->assertInertia(fn (Assert $page): Assert => $page
        ->component('Profile')
        ->where('twoFactorEnabled', true)
    );
});
