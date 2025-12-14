@extends('layouts.master')

@section('title', 'Manifest Detail')

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

            <!-- Content Area -->
            <section class="content-area">
                <!-- Informations du manifeste (améliorées) -->
                <div class="manifest-info card shadow mb-4 p-4" style="background: linear-gradient(90deg, #f8fafc 60%, #e3f2fd 100%); border-radius: 1rem;">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-ship fa-2x text-primary me-3"></i>
                        <h4 class="mb-0">Informations du manifeste</h4>
                        <span class="badge bg-info text-dark ms-3"><i class="fas fa-hashtag me-1"></i> {{ $travel->num_travel }}</span>
                    </div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-4">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-flag fa-fw text-secondary me-2"></i>
                                <strong>Statut :</strong>
                                <span class="ms-2 badge {{ $travel->status == 'completed' ? 'bg-success' : ($travel->status == 'in_progress' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                    <i class="fas fa-circle me-1"></i> {{ ucfirst(str_replace('_', ' ', $travel->status)) }}
                                </span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-ship fa-fw text-primary me-2"></i>
                                <strong>Navire :</strong>
                                <span class="ms-2">{{ $travel->ship && $travel->ship->name_nav ? $travel->ship->name_nav : 'Non renseigné' }}</span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-building fa-fw text-info me-2"></i>
                                <strong>Agence :</strong>
                                <span class="ms-2">{{ $travel->agency && $travel->agency->name_agency ? $travel->agency->name_agency : 'Non renseignée' }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-4">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt fa-fw text-success me-2"></i>
                                <strong>Date d'arrivée :</strong>
                                <span class="ms-2">{{ $travel->arrival_date }}</span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-anchor fa-fw text-primary me-2"></i>
                                <strong>Date d'accostage :</strong>
                                <span class="ms-2">{{ $travel->docking_date }}</span>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-box-open fa-fw text-warning me-2"></i>
                                <strong>Fin de déchargement :</strong>
                                <span class="ms-2">{{ $travel->end_unloading }}</span>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- DataTable -->
                @include('components.table_manifest_detail')
            </section>
        </main>
    </div>
    <!-- Add Vehicle Modal -->
    @include('components.manifest-detail-modal')

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
        const addVehicleModal = document.getElementById('addVehicleModal');
        const addVehicleBtn = document.getElementById('addVehicleBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');

        addVehicleBtn.addEventListener('click', function() {
            addVehicleModal.classList.add('active');
        });

        function closeModal() {
            addVehicleModal.classList.remove('active');
            document.getElementById('vehicleForm').reset();
        }

        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        saveBtn.addEventListener('click', function() {
            const form = document.getElementById('vehicleForm');
            if (form.checkValidity()) {
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
                saveBtn.disabled = true;
                // Préparer les données du formulaire
                const travelId = document.getElementById('travel_id').value;
                const data = {
                    bl: document.getElementById('bl').value,
                    consignor: document.getElementById('consignor').value,
                    destination: document.getElementById('destination').value,
                    consignor_adress: document.getElementById('consignor_adress').value,
                    chassis: document.getElementById('chassis').value,
                    mark: document.getElementById('mark').value,
                    type: document.getElementById('type').value,
                    year_make: document.getElementById('year_make').value,
                    travel_id: travelId,
                    bar_code: Math.random().toString(36).substring(2, 12)
                };
                // CSRF
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content') || document.querySelector('input[name="_token"]').value;
                fetch(`/travels/${travelId}/details`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(json => {
                    if (json.success) {
                        location.reload();
                    } else {
                        throw new Error(json.message || 'Erreur lors de l\'ajout');
                    }
                })
                .catch(error => {
                    saveBtn.innerHTML = 'Enregistrer';
                    saveBtn.disabled = false;
                    alert('Erreur lors de l\'ajout : ' + (error.message || error));
                });
            } else {
                alert('Veuillez remplir tous les champs obligatoires.');
            }
        });

        // Initialize DataTable et gestion suppression réelle
        $(document).ready(function() {
            const table = $('#vehiclesTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                },
                "pageLength": 10,
                "responsive": true,
                "order": [[0, "asc"]],
                "dom": '<"datatable-controls"<"datatable-length"l><"datatable-filter"f>>t<"datatable-info"i><"datatable-paging"p>',
                "columnDefs": [
                    {
                        targets: -1,
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Suppression réelle
            $('#vehiclesTable').on('click', '.btn-delete', function() {
                const btn = this;
                const row = $(this).closest('tr');
                const bl = row.find('td').eq(0).text();
                const id = row.data('id');
                const travelId = document.getElementById('travel_id').value;
                if (!confirm(`Voulez-vous vraiment supprimer ${bl} ?`)) return;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                btn.disabled = true;
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content') || document.querySelector('input[name="_token"]').value;
                fetch(`/travels/${travelId}/details/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                })
                .then(response => response.json())
                .then(json => {
                    if (!json.success) throw new Error(json.message || 'Erreur lors de la suppression');
                    table.row(row).remove().draw();
                    alert(`Suppression effectuée pour ${bl}`);
                })
                .catch(error => {
                    btn.innerHTML = '<i class="fas fa-trash"></i>';
                    btn.disabled = false;
                    alert(error.message || 'Erreur lors de la suppression');
                });
            });
        });
        
    </script>
@endsection
