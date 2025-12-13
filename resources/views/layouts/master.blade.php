<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.head')
</head>

<body>
    @yield('content')
    
    <!-- Scripts -->
    <script>
        // Configuration AJAX globale pour inclure le jeton CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        // Fonction utilitaire pour afficher les notifications
        function showNotification(message, type = 'success') {
            // Supprimer les notifications existantes
            document.querySelectorAll('.alert-notification').forEach(el => el.remove());
            
            // Créer la notification
            const notification = document.createElement('div');
            notification.className = `alert-notification ${type} alert-blink`;
            notification.textContent = message;
            
            // Ajouter la notification au DOM
            document.body.appendChild(notification);
            
            // Supprimer la notification après 5 secondes
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Afficher les messages de session si présents
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showNotification("{{ session('success') }}", 'success');
            @endif

            @if(session('error'))
                showNotification("{{ session('error') }}", 'error');
            @endif
        });
    </script>
</body>
</html>
