@extends('layouts.master')

@section('title', 'Agence - Gestion de Parc Automobile')

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
                            <th>Nom de l'agence</th>
                            <th>Ligne</th>
                            <th>Pays</th>
                            <th>Adresse</th>
                            <th class="d-flex justify-content-end gap-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div id="agency-import-errors" style="display:none; margin-bottom:10px; color:#dc2626; font-weight:bold;"></div>
                        @forelse($agencies as $agency)
                        <tr data-agency-id="{{ $agency->id }}">
                            <td>
                                <span class="agency-name-text">{{ $agency->name_agency }}</span>
                                <input type="text" class="form-control agency-name-input" value="{{ $agency->name_agency }}" style="display:none; width: 80%;" />
                            </td>
                            <td>
                                <span class="agency-line-text">{{ $agency->line->name_line ?? '' }}</span>
                                <select class="form-control agency-line-select" style="display:none; width: 80%;">
                                    @foreach(App\Models\Line::all() as $line)
                                    <option value="{{ $line->id }}" @if($agency->line_id == $line->id) selected @endif>{{ $line->name_line }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <span class="agency-pays-text">{{ $agency->pays->nom ?? '' }}</span>
                                <select class="form-control agency-pays-select" style="display:none; width: 80%;">
                                    <option value="">Aucun pays</option>
                                    @foreach(App\Models\Pays::all() as $pays)
                                    <option value="{{ $pays->id }}" @if($agency->pays_id == $pays->id) selected @endif>{{ $pays->nom }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <span class="agency-adress-text">{{ $agency->adress_agency }}</span>
                                <input type="text" class="form-control agency-adress-input" value="{{ $agency->adress_agency }}" style="display:none; width: 80%;" />
                            </td>
                            <td>
                                <div class="action-buttons d-flex justify-content-end gap-2">
                                    <a href="{{ route('agencies.show', $agency) }}" class="action-btn btn-view" style="text-decoration: none;" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="action-btn btn-update" title="Modifier" type="button">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn btn-validate" title="Valider" style="display:none;">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <form action="{{ route('agencies.destroy', $agency) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="action-btn btn-delete" title="Supprimer" data-agency-id="{{ $agency->id }}" data-agency-name="{{ $agency->name_agency }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucune agency pour le moment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <div id="agency-success-msg" style="display:none;position:fixed;top:20px;left:50%;transform:translateX(-50%);background:#22c55e;color:#fff;padding:10px 30px;border-radius:6px;z-index:9999;font-weight:bold;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                        Modification effectuée avec succès !
                    </div>
                    <script>
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
                                    tr.querySelector('.btn-cancel').style.display = 'inline-block';
                                });
                            });

                            // Gestion de l'annulation de la modification
                            document.querySelectorAll('.btn-cancel').forEach(function(cancelBtn) {
                                cancelBtn.addEventListener('click', function() {
                                    const tr = cancelBtn.closest('tr');
                                    
                                    // Récupérer les valeurs d'origine
                                    const nameText = tr.querySelector('.agency-name-text').textContent;
                                    const lineText = tr.querySelector('.agency-line-text').textContent;
                                    const paysText = tr.querySelector('.agency-pays-text').textContent;
                                    const adressText = tr.querySelector('.agency-adress-text').textContent;
                                    
                                    // Réinitialiser les champs de formulaire
                                    const nameInput = tr.querySelector('.agency-name-input');
                                    const lineSelect = tr.querySelector('.agency-line-select');
                                    const paysSelect = tr.querySelector('.agency-pays-select');
                                    const adressInput = tr.querySelector('.agency-adress-input');
                                    
                                    if (nameInput) nameInput.value = nameText;
                                    if (lineSelect) {
                                        // Trouver l'option correspondant au texte affiché
                                        for (let i = 0; i < lineSelect.options.length; i++) {
                                            if (lineSelect.options[i].text === lineText) {
                                                lineSelect.selectedIndex = i;
                                                break;
                                            }
                                        }
                                    }
                                    if (paysSelect) {
                                        // Trouver l'option correspondant au texte affiché
                                        for (let i = 0; i < paysSelect.options.length; i++) {
                                            if (paysSelect.options[i].text === paysText) {
                                                paysSelect.selectedIndex = i;
                                                break;
                                            }
                                        }
                                    }
                                    if (adressInput) adressInput.value = adressText;
                                    
                                    // Revenir à l'affichage normal
                                    tr.querySelectorAll('.agency-name-text, .agency-line-text, .agency-pays-text, .agency-adress-text')
                                        .forEach(el => el.style.display = '');
                                    tr.querySelectorAll('.agency-name-input, .agency-line-select, .agency-pays-select, .agency-adress-input')
                                        .forEach(el => el.style.display = 'none');
                                    
                                    // Cacher les boutons de validation/annulation et afficher le bouton de modification
                                    tr.querySelectorAll('.btn-validate, .btn-cancel').forEach(btn => btn.style.display = 'none');
                                    tr.querySelector('.btn-update').style.display = '';
                                    
                                    // Afficher un message d'information
                                    showNotification('Modification annulée', 'info');
                                });
                            });

                            // Gestion de la validation de la modification
                            document.querySelectorAll('.btn-validate').forEach(function(validateBtn) {
                                validateBtn.addEventListener('click', function() {
                                    const tr = validateBtn.closest('tr');
                                    const agencyId = tr.getAttribute('data-agency-id');
                                    const nameInput = tr.querySelector('.agency-name-input');
                                    const lineSelect = tr.querySelector('.agency-line-select');
                                    const paysSelect = tr.querySelector('.agency-pays-select');
                                    const adressInput = tr.querySelector('.agency-adress-input');

                                    const name = nameInput ? nameInput.value.trim() : '';
                                    const lineId = lineSelect ? lineSelect.value : '';
                                    const paysId = paysSelect ? paysSelect.value : '';
                                    const adress = adressInput ? adressInput.value.trim() : '';

                                    // Vérifier que les champs obligatoires sont remplis
                                    if (!name) {
                                        showNotification('Le nom de l\'agence est obligatoire', 'danger');
                                        return;
                                    }

                                    // Désactiver le bouton pendant la requête
                                    const originalHtml = validateBtn.innerHTML;
                                    validateBtn.disabled = true;
                                    validateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                                    // Envoyer les données au format FormData pour une meilleure compatibilité
                                    const formData = new FormData();
                                    formData.append('_method', 'PUT');
                                    formData.append('name_agency', name);
                                    formData.append('line_id', lineId);
                                    formData.append('pays_id', paysId);
                                    formData.append('adress_agency', adress);

                                    // Utiliser jQuery.ajax pour une meilleure gestion des erreurs
                                    $.ajax({
                                        url: `/agencies/${agencyId}`,
                                        type: 'POST',
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                            'X-Requested-With': 'XMLHttpRequest'
                                        },
                                        success: function(response) {
                                            if (response && response.success) {
                                                // Mettre à jour les champs texte
                                                const nameText = tr.querySelector('.agency-name-text');
                                                const lineText = tr.querySelector('.agency-line-text');
                                                const paysText = tr.querySelector('.agency-pays-text');
                                                const adressText = tr.querySelector('.agency-adress-text');

                                                if (nameText) nameText.textContent = name;
                                                if (lineText) lineText.textContent = lineSelect ? lineSelect.options[lineSelect.selectedIndex].text : '';
                                                if (paysText) paysText.textContent = paysSelect ? paysSelect.options[paysSelect.selectedIndex].text : '';
                                                if (adressText) adressText.textContent = adress;

                                                // Afficher les champs texte et cacher les champs de formulaire
                                                tr.querySelectorAll('.agency-name-text, .agency-line-text, .agency-pays-text, .agency-adress-text')
                                                    .forEach(el => el.style.display = '');
                                                tr.querySelectorAll('.agency-name-input, .agency-line-select, .agency-pays-select, .agency-adress-input')
                                                    .forEach(el => el.style.display = 'none');

                                                // Mettre à jour les data-attributes si nécessaire
                                                tr.setAttribute('data-line-id', lineId);
                                                tr.setAttribute('data-pays-id', paysId);

                                                // Cacher les boutons de validation/annulation et afficher le bouton de modification
                                                tr.querySelectorAll('.btn-validate, .btn-cancel').forEach(btn => btn.style.display = 'none');
                                                tr.querySelector('.btn-update').style.display = '';

                                                // Afficher un message de succès
                                                showNotification('Agence mise à jour avec succès', 'success');
                                            } else {
                                                throw new Error('Réponse invalide du serveur');
                                            }
                                        },
                                        error: function(xhr) {
                                            let errorMessage = 'Une erreur est survenue lors de la mise à jour';
                                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                                errorMessage = xhr.responseJSON.message;
                                            } else if (xhr.statusText) {
                                                errorMessage += `: ${xhr.statusText}`;
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
        </section>
    </main>
</div>

<!-- Add Agency Modal -->
<!-- Modal d'ajout de véhicule -->
<div class="modal" id="addAgencyModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Ajouter une agence</h3>
            <!-- type="button" ajouté pour éviter un submit accidentel -->
            <button type="button" class="modal-close" id="closeModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="agencyForm" action="{{ route('agencies.store') }}" method="POST">
                @csrf
                <!-- Nom de l’agence, Ligne et Pays -->
                <div class="form-row d-flex gap-2 mb-3">
                    <div class="form-group flex-fill">
                        <label class="form-label" for="name_agency">Nom de l’agence</label>
                        <input type="text" class="form-control" id="name_agency" name="name_agency" required>
                    </div>
                    <div class="form-group flex-fill">
                        <label class="form-label" for="line_id">Ligne</label>
                        <select class="form-control" id="line_id" name="line_id" required>
                            <option value="">Sélectionner une ligne</option>
                            @foreach(App\Models\Line::all() as $line)
                            <option value="{{ $line->id }}">{{ $line->name_line }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row d-flex gap-2 mb-3">
                    <div class="form-group flex-fill">
                        <label class="form-label" for="adress_agency">Adresse de l’agence</label>
                        <input type="text" class="form-control" id="adress_agency" name="adress_agency" required>
                    </div>
                    <div class="form-group flex-fill">
                        <label class="form-label" for="pays_id">Pays</label>
                        <select class="form-control" id="pays_id" name="pays_id" required>
                            <option value="">Sélectionner un pays</option>
                            @foreach(App\Models\Pays::all() as $pays)
                            <option value="{{ $pays->id }}">{{ $pays->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- type="button" pour empêcher le submit automatique -->
                    <button type="button" class="btn btn-secondary" id="cancelBtn">Annuler</button>
                    <!-- type="button" car on utilise fetch() pour envoyer -->
                    <button type="button" class="btn btn-primary" id="saveBtn">Enregistrer</button>
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
        alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-notification alert-blink`;
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
            e.preventDefault(); // empêche tout submit par défaut
            const form = document.getElementById('agencyForm');
            if (!form) return;

            if (form.checkValidity()) {
                // feedback UI
                const originalHtml = saveBtn.innerHTML;
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
                saveBtn.disabled = true;

                const formData = new FormData(form);
                // token CSRF
                const token = form.querySelector('input[name="_token"]')?.value || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                // IMPORTANT: ne pas définir Content-Type si on envoie FormData
                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(async response => {
                        // si erreur 422 ou autre on récupère le JSON (si fourni)
                        const text = await response.text();
                        let data = {};
                        try { data = JSON.parse(text); } catch (err) { data = {}; }

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
                        // Afficher la notification de succès
                        showNotification('Agence ajoutée avec succès !', 'success');
                        
                        // Fermer le modal
                        closeModal();

                        // Supprime la ligne "Aucune agency pour le moment." s'il y en a une
                        const table = document.getElementById('agenciesTable').getElementsByTagName('tbody')[0];
                        const emptyRow = table ? table.querySelector('tr td[colspan]') : null;
                        if (emptyRow) {
                            emptyRow.parentElement.remove();
                        }

                        // Ajout dynamique dans le tableau sans reload (si le controller renvoie data.agency)
                        if (data && data.agency && table) {
                            const newRow = document.createElement('tr');
                            newRow.setAttribute('data-agency-id', data.agency.id);
                            newRow.innerHTML = `
                                <td>${data.agency.id}</td>
                                <td>
                                    <span class='agency-name-text'>${data.agency.name_agency}</span>
                                    <input type='text' class='form-control agency-name-input' value='${data.agency.name_agency}' style='display:none; width: 80%;' />
                                </td>
                                <td>
                                    <span class='agency-line-text'></span>
                                    <select class='form-control agency-line-select' style='display:none; width: 80%;'>
                                        ${document.getElementById('line_id') ? document.getElementById('line_id').innerHTML : ''}
                                    </select>
                                </td>
                                <td>
                                    <span class='agency-pays-text'></span>
                                </td>
                                <td>
                                    <span class='agency-adress-text'>${data.agency.adress_agency || ''}</span>
                                    <input type='text' class='form-control agency-adress-input' value='${data.agency.adress_agency || ''}' style='display:none; width: 80%;' />
                                </td>
                                <td>
                                    <div class='action-buttons d-flex justify-content-end gap-2'>
                                        <a href='/agencies/${data.agency.id}' class='action-btn btn-view' style='text-decoration: none;' title='Voir'>
                                            <i class='fas fa-eye'></i>
                                        </a>
                                        <button class='action-btn btn-update' title='Modifier' type='button'>
                                            <i class='fas fa-edit'></i>
                                        </button>
                                        <button class='action-btn btn-validate' title='Valider' style='display:none;'>
                                            <i class='fas fa-check'></i>
                                        </button>
                                        <form action='/agencies/${data.agency.id}' method='POST' style='display:inline;'>
                                            <input type='hidden' name='_token' value='${form.querySelector('input[name="_token"]').value}'>
                                            <input type='hidden' name='_method' value='DELETE'>
                                            <button type='submit' class='action-btn btn-delete' title='Supprimer' onclick='return confirm("Voulez-vous vraiment supprimer cette agence ?")'>
                                                <i class='fas fa-trash'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            `;
                            table.appendChild(newRow);
                        }
                    })
                    .catch(error => {
                        // Afficher la notification d'erreur
                        showNotification('Une erreur est survenue lors de l\'ajout de l\'agence', 'danger');
                        
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

    // Gestion de la suppression avec confirmation et feedback visuel
    $(document).on('click', '.btn-delete', function() {
        const button = $(this);
        const agencyId = button.data('agency-id');
        const agencyName = button.data('agency-name');
        const row = button.closest('tr');
        
        // Afficher une confirmation avant de supprimer
        if (!confirm(`Êtes-vous sûr de vouloir supprimer l'agence "${agencyName}" ?`)) {
            return;
        }
        
        // Désactiver le bouton pour éviter les clics multiples
        const originalHtml = button.html();
        button.html('<i class="fas fa-spinner fa-spin"></i>');
        button.prop('disabled', true);
        
        // Créer un objet FormData pour l'envoi
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'DELETE');
        
        // Envoyer la requête de suppression
        $.ajax({
            url: `/agencies/${agencyId}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response && response.success) {
                    // Supprimer la ligne du tableau avec une animation
                    row.fadeOut(400, function() {
                        row.remove();
                        // Si le tableau est vide, afficher un message
                        if ($('#agenciesTable tbody tr').length === 0) {
                            $('#agenciesTable tbody').html('<tr><td colspan="5" class="text-center">Aucune agence trouvée.</td></tr>');
                        }
                        // Afficher la notification de succès après l'animation
                        showNotification('L\'agence a été supprimée avec succès', 'success');
                    });
                } else {
                    throw new Error('Réponse invalide du serveur');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Une erreur est survenue lors de la suppression de l\'agence';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.statusText) {
                    errorMessage += `: ${xhr.statusText}`;
                }
                
                // Afficher la notification d'erreur
                showNotification(errorMessage, 'danger');
                console.error('Erreur lors de la suppression :', xhr);
                
                // Réactiver le bouton en cas d'erreur
                button.html(originalHtml);
                button.prop('disabled', false);
            }
        });
    });

    // Initialize DataTable
    $(document).ready(function() {
        const table = $('#agenciesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            },
            "pageLength": 10,
            "responsive": true,
            "order": [
                [0, "asc"]
            ],
            "dom": '<"datatable-controls"<"datatable-length"l><"datatable-filter"f>>t<"datatable-info"i><"datatable-paging"p>',
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
        $('#agenciesTable').on('click', '.btn-view', function() {
            const row = $(this).closest('tr');
            const rowData = table.row(row).data();
            alert(`Affichage des détails pour ${rowData[0]} (${rowData[1]})`);
        });
    });
</script>

            
@endsection