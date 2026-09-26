<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Show the authenticated user's profile overview.
     */
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Profile', [
            'twoFactorEnabled' => $request->user()->hasEnabledTwoFactorAuthentication(),
        ]);
    }
}
