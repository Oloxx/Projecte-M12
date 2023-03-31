@extends('layout')

@section('title', 'Llistat de biblioteques')

@section('stylesheets')
@parent
@endsection

@section('content')
<h1>Llistat d'Empreses</h1>
<a href="{{ route('empresa.create') }}">+ Nova Empresa</a>

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
            <th>Contacte</th>
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
                <a href="{{ route('empresa.edit', ['empresa' => $empresa->id]) }}">Editar</a>
                <form method="POST" action="{{ route('empresa.destroy', ['empresa' => $empresa->id]) }}">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Eliminar">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>
@endsection