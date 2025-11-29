    <!-- Modal d'ajout de véhicule -->
    <div class="modal" id="addNavireModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter un navire</h3>
                <button class="modal-close" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="navireForm">

                    <!-- Nom du navire et Ligne -->
                    <div class="form-row d-flex gap-3 mb-3">

                        <div class="form-group flex-fill">
                            <label class="form-label" for="name_nav">Nom du navire</label>
                            <input type="text" class="form-control" id="name_nav" required>
                        </div>

                        <div class="form-group flex-fill">
                            <label class="form-label" for="id_line">Ligne</label>
                            <select class="form-control" id="id_line" required>
                                <option value="">Sélectionner une ligne</option>
                                <!-- Options dynamiques -->
                            </select>
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