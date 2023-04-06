@extends('layout')

@section('title', 'Llistat de col·laboracions')

@section('stylesheets')
@parent
@endsection

@section('content')
<h1>Llistat de col·laboracions</h1>
<a href="{{ route('collaboracio_create') }}">+ Nova Col·laboració</a>

@if (session('status'))
<div>
    <strong>Success!</strong> {{ session('status') }}
</div>
@endif

<table style="margin-top: 20px;margin-bottom: 10px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Empresa</th>
            <th>Contacte</th>
            <th>Cicle</th>
            <th>Curs</th>
            <th>Usuari</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($collaboracions as $collaboracio)
        <tr>
            <td>{{ $collaboracio->id }}</td>
            <td>{{ $collaboracio->empresa->nom }}</td>
            <td>{{ $collaboracio->contacte->nom }}</td>
            <td>{{ $collaboracio->cicle->codi }}</td>
            <td>{{ $collaboracio->any }}</td>
            <td>{{ $collaboracio->user->name }}</td>
            <td>
                <a href="{{ route('collaboracio_edit', ['id' => $collaboracio->id]) }}">Editar</a>
                <form method="POST" action="{{ route('collaboracio_delete', ['id' => $collaboracio->id]) }}">
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