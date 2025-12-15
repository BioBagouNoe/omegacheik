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
                        <span class="badge bg-info text-dark ms-3"><i class="fas fa-hashtag me-1"></i> <span id="num_travel_display">{{ $travel->num_travel }}</span></span>
                        <button id="editManifestBtn" class="btn btn-outline-primary btn-sm ms-auto" style="border-radius: 2rem; font-weight: 600;">
                            <i class="fas fa-pen"></i> Modifier
                        </button>
                        <button id="saveManifestBtn" class="btn btn-success btn-sm ms-2 d-none" style="border-radius: 2rem; font-weight: 600;">
                            <i class="fas fa-check"></i> Sauvegarder
                        </button>
                        <button id="cancelManifestBtn" class="btn btn-secondary btn-sm ms-2 d-none" style="border-radius: 2rem; font-weight: 600;">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                    </div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-4">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-flag fa-fw text-secondary me-2"></i>
                                <strong>Statut :</strong>
                                <span id="status_display" class="ms-2 badge {{ $travel->status == 'completed' ? 'bg-success' : ($travel->status == 'in_progress' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                    <i class="fas fa-circle me-1"></i> {{ ucfirst(str_replace('_', ' ', $travel->status)) }}
                                </span>
                                <select id="status_input" class="form-select form-select-sm d-none ms-2" style="width:auto;">
                                    <option value="scheduled" {{ $travel->status == 'scheduled' ? 'selected' : '' }}>Prévu</option>
                                    <option value="in_progress" {{ $travel->status == 'in_progress' ? 'selected' : '' }}>En cours</option>
                                    <option value="completed" {{ $travel->status == 'completed' ? 'selected' : '' }}>Terminé</option>
                                    <option value="canceled" {{ $travel->status == 'canceled' ? 'selected' : '' }}>Annulé</option>
                                </select>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-ship fa-fw text-primary me-2"></i>
                                <strong>Navire :</strong>
                                <span id="ship_display" class="ms-2">{{ $travel->ship && $travel->ship->name_nav ? $travel->ship->name_nav : 'Non renseigné' }}</span>
                                <select id="ship_input" class="form-select form-select-sm d-none ms-2" style="width:auto;display:inline-block;max-width:180px;">
                                    @foreach(App\Models\Ship::all() as $ship)
                                        <option value="{{ $ship->id }}" {{ $travel->ship_id == $ship->id ? 'selected' : '' }}>{{ $ship->name_nav }}</option>
                                    @endforeach
                                </select>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-building fa-fw text-info me-2"></i>
                                <strong>Agence :</strong>
                                <span id="agency_display" class="ms-2">{{ $travel->agency && $travel->agency->name_agency ? $travel->agency->name_agency : 'Non renseignée' }}</span>
                                <select id="agency_input" class="form-select form-select-sm d-none ms-2" style="width:auto;display:inline-block;max-width:180px;">
                                    @foreach(App\Models\Agency::all() as $agency)
                                        <option value="{{ $agency->id }}" {{ $travel->agency_id == $agency->id ? 'selected' : '' }}>{{ $agency->name_agency }}</option>
                                    @endforeach
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="row g-3 mb-2">
                        <div class="col-md-4">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt fa-fw text-success me-2"></i>
                                <strong>Date d'arrivée :</strong>
                                <span id="arrival_display" class="ms-2">{{ $travel->arrival_date }}</span>
                                <input id="arrival_input" type="date" class="form-control form-control-sm d-none ms-2" style="width:auto;display:inline-block;max-width:150px;" value="{{ $travel->arrival_date }}" />
                            </span>
                        </div>
                        <div class="col-md-4">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-anchor fa-fw text-primary me-2"></i>
                                <strong>Date d'accostage :</strong>
                                <span id="docking_display" class="ms-2">{{ $travel->docking_date }}</span>
                                <input id="docking_input" type="date" class="form-control form-control-sm d-none ms-2" style="width:auto;display:inline-block;max-width:150px;" value="{{ $travel->docking_date }}" />
                            </span>
                        </div>
                        <div class="col-md-4">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-box-open fa-fw text-warning me-2"></i>
                                <strong>Fin de déchargement :</strong>
                                <span id="end_unloading_display" class="ms-2">{{ $travel->end_unloading }}</span>
                                <input id="end_unloading_input" type="date" class="form-control form-control-sm d-none ms-2" style="width:auto;display:inline-block;max-width:150px;" value="{{ $travel->end_unloading }}" />
                            </span>
                        </div>
                    </div>
                </div>
                <!-- DataTable -->
                @include('components.table_manifest_detail')
                @stack('scripts')
            </section>
        </main>
    </div>
    <!-- Add Vehicle Modal -->
    @include('components.manifest-detail-modal')

    <script>
                // --- Manifest Edit Inline ---
                const editManifestBtn = document.getElementById('editManifestBtn');
                const saveManifestBtn = document.getElementById('saveManifestBtn');
                const cancelManifestBtn = document.getElementById('cancelManifestBtn');
                const fields = [
                    {display: 'num_travel_display', input: null},
                    {display: 'status_display', input: 'status_input'},
                    {display: 'ship_display', input: 'ship_input'},
                    {display: 'agency_display', input: 'agency_input'},
                    {display: 'arrival_display', input: 'arrival_input'},
                    {display: 'docking_display', input: 'docking_input'},
                    {display: 'end_unloading_display', input: 'end_unloading_input'},
                ];
                let manifestEditBackup = {};
                if(editManifestBtn) {
                    editManifestBtn.addEventListener('click', function() {
                        fields.forEach(f => {
                            if(f.input) {
                                document.getElementById(f.display).classList.add('d-none');
                                document.getElementById(f.input).classList.remove('d-none');
                            }
                        });
                        editManifestBtn.classList.add('d-none');
                        saveManifestBtn.classList.remove('d-none');
                        cancelManifestBtn.classList.remove('d-none');
                        // Backup
                        manifestEditBackup = {};
                        fields.forEach(f => {
                            if(f.input) manifestEditBackup[f.input] = document.getElementById(f.input).value;
                        });
                    });
                    cancelManifestBtn.addEventListener('click', function() {
                        fields.forEach(f => {
                            if(f.input) {
                                document.getElementById(f.display).classList.remove('d-none');
                                document.getElementById(f.input).classList.add('d-none');
                                document.getElementById(f.input).value = manifestEditBackup[f.input];
                            }
                        });
                        editManifestBtn.classList.remove('d-none');
                        saveManifestBtn.classList.add('d-none');
                        cancelManifestBtn.classList.add('d-none');
                    });
                    saveManifestBtn.addEventListener('click', function() {
                        const travelId = {{ $travel->id }};
                        const data = {
                            status: document.getElementById('status_input').value,
                            ship_id: document.getElementById('ship_input').value,
                            agency_id: document.getElementById('agency_input').value,
                            arrival_date: document.getElementById('arrival_input').value,
                            docking_date: document.getElementById('docking_input').value,
                            end_unloading: document.getElementById('end_unloading_input').value,
                        };
                        saveManifestBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sauvegarde...';
                        saveManifestBtn.disabled = true;
                        fetch(`/travels/${travelId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(data)
                        })
                        .then(r => r.json())
                        .then(json => {
                            if(json.status === 'success' || json.success) {
                                location.reload();
                            } else {
                                throw new Error(json.message || 'Erreur lors de la sauvegarde');
                            }
                        })
                        .catch(e => {
                            saveManifestBtn.innerHTML = '<i class="fas fa-check"></i> Sauvegarder';
                            saveManifestBtn.disabled = false;
                            alert(e.message || 'Erreur lors de la sauvegarde');
                        });
                    });
                }
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

        // Initialize DataTable
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
            // Note: Delete handler is in table_manifest_detail.blade.php to avoid duplication
        });
        
    </script>
@endsection
