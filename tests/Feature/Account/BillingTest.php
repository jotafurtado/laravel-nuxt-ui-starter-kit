<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function (): void {
    $response = $this->get('/billing');
    $response->assertRedirect('/login');
});

test('authenticated users can see the billing page', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/billing');
    $response->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('Billing')
            ->where('plan.name', 'Pro')
            ->hasAll(['payment_method.brand', 'payment_method.last4', 'payment_method.expires'])
            ->has('invoices', 8, fn (Assert $invoice): Assert => $invoice
                ->hasAll(['id', 'amount', 'currency', 'status', 'date'])
                ->missing('minutes_ago')
            )
        );
});
