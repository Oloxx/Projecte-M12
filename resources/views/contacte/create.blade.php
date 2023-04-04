@extends('layout')

@section('title', 'Nou Contacte')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <h1>Nou Contacte</h1>
    <a href="{{ route('empresa_index') }}">&laquo; Torna</a>
	<div style="margin-top: 20px">
        <form method="POST" action="{{ route('contacte_store') }}">
            @csrf
            <div>
                <label for="nom">Nom</label>
                <input type="text" name="nom" />
            </div>
            <div>
                <label for="cognoms">Cognoms</label>
                <input type="text" name="cognoms" />
            </div>
            <div>
                <label for="movil">Mòvil</label>
                <input type="text" name="movil" />
            </div>
            <div>
                <label for="email">E-mail</label>
                <input type="text" name="email"  />
            </div>
            <div>
                <label for="empresa">Empreses</label>
                <select name="empresa" id="empresa">
                    <option value="">Selecciona una empresa</option>
                    @foreach ($empreses as $empresa)
                    <option value="{{$empresa->id}}" @selected($idEmpresa == $empresa->id)>{{$empresa->nom}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit">Crear Contacte</button>
        </form>
	</div>
@endsection