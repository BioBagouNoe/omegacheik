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
            <tr>
                <td>VH-001</td>
                <td>AB-123-CD</td>
                <td>Toyota</td>
                <td>-----</td>
                <td>2024</td>
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
            <tr>
                <td>VH-002</td>
                <td>EF-456-GH</td>
                <td>Renault</td>
                <td>-----</td>
                <td>2021</td>
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
            <tr>
                <td>VH-003</td>
                <td>IJ-789-KL</td>
                <td>Peugeot</td>
                <td>-----</td>
                <td>2023</td>
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
            <tr>
                <td>VH-004</td>
                <td>MN-012-OP</td>
                <td>Citroën</td>
                <td>-----</td>
                <td>2020</td>
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
        </tbody>
    </table>
</div>