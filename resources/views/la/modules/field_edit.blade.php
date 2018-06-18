@extends("la.layouts.app")

@section("contentheader_title", "Edycja pola : ".$field->label)
@section("contentheader_description", "z ".$module->model." modułu")
@section("section", "Moduł ".$module->name)
@section("section_url", url(config('laraadmin.adminRoute') . '/modules/'.$module->id))
@section("sub_section", "Edytuj pole")

@section("htmlheader_title", "Edycja pola : ".$field->label)

@section("main-content")
<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($field, ['route' => [config('laraadmin.adminRoute') . '.module_fields.update', $field->id ], 'method'=>'PUT', 'id' => 'field-edit-form']) !!}
					{{ Form::hidden("module_id", $module->id) }}
					
					<div class="form-group">
						<label for="label">Etykieta Pola :</label>
						{{ Form::text("label", null, ['class'=>'form-control', 'placeholder'=>'Field Label',
						'data-rule-minlength' => 2, 'data-rule-maxlength'=>60, 'required' => 'required']) }}
					</div>
					
					<div class="form-group">
						<label for="colname">Nazwa kolumny :</label>
						{{ Form::text("colname", null, ['class'=>'form-control', 'placeholder'=>'Column Name (lowercase)', 'data-rule-minlength' => 2, 'data-rule-maxlength'=>20, 'data-rule-banned-words' => 'true', 'required' => 'required']) }}
					</div>
					
					<div class="form-group">
						<label for="field_type">Typ interfejsu użytkownika:</label>
						{{ Form::select("field_type", $ftypes, null, ['class'=>'form-control', 'required' => 'required']) }}
					</div>
					
					<div id="unique_val">
						<div class="form-group">
							<label for="unique">Unikalny:</label>
							{{ Form::checkbox("unique", "unique") }}
							<div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
						</div>
					</div>

					<div class="form-group">
						<label for="defaultvalue">Domyślna wartość :</label>
						{{ Form::text("defaultvalue", null, ['class'=>'form-control', 'placeholder'=>'Domyślna wartość']) }}
					</div>
					
					<div id="length_div">
						<div class="form-group">
							<label for="minlength">Minimum :</label>
							{{ Form::number("minlength", null, ['class'=>'form-control', 'placeholder'=>'Domyślna wartość']) }}
						</div>
						
						<div class="form-group">
							<label for="maxlength">Makimum :</label>
							{{ Form::number("maxlength", null, ['class'=>'form-control', 'placeholder'=>'Domyślna wartość']) }}
						</div>
					</div>
					
					<div class="form-group">
						<label for="required">Wymagane:</label>
						{{ Form::checkbox("required", "required") }}
						<div class="Switch Round Off" style="vertical-align:top;margin-left:10px;"><div class="Toggle"></div></div>
					</div>
					
					<div class="form-group values">
						<label for="popup_vals">Wartości :</label>
						<?php
						$default_val = "";
						$popup_value_type_table = false;
						$popup_value_type_list = false;
						if(starts_with($field->popup_vals, "@")) {
							$popup_value_type_table = true;
							$default_val = str_replace("@", "", $field->popup_vals);
						} else if(starts_with($field->popup_vals, "[")) {
							$popup_value_type_list = true;
							$default_val = json_decode($field->popup_vals);
						}
						?>
						<div class="radio" style="margin-bottom:20px;">
							<label>{{ Form::radio("popup_value_type", "table", $popup_value_type_table) }} z
								tabeli</label>
							<label>{{ Form::radio("popup_value_type", "list", $popup_value_type_list) }} z listy</label>
						</div>
						{{ Form::select("popup_vals_table", $tables, $default_val, ['class'=>'form-control', 'rel' => '']) }}
						
						<select class="form-control popup_vals_list" rel="taginput" multiple="1" data-placeholder="Dodaj wiele wartości (naciśnij klawisz Enter, aby dodać)" name="popup_vals_list[]">
							@if(is_array($default_val))
								@foreach ($default_val as $value)
									<option selected>{{ $value }}</option>
								@endforeach
							@endif
						</select>
						
						<?php
						// print_r($tables);
						?>
					</div>
					
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Aktualizuj', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/modules/'.$module->id) }}">Anuluj</a></button>
					</div>
				{!! Form::close() !!}
				
				@if($errors->any())
				<ul class="alert alert-danger">
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
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
	$("select.popup_vals_list").show();
	$("select.popup_vals_list").next().show();
	$("select[name='popup_vals_table']").hide();
	
	function showValuesSection() {
		var ft_val = $("select[name='field_type']").val();
		if(ft_val == 7 || ft_val == 15 || ft_val == 18 || ft_val == 20) {
			$(".form-group.values").show();
		} else {
			$(".form-group.values").hide();
		}
		
		$('#length_div').removeClass("hide");
		if(ft_val == 2 || ft_val == 4 || ft_val == 5 || ft_val == 7 || ft_val == 9 || ft_val == 11 || ft_val == 12 || ft_val == 15 || ft_val == 18 || ft_val == 21 || ft_val == 24 ) {
			$('#length_div').addClass("hide");
		}
		
		$('#unique_val').removeClass("hide");
		if(ft_val == 1 || ft_val == 2 || ft_val == 3 || ft_val == 7 || ft_val == 9 || ft_val == 11 || ft_val == 12 || ft_val == 15 || ft_val == 18 || ft_val == 20 || ft_val == 21 || ft_val == 24 ) {
			$('#unique_val').addClass("hide");
		}
	}

	$("select[name='field_type']").on("change", function() {
		showValuesSection();
	});
	showValuesSection();

	function showValuesTypes() {
		console.log($("input[name='popup_value_type']:checked").val());
		if($("input[name='popup_value_type']:checked").val() == "list") {
			$("select.popup_vals_list").show();
			$("select.popup_vals_list").next().show();
			$("select[name='popup_vals_table']").hide();
		} else {
			$("select[name='popup_vals_table']").show();
			$("select.popup_vals_list").hide();
			$("select.popup_vals_list").next().hide();
		}
	}
	
	$("input[name='popup_value_type']").on("change", function() {
		showValuesTypes();
	});
	showValuesTypes();

	$.validator.addMethod("data-rule-banned-words", function(value) {
		return $.inArray(value, ['files']) == -1;
	}, "Column name not allowed.");

	$("#field-edit-form").validate({
		
	});
});
</script>
@endpush