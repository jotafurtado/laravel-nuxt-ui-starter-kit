<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Support\DemoData;
use Inertia\Inertia;
use Inertia\Response;

class BillingController extends Controller
{
    /**
     * Show the billing page with local demo data.
     */
    public function __invoke(): Response
    {
        return Inertia::render('Billing', DemoData::billing());
    }
}
