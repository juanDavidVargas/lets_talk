@extends('layouts.layout')
@section('title', 'BD Conection')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@stop

{{-- ===================================== --}}

@section('content')
    <h3 style="margin-bottom: 1em;">Estado de conexión a la base de datos</h3>
    <p style="font-size: 18px">No se pudo conectar a la base de datos.</p>
@stop
