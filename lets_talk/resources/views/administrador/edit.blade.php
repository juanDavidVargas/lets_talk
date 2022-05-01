@extends('layouts.layout')
@section('title', 'Edit')
@section('css')
@stop
@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <h1 class="text-center text-uppercase">Edit User</h1>
    </div>
</div>

<div class="row m-b-30 m-t-30">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <a class="btn btn-warning" href="{{route('administrador.index')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back</a>
    </div>
</div>

<hr>

{!! Form::model(['method' => 'PUT', 'route' => ['administrador.update', $usuario->id_user], 'class' => 'login100-form validate-form', 'autocomplete' => 'off']) !!}
@csrf

@include('administrador.fields')

{!! Form::close() !!}

@stop
@section('scripts')
<script>

    $( document ).ready(function()
    {
        $("#nombres").trigger('focus');
        $("#apellidos").trigger('focus');
        $("#id_municipio_nacimiento").trigger('focus');
        $("#id_tipo_documento").trigger('focus');
        $("#numero_documento").trigger('focus');
        $("#id_municipio_nacimiento").trigger('focus');
        $("#fecha_nacimiento").trigger('focus');
        $("#estado").trigger('focus');
        $("#genero").trigger('focus');
        $("#id_municipio_residencia").trigger('focus');
        $("#id_rol").trigger('focus');
    });

</script>
@endsection
