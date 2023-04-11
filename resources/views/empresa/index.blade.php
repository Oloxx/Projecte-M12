@extends('layout')

@section('title', 'Llistat d\'empreses')

@section('stylesheets')
@parent
@endsection

@section('content')
<h1>Llistat d'Empreses</h1>
<a href="{{ route('empresa_create') }}">+ Nova Empresa</a>

@if (session('status'))
<div>
    <strong>Success!</strong> {{ session('status') }}
</div>
@endif

<table style="margin-top: 20px;margin-bottom: 10px;">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Telefón</th>
            <th>Web</th>
            <th>E-mail</th>
            <th>Poblacio</th>
            <th>Categoria</th>
            <th>Sector</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empreses as $empresa)
        <tr>
            <td>{{ $empresa->nom }}</td>
            <td>{{ $empresa->telefon }}</td>
            <td>{{ $empresa->web }}</td>
            <td>{{ $empresa->email }}</td>
            <td>{{ $empresa->poblacio->nom }}</td>
            <td>{{ $empresa->categoria->nom }}</td>@if($empresa->sector_id)<td>{{ $empresa->sector->nom }}</td>@endif
            <td>
                <a href="{{ route('empresa_show', ['id' => $empresa->id]) }}">+ Info</a>
                <a href="{{ route('empresa_edit', ['id' => $empresa->id]) }}">Editar</a>
                <form method="POST" action="{{ route('empresa_delete', ['id' => $empresa->id]) }}">
                    @csrf
                    @method('delete')
                    <input type="submit" id="delete" value="Eliminar">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>
@endsection