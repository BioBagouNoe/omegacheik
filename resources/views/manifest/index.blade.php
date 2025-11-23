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
                @include('components.table_manifest')


            </section>
        </main>
    </div>

    <!-- Modal d'ajout de manifeste -->
    @include('components.manifest-modal')

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

        saveBtn.addEventListener('click', function() {
            // Ici, vous ajouteriez la logique pour sauvegarder le manifeste
            const form = document.getElementById('manifestForm');
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
