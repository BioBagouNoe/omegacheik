    <!-- Modal de modification de mot de passe -->
    <div class="modal" id="resetPasswordModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Modifier le mot de passe</h3>
                <button class="modal-close" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="resetPasswordForm">
                    <!-- Form Group (current password)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="currentPassword">Mot de passe actuel</label>
                        <input class="form-control" id="currentPassword" type="password" placeholder="Entrez le mot de passe actuel" />
                    </div>
                    <!-- Form Group (new password)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="newPassword">Nouveau mot de passe</label>
                        <input class="form-control" id="newPassword" type="password" placeholder="Entrez le nouveau mot de passe" />
                    </div>
                    <!-- Form Group (confirm password)-->
                    <div class="mb-3">
                        <label class="small mb-1" for="confirmPassword">Confirmer le mot de passe</label>
                        <input class="form-control" id="confirmPassword" type="password" placeholder="Confirmez le nouveau mot de passe" />
                    </div>
                    <button class="btn btn-primary" type="button">Enregistrer</button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancelBtn">Annuler</button>
                <button class="btn btn-primary" id="saveBtn">Enregistrer</button>
            </div>
        </div>
    </div>