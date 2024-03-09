@extends('layouts.layout')
@section('title', 'Create')
@section('css')
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-center text-uppercase">Create New User</h1>
        </div>
    </div>

    <div class="row m-b-30 m-t-30">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <a class="btn btn-warning" href="{{route('administrador.index')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back</a>
        </div>
    </div>

    <hr>

    {!! Form::open(['method' => 'POST', 'route' => ['administrador.store'], 'class' => 'login100-form validate-form', 'autocomplete' => 'off', 'id' => 'form_new_user', 'accept-charset' => 'UTF-8']) !!}
    @csrf
        @include('administrador.fields')
    {!! Form::close() !!}

    @include('layouts.loader')
@stop

@section('scripts')

<script>
    $(document).ready(function() 
    {
        setTimeout(() => {
            $("#loaderGif").hide();
            $("#loaderGif").addClass('ocultar');
        }, 1500);

        window.$(".select2").prepend(new Option("Select Contact...", "-1"));
        $("#nombres").trigger('focus');
        $("#apellidos").trigger('focus');
        $("#id_municipio_nacimiento").trigger('focus');
        $("#id_tipo_documento").trigger('focus');
        $("#numero_documento").trigger('focus');
        $("#id_municipio_nacimiento").trigger('focus');
        $("#fecha_nacimiento").trigger('focus');
        $("#estado").trigger('focus');
        $("#correo").trigger('focus');
        $("#celular").trigger('focus');
        $("#zoom").trigger('focus');
        $("#zoom_clave").trigger('focus');
        $("#direccion_residencia").trigger('focus');
        $("#genero").trigger('focus');
        $("#id_municipio_residencia").trigger('focus');
        $("#id_rol").trigger('focus');
        $("#id_nivel").trigger('focus');
        $("#id_tipo_ingles").trigger('focus');
        $("#id_primer_contacto").val("-1").trigger('focus');
        $("#id_segundo_contacto").val("-1").trigger('focus');
        $("#id_opcional_contacto").val("-1").trigger('focus');

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

        $.ajax({
            async: true
            , url: "{{route('validar_cedula')}}"
            , type: "POST"
            , dataType: "json"
            , data: {
                'numero_documento': num_doc
            }
            , beforeSend: function() {
                $("#loaderGif").show();
                $("#loaderGif").removeClass('ocultar');
            }
            , success: function(response) {
                if (response == "existe_doc") {

                    $("#loaderGif").hide();
                    $("#loaderGif").addClass('ocultar');
                    $("#numero_documento").val('');

                    Swal.fire({
                        position: 'center'
                        , title: 'Info!'
                        , html: 'There is already a record with the document number entered!'
                        , icon: 'info'
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
                    $("#loaderGif").hide();
                    $("#loaderGif").addClass('ocultar');
                    Swal.fire({
                        position: 'center'
                        , title: 'Error!'
                        , html: 'An error occurred, contact support!'
                        , icon: 'error'
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

        $.ajax({
            async: true
            , url: "{{route('validar_correo')}}"
            , type: "POST"
            , dataType: "json"
            , data: {
                'email': correo
            }
            , beforeSend: function() {
                $("#loaderGif").show();
                $("#loaderGif").removeClass('ocultar');
            }
            , success: function(response) {
                if (response == "existe_correo") {
                    $("#loaderGif").hide();
                    $("#loaderGif").addClass('ocultar');
                    $("#correo").val('');

                    Swal.fire({
                        position: 'center'
                        , title: 'Info!'
                        , html: 'A similar email already exists in our database!'
                        , icon: 'info'
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
                    $("#loaderGif").hide();
                    $("#loaderGif").addClass('ocultar');
                    Swal.fire({
                        position: 'center'
                        , title: 'Error!'
                        , html: 'An error occurred, contact support!'
                        , icon: 'error'
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
            $("#div_primer_telefono").removeClass('ocultar');
            $("#div_primer_celular_whatsapp").addClass('ocultar');
            $("#div_primer_celular_whatsapp").hide('slow');
            $("#div_primer_correo").addClass('ocultar');
            $("#div_primer_correo").hide('slow');
            $("#div_primer_skype").addClass('ocultar');
            $("#div_primer_skype").hide('slow');
            $("#div_primer_zoom").addClass('ocultar');
            $("#div_primer_zoom").hide('slow');
            $("#primer_telefono").trigger('focus');

            // Telefono
            $("#div_tel_1_cont").attr('data-validate', 'This Field is Required');
            $("#div_tel_1_cont").addClass('validate-input');

            // Correo
            $("#div_email_1_cont").removeClass('validate-input');
            $("#div_email_1_cont").removeAttr('data-validate');

            // Whatsapp
            $("#div_whats_1_cont").removeClass('validate-input');
            $("#div_whats_1_cont").removeAttr('data-validate');

            // Skype
            $("#div_skype_1_cont").removeClass('validate-input');
            $("#div_skype_1_cont").removeAttr('data-validate');

            // Zoom
            $("#div_zoom_1_cont").removeClass('validate-input');
            $("#div_zoom_1_cont").removeAttr('data-validate');

        } else if (primer_contacto_valor_edit == 2) // Whatsapp - Celular
        {
            $("#div_primer_celular_whatsapp").removeClass('ocultar');
            $("#div_primer_telefono").addClass('ocultar');
            $("#div_primer_telefono").hide('slow');
            $("#div_primer_correo").addClass('ocultar');
            $("#div_primer_correo").hide('slow');
            $("#div_primer_skype").addClass('ocultar');
            $("#div_primer_skype").hide('slow');
            $("#div_primer_zoom").addClass('ocultar');
            $("#div_primer_zoom").hide('slow');
            $("#primer_celular").trigger('focus');

            // Whatsapp
            $("#div_whats_1_cont").attr('data-validate', 'This Field is Required');
            $("#div_whats_1_cont").addClass('validate-input');

            // Correo
            $("#div_email_1_cont").removeClass('validate-input');
            $("#div_email_1_cont").removeAttr('data-validate');

            // Telefono
            $("#div_tel_1_cont").removeClass('validate-input');
            $("#div_tel_1_cont").removeAttr('data-validate');

            // Skype
            $("#div_skype_1_cont").removeClass('validate-input');
            $("#div_skype_1_cont").removeAttr('data-validate');

            // Zoom
            $("#div_zoom_1_cont").removeClass('validate-input');
            $("#div_zoom_1_cont").removeAttr('data-validate');

        } else if (primer_contacto_valor_edit == 3) // Skype
        {
            $("#div_primer_skype").removeClass('ocultar');
            $("#div_primer_telefono").addClass('ocultar');
            $("#div_primer_telefono").hide('slow');
            $("#div_primer_celular_whatsapp").addClass('ocultar');
            $("#div_primer_celular_whatsapp").hide('slow');
            $("#div_primer_correo").addClass('ocultar');
            $("#div_primer_correo").hide('slow');
            $("#div_primer_zoom").addClass('ocultar');
            $("#div_primer_zoom").hide('slow');
            $("#primer_skype").trigger('focus');

            // Skype
            $("#div_skype_1_cont").attr('data-validate', 'This Field is Required');
            $("#div_skype_1_cont").addClass('validate-input');

            // Correo
            $("#div_email_1_cont").removeClass('validate-input');
            $("#div_email_1_cont").removeAttr('data-validate');

            // Telefono
            $("#div_tel_1_cont").removeClass('validate-input');
            $("#div_tel_1_cont").removeAttr('data-validate');

            // Whatsapp
            $("#div_whats_1_cont").removeClass('validate-input');
            $("#div_whats_1_cont").removeAttr('data-validate');

            // Zoom
            $("#div_zoom_1_cont").removeClass('validate-input');
            $("#div_zoom_1_cont").removeAttr('data-validate');

        } else if (primer_contacto_valor_edit == 4) // Email
        {
            $("#div_primer_correo").removeClass('ocultar');
            $("#div_primer_telefono").addClass('ocultar');
            $("#div_primer_telefono").hide('slow');
            $("#div_primer_celular_whatsapp").addClass('ocultar');
            $("#div_primer_celular_whatsapp").hide('slow');
            $("#div_primer_skype").addClass('ocultar');
            $("#div_primer_skype").hide('slow');
            $("#div_primer_zoom").addClass('ocultar');
            $("#div_primer_zoom").hide('slow');
            $("#primer_correo").trigger('focus');

            // Correo
            $("#div_email_1_cont").addClass('validate-input');
            $("#div_email_1_cont").attr('data-validate', 'This Field is Required');

            // Telefono
            $("#div_tel_1_cont").removeClass('validate-input');
            $("#div_tel_1_cont").removeAttr('data-validate');

            // Whatsapp
            $("#div_whats_1_cont").removeClass('validate-input');
            $("#div_whats_1_cont").removeAttr('data-validate');

            // Skype
            $("#div_skype_1_cont").removeClass('validate-input');
            $("#div_skype_1_cont").removeAttr('data-validate');

            // Zoom
            $("#div_zoom_1_cont").removeClass('validate-input');
            $("#div_zoom_1_cont").removeAttr('data-validate');

        } else if (primer_contacto_valor_edit == 5) // Zoom
        {
            $("#div_primer_zoom").removeClass('ocultar');
            $("#div_primer_telefono").addClass('ocultar');
            $("#div_primer_telefono").hide('slow');
            $("#div_primer_celular_whatsapp").addClass('ocultar');
            $("#div_primer_celular_whatsapp").hide('slow');
            $("#div_primer_skype").addClass('ocultar');
            $("#div_primer_skype").hide('slow');
            $("#div_primer_correo").addClass('ocultar');
            $("#div_primer_correo").hide('slow');
            $("#primer_zoom").trigger('focus');

            // Zoom
            $("#div_zoom_1_cont").attr('data-validate', 'This Field is Required');
            $("#div_zoom_1_cont").addClass('validate-input');

            // Correo
            $("#div_email_1_cont").removeClass('validate-input');
            $("#div_email_1_cont").removeAttr('data-validate');

            // Telefono
            $("#div_tel_1_cont").removeClass('validate-input');
            $("#div_tel_1_cont").removeAttr('data-validate');

            // Whatsapp
            $("#div_whats_1_cont").removeClass('validate-input');
            $("#div_whats_1_cont").removeAttr('data-validate');

            // Skype
            $("#div_skype_1_cont").removeClass('validate-input');
            $("#div_skype_1_cont").removeAttr('data-validate');

        } else {
            $("#div_primer_telefono").addClass('ocultar');
            $("#div_primer_telefono").hide('slow');
            $("#div_primer_celular_whatsapp").addClass('ocultar');
            $("#div_primer_celular_whatsapp").hide('slow');
            $("#div_primer_skype").addClass('ocultar');
            $("#div_primer_skype").hide('slow');
            $("#div_primer_correo").addClass('ocultar');
            $("#div_primer_correo").hide('slow');
            $("#div_primer_zoom").addClass('ocultar');
            $("#div_primer_zoom").hide('slow');

            // Primer Contacto
            $("#1_cont").attr('data-validate', 'This Field is Required');
            $("#1_cont").addClass('validate-input');

            // Zoom
            $("#div_zoom_1_cont").removeClass('validate-input');
            $("#div_zoom_1_cont").removeAttr('data-validate');

            // Correo
            $("#div_email_1_cont").removeClass('validate-input');
            $("#div_email_1_cont").removeAttr('data-validate');

            // Telefono
            $("#div_tel_1_cont").removeClass('validate-input');
            $("#div_tel_1_cont").removeAttr('data-validate');

            // Whatsapp
            $("#div_whats_1_cont").removeClass('validate-input');
            $("#div_whats_1_cont").removeAttr('data-validate');

            // Skype
            $("#div_skype_1_cont").removeClass('validate-input');
            $("#div_skype_1_cont").removeAttr('data-validate');
        }
    });

    $("#id_segundo_contacto").change(function() {
        let segundo_contacto_valor = $("#id_segundo_contacto").val();

        if (segundo_contacto_valor == 1) // Phone
        {
            $("#div_segundo_telefono").removeClass('ocultar');
            $("#div_segundo_celular_whatsapp").addClass('ocultar');
            $("#div_segundo_celular_whatsapp").hide('slow');
            $("#div_segundo_correo").addClass('ocultar');
            $("#div_segundo_correo").hide('slow');
            $("#div_segundo_skype").addClass('ocultar');
            $("#div_segundo_skype").hide('slow');
            $("#div_segundo_zoom").addClass('ocultar');
            $("#div_segundo_zoom").hide('slow');
            $("#segundo_telefono").trigger('focus');
        } else if (segundo_contacto_valor == 2) // Whatsapp - Celular
        {
            $("#div_segundo_celular_whatsapp").removeClass('ocultar');
            $("#div_segundo_telefono").addClass('ocultar');
            $("#div_segundo_telefono").hide('slow');
            $("#div_segundo_correo").addClass('ocultar');
            $("#div_segundo_correo").hide('slow');
            $("#div_segundo_skype").addClass('ocultar');
            $("#div_segundo_skype").hide('slow');
            $("#div_segundo_zoom").addClass('ocultar');
            $("#div_segundo_zoom").hide('slow');
            $("#segundo_celular").trigger('focus');
        } else if (segundo_contacto_valor == 3) // Skype
        {
            $("#div_segundo_skype").removeClass('ocultar');
            $("#div_segundo_telefono").addClass('ocultar');
            $("#div_segundo_telefono").hide('slow');
            $("#div_segundo_celular_whatsapp").addClass('ocultar');
            $("#div_segundo_celular_whatsapp").hide('slow');
            $("#div_segundo_correo").addClass('ocultar');
            $("#div_segundo_correo").hide('slow');
            $("#div_segundo_zoom").addClass('ocultar');
            $("#div_segundo_zoom").hide('slow');
            $("#segundo_skype").trigger('focus');
        } else if (segundo_contacto_valor == 4) // Email
        {
            $("#div_segundo_correo").removeClass('ocultar');
            $("#div_segundo_telefono").addClass('ocultar');
            $("#div_segundo_telefono").hide('slow');
            $("#div_segundo_celular_whatsapp").addClass('ocultar');
            $("#div_segundo_celular_whatsapp").hide('slow');
            $("#div_segundo_skype").addClass('ocultar');
            $("#div_segundo_skype").hide('slow');
            $("#div_segundo_zoom").addClass('ocultar');
            $("#div_segundo_zoom").hide('slow');
            $("#segundo_correo").trigger('focus');
        } else if (segundo_contacto_valor == 5) // Zoom
        {
            $("#div_segundo_zoom").removeClass('ocultar');
            $("#div_segundo_telefono").addClass('ocultar');
            $("#div_segundo_telefono").hide('slow');
            $("#div_segundo_celular_whatsapp").addClass('ocultar');
            $("#div_segundo_celular_whatsapp").hide('slow');
            $("#div_segundo_skype").addClass('ocultar');
            $("#div_segundo_skype").hide('slow');
            $("#div_segundo_correo").addClass('ocultar');
            $("#div_segundo_correo").hide('slow');
            $("#segundo_zoom").trigger('focus');
        } else {
            $("#div_segundo_telefono").addClass('ocultar');
            $("#div_segundo_telefono").hide('slow');
            $("#div_segundo_celular_whatsapp").addClass('ocultar');
            $("#div_segundo_celular_whatsapp").hide('slow');
            $("#div_segundo_skype").addClass('ocultar');
            $("#div_segundo_skype").hide('slow');
            $("#div_segundo_correo").addClass('ocultar');
            $("#div_segundo_correo").hide('slow');
            $("#div_segundo_zoom").addClass('ocultar');
            $("#div_segundo_zoom").hide('slow');
        }
    });

    $("#id_opcional_contacto").change(function() {
        let opcional_contacto_valor = $("#id_opcional_contacto").val();

        if (opcional_contacto_valor == 1) // Phone
        {
            $("#div_opcional_telefono").removeClass('ocultar');
            $("#div_opcional_celular_whatsapp").addClass('ocultar');
            $("#div_opcional_celular_whatsapp").hide('slow');
            $("#div_opcional_correo").addClass('ocultar');
            $("#div_opcional_correo").hide('slow');
            $("#div_opcional_skype").addClass('ocultar');
            $("#div_opcional_skype").hide('slow');
            $("#div_opcional_zoom").addClass('ocultar');
            $("#div_opcional_zoom").hide('slow');
            $("#opcional_telefono").trigger('focus');
        } else if (opcional_contacto_valor == 2) // Whatsapp - Celular
        {
            $("#div_opcional_celular_whatsapp").removeClass('ocultar');
            $("#div_opcional_telefono").addClass('ocultar');
            $("#div_opcional_telefono").hide('slow');
            $("#div_opcional_correo").addClass('ocultar');
            $("#div_opcional_correo").hide('slow');
            $("#div_opcional_skype").addClass('ocultar');
            $("#div_opcional_skype").hide('slow');
            $("#div_opcional_zoom").addClass('ocultar');
            $("#div_opcional_zoom").hide('slow');
            $("#opcional_celular").trigger('focus');
        } else if (opcional_contacto_valor == 3) // Skype
        {
            $("#div_opcional_skype").removeClass('ocultar');
            $("#div_opcional_telefono").addClass('ocultar');
            $("#div_opcional_telefono").hide('slow');
            $("#div_opcional_celular_whatsapp").addClass('ocultar');
            $("#div_opcional_celular_whatsapp").hide('slow');
            $("#div_opcional_correo").addClass('ocultar');
            $("#div_opcional_correo").hide('slow');
            $("#div_opcional_zoom").addClass('ocultar');
            $("#div_opcional_zoom").hide('slow');
            $("#opcional_skype").trigger('focus');
        } else if (opcional_contacto_valor == 4) // Email
        {
            $("#div_opcional_correo").removeClass('ocultar');
            $("#div_opcional_telefono").addClass('ocultar');
            $("#div_opcional_telefono").hide('slow');
            $("#div_opcional_celular_whatsapp").addClass('ocultar');
            $("#div_opcional_celular_whatsapp").hide('slow');
            $("#div_opcional_skype").addClass('ocultar');
            $("#div_opcional_skype").hide('slow');
            $("#div_opcional_zoom").addClass('ocultar');
            $("#div_opcional_zoom").hide('slow');
            $("#opcional_correo").trigger('focus');
        } else if (opcional_contacto_valor == 5) // Zoom
        {
            $("#div_opcional_zoom").removeClass('ocultar');
            $("#div_opcional_telefono").addClass('ocultar');
            $("#div_opcional_telefono").hide('slow');
            $("#div_opcional_celular_whatsapp").addClass('ocultar');
            $("#div_opcional_celular_whatsapp").hide('slow');
            $("#div_opcional_skype").addClass('ocultar');
            $("#div_opcional_skype").hide('slow');
            $("#div_opcional_correo").addClass('ocultar');
            $("#div_opcional_correo").hide('slow');
            $("#opcional_zoom").trigger('focus');
        } else {
            $("#div_opcional_telefono").addClass('ocultar');
            $("#div_opcional_telefono").hide('slow');
            $("#div_opcional_celular_whatsapp").addClass('ocultar');
            $("#div_opcional_celular_whatsapp").hide('slow');
            $("#div_opcional_skype").addClass('ocultar');
            $("#div_opcional_skype").hide('slow');
            $("#div_opcional_correo").addClass('ocultar');
            $("#div_opcional_correo").hide('slow');
            $("#div_opcional_zoom").addClass('ocultar');
            $("#div_opcional_zoom").hide('slow');
        }
    });
</script>
@endsection
