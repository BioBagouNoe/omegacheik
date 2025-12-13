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

            <!-- Content Area -->
            <section class="content-area">
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-value">247</div>
                                <div class="stat-label">Véhicules total</div>
                                <div class="stat-trend trend-up">
                                    <i class="fas fa-arrow-up"></i>
                                    +12% ce mois
                                </div>
                            </div>
                            <div class="stat-icon vehicles">
                                <i class="fas fa-car"></i>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-value">89</div>
                                <div class="stat-label">En maintenance</div>
                                <div class="stat-trend trend-down">
                                    <i class="fas fa-arrow-down"></i>
                                    -5% cette semaine
                                </div>
                            </div>
                            <div class="stat-icon maintenance">
                                <i class="fas fa-tools"></i>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-value">138</div>
                                <div class="stat-label">Disponibles</div>
                                <div class="stat-trend trend-up">
                                    <i class="fas fa-arrow-up"></i>
                                    +8% ce mois
                                </div>
                            </div>
                            <div class="stat-icon available">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <div class="stat-value">20</div>
                                <div class="stat-label">Hors service</div>
                                <div class="stat-trend trend-up">
                                    <i class="fas fa-arrow-up"></i>
                                    +2% ce mois
                                </div>
                            </div>
                            <div class="stat-icon out-of-service">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="charts-grid">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3 class="chart-title">Utilisation des véhicules</h3>
                            <select class="chart-filter">
                                <option>6 derniers mois</option>
                                <option>12 derniers mois</option>
                                <option>Cette année</option>
                            </select>
                        </div>
                        <canvas id="usageChart" style="max-height: 300px;"></canvas>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3 class="chart-title">Statut des véhicules</h3>
                        </div>
                        <canvas id="statusChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>

                <!-- DataTable -->
              <!-- DataTable -->
<div class="datatable-card">
    <div class="datatable-header">
        <h3 class="datatable-title">Manifestes</h3>
        <div class="datatable-actions">
            <button class="action-btn btn-add" id="addManifestBtn">
                <i class="fas fa-plus"></i>
                Ajouter
            </button>
            <button class="action-btn btn-import">
                <i class="fas fa-upload"></i>
                Importer
            </button>
            <button class="action-btn btn-export">
                <i class="fas fa-download"></i>
                Exporter
            </button>
            <button class="action-btn btn-filter">
                <i class="fas fa-filter"></i>
                Filtrer
            </button>
        </div>
    </div>

    <table id="manifestsTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Navire</th>
                <th>Date d'arrivée</th>
                <th>Date d'amarrage</th>
                <th>Fin de déchargement</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="manifestsTableBody">
            <!-- Les lignes seront ajoutées dynamiquement ici -->
        </tbody>
    </table>
