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
                <tr data-id="{{$ship->id}}">
                    <td>{{$ship->id}}</td>
                    <td>
                        <span class="ship-name-text">{{$ship->name_nav}}</span>
                        <input type="text" class="form-control ship-name-input d-none" value="{{$ship->name_nav}}" />
                    </td>
                    <td>
                        <span class="ship-line-text">{{$ship->line ? $ship->line->name_line : ''}}</span>
                        <select class="form-control ship-line-select d-none">
                            @foreach($lines as $line)
                                <option value="{{$line->id}}" @if($ship->line && $ship->line->id == $line->id) selected @endif>{{$line->name_line}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <div class="action-buttons d-flex justify-content-end gap-2">
                            <a href="#" class="action-btn btn-view" title="Voir" style="text-decoration: none;"> <i class="fas fa-eye"></i></a>
                            <button class="action-btn btn-update" title="Modifier"><i class="fas fa-edit"></i></button>
                            <button class="action-btn btn-save d-none" title="Enregistrer"><i class="fas fa-check"></i></button>
                            <button class="action-btn btn-cancel d-none" title="Annuler"><i class="fas fa-times"></i></button>
                            <button class="action-btn btn-delete" title="Supprimer"><i class="fas fa-trash"></i></button>
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