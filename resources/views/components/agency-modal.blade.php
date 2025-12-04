    <!-- Modal d'ajout de véhicule -->
    <div class="modal" id="addAgencyModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter une agence</h3>
                <button class="modal-close" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="agencyForm" action="{{ route('agencies.store') }}" method="POST">
                    @csrf
                    <!-- Nom de l’agence, Ligne et Pays -->
                    <div class="form-row d-flex gap-2 mb-3">
                        <div class="form-group flex-fill">
                            <label class="form-label" for="name_agency">Nom de l’agence</label>
                            <input type="text" class="form-control" id="name_agency" name="name_agency" required>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="line_id">Ligne</label>
                            <select class="form-control" id="line_id" name="line_id" required>
                                <option value="">Sélectionner une ligne</option>
                                @foreach(App\Models\Line::all() as $line)
                                <option value="{{ $line->id }}">{{ $line->name_line }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row d-flex gap-2 mb-3">
                        <div class="form-group flex-fill">
                            <label class="form-label" for="adress_agency">Adresse de l’agence</label>
                            <input type="text" class="form-control" id="adress_agency" name="adress_agency" required>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="pays_id">Pays</label>
                            <select class="form-control" id="pays_id" name="pays_id" required>
                                <option value="">Sélectionner un pays</option>
                                @foreach(App\Models\Pays::all() as $pays)
                                <option value="{{ $pays->id }}">{{ $pays->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" id="cancelBtn">Annuler</button>
                        <button class="btn btn-primary" id="saveBtn">Enregistrer</button>
                    </div>
                </form>

            </div>
        </div>
    </div>