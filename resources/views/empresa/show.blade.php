@extends('layout')

@section('title', 'Empresa')

@section('stylesheets')
@parent
@endsection

@section('content')
<h1>Informació Empresa </h1>
<a href="{{ route('empresa_index') }}">&laquo; Torna</a>
<div style="margin-top: 20px">
    <div>
        <label for="nom"><b>Nom</b></label>
        <span>{{$empresa->nom}}</span>
    </div>
    <div>
        <label for="telefon"><b>Telèfon</b></label>
        <span>{{$empresa->telefon}}</span>
    </div>
    <div>
        <label for="web"><b>Web</b></label>
        <span>{{$empresa->web}}</span>
    </div>
    <div>
        <label for="email"><b>E-mail</b></label>
        <span>{{$empresa->email}}</span>
    </div>
    <div>
        <label for="poblacio_id"><b>Poblacio</b></label>
        <span>{{$empresa->poblacio->nom}}</span>
    </div>
    <div>
        <label for="categoria_id"><b>Categoria</b></label>
        <span>{{$empresa->categoria->nom}}</span>
    </div>
    <div>
        <label for="sector_id"><b>Sector</b></label>
        <span>{{$empresa->sector->nom}}</span>
    </div>

    <table style="margin-top: 20px;margin-bottom: 10px;">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Cognoms</th>
                <th>Mólvil</th>
                <th>E-mail</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contactes as $contacte)
            <tr>
                <td>{{ $contacte->nom }}</td>
                <td>{{ $contacte->cognoms }}</td>
                <td>{{ $contacte->movil }}</td>
                <td>{{ $contacte->email }}</td>
                <td>
                    <a href="{{ route('contacte_edit', ['id' => $contacte->id]) }}">Editar</a>
                    <form method="POST" action="{{ route('contacte_delete', ['id' => $contacte->id]) }}">
                    @csrf
                    @method('delete')
                    <input type="submit" id="delete" value="Eliminar">
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <a href="{{ route('empresa_index') }}">Anar a Llistat</a>
    <a href="{{ route('empresa_create') }}">Crear nova empresa</a>
    <a href="{{ route('contacte_create', ['id' => $empresa->id])}}">Afegir contacte</a>

</div>
@endsection