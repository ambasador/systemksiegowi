@extends("la.layouts.app")

<?php
use Dwij\Laraadmin\Models\Module;
?>

@section("contentheader_title", "Moduły")
@section("contentheader_description", "lista modułów")
@section("section", "Moduły")
@section("sub_section", "Lista")
@section("htmlheader_title", "Lista modułów")

@section("headerElems")
<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Dodaj moduł</button>
@endsection

@section("main-content")

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="dt_modules" class="table table-bordered">
		<thead>
		<tr class="success">
			<th>ID</th>
			<th>Nazwa</th>
			<th>Tabela</th>
			<th>Pola</th>
			<th>Akcje</th>
		</tr>
		</thead>
		<tbody>
			
			@foreach ($modules as $module)
				<tr>
					<td>{{ $module->id }}</td>
					<td><a href="{{ url(config('laraadmin.adminRoute') . '/modules/'.$module->id) }}">{{ $module->name }}</a></td>
					<td>{{ $module->name_db }}</td>
					<td>{{ Module::itemCount($module->name) }}</td>
					<td>
						<a href="{{ url(config('laraadmin.adminRoute') . '/modules/'.$module->id)}}#fields" class="btn btn-primary btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
						<a href="{{ url(config('laraadmin.adminRoute') . '/modules/'.$module->id)}}#access" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-key"></i></a>
						<a href="{{ url(config('laraadmin.adminRoute') . '/modules/'.$module->id)}}#sort" class="btn btn-success btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-sort"></i></a>
						<a module_name="{{ $module->name }}" module_id="{{ $module->id }}" class="btn btn-danger btn-xs delete_module" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Dodaj moduł</h4>
			</div>
			{!! Form::open(['route' => config('laraadmin.adminRoute') . '.modules.store', 'id' => 'module-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
					<div class="form-group">
						<label for="name">Nazwa modułu :</label>
						{{ Form::text("name", null, ['class'=>'form-control', 'placeholder'=>'Nazwa modułu',
						'data-rule-minlength' => 2, 'data-rule-maxlength'=>20, 'required' => 'required']) }}
					</div>
					<div class="form-group">
						<label for="icon">Ikona</label>
						<div class="input-group">
							<input class="form-control" placeholder="Ikona FA" name="icon" type="text" value="fa-cube"
								   data-rule-minlength="1" required>
							<span class="input-group-addon"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
				{!! Form::submit( 'Wyślij', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<!-- module deletion confirmation  -->
<div class="modal" id="module_delete_confirm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Zamknij">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title">Usuń moduł</h4>
			</div>
			<div class="modal-body">
				<p>Czy na pewno chcesz usunąć moduł <b id="moduleNameStr" class="text-danger"></b> ?</p>
				<p>Następujące pliki zostaną usunięte:</p>
				<div id="moduleDeleteFiles"></div>
				<p class="text-danger">Uwaga: plik migracji nie zostanie usunięty, ale zostanie zmodyfikowany.</p>
			</div>
			<div class="modal-footer">
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.modules.destroy', 0], 'id' => 'module_del_form', 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-danger btn-delete pull-left" type="submit">Tak</button>
				{{ Form::close() }}
				<a data-dismiss="modal" class="btn btn-default pull-right" >Nie</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/iconpicker/fontawesome-iconpicker.js') }}"></script>
<script>
$(function () {
    $.extend($.validator.messages, {
        required: "To pole jest wymagane.",
        remote: "Proszę o wypełnienie tego pola.",
        email: "Proszę o podanie prawidłowego adresu email.",
        url: "Proszę o podanie prawidłowego URL.",
        date: "Proszę o podanie prawidłowej daty.",
        dateISO: "Proszę o podanie prawidłowej daty (ISO).",
        number: "Proszę o podanie prawidłowej liczby.",
        digits: "Proszę o podanie samych cyfr.",
        creditcard: "Proszę o podanie prawidłowej karty kredytowej.",
        equalTo: "Proszę o podanie tej samej wartości ponownie.",
        accept: "Proszę o podanie wartości z prawidłowym rozszerzeniem.",
        maxlength: jQuery.validator.format("Proszę o podanie nie więcej niż {0} znaków."),
        minlength: jQuery.validator.format("Proszę o podanie przynajmniej {0} znaków."),
        rangelength: jQuery.validator.format("Proszę o podanie wartości o długości od {0} do {1} znaków."),
        range: jQuery.validator.format("Proszę o podanie wartości z przedziału od {0} do {1}."),
        max: jQuery.validator.format("Proszę o podanie wartości mniejszej bądź równej {0}."),
        min: jQuery.validator.format("Proszę o podanie wartości większej bądź równej {0}.")
    });
	$('.delete_module').on("click", function () {
    	var module_id = $(this).attr('module_id');
		var module_name = $(this).attr('module_name');
		$("#moduleNameStr").html(module_name);
		$url = $("#module_del_form").attr("action");
		$("#module_del_form").attr("action", $url.replace("/0", "/"+module_id));
		$("#module_delete_confirm").modal('show');
		$.ajax({
			url: "{{ url(config('laraadmin.adminRoute') . '/get_module_files/') }}/" + module_id,
			type:"POST",
			beforeSend: function() {
				$("#moduleDeleteFiles").html('<center><i class="fa fa-refresh fa-spin"></i></center>');
			},
			headers: {
		    	'X-CSRF-Token': '{{ csrf_token() }}'
    		},
			success: function(data) {
				var files = data.files;
				var filesList = "<ul>";
				for ($i = 0; $i < files.length; $i++) { 
					filesList += "<li>" + files[$i] + "</li>";
				}
				filesList += "</ul>";
				$("#moduleDeleteFiles").html(filesList);
			}
		});
	});
	
	$('input[name=icon]').iconpicker();
	$("#dt_modules").DataTable({
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
        }
	});
	$("#module-add-form").validate({
		
	});
});
</script>
@endpush
