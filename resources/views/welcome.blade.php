<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMEGA CHEIK - Gestion Cargo Aéroportuaire</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background: #0a0a1a;
            color: #ffffff;
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(10, 10, 26, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 900;
            background: linear-gradient(135deg, #190464ff 0%, #2c0596ff 50%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #190464ff, #10b981);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-cta {
            background: linear-gradient(135deg, #190464ff 0%, #2c0596ff 100%);
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .nav-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(16, 185, 129, 0.5);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 100%);
            position: relative;
            overflow: hidden;
            padding: 0 5%;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(25, 4, 100, 0.3) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            animation: float 6s ease-in-out infinite;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, transparent 70%);
            bottom: -150px;
            left: -150px;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(30px, 30px) rotate(180deg); }
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 900px;
        }

        .hero-icon {
            font-size: 5rem;
            background: linear-gradient(135deg, #190464ff, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ffffff 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.3rem;
            color: #b0b0c0;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1rem 2.5rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #190464ff 0%, #2c0596ff 100%);
            color: white;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(16, 185, 129, 0.6);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #10b981;
        }

        /* Features Section */
        .features {
            padding: 6rem 5%;
            background: #0f0f1e;
            position: relative;
        }

        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ffffff 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-title p {
            color: #b0b0c0;
            font-size: 1.1rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: linear-gradient(135deg, rgba(25, 4, 100, 0.2) 0%, rgba(16, 185, 129, 0.1) 100%);
            padding: 2.5rem;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(25, 4, 100, 0.3) 0%, rgba(16, 185, 129, 0.2) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(16, 185, 129, 0.3);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            font-size: 3rem;
            color: #10b981;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #ffffff;
            position: relative;
            z-index: 1;
        }

        .feature-card p {
            color: #b0b0c0;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        /* Stats Section */
        .stats {
            padding: 4rem 5%;
            background: linear-gradient(135deg, #190464ff 0%, #2c0596ff 100%);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 3rem;
            font-weight: 800;
            color: #10b981;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }

        /* Footer */
        footer {
            background: #0a0a1a;
            padding: 3rem 5%;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }

        .footer-section h3 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            color: #10b981;
        }

        .footer-section p,
        .footer-section a {
            color: #b0b0c0;
            text-decoration: none;
            line-height: 2;
            display: block;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: #10b981;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: #ffffff;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: linear-gradient(135deg, #190464ff, #10b981);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }

        .footer-bottom {
            text-align: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #b0b0c0;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .hero-icon {
                font-size: 3.5rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 2rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="logo-text">OMEGA CHEIK</div>
        <ul class="nav-links">
            <li><a href="#accueil">Accueil</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#stats">Statistiques</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <a href="{{ route('login') }}" class="nav-cta">Se connecter</a>
        <button class="mobile-menu-btn">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="accueil">
        <div class="hero-content">
            <div class="hero-icon">
                <i class="fas fa-plane-departure"></i>
            </div>
            <h1>Gestion Intelligente du Cargo Aéroportuaire</h1>
            <p>Optimisez le déchargement de vos navires et camions avec notre solution moderne de gestion en temps réel. Efficacité, traçabilité et performance au service de votre aéroport.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="fas fa-rocket"></i>
                    Commencer maintenant
                </a>
                <a href="#services" class="btn btn-secondary">
                    <i class="fas fa-info-circle"></i>
                    En savoir plus
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="services">
        <div class="section-title">
            <h2>Nos Services de Gestion</h2>
            <p>Des outils puissants pour une gestion optimale de vos opérations</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-ship"></i>
                </div>
                <h3>Gestion des Navires</h3>
                <p>Suivez en temps réel l'arrivée et le déchargement de vos navires cargo. Planifiez les opérations et optimisez les ressources portuaires.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-truck-loading"></i>
                </div>
                <h3>Déchargement Camions</h3>
                <p>Coordonnez efficacement le déchargement des camions avec un système de suivi intelligent et des notifications en temps réel.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h3>Traçabilité Complète</h3>
                <p>Documentez chaque étape du processus avec un historique détaillé et des rapports automatisés pour une conformité totale.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Analyses & Rapports</h3>
                <p>Accédez à des tableaux de bord interactifs et des analyses approfondies pour améliorer vos performances opérationnelles.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <h3>Gestion d'Équipe</h3>
                <p>Organisez vos équipes, assignez des tâches et suivez la productivité avec des outils collaboratifs intégrés.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Sécurité & Conformité</h3>
                <p>Respectez les normes internationales avec un système sécurisé et conforme aux réglementations aéroportuaires.</p>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats" id="stats">
        <div class="stats-grid">
            <div class="stat-item">
                <h3>500+</h3>
                <p>Navires Gérés</p>
            </div>
            <div class="stat-item">
                <h3>2000+</h3>
                <p>Camions Traités</p>
            </div>
            <div class="stat-item">
                <h3>99.9%</h3>
                <p>Disponibilité</p>
            </div>
            <div class="stat-item">
                <h3>24/7</h3>
                <p>Support Client</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-section">
                <h3>OMEGA CHEIK</h3>
                <p>Solution moderne de gestion cargo aéroportuaire pour optimiser vos opérations de déchargement et de logistique.</p>
                <div class="social-links">
                    <a href="https://facebook.com" target="_blank" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com" target="_blank" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://linkedin.com" target="_blank" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://youtube.com" target="_blank" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Liens Rapides</h3>
                <a href="#accueil">Accueil</a>
                <a href="#services">Services</a>
                <a href="#stats">Statistiques</a>
                <a href="{{ route('login') }}">Se connecter</a>
                <a href="{{ route('register') }}">S'inscrire</a>
            </div>

            <div class="footer-section">
                <h3>Services</h3>
                <a href="#">Gestion des navires</a>
                <a href="#">Déchargement camions</a>
                <a href="#">Traçabilité</a>
                <a href="#">Rapports & Analyses</a>
                <a href="#">Support technique</a>
            </div>

            <div class="footer-section">
                <h3>Contact</h3>
                <p><i class="fas fa-map-marker-alt"></i> Aéroport International, Cotonou</p>
                <p><i class="fas fa-phone"></i> +229 XX XX XX XX</p>
                <p><i class="fas fa-envelope"></i> contact@omegacheik.com</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 OMEGA CHEIK. Tous droits réservés. | Développé avec <i class="fas fa-heart" style="color: #10b981;"></i></p>
        </div>
    </footer>

    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.style.background = 'rgba(10, 10, 26, 0.98)';
            } else {
                nav.style.background = 'rgba(10, 10, 26, 0.95)';
            }
        });

        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card, .stat-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>