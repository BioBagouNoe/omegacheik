<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $verificationCode = rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_code' => $verificationCode,
        ]);

        // $user->assignRole('etudiant');

        event(new Registered($user));

        // Envoi de l'email avec le code
        try {
            Mail::raw("Votre code de vérification est : {$verificationCode}", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Vérification de votre adresse email - Université du Bénin');
            });
        } catch (\Exception $e) {
            // Log l'erreur mais continue le processus
            \Log::error('Erreur envoi email vérification: ' . $e->getMessage());
        }

        Auth::login($user);

        // Redirection vers la page de saisie du code
        return redirect()->route('verification.du.mail')
            ->with('success', 'Un code de vérification a été envoyé à votre adresse email.');
    }

    /**
     * Afficher le formulaire de vérification
     */
    public function showVerificationForm(): View
    {
        $user = Auth::user();
        
        // Si l'email est déjà vérifié, rediriger vers le dashboard approprié
        if ($user->hasVerifiedEmail()) {
            if ($user->hasRole('etudiant')) {
                return redirect()->route('dashboard-student');
            }
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email');
    }

    /**
     * Vérifier le code saisi
     */
    public function verifyCode(Request $request): RedirectResponse
{
    $request->validate([
        'verification_code' => 'required|digits:6',
    ], [
        'verification_code.required' => 'Le code de vérification est requis.',
        'verification_code.digits' => 'Le code doit contenir exactement 6 chiffres.',
    ]);

    $user = Auth::user();

    if ($user->verification_code === $request->verification_code) {
        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->save();

        // Déconnecter l'utilisateur pour le renvoyer vers le login
        Auth::logout();

        return redirect()->route('login')
            ->with('success', 'Email vérifié avec succès ! Vous pouvez maintenant vous connecter 🎉');
    }

    return back()->withErrors([
        'verification_code' => 'Code invalide. Veuillez réessayer.'
    ]);
}


    /**
     * Renvoyer le code de vérification
     */
    public function resendCode(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Vérifier si l'email est déjà vérifié
        if ($user->hasVerifiedEmail()) {
            if ($user->hasRole('etudiant')) {
                return redirect()->route('dashboard-student');
            }
            return redirect()->route('dashboard');
        }

        // Générer un nouveau code
        $newCode = rand(100000, 999999);
        $user->verification_code = $newCode;
        $user->save();

        // Envoyer l'email
        try {
            Mail::raw("Votre nouveau code de vérification est : {$newCode}", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Nouveau code de vérification - Université du Bénin');
            });
            
            return back()->with('success', 'Un nouveau code de vérification a été envoyé.');
        } catch (\Exception $e) {
            \Log::error('Erreur renvoi email vérification: ' . $e->getMessage());
            
            return back()->withErrors([
                'email' => 'Erreur lors de l\'envoi de l\'email. Veuillez réessayer.'
            ]);
        }
    }
}