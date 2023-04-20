@extends('layout')

@section('title', 'Empresa')

@section('stylesheets')
@parent
@endsection

@section('content')
<h1>Nova Empresa </h1>
<a href="{{ route('empresa_index') }}">&laquo; Torna</a>
<div style="margin-top: 20px">
    <div>
        <label for="nom"><b>Nom</b></label>
        <span>{{$contacte->nom}}</span>
    </div>
    <div>
        <label for="cognoms"><b>Telèfon</b></label>
        <span>{{$contacte->cognoms}}</span>
    </div>
    <div>
        <label for="movil"><b>Web</b></label>
        <span>{{$contacte->movil}}</span>
    </div>
    <div>
        <label for="email"><b>E-mail</b></label>
        <span>{{$contacte->email}}</span>
    </div>
    <a href="{{ route('empresa_index')}}">Anar a Llistat</a>
    <a href="{{ route('empresa_create')}}">Crear nova empresa</a>


    
</div>
@endsection