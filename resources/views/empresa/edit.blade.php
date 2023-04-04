@extends('layout')

@section('title', 'Editar Empresa')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <h1>Editar Empresa</h1>
    <a href="{{ route('empresa_index') }}">&laquo; Torna</a>
	<div style="margin-top: 20px">
        <form method="POST" action="{{ route('empresa_update', ['id' => $empresa->id]) }}">
            @csrf
            @method('PUT')
            <div>
                <label for="nom">Nom</label>
                <input type="text" name="nom" value="{{ $empresa->nom }}" />
            </div>
            <div>
                <label for="telefon">Telèfon</label>
                <input type="text" name="telefon" value="{{ $empresa->telefon }}" />
            </div>
            <div>
                <label for="web">Web</label>
                <input type="text" name="web" value="{{ $empresa->web }}" />
            </div>
            <div>
                <label for="email">E-mail</label>
                <input type="text" name="email" value="{{ $empresa->email }}" />
            </div>
            <div>
                <label for="poblacio_id">Poblacio</label>
                <select name="poblacio_id">
                    <option value="">-- selecciona un Poblacio --</option>
                    @foreach ($poblacions as $poblacio)
                        <option value="{{ $poblacio->id }}" @selected($empresa->poblacio_id == $poblacio->id)>{{ $poblacio->nom}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="categoria_id">Categoria</label>
                <select name="categoria_id">
                    <option value="">-- selecciona una categoria --</option>
                    @foreach ($categories as $categoria)
                        <option value="{{ $categoria->id }}" @selected($empresa->categoria_id == $categoria->id)>{{ $categoria->nom}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="sector_id">Sector</label>
                <select name="sector_id">
                    <option value="">-- selecciona un Sector --</option>
                    @foreach ($sectors as $sector)
                        <option value="{{ $sector->id }}" @selected($empresa->sector_id == $sector->id)>{{ $sector->nom}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit">Desar</button>
        </form>
	</div>
@endsection