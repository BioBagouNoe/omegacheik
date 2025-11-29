<!-- DataTable -->
<div class="datatable-card">
    <div class="datatable-header">
        <h3 class="datatable-title">Manifestes</h3>
        <div class="datatable-actions">
            <button class="action-btn btn-add" id="addManifestBtn">
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

    <table id="manifestsTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Navire</th>
                <th>Date d'arrivée</th>
                <th>Date d'amarrage</th>
                <th>Fin de déchargement</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>VH-001</td>
                <td>AB-123-CD</td>
                <td>Toyota</td>
                <td>Corolla</td>
                <td>2022</td>
                <td><span class="status-badge status-available">Disponible</span></td>
                <td>
                    <div class="action-buttons">
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
                <td>VH-002</td>
                <td>EF-456-GH</td>
                <td>Renault</td>
                <td>Clio</td>
                <td>2021</td>
                <td><span class="status-badge status-maintenance">Maintenance</span></td>
                <td>
                    <div class="action-buttons">
                        <a href="{{route('manifest-details')}}" class="action-btn btn-view" style="text-decoration: none;"title="Voir"> <i class="fas fa-eye"></i></a>

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
                <td>308</td>
                <td>2023</td>
                <td><span class="status-badge status-reserved">Réservé</span></td>
                <td>
                    <div class="action-buttons">
                        <a href="{{route('manifest-details')}}" class="action-btn btn-view" style="text-decoration: none;"title="Voir"> <i class="fas fa-eye"></i></a>

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
                <td>C4</td>
                <td>2020</td>
                <td><span class="status-badge status-out-of-service">Hors service</span></td>
                <td>
                    <div class="action-buttons">
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