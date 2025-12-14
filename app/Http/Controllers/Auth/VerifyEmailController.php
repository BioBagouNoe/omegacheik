<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    // public function __invoke(EmailVerificationRequest $request): RedirectResponse
    // {
    //     if ($request->user()->hasVerifiedEmail()) {
    //         return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    //     }

    //     if ($request->user()->markEmailAsVerified()) {
    //         event(new Verified($request->user()));
    //     }

    //     return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    // }

        public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Si l'email est déjà vérifié, redirection vers login
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('login')->with('verified', 1);
        }

        // Marquer l'email comme vérifié
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Après vérification, redirection vers login
        return redirect()->route('login')->with('verified', 1);
    }

}
