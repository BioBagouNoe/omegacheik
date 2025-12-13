@extends('layouts.master')

@section('title', 'Lignes - Gestion de Parc Automobile')

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
            <div class="datatable-card">
                <div class="datatable-header">
                    <h3 class="datatable-title">Lignes</h3>
                    <div class="datatable-actions">
                        <button class="action-btn btn-add" id="addLineBtn">
                            <i class="fas fa-plus"></i>
                            Ajouter
                        </button>
                        <form id="importForm" action="{{ route('lines.import') }}" method="POST" enctype="multipart/form-data" style="display:inline;">
                            @csrf
                            <input type="file" id="importFileInput" name="file" accept=".csv,.xlsx,.xls" style="display:none;">
                            <button type="button" class="action-btn btn-import" id="importBtn">
                                <i class="fas fa-upload"></i>
                                Importer
                            </button>
                        </form>
                        <a href="{{ route('lines.export') }}" class="action-btn btn-export">
                            <i class="fas fa-download"></i>
                            Exporter

                        </a>
                        <button class="action-btn btn-filter">
                            <i class="fas fa-filter"></i>
                            Filtrer
                        </button>
                    </div>
                </div>

                <table id="linesTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th class=" d-flex justify-content-end gap-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lines as $line)
                        <tr data-line-id="{{ $line->id }}">
                            <td>
                                <span class="line-name-text">{{ $line->name_line }}</span>
                                <input type="text" class="form-control line-name-input" value="{{ $line->name_line }}" style="display:none; width: 80%;" />
                            </td>
                            <td>
                                <div class="action-buttons d-flex justify-content-end gap-2">
                                    <a href="{{ route('lines.show', $line) }}" class="action-btn btn-view" style="text-decoration: none;" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="action-btn btn-update" title="Modifier" type="button">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn btn-validate" title="Valider" style="display:none;">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <form action="{{ route('lines.destroy', $line) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer cette ligne ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Aucune ligne pour le moment.</td>
                        </tr>
                        @endforelse
                </table>
                <div id="line-success-msg" style="display:none;position:fixed;top:20px;left:50%;transform:translateX(-50%);background:#22c55e;color:#fff;padding:10px 30px;border-radius:6px;z-index:9999;font-weight:bold;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                    Modification effectuée avec succès !
                </div>
                <script>

                    document.addEventListener('DOMContentLoaded', function() {
                        document.querySelectorAll('.btn-update').forEach(function(editBtn) {
                            editBtn.addEventListener('click', function() {
                                const tr = editBtn.closest('tr');
                                tr.querySelector('.line-name-text').style.display = 'none';
                                tr.querySelector('.line-name-input').style.display = 'inline-block';
                                editBtn.style.display = 'none';
                                tr.querySelector('.btn-validate').style.display = 'inline-block';
                            });
                        });

                        document.querySelectorAll('.btn-validate').forEach(function(validateBtn) {
                            validateBtn.addEventListener('click', function() {
                                const tr = validateBtn.closest('tr');
                                const lineId = tr.getAttribute('data-line-id');
                                const input = tr.querySelector('.line-name-input');
                                const newName = input.value;
                                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value;

                                fetch(`/lines/${lineId}`, {
                                        method: 'PUT',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': token,
                                            'Accept': 'application/json',
                                        },
                                        body: JSON.stringify({
                                            name_line: newName
                                        })
                                    })
                                    .then(response => {
                                        if (!response.ok) throw new Error('Erreur lors de la mise à jour');
                                        return response.json();
                                    })
                                    .then(data => {
                                        tr.querySelector('.line-name-text').textContent = newName;
                                        tr.querySelector('.line-name-text').style.display = 'inline';
                                        input.style.display = 'none';
                                        validateBtn.style.display = 'none';
                                        tr.querySelector('.btn-update').style.display = 'inline-block';
                                        // Afficher une notification de succès
                                        if (typeof showNotification === 'function') {
                                            showNotification('Ligne mise à jour avec succès', 'success');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Erreur:', error);
                                        if (typeof showNotification === 'function') {
                                            showNotification('Erreur lors de la mise à jour de la ligne', 'error');
                                        }
                                    });
                            });
                        });
                    });

                    // Gestion de l'import de fichiers
                    const importForm = document.getElementById('importForm');
                    const importBtn = document.getElementById('importBtn');
                    const importInput = document.getElementById('importFileInput');
                    
                    if (importBtn && importInput) {
                        const importText = importBtn.querySelector('.import-text');
                        const importLoading = importBtn.querySelector('.import-loading');
                        
                        // Gestion du clic sur le bouton d'import
                        importBtn.addEventListener('click', function(e) {
                            importInput.click();
                        });
                        
                        // Gestion du changement de fichier
                        importInput.addEventListener('change', function(e) {
                            if (this.files.length > 0) {
                                // Afficher le chargement
                                if (importText) importText.style.display = 'none';
                                if (importLoading) importLoading.style.display = 'inline-block';
                                
                                // Soumettre le formulaire
                                const formData = new FormData(importForm);
                                
                                fetch(importForm.action, {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        showNotification('Import réussi ! ' + (data.message || ''), 'success');
                                        // Recharger la page pour afficher les nouvelles données
                                        window.location.reload();
                                    } else {
                                        showNotification('Erreur lors de l\'import : ' + (data.message || 'Erreur inconnue'), 'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Erreur:', error);
                                    showNotification('Une erreur est survenue lors de l\'import', 'error');
                                })
                                .finally(() => {
                                    // Réinitialiser le champ de fichier
                                    importInput.value = '';
                                    // Cacher le chargement et réafficher le texte
                                    if (importText) importText.style.display = 'inline-block';
                                    if (importLoading) importLoading.style.display = 'none';
                                });
                            }
                        });
                    }
                </script>
                </tbody>
                </table>
            </div>


        </section>
    </main>
</div>

<!-- Modal d'ajout de manifeste -->
    <!-- Modal d'ajout de véhicule -->
    <div class="modal" id="addLineModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter unen ligne</h3>
                <button class="modal-close" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="lineForm" action="{{ route('lines.store') }}" method="POST">
                    @csrf
                    <!-- Nom de la ligne -->
                    <div class="form-row d-flex gap-3 mb-3">
                        <div class="form-group flex-fill">
                            <label class="form-label" for="name_line">Nom de la ligne</label>
                            <input type="text" class="form-control" id="name_line" name="name_line" required>
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

    const addLineModal = document.getElementById('addLineModal');
    const addLineBtn = document.getElementById('addLineBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const saveBtn = document.getElementById('saveBtn');

    addLineBtn.addEventListener('click', function() {
        addLineModal.classList.add('active');
    });

    function closeModal() {
        addLineModal.classList.remove('active');
        document.getElementById('lineForm').reset();
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
        const table = $('#linesTable').DataTable({
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
        $('#linesTable').on('click', '.btn-reset', function() {
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
    });
</script>
@endsection