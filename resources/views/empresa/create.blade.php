@extends('layout')

@section('title', 'Nova Empresa')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <h1>Nova Empresa</h1>
    <a href="{{ route('empresa.index') }}">&laquo; Torna</a>
	<div style="margin-top: 20px">
        <form method="POST" action="{{ route('empresa.store') }}">
            @csrf
            <div>
                <label for="nom">Nom</label>
                <input type="text" name="nom" />
            </div>
            <div>
                <label for="telefon">Telèfon</label>
                <input type="text" name="telefon" />
            </div>
            <div>
                <label for="web">Web</label>
                <input type="text" name="web" />
            </div>
            <div>
                <label for="email">E-mail</label>
                <input type="text" name="email"  />
            </div>
            <div>
                <label for="poblacio_id">Poblacio</label>
                <select name="poblacio_id">
                    <option value="">-- selecciona un Poblacio --</option>
                    @foreach ($poblacions as $poblacio)
                        <option value="{{ $poblacio->id }}">{{ $poblacio->nom}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="categoria_id">Categoria</label>
                <select name="categoria_id">
                    <option value="">-- selecciona una categoria --</option>
                    @foreach ($categories as $categoria)
                        <option value="{{ $categoria->id }}" >{{ $categoria->nom}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="sector_id">Sector</label>
                <select name="sector_id">
                    <option value="">-- selecciona un Sector --</option>
                    @foreach ($sectors as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->nom}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit">Crear Empresa</button>
        </form>
	</div>
@endsection