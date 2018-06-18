@extends('la.layouts.app')

@section('htmlheader_title')
    Strona nie znaleziona
@endsection

@section('contentheader_title')
    404 Strona Błędu
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')

<div class="error-page">
    <h2 class="headline text-yellow"> 404</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> Ups! Strona nie znaleziona.</h3>
        <p>
            Nie mogliśmy znaleźć strony, której szukasz.
            Tymczasem możesz <a href='{{ url('/home') }}'> wrócić do pulpitu nawigacyjnego </a> lub spróbować skorzystać z formularza wyszukiwania.
        </p>
        <form class='search-form'>
            <div class='input-group'>
                <input type="text" name="search" class='form-control' placeholder="Szukaj"/>
                <div class="input-group-btn">
                    <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
                </div>
            </div><!-- /.input-group -->
        </form>
    </div><!-- /.error-content -->
</div><!-- /.error-page -->
@endsection