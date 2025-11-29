    <!-- Modal d'ajout de véhicule -->
    <div class="modal" id="addLineModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter unen ligne</h3>
                <button class="modal-close" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="lineForm" action="{{ route('lines.store') }}" method="POST">
                    @csrf
                    <!-- Nom de la ligne -->
                    <div class="form-row d-flex gap-3 mb-3">
                        <div class="form-group flex-fill">
                            <label class="form-label" for="name_line">Nom de la ligne</label>
                            <input type="text" class="form-control" id="name_line" name="name_line" required>
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