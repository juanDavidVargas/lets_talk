@extends('layouts.layout')
@section('title', 'Trainers Sessions')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/fixedHeader.bootstrap.min.css')}}">

    <style>
        .left-align{
            text-align:left;
        }

        .right-align{
            text-align: right;
        }

        .color-low{
            color:#31ED2D;
        }

        .color-mid{
            color:#EABC19;
        }

        .color-hi{
            color:#FF0000;
        }

        .w50{
            width: 50%;
        }

        .w100{
            width: 100%;
        }
    </style>
    
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-center text-uppercase">Trainer's Sessions</h1>
        </div>
    </div>

    <div class="row p-b-20 float-right">
        <div class="col-xs-12 col-sm-12 col-md-12">
            {{-- <a href="{{route('administrador.create')}}" class="btn btn-primary">Create New User</a> --}}
        </div>
    </div>
    <div class="row p-t-30">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="tbl_trainer_sessions" aria-describedby="sesiones entrenadores">
                    <thead>
                        <tr class="header-table">
                            <th>Student's Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{$student->nombre_completo}}</td>
                                <td>{{$student->start_date}}</td>
                                <td>{{$student->start_time}}</td>
                                <td><a href="#" id="trainer_sesion_detail_{{$student->id_sesion}}" onclick="seeDetails({{$student->id_sesion}},{{$student->id_user}})" style="color: #434C6A;">SEE DETAILS</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{asset('js/jquery-3.5.1.js') }}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('js/dataTables.fixedHeader.min.js')}}"></script>

    <script>
        $( document ).ready(function() {

            $('#tbl_trainer_sessions').DataTable({
                'ordering': false
            });
        });

        // ===================================================
        // ===================================================

        function seeDetails(idSesion,idUser) {
            $.ajax({
                url: "{{route('detalle_sesion_entrenador')}}",
                type: "POST",
                dataType: "json",
                data: {
                    'id_user': idUser
                },
                success: function(response) {
                    console.log(response[0].nombre_completo);
                    
                    html = `<p><strong>SESSION DETAILS</strong></p>`;
                    // html += `<p>el id del usuario es: ${response[0].id_user}</p>`;

                    // ==============================================

                    html += `
                            <div class="d-flex flex-row" style="padding:0; width:100%">
                                <div style="width:50%">
                                    <p style="color:#33326C;text-align:left;">${response[0].nombre_completo}</p>
                                </div>
                    `;
                                if (response[0].nivel_descripcion) {
                                    if (response[0].nivel_descripcion == "LOW") {
                                        html += `<div class="d-flex flex-row" style="padding:0; width:50%;">
                                                    <p style="width:50%;">LEVEL:</p>
                                                    <p class="color-low right-align w50">${response[0].nivel_descripcion}</p>
                                                 </div>
                                        `;
                                    } else if (response[0].nivel_descripcion == "MID") {
                                        html += `<div class="d-flex flex-row" style="padding:0; width:50%;">
                                                    <p style="width:50%;">LEVEL:</p>
                                                    <p class="color-mid right-align w50">${response[0].nivel_descripcion}</p>
                                                 </div>
                                        `;
                                    } else if (response[0].nivel_descripcion == "HI") {
                                        html += `<div class="d-flex flex-row" style="padding:0; width:50%;">
                                                    <p style="width:50%;">LEVEL:</p>
                                                    <p class="color-hi right-align w50">${response[0].nivel_descripcion}</p>
                                                 </div>
                                        `;
                                    }
                                } else {
                                    html += `<div class="col-md-6" style="padding:0"><p>LEVEL: </p></div>`;
                                }
                    html += `
                            </div>
                    `;

                    // ==============================================

                    if (response[0].celular) {
                        html += `<p style="text-align:left;">PHONE: ${response[0].celular}</p>`;
                    } else {
                        html += `<p style="text-align:left;">PHONE: </p>`;
                    }

                    if (response[0].correo) {
                        html += `<p style="text-align:left;">EMAIL: ${response[0].correo}</p>`;
                    } else {
                        html += `<p style="text-align:left;">EMAIL: </p>`;
                    }

                    // ==============================================

                    html += `
                            <div class="d-flex flex-row" style="padding:0; width:100%">
                                <div style="margin-right:1rem;">
                    `;
                                    if (response[0].zoom) {
                                        html += `<p style="text-align:left;">ZOOM: ${response[0].zoom}</p>`;
                                    } else {
                                        html += `<p style="text-align:left;">ZOOM: </p>`;
                                    }
                    html += `   </div>`;

                    html += `   <div>`;
                                    if (response[0].zoom_clave) {
                                        html += `<p style="text-align:left;">ZOOM PASS: ${response[0].zoom_clave}</p>`;
                                    } else {
                                        html += `<p style="text-align:left;">PASS: </p>`;
                                    }
                    html += `   </div>`;
                    html += `
                            </div>
                    `;
                    
                    // ==============================================

                    html += `<p>SESSION INFO</p>`;

                    
                    if (response[0].id_primer_contacto == 1) { // Phone
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="left-align w50">1ST CONTACT:</p>
                                        <p class="left-align w50">${response[0].primer_telefono}</p>
                                    </div>
                        `;
                    } else if (response[0].id_primer_contacto == 2) { // Whatsapp-Celular
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="left-align w50">1ST CONTACT:</p>
                                        <p class="left-align w50">${response[0].primer_celular}</p>
                                    </div>
                        `;
                    } else if (response[0].id_primer_contacto == 3) { // Skype
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="left-align w50">1ST CONTACT:</p>
                                        <p class="left-align w50">${response[0].primer_skype}</p>
                                    </div>
                        `;
                    } else if (response[0].id_primer_contacto == 4) { // Email
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="left-align w50">1ST CONTACT:</p>
                                        <p class="left-align w50">${response[0].primer_correo}</p>
                                    </div>
                        `;
                    } else if (response[0].id_primer_contacto == 5) { // Zoom
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="left-align w50">1ST CONTACT:</p>
                                        <p class="left-align w50">${response[0].primer_zoom}</p>
                                    </div>
                        `;
                    } else { // Null
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="left-align w50">1ST CONTACT:</p>
                                        <p class="left-align w50"></p>
                                    </div>
                        `;
                    }

                    // ==============================================

                    if (response[0].id_segundo_contacto == 1) { // Phone
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="left-align w50">2ND CONTACT:</p>
                                        <p class="left-align w50">${response[0].segundo_telefono}</p>
                                    </div>
                        `;
                    } else if (response[0].id_segundo_contacto == 2) { // Whatsapp-Celular
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="left-align w50">2ND CONTACT:</p>
                                        <p class="left-align w50">${response[0].segundo_celular}</p>
                                    </div>
                        `;
                    } else if (response[0].id_segundo_contacto == 3) { // Skype
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="left-align w50">2ND CONTACT:</p>
                                        <p class="left-align w50">${response[0].segundo_skype}</p>
                                    </div>
                        `;
                    } else if (response[0].id_segundo_contacto == 4) { // Email
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="left-align w50">2ND CONTACT:</p>
                                        <p class="left-align w50">${response[0].segundo_correo}</p>
                                    </div>
                        `;
                    } else if (response[0].id_segundo_contacto == 5) { // Zoom
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="left-align w50">2ND CONTACT:</p>
                                        <p class="left-align w50">${response[0].segundo_zoom}</p>
                                    </div>
                        `;
                    } else { // Null
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="left-align w50">2ND CONTACT:</p>
                                        <p class="left-align w50"></p>
                                    </div>
                        `;
                    }

                    // ==============================================

                    html += `<p>INTERNAL EVALUATION (NOTES)</p>`;
                    html += `<p>BOTÓN SAVE EVALUATION</p>`;
                    html += `<p>BOTÓN OLD EVALUATION</p>`;

                    Swal.fire({
                        html: html,
                        showCloseButton: true,
                        showCancelButton: true,
                        focusConfirm: false,
                        allowOutsideClick: false,
                        confirmButtonText:
                            '<i class="fa fa-thumbs-up"></i> Great!',
                        confirmButtonAriaLabel: 'Thumbs up, great!',
                        cancelButtonText:
                            '<i class="fa fa-thumbs-down"></i>',
                        cancelButtonAriaLabel: 'Thumbs down'
                    })
                }
            });
        }
    </script>
@endsection
