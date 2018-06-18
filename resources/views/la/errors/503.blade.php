@extends('la.layouts.app')

@section('htmlheader_title')
    Serwis niedostępny
@endsection

@section('contentheader_title')
    503 Strona Błędu
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')

    <div class="error-page">
        <h2 class="headline text-red">503</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> Ups! Coś poszło nie tak.</h3>
            <p>
                Będziemy pracować nad naprawieniem tego od razu.
                                 Tymczasem możesz <a href='{{ url('/home') }}'> wrócić do pulpitu nawigacyjnego </a> lub spróbować skorzystać z formularza wyszukiwania.
            </p>
            <form class='search-form'>
                <div class='input-group'>
                    <input type="text" name="search" class='form-control' placeholder="Szukaj"/>
                    <div class="input-group-btn">
                        <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                    </div>
                </div><!-- /.input-group -->
            </form>
        </div>
    </div><!-- /.error-page -->
@endsection