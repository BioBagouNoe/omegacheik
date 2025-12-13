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
            <form id="navireForm" action="{{ route('ships.store') }}" method="POST">
                @csrf
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

                const formData = new FormData(form);
                // token CSRF
                const token = form.querySelector('input[name="_token"]')?.value || document.querySelector(
                    'meta[name="csrf-token"]')?.getAttribute('content');

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

                        // Ajout dynamique dans le tableau sans reload (si le controller renvoie data.navire)
                        if (data && data.navire && table) {
                            const newRow = document.createElement('tr');
                            newRow.setAttribute('data-navire-id', data.navire.id);
                            newRow.innerHTML = `
          <td>${data.navire.id}</td>
          <td>
              <span class='navire-name-text'>${data.navire.name_nav}</span>
              <input type='text' class='form-control navire-name-input' value='${data.navire.name_nav}' style='display:none; width: 80%;' />
          </td>
          <td>
              <span class='navire-line-text'></span>
              <select class='form-control navire-line-select' style='display:none; width: 80%;'>
                  ${document.getElementById('line_id') ? document.getElementById('line_id').innerHTML : ''}
              </select>
          </td>
          <td>
              <span class='navire-pays-text'></span>
          </td>
          <td>
              <span class='navire-adress-text'>${data.navire.adress_navire || ''}</span>
              <input type='text' class='form-control navire-adress-input' value='${data.navire.adress_navire || ''}' style='display:none; width: 80%;' />
          </td>
          <td>
              <div class='action-buttons d-flex justify-content-end gap-2'>
                  <a href='/agencies/${data.navire.id}' class='action-btn btn-view' style='text-decoration: none;' title='Voir'>
                      <i class='fas fa-eye'></i>
                  </a>
                  <button class='action-btn btn-update' title='Modifier' type='button'>
                      <i class='fas fa-edit'></i>
                  </button>
                  <button class='action-btn btn-validate' title='Valider' style='display:none;'>
                      <i class='fas fa-check'></i>
                  </button>
                  <form action='/agencies/${data.navire.id}' method='POST' style='display:inline;'>
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
                        // Restaurer le bouton et ne pas afficher d'alert intrusive
                        saveBtn.innerHTML = 'Enregistrer';
                        saveBtn.disabled = false;
                        // Optionnel: log dans la console pour debug
                        console.error(error);
                    });
            } else {
                alert('Veuillez remplir tous les champs obligatoires.');
            }
        });
    }

    // Initialize DataTable (laissez comme avant)
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