@extends("la.layouts.app")

@section("contentheader_title", "Kopie zapasowe")
@section("contentheader_description", "Lista kopii zapasowych")
@section("section", "Kopie zapasowe")
@section("sub_section", "Lista")
@section("htmlheader_title", "Lista kopii zapasowych")

@section("headerElems")
@la_access("Backups", "create")
	<button class="btn btn-success btn-sm pull-right" id="CreateBackup">Utówrz kopię zapasową</button>
@endla_access
@endsection

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			@foreach( $listing_cols as $col )
			<th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
			@endforeach
			@if($show_actions)
			<th>Akcje</th>
			@endif
		</tr>
		</thead>
		<tbody>
			
		</tbody>
		</table>
	</div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/backup_dt_ajax') }}",
		language: {
            "processing":     "Przetwarzanie...",
            "search":         "Szukaj:",
            "lengthMenu":     "Pokaż _MENU_ pozycji",
            "info":           "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",
            "infoEmpty":      "Pozycji 0 z 0 dostępnych",
            "infoFiltered":   "(filtrowanie spośród _MAX_ dostępnych pozycji)",
            "infoPostFix":    "",
            "loadingRecords": "Wczytywanie...",
            "zeroRecords":    "Nie znaleziono pasujących pozycji",
            "emptyTable":     "Brak danych",
            "paginate": {
                "first":      "Pierwsza",
                "previous":   "Poprzednia",
                "next":       "Następna",
                "last":       "Ostatnia"
            },
            "aria": {
                "sortAscending": ": aktywuj, by posortować kolumnę rosnąco",
                "sortDescending": ": aktywuj, by posortować kolumnę malejąco"
            }
        },
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	
	$("#CreateBackup").on("click", function() {
		$.ajax({
			url: "{{ url(config('laraadmin.adminRoute') . '/create_backup_ajax') }}",
			method: 'POST',
			beforeSend: function() {
				$("#CreateBackup").html('<i class="fa fa-refresh fa-spin"></i> Tworzę kopię zapasową...');
			},
			headers: {
		    	'X-CSRF-Token': $('input[name="_token"]').val()
    		},
			success: function( data ) {
				if(data.status == "success") {
					$("#CreateBackup").html('<i class="fa fa-check"></i> Utworzono kopię zapasową');
					$('body').pgNotification({
						style: 'circle',
						title: 'Utworzono kopię zapasową',
						message: data.message,
						position: "top-right",
						timeout: 0,
						type: "success",
						thumbnail: '<img width="40" height="40" style="display: inline-block;" src="{{ asset('la-assets/img/laraadmin_logo_white.png') }}" data-src="assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar2x.jpg" alt="">'
					}).show();
					setTimeout(function() {
						window.location.reload();
					}, 1000);
				} else {
					$("#CreateBackup").html('Utworzę kopię zapasową');
					$('body').pgNotification({
						style: 'circle',
						title: 'Tworzenie kopii zapasowych nie powiodło się',
						message: data.message,
						position: "top-right",
						timeout: 0,
						type: "danger",
						thumbnail: '<img width="40" height="40" style="display: inline-block;" src="{{ asset('la-assets/img/laraadmin_logo_white.png') }}" data-src="assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar2x.jpg" alt="">'
					}).show();
					console.log(data.output);
				}
			}
		});
	});
});
</script>
@endpush
