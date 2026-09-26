<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Support\DemoData;
use Inertia\Inertia;
use Inertia\Response;

class MemberController extends Controller
{
    /**
     * Show the members settings page with local demo data.
     */
    public function __invoke(): Response
    {
        return Inertia::render('settings/Members', [
            'members' => DemoData::members(),
        ]);
    }
}
