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
                <td><span class="bl-text">{{ $detail->bl }}</span></td>
                <td><span class="chassis-text">{{ $detail->chassis }}</span></td>
                <td><span class="mark-text">{{ $detail->mark }}</span></td>
                <td><span class="type-text">{{ $detail->type }}</span></td>
                <td><span class="year-make-text">{{ $detail->year_make }}</span></td>
                <td>
                    <div class="action-buttons d-flex justify-content-end gap-2">
                        <button class="action-btn btn-view" title="Voir"><i class="fas fa-eye"></i></button>
                        <button class="action-btn btn-update" title="Modifier" data-id="{{ $detail->id }}"
                            data-bl="{{ $detail->bl }}" data-chassis="{{ $detail->chassis }}" data-mark="{{ $detail->mark }}" data-type="{{ $detail->type }}" data-year_make="{{ $detail->year_make }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn btn-delete" title="Supprimer"><i class="fas fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        @endforeach
        </div>

<!-- Modal d'édition véhicule -->
<div class="modal" id="editVehicleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le véhicule</h5>
                <button type="button" class="btn-close" id="closeEditVehicleModal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="editVehicleForm">
                    <input type="hidden" id="edit-detail-id">
                    <div class="mb-3">
                        <label for="edit-bl" class="form-label">Numéro BL</label>
                        <input type="text" class="form-control" id="edit-bl" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-chassis" class="form-label">Châssis</label>
                        <input type="text" class="form-control" id="edit-chassis" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-mark" class="form-label">Marque</label>
                        <input type="text" class="form-control" id="edit-mark" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-type" class="form-label">Type</label>
                        <input type="text" class="form-control" id="edit-type" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-year-make" class="form-label">Année</label>
                        <input type="text" class="form-control" id="edit-year-make" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelEditVehicle">Annuler</button>
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Ouvrir le modal d'édition avec les infos du véhicule
$(document).on('click', '.btn-update', function() {
    const btn = $(this);
    $('#edit-detail-id').val(btn.data('id'));
    $('#edit-bl').val(btn.data('bl'));
    $('#edit-chassis').val(btn.data('chassis'));
    $('#edit-mark').val(btn.data('mark'));
    $('#edit-type').val(btn.data('type'));
    $('#edit-year-make').val(btn.data('year_make'));
    $('#editVehicleModal').addClass('show').css('display', 'block');
});
$('#closeEditVehicleModal, #cancelEditVehicle').on('click', function() {
    $('#editVehicleModal').removeClass('show').css('display', 'none');
});
// Enregistrement AJAX du véhicule modifié
$('#editVehicleForm').on('submit', function(e) {
    e.preventDefault();
    const detailId = $('#edit-detail-id').val();
    const travelId = {{ $travel->id }};
    const data = {
        bl: $('#edit-bl').val(),
        chassis: $('#edit-chassis').val(),
        mark: $('#edit-mark').val(),
        type: $('#edit-type').val(),
        year_make: $('#edit-year-make').val(),
        _token: '{{ csrf_token() }}',
        _method: 'PUT'
    };
    const submitBtn = $(this).find('button[type="submit"]');
    const originalHtml = submitBtn.html();
    submitBtn.html('<i class="fas fa-spinner fa-spin"></i>');
    submitBtn.prop('disabled', true);
    $.ajax({
        url: `/travels/${travelId}/details/${detailId}`,
        type: 'POST',
        data: data,
        success: function(response) {
            if (response.success) {
                // Mettre à jour la ligne dans le tableau
                const row = $(`tr[data-id='${detailId}']`);
                row.find('.bl-text').text(data.bl);
                row.find('.chassis-text').text(data.chassis);
                row.find('.mark-text').text(data.mark);
                row.find('.type-text').text(data.type);
                row.find('.year-make-text').text(data.year_make);
                $('#editVehicleModal').removeClass('show').css('display', 'none');
            } else {
                alert(response.message || 'Erreur lors de la mise à jour');
            }
        },
        error: function(xhr) {
            alert('Erreur lors de la mise à jour');
        },
        complete: function() {
            submitBtn.html(originalHtml);
            submitBtn.prop('disabled', false);
        }
    });
});
// Suppression AJAX (inchangé)
$(document).on('click', '.btn-delete', function(e) {
    e.preventDefault();
    const row = $(this).closest('tr');
    const detailId = row.data('id');
    const travelId = {{ $travel->id }};
    if (!confirm('Voulez-vous vraiment supprimer ce détail ?')) return;
    const btn = $(this);
    const originalHtml = btn.html();
    btn.html('<i class="fas fa-spinner fa-spin"></i>');
    btn.prop('disabled', true);
    $.ajax({
        url: `/travels/${travelId}/details/${detailId}`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'DELETE'
        },
        success: function(response) {
            if (response.success) {
                row.remove();
            } else {
                alert(response.message || 'Erreur lors de la suppression');
            }
        },
        error: function(xhr) {
            alert('Erreur lors de la suppression');
        },
        complete: function() {
            btn.html(originalHtml);
            btn.prop('disabled', false);
        }
    });
});
</script>
@endpush
        </tbody>
    </table>
</div>