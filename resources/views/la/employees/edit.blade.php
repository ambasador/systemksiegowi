@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/employees') }}">Pracownicy</a> :
@endsection
@section("contentheader_description", $employee->$view_col)
@section("section", "Pracownicy")
@section("section_url", url(config('laraadmin.adminRoute') . '/employees'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Educja użytkowników : ".$employee->$view_col)

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
				{!! Form::model($employee, ['route' => [config('laraadmin.adminRoute') . '.employees.update', $employee->id ], 'method'=>'PUT', 'id' => 'employee-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'name')
					@la_input($module, 'designation')
					@la_input($module, 'gender')
					@la_input($module, 'mobile')
					@la_input($module, 'mobile2')
					@la_input($module, 'email')
					@la_input($module, 'dept')
					@la_input($module, 'city')
					@la_input($module, 'address')
					@la_input($module, 'about')
					@la_input($module, 'date_birth')
					@la_input($module, 'date_hire')
					@la_input($module, 'date_left')
					@la_input($module, 'salary_cur')
					--}}
                    <div class="form-group">
						<label for="role">Role* :</label>
						<select class="form-control" required="1" data-placeholder="Select Role" rel="select2" name="role">
							<?php $roles = App\Role::all(); ?>
							@foreach($roles as $role)
								@if($role->id != 1 || Entrust::hasRole("SUPER_ADMIN"))
									@if($user->hasRole($role->name))
										<option value="{{ $role->id }}" selected>{{ $role->name }}</option>
									@else
										<option value="{{ $role->id }}">{{ $role->name }}</option>
									@endif
								@endif
							@endforeach
						</select>
					</div>
					<br>
					<div class="form-group">
						{!! Form::submit( 'Aktualizuj', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/employees') }}">Anuluj</a></button>
					</div>
				{!! Form::close() !!}
				
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
	$("#employee-edit-form").validate({
		
	});
});
</script>
@endpush
