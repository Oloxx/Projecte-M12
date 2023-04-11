@extends('layout')

@section('title', 'Editar Contacte')
@section('ajax')

@section('stylesheets')
@parent
@endsection

@section('content')
<h1>Editar Contacte</h1>
<a href="{{ route('collaboracio_index') }}">&laquo; Torna</a>
<div style="margin-top: 20px">
    <form method="POST" action="{{ route('collaboracio_update', ['id' => $collaboracio->id]) }}">
        @csrf
        @method('PUT')
        <div>
            <label for="empresa">Empresa</label>
            <select name="empresa" id='empresa_id'>
                <option value="">-- selecciona una empresa --</option>
                @foreach ($empreses as $empresa)
                <option value="{{ $empresa->id }}" @selected($collaboracio->empresa_id == $empresa->id)>{{ $empresa->nom}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="contacte">Contacte</label>
            <select name="contacte" id='contacte_id'>
                <option value="">-- selecciona una contacte --</option>
                @if($contactes)
                @foreach ($contactes as $contacte)
                <option value="{{ $contacte->id }}" @selected($collaboracio->contacte_id == $contacte->id)>{{ $contacte->nom}} {{ $contacte->cognoms}}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div>
            <label for="cicle">Cicle</label>
            <select name="cicle" id="contacte">
                <option value="">Selecciona un cicle</option>
                @foreach ($cicles as $cicle)
                <option value="{{$cicle->id}}" @selected($collaboracio->cicle_id == $cicle->id)>{{$cicle->codi}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="year">Any</label>
            <select name="year">
                <option value="">selecciona l'any</option>
                @for($i = ($year-30); $i < $year; $i++) 
                    <option value="{{ $i }}" @selected($collaboracio->any == $i)>{{$i}}</option>
                @endfor
            </select>
        </div>
        <div>
            <label for="comentaris">Comentari</label>
            <textarea name="comentaris" cols="30" rows="10">{{$collaboracio->comentaris}}</textarea>
        </div>
        <button type="submit">Desar</button>
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
                        contactes.innerHTML += `<option value="${dades[i].id}" @selected($collaboracio->contacte_id == $contacte->id)> ${dades[i].nom} ${dades[i].cognoms}</option>`
                    }
                } else {
                    contactes.innerHTML = '<option value="">Aquesta empresa no té contactes associats</option>'
                }
            }
        });
    }
</script>