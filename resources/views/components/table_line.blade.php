<!-- DataTable -->
<div class="datatable-card">
    <div class="datatable-header">
        <h3 class="datatable-title">Lignes</h3>
        <div class="datatable-actions">
            <button class="action-btn btn-add" id="addLineBtn">
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
                <tr>
                    <td>{{ $line->id }}</td>
                    <td>{{ $line->name_line }}</td>
                    <td>
                        <div class="action-buttons d-flex justify-content-end gap-2">
                            <a href="{{ route('lines.show', $line) }}" class="action-btn btn-view" style="text-decoration: none;" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('lines.edit', $line) }}" class="action-btn btn-update" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
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
        </tbody>
    </table>
</div>