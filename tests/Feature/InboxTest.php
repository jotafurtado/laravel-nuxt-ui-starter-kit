<?php

use App\Models\User;
use Illuminate\Support\Facades\Date;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function (): void {
    $response = $this->get('/inbox');
    $response->assertRedirect('/login');
});

test('authenticated users can see the inbox with dates relative to now', function (): void {
    Date::setTestNow('2026-01-15 12:00:00');

    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/inbox');
    $response->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('Inbox')
            ->has('mails', 20, fn (Assert $mail): Assert => $mail
                ->where('id', 1)
                ->hasAll(['from.name', 'from.email', 'subject', 'body'])
                ->where('date', Date::now()->subMinutes(9)->toIso8601String())
                ->missing('minutes_ago')
                ->etc()
            )
        );
});
