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
                <input type="file" id="importFileInput" name="file" accept=".csv,.xlsx,.xls" style="display:none;" onchange="document.getElementById('importForm').submit();">
                <button type="button" class="action-btn btn-import" onclick="document.getElementById('importFileInput').click();">
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
                <th>ID</th>
                <th>Nom</th>
                <th class=" d-flex justify-content-end gap-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lines as $line)
                <tr data-line-id="{{ $line->id }}">
                    <td>{{ $line->id }}</td>
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
                        body: JSON.stringify({ name_line: newName })
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
                        // Affiche une notification verte en haut
                        const msg = document.getElementById('line-success-msg');
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
        </tbody>
    </table>
</div>