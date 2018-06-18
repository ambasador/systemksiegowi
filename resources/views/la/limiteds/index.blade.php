@extends("la.layouts.app")

@section("contentheader_title", "Spółki Limited")
@section("contentheader_description", "Lista")
@section("section", "Limiteds")
@section("sub_section", "Lista")
@section("htmlheader_title", "Lista")

@section("headerElems")
@la_access("Limiteds", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Dodaj spółkę limited</button>
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

@la_access("Limiteds", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Dodaj spółkę limited</h4>
			</div>
			{!! Form::open(['action' => 'LA\LimitedsController@store', 'id' => 'limited-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    @la_form($module)
					
					{{--
					@la_input($module, 'company_name')
					@la_input($module, 'we_share')
					@la_input($module, 'share_address')
					@la_input($module, 'registration_date')
					@la_input($module, 'company_number')
					@la_input($module, 'contact_person')
					@la_input($module, 'phone_number')
					@la_input($module, 'address_email')
					@la_input($module, 'contact_person_2')
					@la_input($module, 'phone_number_2')
					@la_input($module, 'email_address_2')
					@la_input($module, 'first_set_period')
					@la_input($module, 'Eof_first_settlement')
					@la_input($module, 'b_c_billing_periods')
					@la_input($module, 'end_of_set_period')
					@la_input($module, 'end_of_periods')
					@la_input($module, 'payroll')
					@la_input($module, 'vat')
					@la_input($module, 'vat_numer')
					@la_input($module, 'date_periods_1')
					@la_input($module, 'date_periods_2')
					@la_input($module, 'date_periods_3')
					@la_input($module, 'date_periods_4')
					@la_input($module, 'additional_remarks')
					--}}
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
				{!! Form::submit( 'Wyślij', ['class'=>'btn btn-success']) !!}
			</div>
            <input type="hidden" name="ends_hidden" id="ends_hidden">
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
        ajax: "{{ url(config('laraadmin.adminRoute') . '/limited_dt_ajax') }}",
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

    $ends_hidden = $('#ends_hidden');
	$registration_date = $('input[name=registration_date]');
	$first_set_period = $('input[name=first_set_period]');
	$Eof_first_settlement = $('input[name=Eof_first_settlement]');
    //$first_set_period.prop('readonly', true);
    $registration_date.inputmask({
        mask: "y-1-2",
        placeholder: "yyyy-mm-dd",
        separator: "-",
        alias: "yyyy-mm-dd"
    });
    $first_set_period.inputmask({
        mask: "y-1-2",
        placeholder: "yyyy-mm-dd",
        separator: "-",
        alias: "yyyy-mm-dd"
    });
    $Eof_first_settlement.inputmask({
        mask: "y-1-2",
        placeholder: "yyyy-mm-dd",
        separator: "-",
        alias: "yyyy-mm-dd"
    });
    $first_set_period.attr("placeholder", "");
    //$Eof_first_settlement.prop('readonly', true);
    $Eof_first_settlement.attr("placeholder", "");
    $b_c_billing_periods = $('input[name=b_c_billing_periods]');
    $b_c_billing_periods.attr("placeholder", "");
    //$b_c_billing_periods.prop('readonly', true);
    $end_of_set_period = $('input[name=end_of_set_period]');
    $end_of_set_period.attr("placeholder", "");
    //$end_of_set_period.prop('readonly', true);
    $end_of_periods = $('input[name=end_of_periods]');
    $end_of_periods.attr("placeholder", "");
    //$end_of_periods.prop('readonly', true);
    $date_periods_1 = $('select[name=date_periods_1]');
    $date_periods_2 = $('input[name=date_periods_2]');
    $date_periods_3 = $('input[name=date_periods_3]');
    $date_periods_4 = $('input[name=date_periods_4]');
    $date_periods_2.attr("placeholder", "");
    $date_periods_2.prop('readonly', true);
    $date_periods_3.attr("placeholder", "");
    $date_periods_3.prop('readonly', true);
    $date_periods_4.attr("placeholder", "");
    $date_periods_4.prop('readonly', true);
    $registration_date.on('keyup change blur', function(){
        var date = $(this).val();
        $first_set_period.val($(this).val());

        var set21Months = moment(date, "YYYY-MM-DD").add('months', 21).endOf('month');
        var set1Month = moment(date, "YYYY-MM-DD").add('months', 1).startOf('month');
        var set12Months = moment(date, "DD-MM").add('months', 12).subtract('days', 1).endOf('month');
        var set9Months = moment($ends_hidden.val(), "DD-MM").add('months', 9).endOf('month');
        var day = set21Months.format('DD');
        var month = set21Months.format('MM');
        var year = set21Months.format('YYYY');
        var day1 = set1Month.format('DD');
        var month1 = set1Month.format('MM');
        var day12 = set12Months.format('DD');
        var month12 = set12Months.format('MM');
        var year12 = set12Months.format('YYYY');
        var day9 = set9Months.format('DD');
        var month9 = set9Months.format('MM');

        $Eof_first_settlement.val(year + '-' + month + '-' + day);
        $b_c_billing_periods.val((day1 + '/' + month1));
        $ends_hidden.val(year12 + '-' + month12 + '-' + day12);
        $end_of_set_period.val(day12 + '/' + month12);
        $end_of_periods.val(day9 + '/' + month9);
    });



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
    $.validator.addMethod("validDate", function(value, element) {
        return this.optional(element) ||  /^\d{4}\-\d{1,2}\-\d{1,2}$/.test(value);
    }, "Podaj prawidłową datę w formacie yyyy-mm-dd");
    $.validator.addMethod("validShortDate", function(value, element) {
        return this.optional(element) ||  /^\d{1,2}\/\d{1,2}$/.test(value);
    }, "Podaj prawidłową datę. w formacie dd-mm");
	$("#limited-add-form").validate({
        rules: {
            registration_date:{
                validDate: true
            },
            first_set_period:{
                validDate: true
            },
            Eof_first_settlement:{
                validDate: true
            },
            b_c_billing_periods:{
                validShortDate:true
            },
            end_of_set_period:{
                validShortDate:true
            },
            end_of_periods:{
                validShortDate:true
            }

        },
        invalidHandler: function(form, validator) {
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
