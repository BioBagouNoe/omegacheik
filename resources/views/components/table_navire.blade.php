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
                <tr data-ship-id="{{$ship->id}}">
                    <td>{{$ship->id}}</td>
                    <td>
                        <span class="ship-name-text">{{$ship->name_nav}}</span>
                        <input type="text" class="form-control ship-name-input" value="{{$ship->name_nav}}" style="display:none; width:80%;" />
                    </td>
                    <td>
                        <span class="ship-line-text">{{$ship->line ? $ship->line->name_line : ''}}</span>
                        <select class="form-control ship-line-select" style="display:none; width:80%;">
                            @foreach($lines as $line)
                                <option value="{{$line->id}}" @if($ship->line && $ship->line->id == $line->id) selected @endif>{{$line->name_line}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <div class="action-buttons d-flex justify-content-end gap-2">
                            <a href="#" class="action-btn btn-view" title="Voir" style="text-decoration: none;"> <i class="fas fa-eye"></i></a>
                            <button class="action-btn btn-update" title="Modifier" type="button"><i class="fas fa-edit"></i></button>
                            <button class="action-btn btn-validate" title="Valider" style="display:none;"><i class="fas fa-check"></i></button>
                            <form action="{{ route('ships.destroy', $ship) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-delete" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce navire ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
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
        <div id="navire-success-msg" style="display:none;position:fixed;top:20px;left:50%;transform:translateX(-50%);background:#22c55e;color:#fff;padding:10px 30px;border-radius:6px;z-index:9999;font-weight:bold;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
            Modification effectuée avec succès !
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edition inline
            document.querySelectorAll('.btn-update').forEach(function(editBtn) {
                editBtn.addEventListener('click', function() {
                    const tr = editBtn.closest('tr');
                    tr.querySelector('.ship-name-text').style.display = 'none';
                    tr.querySelector('.ship-name-input').style.display = 'inline-block';
                    tr.querySelector('.ship-line-text').style.display = 'none';
                    tr.querySelector('.ship-line-select').style.display = 'inline-block';
                    editBtn.style.display = 'none';
                    tr.querySelector('.btn-validate').style.display = 'inline-block';
                });
            });

            document.querySelectorAll('.btn-validate').forEach(function(validateBtn) {
                validateBtn.addEventListener('click', function() {
                    const tr = validateBtn.closest('tr');
                    const shipId = tr.getAttribute('data-ship-id');
                    const nameInput = tr.querySelector('.ship-name-input');
                    const lineSelect = tr.querySelector('.ship-line-select');
                    const newName = nameInput.value;
                    const newLineId = lineSelect.value;
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value;

                    fetch(`/ships/${shipId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ name_nav: newName, line_id: newLineId })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Erreur lors de la mise à jour');
                        return response.json();
                    })
                    .then(data => {
                        tr.querySelector('.ship-name-text').textContent = newName;
                        tr.querySelector('.ship-name-text').style.display = 'inline';
                        nameInput.style.display = 'none';
                        tr.querySelector('.ship-line-text').textContent = lineSelect.options[lineSelect.selectedIndex].text;
                        tr.querySelector('.ship-line-text').style.display = 'inline';
                        lineSelect.style.display = 'none';
                        validateBtn.style.display = 'none';
                        tr.querySelector('.btn-update').style.display = 'inline-block';
                        // Notification verte
                        const msg = document.getElementById('navire-success-msg');
                        msg.style.display = 'block';
                        setTimeout(() => { msg.style.display = 'none'; }, 5000);
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