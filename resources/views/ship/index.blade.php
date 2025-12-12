@extends('layouts.master')

@section('title', 'Navire - Gestion de Parc Automobile')

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

                            <th>ID</th>
                            <th>Nom du navire</th>
                            <th>Ligne</th>
                            <th class="text-end">Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($ships) && count($ships) > 0)
                        @foreach($ships as $ship)
                        <tr data-id="{{$ship->id}}">
                            <td>{{$ship->id}}</td>
                            <td>
                                <span class="ship-name-text">{{$ship->name_nav}}</span>
                                <input type="text" class="form-control ship-name-input d-none" value="{{$ship->name_nav}}" />
                            </td>
                            <td>
                                <span class="ship-line-text">{{$ship->line ? $ship->line->name_line : ''}}</span>
                                <select class="form-control ship-line-select d-none">
                                    @foreach($lines as $line)
                                    <option value="{{$line->id}}" @if($ship->line && $ship->line->id == $line->id) selected @endif>{{$line->name_line}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <div class="action-buttons d-flex justify-content-end gap-2">
                                    <a href="#" class="action-btn btn-view" title="Voir" style="text-decoration: none;"> <i class="fas fa-eye"></i></a>
                                    <button class="action-btn btn-update" title="Modifier"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn btn-save d-none" title="Enregistrer"><i class="fas fa-check"></i></button>
                                    <button class="action-btn btn-cancel d-none" title="Annuler"><i class="fas fa-times"></i></button>
                                    <button class="action-btn btn-delete" title="Supprimer"><i class="fas fa-trash"></i></button>
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
<!-- Add Agency Modal -->
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
                <form id="navireForm">

                    <!-- Nom du navire et Ligne -->
                    <div class="form-row d-flex gap-3 mb-3">

                        <div class="form-group flex-fill">
                            <label class="form-label" for="name_nav">Nom du navire</label>
                            <input type="text" class="form-control" id="name_nav" required>
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
    const addAgencyModal = document.getElementById('addNavireModal');
    const addAgencyBtn = document.getElementById('addNavireBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const saveBtn = document.getElementById('saveBtn');

    addAgencyBtn.addEventListener('click', function() {
        addAgencyModal.classList.add('active');
    });

    function closeModal() {
        addAgencyModal.classList.remove('active');
        document.getElementById('navireForm').reset();
    }

    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    saveBtn.addEventListener('click', function() {
        // Ici, vous ajouteriez la logique pour sauvegarder navire
        const form = document.getElementById('navireForm');
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
        $('#naviresTable').on('click', '.btn-view', function() {
            const row = $(this).closest('tr');
            const rowData = table.row(row).data();
            alert(`Affichage des détails pour ${rowData[0]} (${rowData[1]})`);
        });

        $('#naviresTable').on('click', '.btn-update', function() {
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

        $('#naviresTable').on('click', '.btn-reset', function() {
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