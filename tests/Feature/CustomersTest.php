<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function (): void {
    $response = $this->get('/customers');
    $response->assertRedirect('/login');
});

test('authenticated users can see the customers list', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/customers');
    $response->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('Customers')
            ->has('customers', 20, fn (Assert $customer): Assert => $customer
                ->hasAll(['id', 'name', 'email', 'status', 'location'])
            )
        );
});
