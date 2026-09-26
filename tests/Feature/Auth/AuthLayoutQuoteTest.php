<?php

use Inertia\Testing\AssertableInertia as Assert;

test('the inspiring quote is only loaded on demand', function (): void {
    $response = $this->get('/login');

    $response->assertInertia(fn (Assert $page): Assert => $page
        ->missing('quote')
        ->reloadOnly('quote', fn (Assert $reload): Assert => $reload
            ->whereType('quote.message', 'string')
            ->whereType('quote.author', 'string')
            ->where('quote.author', fn (string $author): bool => $author !== '' && ! str_contains($author, ' - '))
        )
    );
});
