<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Inertia\Response;

use function resource_path;

class CustomerController extends Controller
{
    /**
     * Show the customers page with local demo data.
     */
    public function __invoke(): Response
    {
        return Inertia::render('Customers', [
            'customers' => File::json(resource_path('data/customers.json')),
        ]);
    }
}
