<!-- DataTable -->
<div class="datatable-card">
    <div class="datatable-header">
        <h3 class="datatable-title">Véhicules</h3>
        <div class="datatable-actions">
            <button class="action-btn btn-add" id="addVehicleBtn">
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

    <table id="vehiclesTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>BL</th>
                <th>Châssis</th>
                <th>Marque</th>
                <th>Type</th>
                <th>Année</th>
                <th>Actions</th>


            </tr>
        </thead>
        <tbody>
        @foreach($travel->travelDetails as $detail)
            <tr data-id="{{ $detail->id }}">
                <td>{{ $detail->bl }}</td>
                <td>{{ $detail->chassis }}</td>
                <td>{{ $detail->mark }}</td>
                <td>{{ $detail->type }}</td>
                <td>{{ $detail->year_make }}</td>
                <td>
                    <div class="action-buttons">
                        <button class="action-btn btn-view" title="Voir">
                            <i class="fas fa-eye"></i>
                        </button>
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
        @endforeach
        </tbody>
    </table>
</div>