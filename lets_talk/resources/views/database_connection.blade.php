@extends('layouts.layout')
@section('title', 'BD Conection')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@stop

{{-- ===================================== --}}

@section('content')
    <h3 style="margin-bottom: 1em;">Estado de conexión a la base de datos</h3>
    {{-- <h1 class="m-b-5;">Estado de conexión a la base de datos</h1> --}}
    <p>{{ $message }}</p>
@stop

{{-- ===================================== --}}

@section('scripts')
    <script>

    </script>
@stop
