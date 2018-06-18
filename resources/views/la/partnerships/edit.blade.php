@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/partnerships') }}">Spółki Partnerskie</a> :
@endsection
@section("contentheader_description", $partnership->$view_col)
@section("section", "Partnerships")
@section("section_url", url(config('laraadmin.adminRoute') . '/partnerships'))
@section("sub_section", "Edycja")

@section("htmlheader_title", "Edycja : ".$partnership->$view_col)

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

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($partnership, ['route' => [config('laraadmin.adminRoute') . '.partnerships.update', $partnership->id ], 'method'=>'PUT', 'id' => 'partnership-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'partnership_name')
					@la_input($module, 'we_supprot')
					@la_input($module, 'registration_date')
					@la_input($module, 'contact_person')
					@la_input($module, 'phone_number')
					@la_input($module, 'email_address')
					@la_input($module, 'contact_person_2')
					@la_input($module, 'phone_numer_2')
					@la_input($module, 'email_address_2')
					@la_input($module, 'additional_remarks')
					@la_input($module, 'payroll')
					@la_input($module, 'vat')
					@la_input($module, 'vat_number')
					@la_input($module, 'date_periods_1')
					@la_input($module, 'date_periods_2')
					@la_input($module, 'date_periods_3')
					@la_input($module, 'date_periods_4')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Akualizuj', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/partnerships') }}">Anuluj</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
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
    $registration_date = $('input[name=registration_date]');
    $registration_date.inputmask({
        mask: "y-1-2",
        placeholder: "yyyy-mm-dd",
        separator: "-",
        alias: "yyyy-mm-dd"
    });
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
	$("#partnership-edit-form").validate({
        rules: {
            registration_date:{
                validdate: true
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
