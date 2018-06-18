@extends('la.layouts.app')

@section('htmlheader_title')
	Partnership LLP Widok
@endsection


@section('main-content')
	<div id="page-content" class="profile2">
		<div class="bg-primary clearfix">
			<div class="col-md-2">
				<div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>

			</div>
			<div class="col-md-7">
				<h1 class="name">{{ $partnership_lp->$view_col }}</h1>
			</div>

			<div class="col-md-2 actions">
				@la_access("Partnership_LPs", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/partnership_lps/'.$partnership_lp->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
				@endla_access

				@la_access("Partnership_LPs", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.partnership_lps.destroy', $partnership_lp->id], 'method' => 'delete', 'style'=>'display:inline']) }}
				<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
				@endla_access
			</div>
		</div>

		<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
			<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/partnership_lps') }}"
							data-toggle="tooltip" data-placement="right" title="Powrót do listy"><i class="fa
							fa-chevron-left"></i></a></li>
			<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> Ogólne informacje</a></li>
			<li class=""><a role="tab" data-toggle="tab" href="#tab-tax" data-target="#tab-tax"><i class="fa fa fa-money"></i> Tax</a></li>
			<li class=""><a role="tab" data-toggle="tab" href="#tab-payroll" data-target="#tab-payroll"><i class="fa fa fa-cube"></i> Payroll</a></li>
			<li class=""><a role="tab" data-toggle="tab" href="#tab-vat" data-target="#tab-vat"><i class="fa fa-clock-o"></i> VAT</a></li>
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
				<div class="tab-content">
					<div class="panel infolist">
						<div class="panel-default panel-heading">
							<h4>Ogólne informacje</h4>
						</div>
						<div class="panel-body">
							@la_display($module, 'company_name')
							@la_display($module, 'we_support')
							@la_display($module, 'share_address')
							@la_display($module, 'registration_date')
							@la_display($module, 'company_number')
							@la_display($module, 'contact_person')
							@la_display($module, 'phone_number')
							@la_display($module, 'email_address')
							@la_display($module, 'contact_person_2')
							@la_display($module, 'phone_number_2')
							@la_display($module, 'email_address_2')
							@la_display($module, 'additional_remarks')

						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-tax">
				<div class="tab-content">
					<div class="panel infolist">
						<div class="panel-default panel-heading">
							<h4>Tax</h4>
						</div>
						<div class="panel-body">
							@la_display($module, 'first_set_period')
							@la_display($module, 'eof_first_settlement')
							@la_display($module, 'b_c_billing_periods')
							@la_display($module, 'end_of_set_period')

							@la_display($module, 'end_of_periods')

						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-payroll">
				<div class="tab-content">
					<div class="panel infolist">
						<div class="panel-default panel-heading">
							<h4>Payroll</h4>
						</div>
						<div class="panel-body">

							@la_display($module, 'payroll')

						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-vat">
				<div class="tab-content">
					<div class="panel infolist">
						<div class="panel-default panel-heading">
							<h4>Vat</h4>
						</div>
						<div class="panel-body">

							@la_display($module, 'vat')
							@la_display($module, 'vat_number')
							@la_display($module, 'date_periods_1')
							@la_display($module, 'date_periods_2')
							@la_display($module, 'date_periods_3')
							@la_display($module, 'date_periods_4')

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
@endsection
