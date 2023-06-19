@extends('layouts.layout')
@section('title', 'Show')
@section('css')
@stop
@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <h1 class="text-center text-uppercase">Details User {{$usuario->nombres}}</h1>
    </div>
</div>

<div class="row m-b-30 m-t-30">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <a class="btn btn-warning" href="{{route('administrador.index')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back</a>
    </div>
</div>

<hr>

@include('administrador.fields_show')

@stop
@section('scripts')
<script>
    $(document).ready(function() {
        $("#nombres").trigger('focus');
        $("#apellidos").trigger('focus');
        $("#id_municipio_nacimiento").trigger('focus');
        $("#id_tipo_documento").trigger('focus');
        $("#numero_documento").trigger('focus');
        $("#id_municipio_nacimiento").trigger('focus');
        $("#fecha_nacimiento").trigger('focus');
        $("#estado").trigger('focus');
        $("#telefono").trigger('focus');
        $("#celular").trigger('focus');
        $("#direccion_residencia").trigger('focus');
        $("#correo").trigger('focus');
        $("#contacto2").trigger('focus');
        $("#contacto_opcional").trigger('focus');
        $("#skype").trigger('focus');
        $("#zoom").trigger('focus');
        $("#genero").trigger('focus');
        $("#id_municipio_residencia").trigger('focus');
        $("#id_rol").trigger('focus');
        $("#id_nivel").trigger('focus');
        $("#id_tipo_ingles").trigger('focus');
        $("#id_primer_contacto").trigger('focus');
    });

</script>
@endsection
