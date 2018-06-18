@extends("la.layouts.app")

@section("contentheader_title", "Spółki Samozatrudniające")
@section("contentheader_description", "Lista")
@section("section", "Spółki Samozatrudniające")
@section("sub_section", "Lista")
@section("htmlheader_title", "Lista")

@section("headerElems")
@la_access("Self_Employments", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Dodaj Spółkę Samozatrudniającą</button>
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

@la_access("Self_Employments", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Zamknij"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Dodaj spółkę samozatrudniającą</h4>
			</div>
			{!! Form::open(['action' => 'LA\Self_EmploymentsController@store', 'id' => 'self_employment-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    @la_form($module)
					
					{{--
					@la_input($module, 'name_username')
					@la_input($module, 'trade_name')
					@la_input($module, 'we_support')
					@la_input($module, 'registration_date')
					@la_input($module, 'phone_number')
					@la_input($module, 'email_address')
					@la_input($module, 'annotations')
					@la_input($module, 'payroll')
					@la_input($module, 'vat')
					@la_input($module, 'vat_number')
					@la_input($module, 'end_date_1')
					@la_input($module, 'end_date_2')
					@la_input($module, 'end_date_3')
					@la_input($module, 'end_date_4')
					--}}
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
				{!! Form::submit( 'Wyślij', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endla_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('la-assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset('la-assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
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
	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/self_employment_dt_ajax') }}",
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
    $registration_date = $('input[name=registration_date]');
    $registration_date.inputmask({
        mask: "y-1-2",
        placeholder: "yyyy-mm-dd",
        separator: "-",
        alias: "yyyy-mm-dd"
    });
    $date_periods_1 = $('select[name=end_date_1]');
    $date_periods_2 = $('input[name=end_date_2]');
    $date_periods_3 = $('input[name=end_date_3]');
    $date_periods_4 = $('input[name=end_date_4]');
    $date_periods_2.attr("placeholder", "");
    $date_periods_2.prop('readonly', true);
    $date_periods_3.attr("placeholder", "");
    $date_periods_3.prop('readonly', true);
    $date_periods_4.attr("placeholder", "");
    $date_periods_4.prop('readonly', true);
    $date_periods_2.val('30/04');
    $date_periods_3.val('31/07');
    $date_periods_4.val('31/10');
    $date_periods_1.on('change', function() {
        if($(this).val() === '31/01'){
            $date_periods_2.val('30/04');
            $date_periods_3.val('31/07');
            $date_periods_4.val('31/10');
        }
        else if($(this).val() === '28/02'){
            $date_periods_2.val('31/05');
            $date_periods_3.val('31/08');
            $date_periods_4.val('30/11');
        }
        else if($(this).val() === '31/03'){
            $date_periods_2.val('31/06');
            $date_periods_3.val('30/09');
            $date_periods_4.val('31/12');
        }
    });
    $.validator.addMethod("validdate", function(value, element) {
        return this.optional(element) ||  /^\d{4}\-\d{1,2}\-\d{1,2}$/.test(value);
    }, "Podaj prawidłową datę.");
	$("#self_employment-add-form").validate({
        rules: {
            registration_date:{
                validdate: true
            }

        },invalidHandler: function(form, validator) {
            if (!validator.numberOfInvalids())
                return;
            $('html, body').animate({
                scrollTop: $(validator.errorList[0].element).offset().top
            }, 1000);
        },
        submitHandler: function (form) {
            form.submit();
        }
	});
});
</script>
@endpush
