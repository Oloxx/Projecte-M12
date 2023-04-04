@extends('layout')

@section('title', 'Editar Contacte')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <h1>Editar Contacte</h1>
    <a href="{{ route('empresa_index') }}">&laquo; Torna</a>
	<div style="margin-top: 20px">
        <form method="POST" action="{{ route('contacte_update', ['id' => $contacte->id]) }}">
            @csrf
            @method('PUT')
            <div>
                <label for="nom">Nom</label>
                <input type="text" name="nom" value="{{ $contacte->nom }}" />
            </div>
            <div>
                <label for="cognoms">Cognoms</label>
                <input type="text" name="cognoms" value="{{ $contacte->cognoms }}" />
            </div>
            <div>
                <label for="movil">Mòvil</label>
                <input type="text" name="movil" value="{{ $contacte->movil }}" />
            </div>
            <div>
                <label for="email">E-mail</label>
                <input type="text" name="email" value="{{ $contacte->email }}" />
            </div>
            <div>
                <label for="empresa">Empreses</label>
                <select name="empresa" id="empresa">
                    <option value="">Selecciona una empresa</option>
                    @foreach ($empreses as $empresa)
                    <option value="{{$empresa->id}}" @selected($contacte->empresa_id == $empresa->id)>{{$empresa->nom}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit">Desar</button>
        </form>
	</div>
@endsection