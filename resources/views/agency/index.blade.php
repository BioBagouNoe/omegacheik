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
                @include('components.table_agency')
            </section>
        </main>
    </div>
    <!-- Add Agency Modal -->
    @include('components.agency-modal')

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
                    setTimeout(() => { msg.remove(); }, 3000);
                    closeModal();
                    // Ajout dynamique dans le tableau sans reload
                    if (data.agency) {
                        const table = document.getElementById('agenciesTable').getElementsByTagName('tbody')[0];
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
