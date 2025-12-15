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
                                data-bl="{{ $detail->bl }}" data-chassis="{{ $detail->chassis }}" data-mark="{{ $detail->mark }}" data-type="{{ $detail->type }}" data-year_make="{{ $detail->year_make }}"
                                data-consignor="{{ $detail->consignor }}" data-destination="{{ $detail->destination }}" data-consignor_adress="{{ $detail->consignor_adress }}" data-travel_id="{{ $detail->travel_id }}">
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le véhicule</h5>
                <button type="button" class="btn-close" id="closeEditVehicleModal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editVehicleForm">
                    <input type="hidden" id="edit-detail-id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit-consignor" class="form-label fw-semibold">Consignor</label>
                            <input type="text" class="form-control" id="edit-consignor">
                        </div>
                        <div class="col-md-6">
                            <label for="edit-destination" class="form-label fw-semibold">Destination</label>
                            <input type="text" class="form-control" id="edit-destination">
                        </div>

                        <div class="col-md-6">
                            <label for="edit-consignor-adress" class="form-label fw-semibold">Adresse consignor</label>
                            <input type="text" class="form-control" id="edit-consignor-adress">
                        </div>
                        <div class="col-md-6">
                            <label for="edit-travel-id" class="form-label fw-semibold">Voyage</label>
                            <select id="edit-travel-id" class="form-select">
                                @foreach(App\Models\Travel::all() as $t)
                                    <option value="{{ $t->id }}">{{ $t->num_travel }}@if($t->arrival_date) - {{ $t->arrival_date }}@endif</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="edit-bl" class="form-label fw-semibold">Numéro BL</label>
                            <input type="text" class="form-control" id="edit-bl" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit-chassis" class="form-label fw-semibold">Châssis</label>
                            <input type="text" class="form-control" id="edit-chassis" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit-mark" class="form-label fw-semibold">Marque</label>
                            <select id="edit-mark" class="form-control" required>
                                <option value="">-- Sélectionner une marque --</option>
                                @include('components.marque')
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit-type" class="form-label fw-semibold">Type</label>
                            <input type="text" class="form-control" id="edit-type" required>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="edit-year-make" class="form-label fw-semibold">Année</label>
                            <input type="text" class="form-control" id="edit-year-make" required>
                        </div>
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
    // nouveaux champs
    $('#edit-consignor').val(btn.data('consignor'));
    $('#edit-destination').val(btn.data('destination'));
    $('#edit-consignor-adress').val(btn.data('consignor_adress'));
    $('#edit-travel-id').val(btn.data('travel_id'));
    // si la marque n'existe pas dans la liste, l'ajouter au select et le sélectionner
    const markVal = btn.data('mark');
    if(markVal) {
        if($('#edit-mark option[value="'+markVal+'"]').length === 0) {
            $('#edit-mark').append(new Option(markVal, markVal));
        }
        $('#edit-mark').val(markVal);
    }
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
        consignor: $('#edit-consignor').val(),
        destination: $('#edit-destination').val(),
        consignor_adress: $('#edit-consignor-adress').val(),
        travel_id: $('#edit-travel-id').val(),
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
        dataType: 'json',
        headers: {
            'Accept': 'application/json'
        },
        success: function(response) {
                if (response.success) {
                // Mettre à jour la ligne dans le tableau
                const row = $(`tr[data-id='${detailId}']`);
                row.find('.bl-text').text(data.bl);
                row.find('.chassis-text').text(data.chassis);
                row.find('.mark-text').text(data.mark);
                row.find('.type-text').text(data.type);
                row.find('.year-make-text').text(data.year_make);
                // Mettre à jour les data-attributes du bouton d'édition pour futurs edits
                const editBtn = row.find('.btn-update');
                editBtn.attr('data-bl', data.bl).attr('data-chassis', data.chassis).attr('data-mark', data.mark).attr('data-type', data.type).attr('data-year_make', data.year_make);
                editBtn.attr('data-consignor', data.consignor).attr('data-destination', data.destination).attr('data-consignor_adress', data.consignor_adress).attr('data-travel_id', data.travel_id);
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
        dataType: 'json',
        headers: {
            'Accept': 'application/json'
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