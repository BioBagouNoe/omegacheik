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
            <tr>
                <td>001</td>
                <td>Ligne 1</td>
                <td>
                    <div class="action-buttons d-flex justify-content-end gap-2">
                        <a href="{{route('agencies')}}" class="action-btn btn-view" style="text-decoration: none;"title="Voir"> <i class="fas fa-eye"></i></a>

                        <button class="action-btn btn-update" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn btn-reset" title="Réinitialiser">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button class="action-btn btn-delete" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>002</td>
                <td>Ligne 2</td>
                <td>
                    <div class="action-buttons d-flex justify-content-end gap-2">
                        <a href="{{route('agencies')}}" class="action-btn btn-view" style="text-decoration: none;"title="Voir"> <i class="fas fa-eye"></i></a>

                        <button class="action-btn btn-update" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn btn-reset" title="Réinitialiser">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button class="action-btn btn-delete" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>003</td>
                <td>Ligne 3</td>
                <td>
                    <div class="action-buttons d-flex justify-content-end gap-2">
                        <a href="{{route('agencies')}}" class="action-btn btn-view" style="text-decoration: none;"title="Voir"> <i class="fas fa-eye"></i></a>

                        <button class="action-btn btn-update" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn btn-reset" title="Réinitialiser">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button class="action-btn btn-delete" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>004</td>
                <td>Ligne 4</td>
            
                <td>
                    <div class="action-buttons d-flex justify-content-end gap-2">
                        <a href="{{route('agencies')}}" class="action-btn btn-view" title="Voir" style="text-decoration: none;"> <i class="fas fa-eye"></i></a>

                        <button class="action-btn btn-update" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn btn-reset" title="Réinitialiser">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button class="action-btn btn-delete" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>