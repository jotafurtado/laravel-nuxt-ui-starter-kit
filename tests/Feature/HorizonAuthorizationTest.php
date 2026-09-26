<?php

use App\Models\User;
use Illuminate\Support\Facades\Gate;

test('guest cannot view horizon', function (): void {
    $canView = Gate::check('viewHorizon');

    expect($canView)->toBeFalse();
});

test('authenticated user cannot view horizon without allowed email', function (): void {
    $user = User::factory()->create([
        'email' => 'user@example.com',
    ]);

    $canView = Gate::forUser($user)->check('viewHorizon');

    expect($canView)->toBeFalse();
});

test('authenticated user with allowed email can view horizon', function (): void {
    config(['horizon.allowed_emails' => ['admin@example.com']]);

    $user = User::factory()->create([
        'email' => 'Admin@Example.com',
    ]);

    $canView = Gate::forUser($user)->check('viewHorizon');

    expect($canView)->toBeTrue();
});
