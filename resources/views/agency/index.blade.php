@extends('layouts.master')

@section('title', 'Agence - Gestion de Parc Automobile')

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
                                        <button type="submit" class="action-btn btn-delete" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer cette agence ?')">
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
                                });
                            });

                            document.querySelectorAll('.btn-validate').forEach(function(validateBtn) {
                                validateBtn.addEventListener('click', function() {
                                    const tr = validateBtn.closest('tr');
                                    const agencyId = tr.getAttribute('data-agency-id');
                                    const nameInput = tr.querySelector('.agency-name-input');
                                    const lineSelect = tr.querySelector('.agency-line-select');
                                    const paysSelect = tr.querySelector('.agency-pays-select');
                                    const newName = nameInput.value;
                                    const newLineId = lineSelect.value;
                                    const newPaysId = paysSelect.value;
                                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value;
                                    let adressInput = tr.querySelector('.agency-adress-input');
                                    let newAdress = adressInput ? adressInput.value : '';

                                    fetch(`/agencies/${agencyId}`, {
                                            method: 'PUT',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': token,
                                                'Accept': 'application/json',
                                            },
                                            body: JSON.stringify({
                                                name_agency: newName,
                                                line_id: newLineId,
                                                pays_id: newPaysId !== '' ? newPaysId : null,
                                                adress_agency: newAdress
                                            })
                                        })
                                        .then(response => {
                                            if (!response.ok) throw new Error('Erreur lors de la mise à jour');
                                            return response.json();
                                        })
                                        .then(data => {
                                            tr.querySelector('.agency-name-text').textContent = newName;
                                            tr.querySelector('.agency-name-text').style.display = 'inline';
                                            nameInput.style.display = 'none';
                                            tr.querySelector('.agency-line-text').textContent = lineSelect.options[lineSelect.selectedIndex].text;
                                            tr.querySelector('.agency-line-text').style.display = 'inline';
                                            lineSelect.style.display = 'none';
                                            tr.querySelector('.agency-pays-text').textContent = paysSelect.options[paysSelect.selectedIndex].text;
                                            tr.querySelector('.agency-pays-text').style.display = 'inline';
                                            paysSelect.style.display = 'none';
                                            if (adressInput) {
                                                tr.querySelector('.agency-adress-text').textContent = newAdress;
                                                tr.querySelector('.agency-adress-text').style.display = 'inline';
                                                adressInput.style.display = 'none';
                                            }
                                            validateBtn.style.display = 'none';
                                            tr.querySelector('.btn-update').style.display = 'inline-block';
                                            // Affiche une notification verte en haut
                                            const msg = document.getElementById('agency-success-msg');
                                            msg.style.display = 'block';
                                            setTimeout(() => {
                                                msg.style.display = 'none';
                                            }, 5000);
                                        })
                                        .catch(error => {
                                            // Ne rien afficher, ni alert, ni message
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
                <button class="modal-close" id="closeModalBtn">
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
                        <button class="btn btn-secondary" id="cancelBtn">Annuler</button>
                        <button class="btn btn-primary" id="saveBtn">Enregistrer</button>
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

    mobileMenuBtn.addEventListener('click', function() {
        sidebar.classList.add('mobile-open');
        mobileOverlay.classList.add('active');
    });

    mobileOverlay.addEventListener('click', function() {
        sidebar.classList.remove('mobile-open');
        mobileOverlay.classList.remove('active');
    });

    // Modal Functionality
    const addAgencyModal = document.getElementById('addAgencyModal');
    const addAgencyBtn = document.getElementById('addAgencyBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const saveBtn = document.getElementById('saveBtn');

    addAgencyBtn.addEventListener('click', function() {
        addAgencyModal.classList.add('active');
    });

    function closeModal() {
        addAgencyModal.classList.remove('active');
        document.getElementById('agencyForm').reset();
    }

    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    saveBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const form = document.getElementById('agencyForm');
        if (form.checkValidity()) {
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
            saveBtn.disabled = true;
            const formData = new FormData(form);
            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erreur lors de l\'ajout');
                    return response.json();
                })
                .then(data => {
                    // Affiche une notification verte en haut
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
                    const table = document.getElementById('agenciesTable').getElementsByTagName('tbody')[0];
                    const emptyRow = table.querySelector('tr td[colspan]');
                    if (emptyRow) {
                        emptyRow.parentElement.remove();
                    }
                    // Ajout dynamique dans le tableau sans reload
                    if (data.agency) {
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
                                    ${document.getElementById('line_id').innerHTML}
                                </select>
                            </td>
                            <td>
                                <span class='agency-pays-text'></span>
                            </td>
                            <td>
                                <span class='agency-adress-text'>${data.agency.adress_agency}</span>
                                <input type='text' class='form-control agency-adress-input' value='${data.agency.adress_agency}' style='display:none; width: 80%;' />
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
                    saveBtn.innerHTML = 'Enregistrer';
                    saveBtn.disabled = false;
                });
        } else {
            alert('Veuillez remplir tous les champs obligatoires.');
        }
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
        $('#agenciesTable').on('click', '.btn-view', function() {
            const row = $(this).closest('tr');
            const rowData = table.row(row).data();
            alert(`Affichage des détails pour ${rowData[0]} (${rowData[1]})`);
        });



        $('#agenciesTable').on('click', '.btn-delete', function() {
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