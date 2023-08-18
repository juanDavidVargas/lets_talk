@extends('layouts.layout')
@section('title', 'BD Conection')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@stop

{{-- ===================================== --}}

@section('content')
    <h1>Error de conexión a la base de datos</h1>
    <p>No se pudo establecer una conexión con la base de datos. Por favor, inténtelo nuevamente más tarde.</p>
    <p>{{ $message }}</p>
@stop

{{-- ===================================== --}}

@section('scripts')
    <script>

    </script>
@stop

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error de conexión</title>
</head>
<body>
    <h1>Error de conexión a la base de datos</h1>
    <p>No se pudo establecer una conexión con la base de datos. Por favor, inténtelo nuevamente más tarde.</p>
</body>
</html> --}}