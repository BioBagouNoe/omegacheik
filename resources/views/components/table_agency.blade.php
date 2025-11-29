<!-- DataTable -->
<div class="datatable-card">
    <div class="datatable-header">
        <h3 class="datatable-title">Agences</h3>
        <div class="datatable-actions">
            <button class="action-btn btn-add" id="addAgencyBtn">
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

    <table id="agenciesTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom de l'agence</th>
                <th>Ligne</th>
                <th class=" d-flex justify-content-end gap-2">Actions</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td>AG-001</td>
                <td>Agence Centrale</td>
                <td>Ligne 1</td>
                <td>
                    <div class="action-buttons d-flex justify-content-end gap-2">
                        <a href="{{route('manifest-details')}}" class="action-btn btn-view" style="text-decoration: none;" title="Voir"> <i class="fas fa-eye"></i></a>

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
                <td>AG-002</td>
                <td>Agence Nord</td>
                <td>Ligne 2</td>
                <td>
                    <div class="action-buttons d-flex justify-content-end gap-2">
                        <a href="{{route('manifest-details')}}" class="action-btn btn-view" style="text-decoration: none;" title="Voir"> <i class="fas fa-eye"></i></a>

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
                <td>AG-003</td>
                <td>Agence Est</td>
                <td>Ligne 3</td>
                <td>
                    <div class="action-buttons d-flex justify-content-end gap-2">
                        <a href="{{route('manifest-details')}}" class="action-btn btn-view" style="text-decoration: none;" title="Voir"> <i class="fas fa-eye"></i></a>

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
                <td>AG-004</td>
                <td>Agence Sud</td>
                <td>Ligne 4</td>
                <td>
                    <div class="action-buttons d-flex justify-content-end gap-2">
                        <a href="{{route('manifest-details')}}" class="action-btn btn-view" title="Voir" style="text-decoration: none;"> <i class="fas fa-eye"></i></a>

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