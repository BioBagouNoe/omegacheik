@extends('layouts.auth')

@section('title', 'Connexion - OMEGACHEIK')

@section('content')
   <div class="auth-container">
        <!-- Formulaire de connexion -->
        <div class="auth-card" id="loginCard">
            <div class="form-header">
                <div class="logo">OMEGACHEIK</div>
                <h2>Connexion</h2>
                <p>Accédez à votre compte</p>
            </div>

            <form id="loginForm">
                <div class="form-group">
                    <div class="input-with-icon">
                        <input type="email" class="form-control" id="loginEmail" placeholder="Adresse email" required>
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-with-icon">
                        <input type="password" class="form-control" id="loginPassword" placeholder="Mot de passe" required>
                        <i class="fas fa-eye password-toggle input-icon" id="toggleLoginPassword"></i>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" id="rememberMe">
                        Se souvenir
                    </label>
                    <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i>
                    Se connecter
                </button>
            </form>

            <div class="social-auth">
                <button class="btn-social" id="googleLogin">
                    <i class="fab fa-google"></i>
                </button>
                <button class="btn-social" id="appleLogin">
                    <i class="fab fa-apple"></i>
                </button>
            </div>

            <div class="form-footer">
                <p>Pas de compte ? <span class="toggle-link" id="showRegister">S'inscrire</span></p>
            </div>
        </div>

        <!-- Formulaire d'inscription -->
        <div class="auth-card hidden" id="registerCard">
            <div class="form-header">
                <div class="logo">OMEGACHEIK</div>
                <h2>Inscription</h2>
                <p>Créez votre compte</p>
            </div>

            <form id="registerForm">
                <div class="form-group">
                    <div class="input-with-icon">
                        <input type="text" class="form-control" id="registerName" placeholder="Nom complet" required>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-with-icon">
                        <input type="email" class="form-control" id="registerEmail" placeholder="Adresse email" required>
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-with-icon">
                        <input type="password" class="form-control" id="registerPassword" placeholder="Mot de passe" required>
                        <i class="fas fa-eye password-toggle input-icon" id="toggleRegisterPassword"></i>
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar" id="passwordStrength"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-with-icon">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirmer le mot de passe" required>
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    S'inscrire
                </button>
            </form>

            <div class="social-auth">
                <button class="btn-social" id="googleRegister">
                    <i class="fab fa-google"></i>
                </button>
                <button class="btn-social" id="appleRegister">
                    <i class="fab fa-apple"></i>
                </button>
            </div>

            <div class="terms">
                En vous inscrivant, vous acceptez nos <a href="#">Conditions</a> et notre <a href="#">Politique de confidentialité</a>.
            </div>

            <div class="form-footer">
                <p>Déjà un compte ? <span class="toggle-link" id="showLogin">Se connecter</span></p>
            </div>
        </div>
    </div>

    <script>
        // Éléments DOM
        const loginCard = document.getElementById('loginCard');
        const registerCard = document.getElementById('registerCard');
        const showRegister = document.getElementById('showRegister');
        const showLogin = document.getElementById('showLogin');
        const toggleLoginPassword = document.getElementById('toggleLoginPassword');
        const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');
        const registerPassword = document.getElementById('registerPassword');
        const passwordStrength = document.getElementById('passwordStrength');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const googleLogin = document.getElementById('googleLogin');
        const appleLogin = document.getElementById('appleLogin');
        const googleRegister = document.getElementById('googleRegister');
        const appleRegister = document.getElementById('appleRegister');

        // Basculer entre les formulaires
        function showRegisterForm() {
            loginCard.classList.add('hidden');
            registerCard.classList.remove('hidden');
        }

        function showLoginForm() {
            registerCard.classList.add('hidden');
            loginCard.classList.remove('hidden');
        }

        // Événements pour les liens de basculement
        showRegister.addEventListener('click', showRegisterForm);
        showLogin.addEventListener('click', showLoginForm);

        // Basculer la visibilité du mot de passe
        function togglePasswordVisibility(inputId, icon) {
            const passwordInput = document.getElementById(inputId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        toggleLoginPassword.addEventListener('click', function() {
            togglePasswordVisibility('loginPassword', this);
        });

        toggleRegisterPassword.addEventListener('click', function() {
            togglePasswordVisibility('registerPassword', this);
        });

        // Vérification de la force du mot de passe
        registerPassword.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Vérifications de base
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            // Mise à jour de la barre de force
            passwordStrength.className = 'strength-bar';
            if (password.length === 0) {
                passwordStrength.style.width = '0%';
            } else if (strength <= 2) {
                passwordStrength.classList.add('strength-weak');
            } else if (strength === 3) {
                passwordStrength.classList.add('strength-medium');
            } else {
                passwordStrength.classList.add('strength-strong');
            }
        });

        // Validation des formulaires
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('loginEmail').value;
            
            // Simulation de connexion
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert(`Connexion réussie avec ${email}`);
                // Redirection vers le dashboard
                // window.location.href = 'dashboard.html';
            }, 1500);
        });

        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('registerName').value;
            const email = document.getElementById('registerEmail').value;
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Vérification de la correspondance des mots de passe
            if (password !== confirmPassword) {
                alert('Les mots de passe ne correspondent pas');
                return;
            }
            
            // Simulation d'inscription
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert(`Inscription réussie pour ${name}`);
                // Retour à la connexion
                showLoginForm();
            }, 1500);
        });

        // Connexion avec Google
        googleLogin.addEventListener('click', function() {
            const icon = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            setTimeout(() => {
                this.innerHTML = icon;
                alert('Connexion avec Google simulée');
            }, 1500);
        });

        googleRegister.addEventListener('click', function() {
            const icon = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            setTimeout(() => {
                this.innerHTML = icon;
                alert('Inscription avec Google simulée');
            }, 1500);
        });

        // Connexion avec Apple
        appleLogin.addEventListener('click', function() {
            const icon = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            setTimeout(() => {
                this.innerHTML = icon;
                alert('Connexion avec Apple simulée');
            }, 1500);
        });

        appleRegister.addEventListener('click', function() {
            const icon = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            setTimeout(() => {
                this.innerHTML = icon;
                alert('Inscription avec Apple simulée');
            }, 1500);
        });
    </script>
@endsection
