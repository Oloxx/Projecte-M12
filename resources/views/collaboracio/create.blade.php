@extends('layout')

@section('title', 'Nova estada')
@section('ajax')

@section('stylesheets')
@parent
@endsection

@section('content')
<h1>Nova estada</h1>
<a href="{{ route('collaboracio_index') }}">&laquo; Torna</a>
<div style="margin-top: 20px">
    <form method="POST" action="{{ route('collaboracio_store') }}">
        @csrf
        <div>
            <label for="empresa">Empresa</label>
            <select name="empresa" id='empresa_id'>
                <option value="">-- selecciona una empresa --</option>
                @foreach ($empreses as $empresa)
                    <option value="{{ $empresa->id }}">{{ $empresa->nom}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="contacte">Contacte</label>
            <select name="contacte" id='contacte_id'>
                <option value="">Selecciona un valor rere seleccionar una empresa</option>
            </select>
        </div>
        <div>
            <label for="cicle">Cicle</label>
            <select name="cicle">
                <option value="">-- selecciona un cicle --</option>
                @foreach ($cicles as $cicle)
                    <option value="{{ $cicle->id }}">{{ $cicle->codi}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="year">Any</label>
            <select name="year">
                <option value="">-- selecciona un l'any --</option>
                @for ($i = 1970; $i < $year; $i++)
                    <option value="{{ $i }}">{{ $i}}</option>
                @endfor
            </select>
        </div>
        <input type="text" name="user" value={{$user}} hidden>
        <div>
            <label for="comentaris">Comentari</label>
            <textarea name="comentaris" cols="30" rows="10"></textarea>
        </div>
        <button type="submit">Crear Col·laboració</button>
    </form>
</div>
@endsection

<script>
    window.onload = function() {
        var empresa = document.getElementById('empresa_id');
        var contactes = document.querySelector('select[name=contacte]');

        empresa.addEventListener('change', function(e) {

            var ruta = "{{ route('collaboracio_getcontactes') }}";
            var empresa_id = document.getElementById('empresa_id').value;

            $.ajax({
                type: "POST",
                url: ruta,
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': empresa_id
                },
                dataType: "JSON",
                success: mostrarDades
            });

            function mostrarDades(dades) {
                if (dades.length > 0) {
                    contactes.innerHTML = `<option value="">Selecciona un contacte </option>`
                    for (var i = 0; i < dades.length; i++) {
                        contactes.innerHTML += `<option value="${dades[i].id}"> ${dades[i].nom} ${dades[i].cognoms}</option>`
                    }
                } else {
                    contactes.innerHTML = '<option value="">Aquesta empresa no té contactes associats</option>'
                }
            }
        });
    }
</script>