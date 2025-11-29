    <!-- Modal d'ajout de véhicule -->
    <div class="modal" id="addManifestModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter un manifeste</h3>
                <button class="modal-close" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="manifestForm">
                    <!-- Numéro de voyage et Navire -->
                    <div class="form-row d-flex gap-3 mb-3">
                         <div class="form-group flex-fill">
                            <label class="form-label" for="id_nav">Navire</label>
                            <select class="form-control" id="id_nav" required>
                                <option value="">Sélectionner un navire</option>
                                <!-- Options dynamiques -->
                            </select>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="num_travel">Numéro de voyage</label>
                            <input type="text" class="form-control" id="num_travel" required>
                        </div>
                    </div>

                    <!-- Agence et Statut -->
                    <div class="form-row d-flex gap-3 mb-3">
                        <div class="form-group flex-fill">
                            <label class="form-label" for="id_agency">Agence</label>
                            <select class="form-control" id="id_agency" required>
                                <option value="">Sélectionner une agence</option>
                                <!-- Options dynamiques -->
                            </select>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="status">Statut</label>
                            <select class="form-control" id="status" required>
                                <option value="">Sélectionner</option>
                                <option value="1">Actif</option>
                                <option value="0">Inactif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Date d’arrivée, Date d’amarrage, Date de fin de déchargement -->
                    <div class="form-row d-flex gap-3 mb-3">
                        <div class="form-group flex-fill">
                            <label class="form-label" for="arrival_date">Date d’arrivée</label>
                            <input type="date" class="form-control" id="arrival_date" required>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="docking_date">Date d’amarrage</label>
                            <input type="date" class="form-control" id="docking_date" required>
                        </div>
                        <div class="form-group flex-fill">
                            <label class="form-label" for="end_unloading">Date de fin de déchargement</label>
                            <input type="date" class="form-control" id="end_unloading">
                        </div>
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelBtn">Annuler</button>
                <button class="btn btn-primary" id="saveBtn">Enregistrer</button>
            </div>
        </div>
    </div>