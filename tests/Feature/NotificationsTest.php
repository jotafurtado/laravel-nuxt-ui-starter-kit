<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('notifications are only loaded on demand', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertInertia(fn (Assert $page): Assert => $page
        ->missing('notifications')
        ->reloadOnly('notifications', fn (Assert $reload): Assert => $reload
            ->has('notifications', 27, fn (Assert $notification): Assert => $notification
                ->hasAll(['id', 'sender.name', 'sender.email', 'body', 'date'])
                ->missing('minutes_ago')
                ->etc()
            )
        )
    );
});
