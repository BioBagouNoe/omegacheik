<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
  public function create(): View|RedirectResponse
    {
        // Supprime l'ancienne destination "intended"
        session()->forget('url.intended');

        // Redirection si déjà connecté
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }


    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
{
    // Laravel authentifie l'utilisateur via le LoginRequest
    $request->authenticate();

    // Régénère la session (sécurité)
    $request->session()->regenerate();

    // Redirection unique pour tout le monde
    return redirect()->intended(route('dashboard'));
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