</div>


            </section>
        </main>
    </div>

    <!-- Modal d'ajout de travel -->
    <div class="modal" id="addManifestModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter un manifeste</h3>
                <button class="modal-close" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="manifestForm">
                    <!-- Numéro de voyage et Navire -->
                    <div class="form-row d-flex gap-3 mb-3">
                         <div class="form-group flex-fill">
                            <label class="form-label" for="id_nav">Navire</label>
                            <select class="form-control" id="id_nav" required>
                                <option value="">Sélectionner un navire</option>
                                <!-- Options dynamiques -->
                            </select>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="num_travel">Numéro de voyage</label>
                            <input type="text" class="form-control" id="num_travel" required>
                        </div>
                    </div>

                    <!-- Agence et Statut -->
                    <div class="form-row d-flex gap-3 mb-3">
                        <div class="form-group flex-fill">
                            <label class="form-label" for="id_agency">Agence</label>
                            <select class="form-control" id="id_agency" required>
                                <option value="">Sélectionner une agence</option>
                                <!-- Options dynamiques -->
                            </select>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="status">Statut</label>
                            <select class="form-control" id="status" required>
                                <option value="">Sélectionner</option>
                                <option value="1">Actif</option>
                                <option value="0">Inactif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Date d’arrivée, Date d’amarrage, Date de fin de déchargement -->
                    <div class="form-row d-flex gap-3 mb-3">
                        <div class="form-group flex-fill">
                            <label class="form-label" for="arrival_date">Date d’arrivée</label>
                            <input type="date" class="form-control" id="arrival_date" required>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="docking_date">Date d’amarrage</label>
                            <input type="date" class="form-control" id="docking_date" required>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="end_unloading">Date de fin de déchargement</label>
                            <input type="date" class="form-control" id="end_unloading">
                        </div>
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelBtn">Annuler</button>
                <button class="btn btn-primary" id="saveBtn">Enregistrer</button>
            </div>
        </div>
    </div>

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

        const addManifestModal = document.getElementById('addManifestModal');
        const addManifestBtn = document.getElementById('addManifestBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');

        addManifestBtn.addEventListener('click', function() {
            addManifestModal.classList.add('active');
        });

        function closeModal() {
            addManifestModal.classList.remove('active');
            document.getElementById('manifestForm').reset();
        }

        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        // Fonction pour afficher les travels dans le tableau
        function renderTravels(travels) {
            const tbody = document.getElementById('manifestsTableBody');
            tbody.innerHTML = '';
            travels.forEach(travel => {
                let statusLabel = '';
                switch(travel.status) {
                    case 'scheduled': statusLabel = '<span class="status-badge status-available">Prévu</span>'; break;
                    case 'in_progress': statusLabel = '<span class="status-badge status-maintenance">En cours</span>'; break;
                    case 'completed': statusLabel = '<span class="status-badge status-reserved">Terminé</span>'; break;
                    case 'canceled': statusLabel = '<span class="status-badge status-out-of-service">Annulé</span>'; break;
                    default: statusLabel = travel.status;
                }
                tbody.innerHTML += `
                <tr data-id="${travel.id}">
                    <td>${travel.num_travel}</td>
                    <td>${travel.id_nav || ''}</td>
                    <td>${travel.arrival_date}</td>
                    <td>${travel.docking_date}</td>
                    <td>${travel.end_unloading}</td>
                    <td>${statusLabel}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn btn-view" title="Voir"><i class="fas fa-eye"></i></button>
                            <button class="action-btn btn-update" title="Modifier"><i class="fas fa-edit"></i></button>
                            <button class="action-btn btn-delete" title="Supprimer"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>`;
            });
        }

        // Charger les travels au chargement de la page
        function fetchTravels() {
            fetch('/travels')
                .then(res => res.json())
                .then(data => renderTravels(data));
        }
        fetchTravels();

        // Ajout d'un travel via le modal
        saveBtn.addEventListener('click', function() {
            const form = document.getElementById('manifestForm');
            if (form.checkValidity()) {
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
                saveBtn.disabled = true;
                const travelData = {
                    num_travel: document.getElementById('num_travel').value,
                    arrival_date: document.getElementById('arrival_date').value,
                    docking_date: document.getElementById('docking_date').value,
                    end_unloading: document.getElementById('end_unloading').value,
                    status: document.getElementById('status').value
                };
                fetch('/travels', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(travelData)
                })
                .then(res => {
                    if (!res.ok) throw new Error('Erreur lors de l\'ajout');
                    return res.json();
                })
                .then(data => {
                    fetchTravels();
                    closeModal();
                })
                .catch(() => alert('Erreur lors de l\'ajout'))
                .finally(() => {
                    saveBtn.innerHTML = 'Enregistrer';
                    saveBtn.disabled = false;
                });
            } else {
                alert('Veuillez remplir tous les champs obligatoires.');
            }
        });

        // Actions Voir, Modifier, Supprimer
        document.getElementById('manifestsTableBody').addEventListener('click', function(e) {
            const tr = e.target.closest('tr');
            const id = tr?.getAttribute('data-id');
            if (!id) return;

            // Voir
            if (e.target.closest('.btn-view')) {
                fetch(`/travels/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        alert(`Détails du manifeste :\nNuméro : ${data.num_travel}\nArrivée : ${data.arrival_date}\nStatut : ${data.status}`);
                    });
            }

            // Modifier
            if (e.target.closest('.btn-update')) {
                // Pour la démo, on demande un nouveau statut
                const newStatus = prompt('Nouveau statut (scheduled, in_progress, completed, canceled) :');
                if (!newStatus) return;
                fetch(`/travels/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Erreur lors de la modification');
                    return res.json();
                })
                .then(() => fetchTravels())
                .catch(() => alert('Erreur lors de la modification'));
            }

            // Supprimer
            if (e.target.closest('.btn-delete')) {
                if (!confirm('Voulez-vous vraiment supprimer ce manifeste ?')) return;
                fetch(`/travels/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Erreur lors de la suppression');
                    return res.json();
                })
                .then(() => fetchTravels())
                .catch(() => alert('Erreur lors de la suppression'));
            }
        });

        // Initialize DataTable
        $(document).ready(function() {
            const table = $('#manifestsTable').DataTable({
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

            // Button Actions
            document.querySelector('.btn-export').addEventListener('click', function() {
                const btn = this;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exportation...';
                btn.disabled = true;
                setTimeout(() => {
                    btn.innerHTML = '<i class="fas fa-download"></i> Exporter';
                    btn.disabled = false;
                    alert('Export terminé avec succès !');
                }, 1500);
            });

            document.querySelector('.btn-import').addEventListener('click', function() {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = '.csv,.xlsx,.xls';
                input.click();
                
                input.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        const btn = document.querySelector('.btn-import');
                        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Importation...';
                        btn.disabled = true;
                        setTimeout(() => {
                            btn.innerHTML = '<i class="fas fa-upload"></i> Importer';
                            btn.disabled = false;
                            alert('Import terminé avec succès !');
                        }, 1500);
                    }
                });
            });

            document.querySelector('.btn-filter').addEventListener('click', function() {
                const filterInput = document.querySelector('.dataTables_filter input');
                if (filterInput) {
                    filterInput.focus();
                }
            });

            // Table Action Buttons
            $('#manifestsTable').on('click', '.btn-view', function() {
                const row = $(this).closest('tr');
                const rowData = table.row(row).data();
                alert(`Affichage des détails pour ${rowData[0]} (${rowData[1]})`);
            });

            $('#manifestsTable').on('click', '.btn-update', function() {
                const btn = this;
                const row = $(this).closest('tr');
                const rowData = table.row(row).data();
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                btn.disabled = true;
                setTimeout(() => {
                    btn.innerHTML = '<i class="fas fa-edit"></i>';
                    btn.disabled = false;
                    alert(`Mise à jour effectuée pour ${rowData[0]} (${rowData[1]})`);
                }, 1500);
            });

            $('#manifestsTable').on('click', '.btn-reset', function() {
                const btn = this;
                const row = $(this).closest('tr');
                const rowData = table.row(row).data();
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                btn.disabled = true;
                setTimeout(() => {
                    btn.innerHTML = '<i class="fas fa-undo"></i>';
                    btn.disabled = false;
                    alert(`Réinitialisation effectuée pour ${rowData[0]} (${rowData[1]})`);
                }, 1500);
            });

            $('#manifestsTable').on('click', '.btn-delete', function() {
                const btn = this;
                const row = $(this).closest('tr');
                const rowData = table.row(row).data();
                if (confirm(`Voulez-vous vraiment supprimer ${rowData[0]} (${rowData[1]}) ?`)) {
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    btn.disabled = true;
                    setTimeout(() => {
                        table.row(row).remove().draw();
                        alert(`Suppression effectuée pour ${rowData[0]} (${rowData[1]})`);
                    }, 1500);
                }
            });
        });

        // Charts
        const ctx1 = document.getElementById('usageChart').getContext('2d');
        const usageChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre'],
                datasets: [{
                    label: 'Véhicules utilisés',
                    data: [65, 78, 85, 92, 108, 125],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            color: '#f3f4f6'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const ctx2 = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Disponibles', 'En maintenance', 'Réservés', 'Hors service'],
                datasets: [{
                    data: [138, 89, 20, 20],
                    backgroundColor: [
                        '#3b82f6',
                        '#f59e0b',
                        '#0ea5e9',
                        '#ef4444'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>
@endsection
