<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\DemoData;
use Inertia\Inertia;
use Inertia\Response;

class InboxController extends Controller
{
    /**
     * Show the inbox page with local demo data.
     */
    public function __invoke(): Response
    {
        return Inertia::render('Inbox', [
            'mails' => DemoData::mails(),
        ]);
    }
}
