@extends('layouts.master')

@section('title', 'Manifestes - Gestion de Parc Automobile')

@section('content')
<div class="dashboard">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Bar -->
        @include('partials.navbar')

        <div class="container-xl px-4 mt-4">
            <div class="row">
                <div class="">
                    <!-- Account details card-->
                    <div class="profile-section mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Détails du compte</span>
                            <button class="btn btn-sm btn-primary" type="button" id="resetPasswordBtn" >
                                Modifier le mot de passe
                            </button>
                        </div>
                        <div class="card-body user-profile">
                            <form>
                                <!-- Form Group (username)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputUsername">Nom d'utilisateur</label>
                                    <input class="form-control" id="inputUsername" type="text" placeholder="Entrez votre nom d'utilisateur" value="username" />
                                </div>

                                <!-- Form Row        -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (organization name)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputOrgName">Agence</label>
                                        <input class="form-control" id="inputOrgName" type="text" placeholder="Entrez le nom de votre agence" value="Start Bootstrap" />
                                    </div>
                                    <!-- Form Group (location)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLocation">Rôle</label>
                                        <input class="form-control" id="inputLocation" type="text" placeholder="Entrez votre rôle" value="San Francisco, CA" />
                                    </div>
                                </div>
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (email number)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputEmailAddress">Adresse email</label>
                                        <input class="form-control" id="inputEmailAddress" type="email" placeholder="Entrez votre adresse email" value="name@example.com" />
                                    </div>
                                    <!-- Form Group (phone number)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Téléphone</label>
                                        <input class="form-control" id="inputPhone" type="tel" placeholder="Entrez votre numéro de téléphone" value="555-123-4567" />
                                    </div>
                                </div>
                                <!-- Save changes button-->
                                <button class="btn btn-primary" type="button">Enrégistrer changements</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
  @include('components.reset-password-modal')
  <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');

        mobileMenuBtn.addEventListener('click', function() {
            sidebar.classList.add('mobile-open');
            mobileOverlay.classList.add('active');
        });

        mobileOverlay.addEventListener('click', function() {
            sidebar.classList.remove('mobile-open');
            mobileOverlay.classList.remove('active');
        });

        // Modal Functionality

        const resetPasswordModal = document.getElementById('resetPasswordModal');
        const resetPasswordBtn = document.getElementById('resetPasswordBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');

        resetPasswordBtn.addEventListener('click', function() {
            resetPasswordModal.classList.add('active');
        });

        function closeModal() {
            resetPasswordModal.classList.remove('active');
            document.getElementById('resetPasswordForm').reset();
        }

        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        saveBtn.addEventListener('click', function() {
            // Ici, vous ajouteriez la logique pour sauvegarder le manifeste
            const form = document.getElementById('resetPasswordForm');
            if (form.checkValidity()) {
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
                saveBtn.disabled = true;
                
                setTimeout(() => {
                    saveBtn.innerHTML = 'Enregistrer';
                    saveBtn.disabled = false;
                    alert('Véhicule ajouté avec succès !');
                    closeModal();
                }, 1500);
            } else {
                alert('Veuillez remplir tous les champs obligatoires.');
            }
        });
    </script>
@endsection