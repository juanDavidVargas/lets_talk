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
        window.$(".select2").prepend(new Option("Select Contact...", "-1"));
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
        $("#skype").trigger('focus');
        $("#zoom").trigger('focus');
        $("#genero").trigger('focus');
        $("#id_municipio_residencia").trigger('focus');
        $("#id_rol").trigger('focus');
        $("#id_nivel").trigger('focus');
        $("#id_tipo_ingles").trigger('focus');
        $("#id_primer_contacto").trigger('focus');

        let primer_contacto_tipo_editado = @json($usuario->primer_contacto_tipo);
        let segundo_contacto_tipo_editado = @json($usuario->segundo_contacto_tipo);
        let opcional_contacto_tipo_editado = @json($usuario->opcional_contacto_tipo);

        console.log(primer_contacto_tipo_editado);
        console.log(segundo_contacto_tipo_editado);
        console.log(opcional_contacto_tipo_editado);

        if (primer_contacto_tipo_editado != null) {
            $("#id_primer_contacto").val(primer_contacto_tipo_editado);
            console.log(primer_contacto_tipo_editado);

            if (primer_contacto_tipo_editado == 1) {  // Phone
                $("#div_primer_telefono").removeClass('ocultar');
                $("#primer_telefono").trigger('focus');
                $("#div_primer_celular_whatsapp").addClass('ocultar');
                $("#div_primer_celular_whatsapp").hide('slow');
                $("#div_primer_correo").addClass('ocultar');
                $("#div_primer_correo").hide('slow');
                $("#div_primer_skype").addClass('ocultar');
                $("#div_primer_skype").hide('slow');
                $("#div_primer_zoom").addClass('ocultar');
                $("#div_primer_zoom").hide('slow');
            } else if (primer_contacto_tipo_editado == 2) { // Whatsapp - Celular
                $("#div_primer_celular_whatsapp").removeClass('ocultar');
                $("#primer_celular").trigger('focus');
                $("#div_primer_telefono").addClass('ocultar');
                $("#div_primer_telefono").hide('slow');
                $("#div_primer_correo").addClass('ocultar');
                $("#div_primer_correo").hide('slow');
                $("#div_primer_skype").addClass('ocultar');
                $("#div_primer_skype").hide('slow');
                $("#div_primer_zoom").addClass('ocultar');
                $("#div_primer_zoom").hide('slow');
            } else if (primer_contacto_tipo_editado == 3) { // Skype
                $("#div_primer_skype").removeClass('ocultar');
                $("#primer_skype").trigger('focus');
                $("#div_primer_telefono").addClass('ocultar');
                $("#div_primer_telefono").hide('slow');
                $("#div_primer_celular_whatsapp").addClass('ocultar');
                $("#div_primer_celular_whatsapp").hide('slow');
                $("#div_primer_correo").addClass('ocultar');
                $("#div_primer_correo").hide('slow');
                $("#div_primer_zoom").addClass('ocultar');
                $("#div_primer_zoom").hide('slow');
            } else if (primer_contacto_tipo_editado == 4) { // Email
                $("#div_primer_correo").removeClass('ocultar');
                $("#primer_correo").trigger('focus');
                $("#div_primer_telefono").addClass('ocultar');
                $("#div_primer_telefono").hide('slow');
                $("#div_primer_celular_whatsapp").addClass('ocultar');
                $("#div_primer_celular_whatsapp").hide('slow');
                $("#div_primer_skype").addClass('ocultar');
                $("#div_primer_skype").hide('slow');
                $("#div_primer_zoom").addClass('ocultar');
                $("#div_primer_zoom").hide('slow');
            } else if (primer_contacto_tipo_editado == 5) { // Zoom
                $("#div_primer_zoom").removeClass('ocultar');
                $("#primer_zoom").trigger('focus');
                $("#div_primer_telefono").addClass('ocultar');
                $("#div_primer_telefono").hide('slow');
                $("#div_primer_celular_whatsapp").addClass('ocultar');
                $("#div_primer_celular_whatsapp").hide('slow');
                $("#div_primer_skype").addClass('ocultar');
                $("#div_primer_skype").hide('slow');
                $("#div_primer_correo").addClass('ocultar');
                $("#div_primer_correo").hide('slow');
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
        }
        else {
            $("#div_id_primer_contacto").addClass('ocultar');
        }

        // =============================================================================

        if (segundo_contacto_tipo_editado != null) {
        
            $("#id_segundo_contacto").val(segundo_contacto_tipo_editado);

            if (segundo_contacto_tipo_editado == 1) // Phone
            {
                $("#div_segundo_telefono").removeClass('ocultar');
                $("#segundo_telefono").trigger('focus');
                $("#div_segundo_celular_whatsapp").addClass('ocultar');
                $("#div_segundo_celular_whatsapp").hide('slow');
                $("#div_segundo_correo").addClass('ocultar');
                $("#div_segundo_correo").hide('slow');
                $("#div_segundo_skype").addClass('ocultar');
                $("#div_segundo_skype").hide('slow');
                $("#div_segundo_zoom").addClass('ocultar');
                $("#div_segundo_zoom").hide('slow');
            } else if (segundo_contacto_tipo_editado == 2) // Whatsapp - Celular
            {
                $("#div_segundo_celular_whatsapp").removeClass('ocultar');
                $("#segundo_celular").trigger('focus');
                $("#div_segundo_telefono").addClass('ocultar');
                $("#div_segundo_telefono").hide('slow');
                $("#div_segundo_correo").addClass('ocultar');
                $("#div_segundo_correo").hide('slow');
                $("#div_segundo_skype").addClass('ocultar');
                $("#div_segundo_skype").hide('slow');
                $("#div_segundo_zoom").addClass('ocultar');
                $("#div_segundo_zoom").hide('slow');
            } else if (segundo_contacto_tipo_editado == 3) // Skype
            {
                $("#div_segundo_skype").removeClass('ocultar');
                $("#segundo_skype").trigger('focus');
                $("#div_segundo_telefono").addClass('ocultar');
                $("#div_segundo_telefono").hide('slow');
                $("#div_segundo_celular_whatsapp").addClass('ocultar');
                $("#div_segundo_celular_whatsapp").hide('slow');
                $("#div_segundo_correo").addClass('ocultar');
                $("#div_segundo_correo").hide('slow');
                $("#div_segundo_zoom").addClass('ocultar');
                $("#div_segundo_zoom").hide('slow');
            } else if (segundo_contacto_tipo_editado == 4) // Email
            {
                $("#div_segundo_correo").removeClass('ocultar');
                $("#segundo_correo").trigger('focus');
                $("#div_segundo_telefono").addClass('ocultar');
                $("#div_segundo_telefono").hide('slow');
                $("#div_segundo_celular_whatsapp").addClass('ocultar');
                $("#div_segundo_celular_whatsapp").hide('slow');
                $("#div_segundo_skype").addClass('ocultar');
                $("#div_segundo_skype").hide('slow');
                $("#div_segundo_zoom").addClass('ocultar');
                $("#div_segundo_zoom").hide('slow');
            } else if (segundo_contacto_tipo_editado == 5) // Zoom
            {
                $("#div_segundo_zoom").removeClass('ocultar');
                $("#segundo_zoom").trigger('focus');
                $("#div_segundo_telefono").addClass('ocultar');
                $("#div_segundo_telefono").hide('slow');
                $("#div_segundo_celular_whatsapp").addClass('ocultar');
                $("#div_segundo_celular_whatsapp").hide('slow');
                $("#div_segundo_skype").addClass('ocultar');
                $("#div_segundo_skype").hide('slow');
                $("#div_segundo_correo").addClass('ocultar');
                $("#div_segundo_correo").hide('slow');
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
        } else {
            $("#div_id_segundo_contacto").addClass('ocultar');
        }

        // =============================================================================

        if (opcional_contacto_tipo_editado != null) {

            $("#id_opcional_contacto").val(opcional_contacto_tipo_editado);

            if (opcional_contacto_tipo_editado == 1) // Phone
            {
                $("#div_opcional_telefono").removeClass('ocultar');
                $("#opcional_telefono").trigger('focus');
                $("#div_opcional_celular_whatsapp").addClass('ocultar');
                $("#div_opcional_celular_whatsapp").hide('slow');
                $("#div_opcional_correo").addClass('ocultar');
                $("#div_opcional_correo").hide('slow');
                $("#div_opcional_skype").addClass('ocultar');
                $("#div_opcional_skype").hide('slow');
                $("#div_opcional_zoom").addClass('ocultar');
                $("#div_opcional_zoom").hide('slow');
            } else if (opcional_contacto_tipo_editado == 2) // Whatsapp - Celular
            {
                $("#div_opcional_celular_whatsapp").removeClass('ocultar');
                $("#opcional_celular").trigger('focus');
                $("#div_opcional_telefono").addClass('ocultar');
                $("#div_opcional_telefono").hide('slow');
                $("#div_opcional_correo").addClass('ocultar');
                $("#div_opcional_correo").hide('slow');
                $("#div_opcional_skype").addClass('ocultar');
                $("#div_opcional_skype").hide('slow');
                $("#div_opcional_zoom").addClass('ocultar');
                $("#div_opcional_zoom").hide('slow');
            } else if (opcional_contacto_tipo_editado == 3) // Skype
            {
                $("#div_opcional_skype").removeClass('ocultar');
                $("#opcional_skype").trigger('focus');
                $("#div_opcional_telefono").addClass('ocultar');
                $("#div_opcional_telefono").hide('slow');
                $("#div_opcional_celular_whatsapp").addClass('ocultar');
                $("#div_opcional_celular_whatsapp").hide('slow');
                $("#div_opcional_correo").addClass('ocultar');
                $("#div_opcional_correo").hide('slow');
                $("#div_opcional_zoom").addClass('ocultar');
                $("#div_opcional_zoom").hide('slow');
            } else if (opcional_contacto_tipo_editado == 4) // Email
            {
                $("#div_opcional_correo").removeClass('ocultar');
                $("#opcional_correo").trigger('focus');
                $("#div_opcional_telefono").addClass('ocultar');
                $("#div_opcional_telefono").hide('slow');
                $("#div_opcional_celular_whatsapp").addClass('ocultar');
                $("#div_opcional_celular_whatsapp").hide('slow');
                $("#div_opcional_skype").addClass('ocultar');
                $("#div_opcional_skype").hide('slow');
                $("#div_opcional_zoom").addClass('ocultar');
                $("#div_opcional_zoom").hide('slow');
            } else if (opcional_contacto_tipo_editado == 5) // Zoom
            {
                $("#div_opcional_zoom").removeClass('ocultar');
                $("#opcional_zoom").trigger('focus');
                $("#div_opcional_telefono").addClass('ocultar');
                $("#div_opcional_telefono").hide('slow');
                $("#div_opcional_celular_whatsapp").addClass('ocultar');
                $("#div_opcional_celular_whatsapp").hide('slow');
                $("#div_opcional_skype").addClass('ocultar');
                $("#div_opcional_skype").hide('slow');
                $("#div_opcional_correo").addClass('ocultar');
                $("#div_opcional_correo").hide('slow');
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
        } else {
            $("#div_id_opcional_contacto").addClass('ocultar');
        }
    });

</script>
@endsection
