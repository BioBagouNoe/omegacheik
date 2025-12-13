@extends('layouts.master')

@section('title', 'Navire - Gestion de Parc Automobile')

@section('content')
<style>
    /* Style pour les notifications */
    .alert-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        min-width: 300px;
        z-index: 1100;
        opacity: 0.95;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }

    /* Animation de clignotement */
    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    .alert-blink {
        animation: blink 1s infinite;
    }
</style>
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
            <!-- DataTable -->
            <!-- DataTable -->
            <div class="datatable-card">
                <div class="datatable-header">
                    <h3 class="datatable-title">Navires</h3>
                    <div class="datatable-actions">
                        <button class="action-btn btn-add" id="addNavireBtn">
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

                <table id="naviresTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nom du navire</th>
                            <th>Ligne</th>
                            <th class="text-end">Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($ships) && count($ships) > 0)
                        @foreach($ships as $ship)
                        <tr data-id="{{$ship->id}}">
                            <td>
                                <span class="ship-name-text">{{$ship->name_nav}}</span>
                                <input type="text" class="form-control ship-name-input d-none"
                                    value="{{$ship->name_nav}}" />
                            </td>
                            <td>
                                <span class="ship-line-text">{{$ship->line ? $ship->line->name_line : ''}}</span>
                                <select class="form-control ship-line-select d-none">
                                    @foreach($lines as $line)
                                    <option value="{{$line->id}}" @if($ship->line && $ship->line->id == $line->id)
                                        selected @endif>{{$line->name_line}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <div class="action-buttons d-flex justify-content-end gap-2">
                                    <a href="#" class="action-btn btn-view" title="Voir" style="text-decoration: none;">
                                        <i class="fas fa-eye"></i></a>
                                    <button class="action-btn btn-update" title="Modifier"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="action-btn btn-save d-none" title="Enregistrer"><i
                                            class="fas fa-check"></i></button>
                                    <button class="action-btn btn-cancel d-none" title="Annuler"><i
                                            class="fas fa-times"></i></button>
                                    <button class="action-btn btn-delete" title="Supprimer"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4" class="text-center">Aucun navire trouvé.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
<!-- Add navire Modal -->
<!-- Modal d'ajout de véhicule -->
<div class="modal" id="addNavireModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Ajouter un navire</h3>
            <button class="modal-close" id="closeModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="navireForm" action="{{ route('ships.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Nom du navire et Ligne -->
                <div class="form-row d-flex gap-3 mb-3">
                    <div class="form-group flex-fill">
                        <label class="form-label" for="name_nav">Nom du navire</label>
                        <input type="text" class="form-control" id="name_nav" name="name_nav" required>
                    </div>

                    <div class="form-group flex-fill">
                        <label class="form-label" for="id_line">Ligne</label>
                        <select class="form-control" id="id_line" name="line_id" required>
                            <option value="">Sélectionner une ligne</option>
                            @if(isset($lines) && count($lines) > 0)
                            @foreach($lines as $line)
                            <option value="{{$line->id}}">{{$line->name_line}}</option>
                            @endforeach
                            @endif
                        </select>
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
    const addNavireModal = document.getElementById('addNavireModal');
    const addNavireBtn = document.getElementById('addNavireBtn'); // existe dans la page
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const saveBtn = document.getElementById('saveBtn');

    if (addNavireBtn) {
        // s'assurer que le bouton d'ouverture ne soumet pas si dans un form parent
        addNavireBtn.setAttribute('type', 'button');
        addNavireBtn.addEventListener('click', function() {
            addNavireModal.classList.add('active');
        });
    }

    function closeModal() {
        addNavireModal.classList.remove('active');
        const f = document.getElementById('navireForm');
        if (f) f.reset();
    }

    // Fonction utilitaire pour afficher les notifications
    function showNotification(message, type = 'success') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-notification alert-blink`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        // Ajouter la notification au corps du document
        document.body.appendChild(alertDiv);

        // Désactiver le clignotement après 3 secondes
        setTimeout(() => {
            alertDiv.classList.remove('alert-blink');
        }, 3000);

        // Supprimer la notification après 5 secondes
        setTimeout(() => {
            $(alertDiv).alert('close');
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.parentNode.removeChild(alertDiv);
                }
            }, 150);
        }, 5000);
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
            e.preventDefault(); // empêche tout submit par défaut
            const form = document.getElementById('navireForm');
            if (!form) return;

            if (form.checkValidity()) {
                // feedback UI
                const originalHtml = saveBtn.innerHTML;
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
                saveBtn.disabled = true;

                // Créer un objet FormData à partir du formulaire
                const formData = new FormData(form);
                
                // Récupérer le token CSRF
                const token = document.querySelector('meta[name="csrf-token"]')?.content;
                
                // Envoyer la requête
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                    .then(async response => {
                        // si erreur 422 ou autre on récupère le JSON (si fourni)
                        const text = await response.text();
                        let data = {};
                        try {
                            data = JSON.parse(text);
                        } catch (err) {
                            data = {};
                        }

                        if (!response.ok) {
                            // si le serveur envoie des erreurs de validation
                            if (data && data.errors) {
                                // afficher erreurs côté client (simple)
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
                        // Notification visuelle
                        const msg = document.createElement('div');
                        msg.textContent = 'Agence ajoutée avec succès !';
                        msg.style.display = 'block';
                        msg.style.position = 'fixed';
                        msg.style.top = '20px';
                        msg.style.left = '50%';
                        msg.style.transform = 'translateX(-50%)';
                        msg.style.background = '#22c55e';
                        msg.style.color = '#fff';
                        msg.style.padding = '10px 30px';
                        msg.style.borderRadius = '6px';
                        msg.style.zIndex = '9999';
                        msg.style.fontWeight = 'bold';
                        msg.style.boxShadow = '0 2px 8px rgba(0,0,0,0.08)';
                        document.body.appendChild(msg);
                        setTimeout(() => {
                            msg.remove();
                        }, 3000);

                        closeModal();

                        // Supprime la ligne "Aucune agency pour le moment." s'il y en a une
                        const table = document.getElementById('naviresTable').getElementsByTagName('tbody')[0];
                        const emptyRow = table ? table.querySelector('tr td[colspan]') : null;
                        if (emptyRow) {
                            emptyRow.parentElement.remove();
                        }

                        // Ajout dynamique dans le tableau avec DataTables
                        if (data.success && data.navire) {
                            const table = $('#naviresTable').DataTable();
                            
                            // Créer la nouvelle ligne avec la structure attendue
                            const newRow = [
                                // Nom du navire
                                `
                                <span class="ship-name-text">${data.navire.name_nav}</span>
                                <input type="text" class="form-control ship-name-input d-none" value="${data.navire.name_nav}" />
                                `,
                                // Ligne
                                `
                                <span class="ship-line-text">${data.line ? data.line.name_line : ''}</span>
                                <select class="form-control ship-line-select d-none">
                                    ${$('#line_id').find('option').map((i, el) => 
                                        `<option value="${el.value}" ${el.value == data.navire.line_id ? 'selected' : ''}>${el.text}</option>`
                                    ).get().join('')}
                                </select>
                                `,
                                // Actions
                                `
                                <div class="action-buttons d-flex justify-content-end gap-2">
                                    <a href="#" class="action-btn btn-view" title="Voir" style="text-decoration: none;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="action-btn btn-update" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn btn-save d-none" title="Enregistrer">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="action-btn btn-cancel d-none" title="Annuler">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button class="action-btn btn-delete" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                `
                            ];

                            // Ajouter la nouvelle ligne à DataTables
                            const rowNode = table.row.add(newRow).draw(false).node();
                            $(rowNode).attr('data-id', data.navire.id);
                            
                            // Supprimer le message 'Aucun navire trouvé' s'il existe
                            const emptyRow = table.rows().nodes().to$().filter('td.dataTables_empty').parent();
                            if (emptyRow.length) {
                                emptyRow.remove();
                            }
                            
                            // Afficher la notification de succès
                            showNotification('Le navire a été ajouté avec succès', 'success');
                            
                            // Fermer le modal
                            closeModal();
                            
                            // Recharger la page pour afficher le nouveau navire
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }


                    })
                    .catch(error => {
                        // Afficher la notification d'erreur
                        showNotification('Une erreur est survenue lors de l\'ajout du navire', 'danger');
                        
                        // Restaurer le bouton
                        saveBtn.innerHTML = 'Enregistrer';
                        saveBtn.disabled = false;
                        
                        // Log dans la console pour debug
                        console.error(error);
                    });
            } else {
                alert('Veuillez remplir tous les champs obligatoires.');
            }
        });
    }

    // Gestion des boutons d'édition
    $(document).on('click', '.btn-update', function() {
        const row = $(this).closest('tr');
        row.find('.ship-name-text, .ship-line-text').addClass('d-none');
        row.find('.ship-name-input, .ship-line-select').removeClass('d-none');
        row.find('.btn-update, .btn-delete').addClass('d-none');
        row.find('.btn-save, .btn-cancel').removeClass('d-none');
    });

    // Gestion du bouton d'annulation
    $(document).on('click', '.btn-cancel', function() {
        const row = $(this).closest('tr');
        row.find('.ship-name-text, .ship-line-text').removeClass('d-none');
        row.find('.ship-name-input, .ship-line-select').addClass('d-none');
        row.find('.btn-save, .btn-cancel').addClass('d-none');
        row.find('.btn-update, .btn-delete').removeClass('d-none');
    });

    // Gestion de l'enregistrement des modifications
    $(document).on('click', '.btn-save', function() {
        const row = $(this).closest('tr');
        const shipId = row.data('id');
        const name = row.find('.ship-name-input').val();
        const lineId = row.find('.ship-line-select').val();
        const saveBtn = row.find('.btn-save');
        
        // Afficher le loader
        const originalHtml = saveBtn.html();
        saveBtn.html('<i class="fas fa-spinner fa-spin"></i>');
        saveBtn.prop('disabled', true);

        // Envoyer la requête de mise à jour
        $.ajax({
            url: `/ships/${shipId}`,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                name_nav: name,
                line_id: lineId
            },
            success: function(response) {
                if (response.success) {
                    // Mettre à jour les valeurs affichées
                    row.find('.ship-name-text').text(name);
                    row.find('.ship-line-text').text(row.find('.ship-line-select option:selected').text());
                    
                    // Réinitialiser l'interface
                    row.find('.ship-name-text, .ship-line-text').removeClass('d-none');
                    row.find('.ship-name-input, .ship-line-select').addClass('d-none');
                    row.find('.btn-save, .btn-cancel').addClass('d-none');
                    row.find('.btn-update, .btn-delete').removeClass('d-none');
                    
                    // Afficher la notification de succès
                    showNotification('Le navire a été mis à jour avec succès', 'success');
                }
            },
            error: function(xhr) {
                // Afficher la notification d'erreur
                showNotification('Une erreur est survenue lors de la mise à jour du navire', 'danger');
                
                console.error(xhr);
            },
            complete: function() {
                saveBtn.html(originalHtml);
                saveBtn.prop('disabled', false);
            }
        });
    });

    // Gestion de la suppression
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const row = $(this).closest('tr');
        const shipId = row.data('id');
        const deleteBtn = $(this);
        const shipName = row.find('.ship-name-text').text();
        
        // Désactiver le bouton pour éviter les clics multiples
        deleteBtn.prop('disabled', true);
        const originalHtml = deleteBtn.html();
        deleteBtn.html('<i class="fas fa-spinner fa-spin"></i>');

        // Afficher une confirmation avant de supprimer
        if (!confirm(`Êtes-vous sûr de vouloir supprimer le navire "${shipName}" ?`)) {
            deleteBtn.html(originalHtml);
            deleteBtn.prop('disabled', false);
            return;
        }

        // Réactiver le bouton après la confirmation
        deleteBtn.html(originalHtml);
        deleteBtn.prop('disabled', false);

        // Envoyer la requête de suppression
        $.ajax({
            url: `/ships/${shipId}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Supprimer la ligne du tableau
                    row.fadeOut(400, function() {
                        row.remove();
                        // Si le tableau est vide, afficher un message
                        if ($('#naviresTable tbody tr').length === 0) {
                            $('#naviresTable tbody').html('<tr><td colspan="3" class="text-center">Aucun navire trouvé.</td></tr>');
                        }
                    });
                    
                    // Afficher la notification de succès
                    showNotification('Le navire a été supprimé avec succès', 'success');
                }
            },
            error: function(xhr) {
                // Afficher la notification d'erreur
                showNotification('Une erreur est survenue lors de la suppression du navire', 'danger');
                console.error(xhr);
            },
            complete: function() {
                // Réactiver le bouton
                deleteBtn.html(originalHtml);
                deleteBtn.prop('disabled', false);
            }
        });
    });

    // Initialize DataTable
    $(document).ready(function() {
        const table = $('#naviresTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            },
            "pageLength": 10,
            "responsive": true,
            "order": [
                [0, "asc"]
            ],
            "dom": '<"datatable-controls"<"datatable-length"l><"datatable-filter"f>>t<"datatable-info"i><"datatable-paging"p>',
            "columns": [
                { "name": "name_nav", "orderable": true, "searchable": true },
                { "name": "line", "orderable": true, "searchable": true },
                { 
                    "name": "actions", 
                    "orderable": false, 
                    "searchable": false,
                    "className": "text-end"
                }
            ],
            "columnDefs": [{
                targets: -1,
                orderable: false,
                searchable: false
            }]
        });

        // Button Actions (export/import/filter) - inchangés
        document.querySelectorAll('.btn-export, .btn-import, .btn-filter').forEach(btn => {
            if (!btn) return;
        });

        // Table Action Buttons
        $('#naviresTable').on('click', '.btn-view', function() {
            const row = $(this).closest('tr');
            const rowData = table.row(row).data();
            alert(`Affichage des détails pour ${rowData[0]} (${rowData[1]})`);
        });

        $('#naviresTable').on('click', '.btn-delete', function() {
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
</script>


@endsection