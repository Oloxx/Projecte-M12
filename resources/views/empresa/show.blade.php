@extends('layout')

@section('title', 'Empresa')

@section('stylesheets')
@parent
@endsection

@section('content')
<h1>Nova Empresa </h1>
<a href="{{ route('empresa.index') }}">&laquo; Torna</a>
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
        <span>{{$empresa->poblacio_id}}</span>
    </div>
    <div>
        <label for="categoria_id"><b>Categoria</b></label>
        <span>{{$empresa->categoria_id}}</span>
    </div>
    <div>
        <label for="sector_id"><b>Sector</b></label>
        <span>{{$empresa->sector_id}}</span>
    </div>
    <a href="{{ route('empresa.index')}}">Anar a Llistat</a>
    <a href="{{ route('empresa.create')}}">Crear nova empresa</a>


    
</div>
@endsection