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
                @include('components.table_line')


            </section>
        </main>
    </div>

    <!-- Modal d'ajout de manifeste -->
    @include('components.line-modal')

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
