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
{!! Form::model($usuario, ['method' => 'PUT', 'route' => ['administrador.update', $usuario->id_user], 'class' => 'login100-form validate-form', 'autocomplete' => 'off']) !!}

@include('administrador.fields')

{!! Form::close() !!}

@stop
@section('scripts')
<script>
    $(document).ready(function() {
        window.$(".select2").prepend(new Option("Select Contact...", "-1"));
        $("#nombres").trigger('focus');
        $("#apellidos").trigger('focus');
        $("#id_municipio_nacimiento").trigger('focus');
        $("#id_tipo_documento").trigger('focus');
        $("#numero_documento").trigger('focus');
        $("#id_municipio_nacimiento").trigger('focus');
        $("#fecha_nacimiento").trigger('focus');
        $("#estado").trigger('focus');
        $("#direccion_residencia").trigger('focus');
        $("#contacto2").trigger('focus');
        $("#contacto_opcional").trigger('focus');
        $("#genero").trigger('focus');
        $("#id_municipio_residencia").trigger('focus');
        $("#id_rol").trigger('focus');
        $("#id_nivel").trigger('focus');
        $("#id_tipo_ingles").trigger('focus');
        $("#id_primer_contacto").val("-1").trigger('focus');

        let id_rol = $("#id_rol").val();

        if (id_rol == 3 || id_rol == "3") {
            $("#div_nivel").show('slow');
            $("#div_nivel").removeClass('ocultar');
            $("#div_tipo_ing").hide('slow');
            $("#div_tipo_ing").addClass('ocultar');

            $("#id_nivel").trigger('focus');

        } else {

            $("#div_nivel").hide('slow');
            $("#div_nivel").addClass('ocultar');
            $("#div_tipo_ing").show('slow');
            $("#div_tipo_ing").removeClass('ocultar');

            $("#id_tipo_ingles").trigger('focus');
        }
    });

    $("#numero_documento").blur(function() {

        let num_doc = $("#numero_documento").val();
        let id_usuario = $("#id_usuario").val();

        $.ajax({
            async: false
            , url: "{{route('validar_cedula_edicion')}}"
            , type: "POST"
            , dataType: "json"
            , data: {
                'numero_documento': num_doc
                , 'id_usuario': id_usuario
            }
            , success: function(response) {
                if (response == "existe_doc") {
                    $("#numero_documento").val('');

                    Swal.fire({
                        position: 'center'
                        , title: 'Info!'
                        , html: 'There is already a record with the document number entered!'
                        , type: 'info'
                        , showCancelButton: false
                        , showConfirmButton: false
                        , allowOutsideClick: false
                        , allowEscapeKey: false
                        , timer: 6000
                    });

                    return;
                }

                if (response == "error_exception") {
                    Swal.fire({
                        position: 'center'
                        , title: 'Error!'
                        , html: 'An error occurred, contact support!'
                        , type: 'error'
                        , showCancelButton: false
                        , showConfirmButton: false
                        , allowOutsideClick: false
                        , allowEscapeKey: false
                        , timer: 6000
                    });

                    return;
                }
            }
        });
    });

    $("#correo").blur(function() {

        let correo = $("#correo").val();
        let id_usuario = $("#id_usuario").val();

        $.ajax({
            async: false
            , url: "{{route('validar_correo_edicion')}}"
            , type: "POST"
            , dataType: "json"
            , data: {
                'email': correo
                , 'id_usuario': id_usuario
            }
            , success: function(response) {
                if (response == "existe_correo") {
                    $("#correo").val('');

                    Swal.fire({
                        position: 'center'
                        , title: 'Info!'
                        , html: 'A similar email already exists in our database!'
                        , type: 'info'
                        , showCancelButton: false
                        , showConfirmButton: false
                        , allowOutsideClick: false
                        , allowEscapeKey: false
                        , timer: 6000
                    });

                    return;
                }

                if (response == "error_exception_correo") {
                    Swal.fire({
                        position: 'center'
                        , title: 'Error!'
                        , html: 'An error occurred, contact support!'
                        , type: 'error'
                        , showCancelButton: false
                        , showConfirmButton: false
                        , allowOutsideClick: false
                        , allowEscapeKey: false
                        , timer: 6000
                    });

                    return;
                }
            }
        });
    });

    $("#id_rol").change(function() {
        let id_rol = $("#id_rol").val();

        if (id_rol == 3 || id_rol == "3") {
            $("#div_nivel").show('slow');
            $("#div_nivel").removeClass('ocultar');
            $("#div_tipo_ing").hide('slow');
            $("#div_tipo_ing").addClass('ocultar');

            $("#id_nivel").trigger('focus');

        } else {

            $("#div_nivel").hide('slow');
            $("#div_nivel").addClass('ocultar');
            $("#div_tipo_ing").show('slow');
            $("#div_tipo_ing").removeClass('ocultar');

            $("#id_tipo_ingles").trigger('focus');
        }
    });

    $("#id_primer_contacto").change(function() {
        let primer_contacto_valor_edit = $("#id_primer_contacto").val();

        if (primer_contacto_valor_edit == 1) // Phone
        {
            $("#div_telefono").removeClass('ocultar');
            $("#div_celular_whatsapp").addClass('ocultar');
            $("#div_celular_whatsapp").hide('slow');
            $("#div_correo").addClass('ocultar');
            $("#div_correo").hide('slow');
            $("#div_skype").addClass('ocultar');
            $("#div_skype").hide('slow');
            $("#div_zoom").addClass('ocultar');
            $("#div_zoom").hide('slow');
            $("#telefono").trigger('focus');
        } else if (primer_contacto_valor_edit == 2) // Whatsapp - Celular
        {
            $("#div_celular_whatsapp").removeClass('ocultar');
            $("#div_telefono").addClass('ocultar');
            $("#div_telefono").hide('slow');
            $("#div_correo").addClass('ocultar');
            $("#div_correo").hide('slow');
            $("#div_skype").addClass('ocultar');
            $("#div_skype").hide('slow');
            $("#div_zoom").addClass('ocultar');
            $("#div_zoom").hide('slow');
            $("#celular").trigger('focus');
        } else if (primer_contacto_valor_edit == 3) // Skype
        {
            $("#div_skype").removeClass('ocultar');
            $("#div_telefono").addClass('ocultar');
            $("#div_telefono").hide('slow');
            $("#div_celular_whatsapp").addClass('ocultar');
            $("#div_celular_whatsapp").hide('slow');
            $("#div_correo").addClass('ocultar');
            $("#div_correo").hide('slow');
            $("#div_zoom").addClass('ocultar');
            $("#div_zoom").hide('slow');
            $("#skype").trigger('focus');
        } else if (primer_contacto_valor_edit == 4) // Email
        {
            $("#div_correo").removeClass('ocultar');
            $("#div_telefono").addClass('ocultar');
            $("#div_telefono").hide('slow');
            $("#div_celular_whatsapp").addClass('ocultar');
            $("#div_celular_whatsapp").hide('slow');
            $("#div_skype").addClass('ocultar');
            $("#div_skype").hide('slow');
            $("#div_zoom").addClass('ocultar');
            $("#div_zoom").hide('slow');
            $("#correo").trigger('focus');
        } else if (primer_contacto_valor_edit == 5) // Zoom
        {
            $("#div_zoom").removeClass('ocultar');
            $("#div_telefono").addClass('ocultar');
            $("#div_telefono").hide('slow');
            $("#div_celular_whatsapp").addClass('ocultar');
            $("#div_celular_whatsapp").hide('slow');
            $("#div_skype").addClass('ocultar');
            $("#div_skype").hide('slow');
            $("#div_correo").addClass('ocultar');
            $("#div_correo").hide('slow');
            $("#zoom").trigger('focus');
        } else {
            $("#div_telefono").addClass('ocultar');
            $("#div_telefono").hide('slow');
            $("#div_celular_whatsapp").addClass('ocultar');
            $("#div_celular_whatsapp").hide('slow');
            $("#div_skype").addClass('ocultar');
            $("#div_skype").hide('slow');
            $("#div_correo").addClass('ocultar');
            $("#div_correo").hide('slow');
            $("#div_zoom").addClass('ocultar');
            $("#div_zoom").hide('ocultar');
        }
    });

</script>
@endsection
