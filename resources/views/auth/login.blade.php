<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion & Inscription - Gestion des Actes Académiques</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 10px;
            perspective: 1500px;
            overflow: hidden;
        }

        .auth-container {
            max-width: 360px;
            width: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            height: auto;
            min-height: 500px;
        }

        .auth-container.flip {
            transform: rotateY(180deg);
        }

        .auth-card {
            background: white;
            padding: 0;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #f3f4f6;
            text-align: center;
            position: absolute;
            width: 100%;
            backface-visibility: hidden;
            height: auto;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .auth-card-content {
            overflow-y: auto;
            overflow-x: hidden;
            padding: 20px 25px;
            scrollbar-width: thin;
            scrollbar-color: #d1d5db transparent;
        }

        .auth-card-content::-webkit-scrollbar {
            width: 5px;
        }

        .auth-card-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .auth-card-content::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        .auth-card-content::-webkit-scrollbar-thumb:hover {
            background: #0c054eff;
        }

        .login-card {
            transform: rotateY(0deg);
        }

        .register-card {
            transform: rotateY(180deg);
        }

        .auth-header {
            margin-bottom: 12px;
        }

        .auth-header .logo {
            margin-bottom: 6px;
            position: relative;
            display: inline-block;
        }

        .auth-header .logo-text {
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(135deg, #190464ff 0%, #2c0596ff 50%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 2px;
            text-transform: uppercase;
            filter: drop-shadow(0 2px 8px rgba(16, 185, 129, 0.3));
            transition: all 0.3s ease;
            position: relative;
        }

        .auth-header .logo-text::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #190464ff, #10b981);
            transition: width 0.3s ease;
            border-radius: 2px;
        }

        .auth-header .logo:hover .logo-text {
            transform: scale(1.05);
            filter: drop-shadow(0 4px 12px rgba(16, 185, 129, 0.5));
        }

        .auth-header .logo:hover .logo-text::after {
            width: 100%;
        }

        .auth-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-top: 3px;
            letter-spacing: -0.5px;
        }

        .auth-header p {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 3px;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
            text-align: left;
            position: relative;
        }

        .form-group label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #0c054eff;
            margin-left: 4px;
        }

        .form-group input {
            padding: 8px 11px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.8rem;
            color: #0c054eff;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .form-group input:hover {
            background: #ffffff;
            border-color: #d1d5db;
        }

        .form-group input:focus {
            outline: none;
            border-color: #0c054eff;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            transform: translateY(-1px);
        }

        .form-group input.error {
            border-color: #ef4444;
            background: #fef2f2;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            display: none;
            margin-top: 4px;
            margin-left: 4px;
            font-weight: 500;
        }

        .error-message.show {
            display: block;
        }

        .session-error {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 6px 8px;
            border-radius: 6px;
            margin-bottom: 8px;
            font-size: 0.72rem;
            text-align: center;
            line-height: 1.3;
        }

        .session-success {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
            padding: 6px 8px;
            border-radius: 6px;
            margin-bottom: 8px;
            font-size: 0.72rem;
            text-align: center;
            line-height: 1.3;
        }

        .auth-btn {
            background: linear-gradient(135deg, #190464ff 0%, #2c0596ff 100%);
            color: white;
            padding: 9px 14px;
            border: none;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
            margin-top: 3px;
        }

        .auth-btn:hover:not(:disabled) {
            background: linear-gradient(135deg, #050f96ff 0%, #040253ff 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .auth-btn:active:not(:disabled) {
            transform: translateY(0px);
        }

        .auth-btn:disabled {
            background: #d1d5db;
            cursor: not-allowed;
            opacity: 0.7;
            box-shadow: none;
        }

        .forgot-password {
            font-size: 0.72rem;
            color: #6b7280;
            text-decoration: none;
            margin-top: 5px;
            display: inline-block;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .forgot-password:hover {
            color: #10b981;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 10px 0 8px;
            color: #9ca3af;
            font-size: 0.72rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e5e7eb;
        }

        .divider span {
            padding: 0 10px;
            font-weight: 500;
        }

        .toggle-auth {
            font-size: 0.78rem;
            color: #190455ff;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s ease;
            font-weight: 600;
            padding: 3px 0;
        }

        .toggle-auth:hover {
            color: #110555ff;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            body {
                padding: 8px;
            }

            .auth-container {
                max-width: 100%;
            }

            .auth-card-content {
                padding: 16px 20px;
            }

            .auth-header h2 {
                font-size: 1.15rem;
            }

            .auth-header .logo-text {
                font-size: 1.8rem;
            }

            .form-group input {
                padding: 7px 10px;
                font-size: 0.78rem;
            }

            .auth-btn {
                padding: 8px 12px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 5px;
            }

            .auth-card-content {
                padding: 14px 18px;
            }
            
            .auth-header .logo-text {
                font-size: 1.7rem;
            }

            .auth-header h2 {
                font-size: 1.1rem;
            }

            .auth-header p {
                font-size: 0.7rem;
            }
        }

        @media (max-height: 700px) {
            .auth-header .logo-text {
                font-size: 1.65rem;
            }

            .auth-header h2 {
                font-size: 1.1rem;
            }

            .auth-header p {
                font-size: 0.7rem;
            }

            .auth-card-content {
                padding: 15px 22px;
            }

            .form-group {
                gap: 3px;
            }

            .auth-form {
                gap: 8px;
            }

            .divider {
                margin: 8px 0 6px;
            }
        }

        @media (max-height: 600px) {
            .auth-header {
                margin-bottom: 8px;
            }

            .auth-header .logo-text {
                font-size: 1.5rem;
            }

            .auth-header h2 {
                font-size: 1.05rem;
            }

            .auth-card-content {
                padding: 12px 18px;
            }

            .auth-form {
                gap: 7px;
            }

            .form-group input {
                padding: 6px 9px;
            }

            .auth-btn {
                padding: 7px 12px;
            }

            .divider {
                margin: 6px 0 5px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container" id="authContainer">
        <!-- Login Card -->
        <div class="auth-card login-card">
            <div class="auth-card-content">
                <div class="auth-header">
                    <div class="logo">
                        <div class="logo-text">OMEGA CHEIK</div>
                    </div>
                    <h2>Bienvenue !</h2>
                    <p>Connectez-vous à votre compte</p>
                </div>

                <!-- Session Error Message -->
                @if(session('error'))
                <div class="session-error">
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="session-success">
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any() && !old('name'))
                <div class="session-error">
                    {{ $errors->first() }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="auth-form" id="loginForm">
                    @csrf
                    <div class="form-group">
                        <label for="loginEmail">Adresse email</label>
                        <input type="email" id="loginEmail" name="email" placeholder="Entrez votre email" value="{{ old('email') }}" required>
                        <span class="error-message" id="loginEmailError">Veuillez entrer un email valide.</span>
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">Mot de passe</label>
                        <input type="password" id="loginPassword" name="password" placeholder="Entrez votre mot de passe" required>
                        <span class="error-message" id="loginPasswordError">Veuillez entrer un mot de passe.</span>
                    </div>
                    <button type="submit" class="auth-btn">
                        <i class="fas fa-sign-in-alt"></i>
                        Se connecter
                    </button>
                    <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                    <div class="divider">
                        <span>OU</span>
                    </div>
                    <a href="#" class="toggle-auth" onclick="flipCard(event)">Pas de compte ? Inscrivez-vous</a>
                </form>
            </div>
        </div>

        <!-- Register Card -->
        <div class="auth-card register-card">
            <div class="auth-card-content">
                <div class="auth-header">
                    <div class="logo">
                        <div class="logo-text">OMEGA CHEIK</div>
                    </div>
                    <h2>Créer un compte</h2>
                    <p>Rejoignez-nous dès maintenant</p>
                </div>

                <!-- Session Error Message for Register -->
                @if(session('register_error'))
                <div class="session-error">
                    {{ session('register_error') }}
                </div>
                @endif

                @if($errors->has('name'))
                <div class="session-error">
                    {{ $errors->first('name') }}
                </div>
                @endif

                @if($errors->has('email') && old('name'))
                <div class="session-error">
                    {{ $errors->first('email') }}
                </div>
                @endif

                @if($errors->has('password') && old('name'))
                <div class="session-error">
                    {{ $errors->first('password') }}
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="auth-form" id="registerForm" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="registerName">Nom complet</label>
                        <input type="text" id="registerName" name="name" placeholder="Entrez votre nom complet" value="{{ old('name') }}" required>
                        <span class="error-message" id="registerNameError">Veuillez entrer votre nom.</span>
                    </div>
                    <div class="form-group">
                        <label for="registerEmail">Email</label>
                        <input type="email" id="registerEmail" name="email" placeholder="Entrez votre email" value="{{ old('email') }}" required>
                        <span class="error-message" id="registerEmailError">Veuillez entrer un email valide.</span>
                    </div>
                    <div class="form-group">
                        <label for="registerPassword">Mot de passe</label>
                        <input type="password" id="registerPassword" name="password" placeholder="Choisissez un mot de passe" required>
                        <span class="error-message" id="registerPasswordError">Veuillez entrer un mot de passe.</span>
                    </div>
                    <div class="form-group">
                        <label for="registerConfirmPassword">Confirmer le mot de passe</label>
                        <input type="password" id="registerConfirmPassword" name="password_confirmation" placeholder="Confirmez votre mot de passe" required>
                        <span class="error-message" id="registerConfirmPasswordError">Les mots de passe ne correspondent pas.</span>
                    </div>
                    <button type="submit" class="auth-btn">
                        <i class="fas fa-user-plus"></i>
                        S'inscrire
                    </button>
                    <div class="divider">
                        <span>OU</span>
                    </div>
                    <a href="#" class="toggle-auth" onclick="flipCard(event)">Déjà un compte ? Connectez-vous</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function flipCard(event) {
            if (event) event.preventDefault();
            const container = document.getElementById('authContainer');
            container.classList.toggle('flip');
        }

        // Client-side validation for Login
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('loginEmail');
            const password = document.getElementById('loginPassword');
            const emailError = document.getElementById('loginEmailError');
            const passwordError = document.getElementById('loginPasswordError');

            email.classList.remove('error');
            password.classList.remove('error');
            emailError.classList.remove('show');
            passwordError.classList.remove('show');

            let hasError = false;

            // Validate email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim() || !emailRegex.test(email.value)) {
                email.classList.add('error');
                emailError.classList.add('show');
                hasError = true;
            }

            // Validate password
            if (!password.value.trim()) {
                password.classList.add('error');
                passwordError.classList.add('show');
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
            }
        });

        // Client-side validation for Register - MODIFIÉ POUR PERMETTRE L'ENVOI
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const name = document.getElementById('registerName');
            const email = document.getElementById('registerEmail');
            const password = document.getElementById('registerPassword');
            const confirmPassword = document.getElementById('registerConfirmPassword');
            const nameError = document.getElementById('registerNameError');
            const emailError = document.getElementById('registerEmailError');
            const passwordError = document.getElementById('registerPasswordError');
            const confirmPasswordError = document.getElementById('registerConfirmPasswordError');

            // Reset errors
            name.classList.remove('error');
            email.classList.remove('error');
            password.classList.remove('error');
            confirmPassword.classList.remove('error');
            nameError.classList.remove('show');
            emailError.classList.remove('show');
            passwordError.classList.remove('show');
            confirmPasswordError.classList.remove('show');

            let hasError = false;

            // Validate name (basique seulement)
            if (!name.value.trim()) {
                name.classList.add('error');
                nameError.classList.add('show');
                hasError = true;
            }

            // Validate email (basique seulement)
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim() || !emailRegex.test(email.value)) {
                email.classList.add('error');
                emailError.classList.add('show');
                hasError = true;
            }

            // Validate password (basique - juste vérifier qu'il n'est pas vide)
            if (!password.value.trim()) {
                password.classList.add('error');
                passwordError.textContent = 'Veuillez entrer un mot de passe.';
                passwordError.classList.add('show');
                hasError = true;
            }

            // Validate password confirmation
            if (password.value !== confirmPassword.value) {
                confirmPassword.classList.add('error');
                confirmPasswordError.classList.add('show');
                hasError = true;
            }

            // Seulement empêcher l'envoi si erreurs BASIQUES
            if (hasError) {
                e.preventDefault();
            }
            // Sinon, laisser Laravel gérer la validation complète (min 8 caractères, etc.)
        });

        // Auto-show register form if there are register errors
        @if(session('register_error') || old('name'))
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('authContainer').classList.add('flip');
            });
        @endif

        // Remove error styling on input
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('error');
                const errorMsg = this.parentElement.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>