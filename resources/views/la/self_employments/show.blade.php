@extends('la.layouts.app')

@section('htmlheader_title')
	Spółka Samozatrudniająca Widok
@endsection


@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
		<div class="col-md-2">
			<div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>
		</div>
		<div class="col-md-7">
			<h1 class="name">{{ $self_employment->$view_col }}</h1>
		</div>

		<div class="col-md-1 actions">
			@la_access("Self_Employments", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/self_employments/'.$self_employment->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
			@endla_access
			
			@la_access("Self_Employments", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.self_employments.destroy', $self_employment->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endla_access
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/self_employments') }}" data-toggle="tooltip" data-placement="right" title="Powrót do listy"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> Ogólne informacje</a></li>
		<li class=""><a role="tab" data-toggle="tab" href="#tab-payroll" data-target="#tab-payroll"><i class="fa fa fa-cube"></i> Payroll</a></li>
		<li class=""><a role="tab" data-toggle="tab" href="#tab-vat" data-target="#tab-vat"><i class="fa fa-clock-o"></i> VAT</a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>Informacje ogólne</h4>
					</div>
					<div class="panel-body">
						@la_display($module, 'name_username')
						@la_display($module, 'trade_name')
						@la_display($module, 'we_support')
						@la_display($module, 'registration_date')
						@la_display($module, 'phone_number')
						@la_display($module, 'email_address')
						@la_display($module, 'annotations')
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-payroll">
			<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>Payroll</h4>
					</div>
					<div class="panel-body">
					@la_display($module, 'payroll')
					</div>
					</div>
		</div>
		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-vat">
			<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>Vat</h4>
					</div>
					<div class="panel-body">
					@la_display($module, 'vat')
						@la_display($module, 'vat_number')
						@la_display($module, 'end_date_1')
						@la_display($module, 'end_date_2')
						@la_display($module, 'end_date_3')
						@la_display($module, 'end_date_4')
					</div>
					</div>
		</div>
		
	</div>
	</div>
	</div>
</div>
@endsection
