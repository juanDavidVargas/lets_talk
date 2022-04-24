@extends('layouts.layout')
@section('title', 'Create')
@section('css')
{{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
@stop
@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <h1 class="text-center text-uppercase">Create New User</h1>
    </div>
</div>

{!! Form::open(['method' => 'POST', 'class' => 'login100-form validate-form']) !!}
@csrf
    <div class="row m-t-30">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="wrap-input100 validate-input" data-validate="Name Is Required">
                {!! Form::text('nombres', null, ['class' => 'input100', 'id' => 'nombres']) !!}
                <span class="focus-input100" data-placeholder="Name"></span>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="wrap-input100 validate-input" data-validate="Surname Is Required">
                {!! Form::text('apellidos', null, ['class' => 'input100', 'id' => 'apellidos']) !!}
                <span class="focus-input100" data-placeholder="Surname"></span>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="wrap-input100 validate-input" data-validate="Document Type Is Required">
                {!! Form::select('id_tipo_documento', [], null, ['class' => 'input100 select2', 'id' => 'id_tipo_documento']) !!}
                <span class="focus-input100" data-placeholder="Document Type"></span>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="wrap-input100 validate-input" data-validate="Document Number Is Required">
                {!! Form::text('numero_documento', null, ['class' => 'input100', 'id' => 'numero_documento']) !!}
                <span class="focus-input100" data-placeholder="Document Number"></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="form-group">
                <label for="id_municipio_nacimiento">Place Of Birth</label>
                {!! Form::select('id_municipio_nacimiento', [], null, ['class' => 'form-control select2', 'placeholder' => 'Place Of Birth...']) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="form-group">
                <label for="fecha_nacimiento">Date Of Birth</label>
                {!! Form::date('fecha_nacimiento', null, ['class' => 'form-control', 'placeholder' => 'Date Of Birth...']) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="form-group">
                <label for="genero">Genre</label>
                {!! Form::select('genero', ['M' => 'Masculino', 'F' => 'Femenino'], null, ['class' => 'form-control select2', 'placeholder' => 'Select...']) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="form-group">
                <label for="estado">State</label>
                {!! Form::select('estado', ['1' => 'Activo', '0' => 'Inactivo'], null, ['class' => 'form-control select2', 'placeholder' => 'Select...']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="form-group">
                <label for="telefono">Phone</label>
                {!! Form::text('telefono', null, ['class' => 'form-control', 'placeholder' => 'Phone...']) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="form-group">
                <label for="celular">Mobile Phone</label>
                {!! Form::text('celular', null, ['class' => 'form-control', 'placeholder' => 'Mobile Phone...']) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="form-group">
                <label for="correo">Email</label>
                {!! Form::email('correo', null, ['class' => 'form-control', 'placeholder' => 'Email...']) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="form-group">
                <label for="direccion_residencia">Residence Address</label>
                {!! Form::email('direccion_residencia', null, ['class' => 'form-control', 'placeholder' => 'Residence Address...']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="form-group">
                <label for="id_municipio_residencia">Residence City</label>
                {!! Form::select('direccion_residencia', [], null, ['class' => 'form-control select2', 'placeholder' => 'Select...']) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="form-group">
                <label for="id_rol">Role</label>
                {!! Form::select('id_rol', [], null, ['class' => 'form-control select2', 'placeholder' => 'Select...']) !!}
            </div>
        </div>
    </div>

    <div class="row m-b-45">
        <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4">
            <div class="container-login100-form-btn">
                <div class="wrap-login100-form-btn">
                    <div class="login100-form-bgbtn"></div>
                    <button class="login100-form-btn" type="submit" id="btn_save_user" name="btn_save_user">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>

{!! Form::close() !!}
</form>

@stop
@section('scripts')

<script>

    $( document ).ready(function() {
        $("#nombres").trigger('focus');
    });

</script>
@endsection
