@extends('layout')

@section('title', 'Llistat de biblioteques')

@section('stylesheets')
@parent
@endsection

@section('content')
<h1>Llistat d'Empreses</h1>
<a href="{{ route('contacte_createWithoutId') }}">+ Nou Contacte</a>

@if (session('status'))
<div>
    <strong>Success!</strong> {{ session('status') }}
</div>
@endif

<table style="margin-top: 20px;margin-bottom: 10px;">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Cognoms</th>
            <th>Mòvil</th>
            <th>E-mail</th>
            <th>Empresa</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($contactes as $contacte)
        <tr>
            <td>{{ $contacte->nom }}</td>
            <td>{{ $contacte->cognoms }}</td>
            <td>{{ $contacte->movil }}</td>
            <td>{{ $contacte->email }}</td>
            @if($contacte->empresa_id)<td>{{ $contacte->empresa->nom }}</td>@else<td>No pertany a cap empresa</td>@endif

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

<br>
@endsection