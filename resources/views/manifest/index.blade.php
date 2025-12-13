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


            <div class="datatable-card">
                <div class="datatable-header">
                    <h3 class="datatable-title">Agences</h3>
                    <div class="datatable-actions">
                        <button class="action-btn btn-add" id="addAgencyBtn">
                            <i class="fas fa-plus"></i>
                            Ajouter
                        </button>
                        <button class="action-btn btn-import" id="btnImportAgency">
                            <i class="fas fa-upload"></i>
                            <span class="import-text">Importer</span>
                            <span class="import-loading" style="display:none;"><i class="fas fa-spinner fa-spin"></i> Importation...</span>
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

                <table id="agenciesTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Navire</th>
                            <th>Date d'arrivée</th>
                            <th>Date d'amarrage</th>
                            <th>Fin de déchargement</th>
                            <th>Statut</th>
                            <th class="d-flex justify-content-end gap-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div id="agency-import-errors" style="display:none; margin-bottom:10px; color:#dc2626; font-weight:bold;"></div>

                        @forelse($travels as $travel)
                        <tr data-travel-id="{{ $travel->id }}" data-ship-id="{{ $travel->ship_id }}">
                            <!-- Navire -->
                            <td class="ship-name-cell" data-ship-id="{{ $travel->ship_id }}">
                                {{ $travel->ship->name_nav ?? '' }}
                            </td>

                            <!-- Date d'arrivée -->
                            <td>
                                {{ $travel->arrival_date }}
                            </td>

                            <!-- Date d'amarrage -->
                            <td>
                                {{ $travel->docking_date }}
                            </td>

                            <!-- Fin de déchargement -->
                            <td>
                                {{ $travel->end_unloading }}
                            </td>

                            <!-- Statut -->
                            <td>
                                {{ $travel->status }}
                            </td>

                            <!-- Actions (styles inchangés) -->
                            <td>
                                <div class="action-buttons d-flex justify-content-end gap-2">
                                    <a href="{{ route('travels.show', $travel) }}" class="action-btn btn-view" style="text-decoration: none;" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <button class="action-btn btn-update" title="Modifier" type="button">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('travels.destroy', $travel) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Aucun voyage pour le moment.</td>
                        </tr>
                        @endforelse
                    </tbody>

                    <div id="agency-success-msg" style="display:none;position:fixed;top:20px;left:50%;transform:translateX(-50%);background:#22c55e;color:#fff;padding:10px 30px;border-radius:6px;z-index:9999;font-weight:bold;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                        Modification effectuée avec succès !
                    </div>

                    <script>
                        // Liste des navires pour affichage dynamique (injectée côté JS)
                        const shipsList = [
                            @foreach($ships as $ship)
                            {id: {{ $ship->id }}, name: @json($ship->name_nav)},
                            @endforeach
                        ];
                        document.addEventListener('DOMContentLoaded', function() {
                            // Import agences
                            document.getElementById('btnImportAgency').addEventListener('click', function() {
                                const input = document.createElement('input');
                                input.type = 'file';
                                input.accept = '.csv,.xlsx,.xls';
                                input.click();
                                input.addEventListener('change', function() {
                                    if (this.files.length > 0) {
                                        const btn = document.getElementById('btnImportAgency');
                                        btn.querySelector('.import-text').style.display = 'none';
                                        btn.querySelector('.import-loading').style.display = 'inline-block';
                                        btn.disabled = true;
                                        const formData = new FormData();
                                        formData.append('file', this.files[0]);
                                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value;
                                        fetch('/agencies/import', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': token
                                                },
                                                body: formData
                                            })
                                            .then(async response => {
                                                const data = await response.json();
                                                btn.querySelector('.import-text').style.display = 'inline-block';
                                                btn.querySelector('.import-loading').style.display = 'none';
                                                btn.disabled = false;
                                                if (response.ok && data.success) {
                                                    location.reload();
                                                } else if (data.errors) {
                                                    const errorDiv = document.getElementById('agency-import-errors');
                                                    errorDiv.innerHTML = data.errors.map(e => `<div>${e}</div>`).join('');
                                                    errorDiv.style.display = 'block';
                                                } else {
                                                    alert('Erreur lors de l\'import.');
                                                }
                                            })
                                            .catch(error => {
                                                btn.querySelector('.import-text').style.display = 'inline-block';
                                                btn.querySelector('.import-loading').style.display = 'none';
                                                btn.disabled = false;
                                                alert('Erreur lors de l\'import.');
                                            });
                                    }
                                });
                            });

                            // Export agences
                            document.querySelector('.btn-export').addEventListener('click', function() {
                                window.location.href = '/agencies/export';
                            });

                            document.querySelectorAll('.btn-update').forEach(function(editBtn) {
                                editBtn.addEventListener('click', function() {
                                    const tr = editBtn.closest('tr');
                                    tr.querySelector('.agency-name-text').style.display = 'none';
                                    tr.querySelector('.agency-name-input').style.display = 'inline-block';
                                    tr.querySelector('.agency-line-text').style.display = 'none';
                                    tr.querySelector('.agency-line-select').style.display = 'inline-block';
                                    tr.querySelector('.agency-pays-text').style.display = 'none';
                                    tr.querySelector('.agency-pays-select').style.display = 'inline-block';
                                    tr.querySelector('.agency-adress-text').style.display = 'none';
                                    tr.querySelector('.agency-adress-input').style.display = 'inline-block';
                                    editBtn.style.display = 'none';
                                    tr.querySelector('.btn-validate').style.display = 'inline-block';

                                            }
                                            showNotification(errorMessage, 'danger');
                                            console.error('Erreur:', xhr);
                                        },
                                        complete: function() {
                                            // Réactiver le bouton
                                            validateBtn.disabled = false;
                                            validateBtn.innerHTML = originalHtml;
                                        }
                                    });
                                });
                            });
                        });
                    </script>
                </table>
            </div>


            <!-- Add Agency Modal -->
            <!-- Add Travel Modal -->
            <div class="modal" id="addAgencyModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Ajouter un voyage</h3>
                        <button type="button" class="modal-close" id="closeModalBtn">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="travelForm" action="{{ route('travels.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Numéro du voyage + Navire -->
                            <div class="form-row d-flex gap-2 mb-3">
                                <div class="form-group flex-fill">
                                    <label class="form-label" for="num_travel">Numéro du voyage</label>
                                    <input type="text" class="form-control" id="num_travel" name="num_travel" required>
                                </div>

                                <div class="form-group flex-fill">
                                    <label class="form-label" for="ship_id">Navire</label>
                                    <select class="form-control" id="ship_id" name="ship_id" required>
                                        <option value="">Sélectionner un navire</option>
                                        @foreach($ships as $ship)
                                        <option value="{{ $ship->id }}">{{ $ship->name_nav }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Agence + Statut -->
                            <div class="form-row d-flex gap-2 mb-3">
                                <div class="form-group flex-fill">
                                    <label class="form-label" for="agency_id">Agence</label>
                                    <select class="form-control" id="agency_id" name="agency_id" required>
                                        <option value="">Sélectionner une agence</option>
                                        @foreach($agencies as $agency)
                                        <option value="{{ $agency->id }}">{{ $agency->name_agency }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group flex-fill">
                                    <label class="form-label" for="status">Statut</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">Sélectionner un statut</option>
                                        <option value="scheduled">Prévu</option>
                                        <option value="in_progress">En cours</option>
                                        <option value="completed">Terminé</option>
                                        <option value="canceled">Annulé</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Dates -->
                            <div class="form-row d-flex gap-2 mb-3">
                                <div class="form-group flex-fill">
                                    <label class="form-label" for="arrival_date">Date d'arrivée</label>
                                    <input type="date" class="form-control" id="arrival_date" name="arrival_date" required>
                                </div>

                                <div class="form-group flex-fill">
                                    <label class="form-label" for="docking_date">Date d'amarrage</label>
                                    <input type="date" class="form-control" id="docking_date" name="docking_date" required>
                                </div>
                            </div>

                            <div class="form-row d-flex gap-2 mb-3">
                                <div class="form-group flex-fill">
                                    <label class="form-label" for="end_unloading">Fin de déchargement</label>
                                    <input type="date" class="form-control" id="end_unloading" name="end_unloading" required>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cancelBtn">Annuler</button>
                                <button type="submit" class="btn btn-primary" id="saveBtn">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                // Fonction utilitaire pour afficher les notifications
                function showNotification(message, type = 'success') {
                    // Supprimer les notifications existantes
                    document.querySelectorAll('.alert-notification').forEach(el => el.remove());

                    const alertDiv = document.createElement('div');
                    alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-notification`;
                    alertDiv.role = 'alert';
                    alertDiv.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

                    // Ajouter la notification au corps du document
                    document.body.appendChild(alertDiv);

                    // Forcer le reflow pour que l'animation fonctionne
                    alertDiv.offsetHeight;

                    // Désactiver le clignotement après 3 secondes
                    setTimeout(() => {
                        alertDiv.classList.remove('alert-blink');
                    }, 3000);

                    // Supprimer la notification après 5 secondes
                    setTimeout(() => {
                        alertDiv.classList.add('fade');
                        setTimeout(() => {
                            if (alertDiv.parentNode) {
                                alertDiv.parentNode.removeChild(alertDiv);
                            }
                        }, 150);
                    }, 5000);
                }

                // Mobile Menu Toggle
                const mobileMenuBtn = document.getElementById('mobileMenuBtn');
                const sidebar = document.getElementById('sidebar');
                const mobileOverlay = document.getElementById('mobileOverlay');

                // guard: si le bouton n'existe pas, on évite une erreur JS
                if (mobileMenuBtn) {
                    mobileMenuBtn.addEventListener('click', function() {
                        sidebar.classList.add('mobile-open');
                        mobileOverlay.classList.add('active');
                    });
                }

                if (mobileOverlay) {
                    mobileOverlay.addEventListener('click', function() {
                        sidebar.classList.remove('mobile-open');
                        mobileOverlay.classList.remove('active');
                    });
                }

                // Modal Functionality
                const addAgencyModal = document.getElementById('addAgencyModal');
                const addAgencyBtn = document.getElementById('addAgencyBtn'); // existe dans la page
                const closeModalBtn = document.getElementById('closeModalBtn');
                const cancelBtn = document.getElementById('cancelBtn');
                const saveBtn = document.getElementById('saveBtn');

                if (addAgencyBtn) {
                    // s'assurer que le bouton d'ouverture ne soumet pas si dans un form parent
                    addAgencyBtn.setAttribute('type', 'button');
                    addAgencyBtn.addEventListener('click', function() {
                        addAgencyModal.classList.add('active');
                    });
                }

                function closeModal() {
                    addAgencyModal.classList.remove('active');
                    const f = document.getElementById('agencyForm');
                    if (f) f.reset();
                }

                if (closeModalBtn) {
                    closeModalBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        closeModal();
                    });
                }

                if (cancelBtn) {
                    cancelBtn.addEventListener('click', function(e) {
                        // empêche le submit par défaut et ferme le modal
                        e.preventDefault();
                        closeModal();
                    });
                }

                if (saveBtn) {
                    saveBtn.addEventListener('click', function(e) {
                        e.preventDefault(); // Empêche le submit classique
                        const form = document.getElementById('travelForm');
                        if (!form) return;

                        if (form.checkValidity()) {
                            // feedback UI
                            const originalHtml = saveBtn.innerHTML;
                            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
                            saveBtn.disabled = true;

                            const formData = new FormData(form);
                            // token CSRF
                            const token = form.querySelector('input[name="_token"]')?.value || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                            fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': token,
                                    'Accept': 'application/json'
                                },
                                body: formData
                            })
                            .then(async response => {
                                const text = await response.text();
                                let data = {};
                                try {
                                    data = JSON.parse(text);
                                } catch (err) {
                                    data = {};
                                }
                                if (!response.ok) {
                                    if (data && data.errors) {
                                        alert('Erreurs :\n' + Object.values(data.errors).flat().join('\n'));
                                    } else if (data && data.message) {
                                        alert(data.message);
                                    } else {
                                        throw new Error('Erreur lors de l\'ajout');
                                    }
                                    throw new Error('Response not ok');
                                }
                                return data;
                            })
                            .then(data => {
                                // Fermer le modal et réinitialiser le formulaire
                                closeModal();
                                form.reset();

                                // Récupérer l'instance DataTable
                                const table = $('#agenciesTable').DataTable();

                                // Supprimer le message "Aucun voyage" s'il existe
                                if (table.data().count() === 1 && table.row(':eq(0)').data()[0] === 'Aucun voyage pour le moment.') {
                                    table.clear().draw();
                                }

                                // Créer la nouvelle ligne avec le nom du navire (pas l'id)
                                const travel = data;
                                let shipName = '';
                                if (travel.ship && travel.ship.name_nav) {
                                    shipName = travel.ship.name_nav;
                                } else if (travel.ship_id) {
                                    const foundShip = shipsList.find(s => s.id == travel.ship_id);
                                    shipName = foundShip ? foundShip.name : '';
                                }
                                const newRow = [
                                    shipName,
                                    travel.arrival_date || '',
                                    travel.docking_date || '',
                                    travel.end_unloading || '',
                                    travel.status || '',
                                    `
                                    <div class="action-buttons d-flex justify-content-end gap-2">
                                        <a href="/travels/${travel.id}" class="action-btn btn-view" style="text-decoration: none;" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="action-btn btn-update" title="Modifier" type="button">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="/travels/${travel.id}" method="POST" style="display:inline;">
                                            <input type="hidden" name="_token" value="${token}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="action-btn btn-delete" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    `
                                ];
                                table.row.add(newRow).draw(false);
                                setTimeout(adjustTableColumns, 100);
                                showNotification('Voyage ajouté avec succès !', 'success');
                            })
                            .catch(error => {
                                showNotification('Une erreur est survenue lors de l\'ajout du voyage', 'danger');
                                saveBtn.innerHTML = 'Enregistrer';
                                saveBtn.disabled = false;
                                console.error(error);
                            });
                        } else {
                            if (typeof showNotification === 'function') {
                                showNotification('Veuillez remplir tous les champs obligatoires.', 'warning');
                            } else {
                                alert('Veuillez remplir tous les champs obligatoires.');
                            }
                        }
                    });
                }

                // Suppression AJAX pour les voyages
                $(document).on('click', '.btn-delete', function(e) {
                    e.preventDefault();
                    const button = $(this);
                    // Trouver la ligne et l'id du voyage
                    const row = button.closest('tr');
                    // L'id est dans l'attribut data-travel-id
                    const travelId = row.attr('data-travel-id');
                    if (!travelId) return;
                    if (!confirm('Êtes-vous sûr de vouloir supprimer ce voyage ?')) return;

                    // Désactiver le bouton pour éviter les clics multiples
                    const originalHtml = button.html();
                    button.html('<i class="fas fa-spinner fa-spin"></i>');
                    button.prop('disabled', true);

                    // Token CSRF
                    const token = $('meta[name="csrf-token"]').attr('content') || $("input[name='_token']").val();

                    $.ajax({
                        url: `/travels/${travelId}`,
                        type: 'POST',
                        data: {
                            _token: token,
                            _method: 'DELETE'
                        },
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            // Supprimer la ligne du tableau avec une animation
                            row.fadeOut(400, function() {
                                row.remove();
                                // Si le tableau est vide, afficher un message
                                if ($('#agenciesTable tbody tr').length === 0) {
                                    $('#agenciesTable tbody').html('<tr><td colspan="7" class="text-center">Aucun voyage pour le moment.</td></tr>');
                                }
                                showNotification('Voyage supprimé avec succès', 'success');
                            });
                        },
                        error: function(xhr) {
                            let errorMessage = 'Une erreur est survenue lors de la suppression du voyage';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.statusText) {
                                errorMessage += `: ${xhr.statusText}`;
                            }
                            showNotification(errorMessage, 'danger');
                            button.html(originalHtml);
                            button.prop('disabled', false);
                        }
                    });
                });

                // Fonction pour ajuster la largeur des colonnes
                function adjustTableColumns() {
                    const table = $('#agenciesTable').DataTable();
                    table.columns.adjust().draw(false);

                    // Forcer le recalcul des largeurs après un court délai
                    setTimeout(() => {
                        table.columns.adjust().draw(false);
                    }, 50);
                }

                // Initialize DataTable
                $(document).ready(function() {
                    const table = $('#agenciesTable').DataTable({
                        "responsive": true,
                        "autoWidth": false,
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                        },
                        "pageLength": 10,
                        "order": [ [0, "asc"] ],
                        "dom": '<"datatable-controls"<"datatable-length"l><"datatable-filter"f>>t<"datatable-info"i><"datatable-paging"p>',
                        "columnDefs": [
                            { targets: -1, orderable: false, searchable: false }
                        ]
                    });

                    // Table Action Buttons
                    $('#agenciesTable').on('click', '.btn-view', function() {
                        const row = $(this).closest('tr');
                        const rowData = table.row(row).data();
                        alert(`Affichage des détails pour le voyage #${rowData[0]}`);
                    });

                    // Liste des navires pour le select (injectée côté JS)
                    const shipsList = [
                        @foreach($ships as $ship)
                        {id: {{ $ship->id }}, name: @json($ship->name_nav)},
                        @endforeach
                    ];

                    // Edition inline AJAX pour voyages
                    $('#agenciesTable').on('click', '.btn-update', function() {
                        const row = $(this).closest('tr');
                        if (row.hasClass('editing')) return;
                        row.addClass('editing');
                        const tds = row.find('td');
                        // Sauvegarde valeurs actuelles
                        const shipId = row.data('ship-id') || tds.eq(0).data('ship-id');
                        const navire = tds.eq(0).text().trim();
                        const arrival = tds.eq(1).text().trim();
                        const docking = tds.eq(2).text().trim();
                        const endUnload = tds.eq(3).text().trim();
                        const status = tds.eq(4).text().trim();

                        // Création du select navire
                        let shipSelect = `<select class='form-control form-control-sm' name='ship_id' required>`;
                        shipSelect += `<option value=''>Sélectionner un navire</option>`;
                        shipsList.forEach(function(ship) {
                            shipSelect += `<option value='${ship.id}' ${(shipId == ship.id) ? 'selected' : ''}>${ship.name}</option>`;
                        });
                        shipSelect += `</select>`;

                        tds.eq(0).html(shipSelect);
                        tds.eq(1).html(`<input type='date' class='form-control form-control-sm' value="${arrival}" name='arrival_date' required>`);
                        tds.eq(2).html(`<input type='date' class='form-control form-control-sm' value="${docking}" name='docking_date' required>`);
                        tds.eq(3).html(`<input type='date' class='form-control form-control-sm' value="${endUnload}" name='end_unloading' required>`);
                        tds.eq(4).html(`
                            <select class='form-control form-control-sm' name='status' required>
                                <option value='scheduled' ${status==='scheduled'?'selected':''}>Prévu</option>
                                <option value='in_progress' ${status==='in_progress'?'selected':''}>En cours</option>
                                <option value='completed' ${status==='completed'?'selected':''}>Terminé</option>
                                <option value='canceled' ${status==='canceled'?'selected':''}>Annulé</option>
                            </select>
                        `);
                        tds.eq(5).html(`
                            <button class="btn btn-success btn-save-edit" title="Valider"><i class="fas fa-check"></i></button>
                            <button class="btn btn-secondary btn-cancel-edit" title="Annuler"><i class="fas fa-times"></i></button>
                        `);
                    });

                    // Annuler édition
                    $('#agenciesTable').on('click', '.btn-cancel-edit', function() {
                        const row = $(this).closest('tr');
                        table.row(row).invalidate().draw(false);
                        row.removeClass('editing');
                    });

                    // Sauvegarder édition AJAX
                    $('#agenciesTable').on('click', '.btn-save-edit', function() {
                        const row = $(this).closest('tr');
                        const tds = row.find('td');
                        const id = row.data('travel-id'); // Correction ici !
                        const shipId = tds.eq(0).find('select').val();
                        const shipName = shipsList.find(s => s.id == shipId)?.name || '';
                        const arrival = tds.eq(1).find('input').val();
                        const docking = tds.eq(2).find('input').val();
                        const endUnload = tds.eq(3).find('input').val();
                        const status = tds.eq(4).find('select').val();
                        const token = $('meta[name="csrf-token"]').attr('content') || $("input[name='_token']").val();

                        $.ajax({
                            url: `/travels/${id}`,
                            type: 'POST',
                            data: {
                                _token: token,
                                _method: 'PUT',
                                ship_id: shipId,
                                arrival_date: arrival,
                                docking_date: docking,
                                end_unloading: endUnload,
                                status: status
                            },
                            success: function(response) {
                                // Met à jour la ligne avec les nouvelles valeurs
                                tds.eq(0).html(shipName).attr('data-ship-id', shipId);
                                tds.eq(1).html(arrival);
                                tds.eq(2).html(docking);
                                tds.eq(3).html(endUnload);
                                tds.eq(4).html(status);
                                tds.eq(5).html(`
                                    <div class="action-buttons d-flex justify-content-end gap-2">
                                        <a href="/travels/${id}" class="action-btn btn-view" style="text-decoration: none;" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="action-btn btn-update" title="Modifier" type="button">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="/travels/${id}" method="POST" style="display:inline;">
                                            <input type="hidden" name="_token" value="${token}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="action-btn btn-delete" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                `);
                                row.removeClass('editing');
                                showNotification('Voyage modifié avec succès', 'success');
                            },
                            error: function(xhr) {
                                let errorMessage = 'Erreur lors de la modification du voyage';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                } else if (xhr.statusText) {
                                    errorMessage += `: ${xhr.statusText}`;
                                }
                                showNotification(errorMessage, 'danger');
                            }
                        });
                    });
                });
            </script>

            @endsection