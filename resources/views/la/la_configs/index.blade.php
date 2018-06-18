@extends("la.layouts.app")

@section("contentheader_title", "Konfiguracja")
@section("contentheader_description", "")
@section("section", "Konfiguracja")
@section("sub_section", "")
@section("htmlheader_title", "Konfiguracja")

@section("headerElems")
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
<form action="{{route(config('laraadmin.adminRoute').'.la_configs.store')}}" method="POST">
	<!-- general form elements disabled -->
	<div class="box box-warning">
		<div class="box-header with-border">
			<h3 class="box-title">Ustawienia GUI</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			{{ csrf_field() }}
			<!-- text input -->
			<div class="form-group">
				<label>Nazwa strony</label>
				<input type="text" class="form-control" placeholder="Firma w Anglii" name="sitename"
					   value="{{$configs->sitename}}">
			</div>
			<div class="form-group">
				<label>Pierwsze Słowo firmy</label>
				<input type="text" class="form-control" placeholder="Firma w Anglii" name="sitename_part1" value="{{$configs->sitename_part1}}">
			</div>
			<div class="form-group">
				<label>Drugie słowo firmy</label>
				<input type="text" class="form-control" placeholder="Admin 1.0" name="sitename_part2" value="{{$configs->sitename_part2}}">
			</div>
			<div class="form-group">
				<label>Skrót (2/3 litery)</label>
				<input type="text" class="form-control" placeholder="FWa" maxlength="2" name="sitename_short"
					   value="{{$configs->sitename_short}}">
			</div>
			<div class="form-group">
				<label>Opis strony</label>
				<input type="text" class="form-control" placeholder="Opis 140 znaków" maxlength="140" name="site_description" value="{{$configs->site_description}}">
			</div>
			<!-- checkbox -->
			<div class="form-group">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="sidebar_search" @if($configs->sidebar_search) checked @endif>
						Pokaż pasek wyszukiwania
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="show_messages" @if($configs->show_messages) checked @endif>
						Pokaż ikonę wiadomości
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="show_notifications" @if($configs->show_notifications) checked @endif>
						Pokaż ikonę powiadomień
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="show_tasks" @if($configs->show_tasks) checked @endif>
						Pokaż ikonę zadań
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="show_rightsidebar" @if($configs->show_rightsidebar) checked @endif>
						Pokaż ikonę po prawej stronie
					</label>
				</div>
			</div>
			<!-- select -->
			<div class="form-group">
				<label>Wygląd strony</label>
				<select class="form-control" name="skin">
					@foreach($skins as $name=>$property)
						<option value="{{ $property }}" @if($configs->skin == $property) selected @endif>{{ $name }}</option>
					@endforeach
				</select>
			</div>
			
			<div class="form-group">
				<label>Układ</label>
				<select class="form-control" name="layout">
					@foreach($layouts as $name=>$property)
						<option value="{{ $property }}" @if($configs->layout == $property) selected @endif>{{ $name }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label>Domyślny adres e-mail</label>
				<input type="text" class="form-control" placeholder="Aby wysyłać e-maile do innych przez SMTP" maxlength="100" name="default_email" value="{{$configs->default_email}}">
			</div>
		</div><!-- /.box-body -->
		<div class="box-footer">
			<button type="submit" class="btn btn-primary">Zachowaj</button>
		</div><!-- /.box-footer -->
	</div><!-- /.box -->
</form>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>

@endpush
