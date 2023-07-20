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

    {!! Form::open(['method' => 'POST', 'route' => ['administrador.store'], 'class' => 'login100-form', 'autocomplete' => 'off', 'id' => 'form_new_user', 'accept-charset' => 'UTF-8']) !!}
    @csrf
        @include('administrador.fields')
    {!! Form::close() !!}
@stop

{{-- ================================================================================== --}}
{{-- ================================================================================== --}}
{{-- ================================================================================== --}}

@section('scripts')
    <script src="{{asset('validate/cdnjs.cloudflare.com_ajax_libs_jquery_3.4.0_jquery.min.js')}}"></script>
    <script src="{{asset('validate/cdnjs.cloudflare.com_ajax_libs_jquery-validate_1.19.0_jquery.validate.min.js')}}"></script>

<script>
    $(document).ready(function() {
        window.$(".select2").prepend(new Option("Select Contact...", "-1"));
        $("#id_municipio_nacimiento").trigger('focus');
        $("#id_tipo_documento").trigger('focus');
        $("#numero_documento").trigger('focus');
        $("#id_municipio_nacimiento").trigger('focus');
        $("#fecha_nacimiento").trigger('focus');
        $("#estado").trigger('focus');
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

        // =============================================================================

        form_new_user = $('#form_new_user');

        form_new_user.validate({
            rules: {
                // DATOS GENERALES
                nombres: {required: true},
                apellidos: {required: true},
                id_tipo_documento: {required: true},
                numero_documento: {required: true},
                id_municipio_nacimiento: {required: true},
                fecha_nacimiento: {required: true},
                genero: {required: true},
                estado: {required: true},
                correo: {required: true},
                celular: {required: true},
                zoom: {required: false},
                zoom_clave: {required: false},
                direccion_residencia: {required: true},
                id_municipio_residencia: {required: true},
                id_rol: {required: true},
                id_nivel: {required: true},
                id_tipo_ingles: {required: true},

                // =========================

                // PRIMER CONTACTO
                primer_telefono : {required: true},
                primer_celular: {required: true},
                primer_correo: {required: true},
                primer_skype: {required: true},
                primer_zoom: {required: true},

                // =========================

                // SEGUNDO CONTACTO
                segundo_telefono : {required: true},
                segundo_celular: {required: true},
                segundo_correo: {required: true},
                segundo_skype: {required: true},
                segundo_zoom: {required: true},

                // =========================
                
                // OPCIONAL CONTACTO
                opcional_telefono : {required: true},
                opcional_celular: {required: true},
                opcional_correo: {required: true},
                opcional_skype: {required: true},
                opcional_zoom: {required: true}
            } // FIN Rules
        }); // FIN Validate
    });

    // ==================================================================================
    // ==================================================================================

    $("#numero_documento").blur(function() {

        let num_doc = $("#numero_documento").val();

        $.ajax({
            async: false
            , url: "{{route('validar_cedula')}}"
            , type: "POST"
            , dataType: "json"
            , data: {
                'numero_documento': num_doc
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

        $.ajax({
            async: false
            , url: "{{route('validar_correo')}}"
            , type: "POST"
            , dataType: "json"
            , data: {
                'email': correo
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

    // ==================================================================================
    // ==================================================================================

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

    // ==================================================================================
    // ==================================================================================

    $("#id_primer_contacto").change(function() {
        let primer_contacto_valor_edit = $("#id_primer_contacto").val();
        console.log(primer_contacto_valor_edit);

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
        }
    });

    // ==================================================================================
    // ==================================================================================

    $("#id_segundo_contacto").change(function() {
        let segundo_contacto_valor = $("#id_segundo_contacto").val();
        console.log(segundo_contacto_valor);

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

    // ==================================================================================
    // ==================================================================================

    $("#id_opcional_contacto").change(function() {
        let opcional_contacto_valor = $("#id_opcional_contacto").val();
        console.log(opcional_contacto_valor);

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
