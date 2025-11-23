    <!-- Modal d'ajout de véhicule -->
    <div class="modal" id="addVehicleModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter un véhicule</h3>
                <button class="modal-close" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="vehicleForm">
                    <!-- Row : Numéro BL et Expéditeur -->
                    <div class="form-row d-flex gap-3 mb-3">
                        <div class="form-group flex-fill">
                            <label class="form-label" for="bl">Numéro BL</label>
                            <input type="text" class="form-control" id="bl" required>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="consignor">Expéditeur</label>
                            <input type="text" class="form-control" id="consignor" required>
                        </div>
                    </div>

                    <!-- Row : Destination et Adresse de l’expéditeur -->
                    <div class="form-row d-flex gap-3 mb-3">
                        <div class="form-group flex-fill">
                            <label class="form-label" for="destination">Destination</label>
                            <input type="text" class="form-control" id="destination" required>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="consignor_adress">Adresse de l’expéditeur</label>
                            <input type="text" class="form-control" id="consignor_adress">
                        </div>
                    </div>

                    <!-- Row : Châssis et Marque -->
                    <div class="form-row d-flex gap-3 mb-3">
                        <div class="form-group flex-fill">
                            <label class="form-label" for="chassis">Numéro de châssis</label>
                            <input type="text" class="form-control" id="chassis" required>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="mark">Marque du véhicule</label>
                            <select class="form-control" id="mark" name="mark" required>
                                <option value="">Sélectionner une marque</option>
                                @include('components.marque')
                            </select>
                        </div>
                    </div>

                    <!-- Row : Type et Année de fabrication -->
                    <div class="form-row d-flex gap-3 mb-3">
                        <div class="form-group flex-fill">
                            <label class="form-label" for="type">Type de marchandise ou véhicule</label>
                            <input type="text" class="form-control" id="type" required>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="year_make">Année de fabrication</label>
                            <input type="number" class="form-control" id="year_make" min="1900" max="2025" required>
                        </div>
                    </div>

                    <!-- Manifest associé -->
                    <div class="form-group mb-3">
                        <label class="form-label" for="id_manifest">Manifeste</label>
                        <select class="form-control" id="id_manifest" required>
                            <option value="">Sélectionner un manifeste</option>
                            <!-- Options dynamiques depuis la table manifest -->
                        </select>
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelBtn">Annuler</button>
                <button class="btn btn-primary" id="saveBtn">Enregistrer</button>
            </div>
        </div>
    </div>