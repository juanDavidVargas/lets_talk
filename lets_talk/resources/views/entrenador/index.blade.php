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

        .center-align{
            text-align: center !important;
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
        .gral-font{
            font-family: Roboto;
            font-size: 20px;
            font-weight: 400;
            letter-spacing: 0em;
            text-align: left;
        }
        .margin-top{
            margin-top: 3rem;
        }

        .margin-bottom{
            margin-bottom: 3rem;
        }

        .margin-y{
            margin-top: 5rem;
            margin-bottom: 2rem;
        }
        textarea {
            resize: none;
            background: #ECF3FF;
            box-shadow: 0px 4px 4px 0px #0000004D inset;
        }
        .btn-evaluation {
            font-family: Encode Sans;
            font-size: 18px;
            font-weight: 400;
            line-height: 23px;
            letter-spacing: 0em;
            background: #FFFFFF;
            border: 1px solid #FFFFFF;
            color: white;
            box-shadow: 0px 4px 4px 0px #00000040;
            padding: 1rem
        }
        .flex{
            display: flex;
        }
        .flex-start{
            justify-content: flex-start;
        }
        .flex-end{
            justify-content: flex-end !important;
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
                    
                    html = `<p class="gral-font center-align"><strong>SESSION DETAILS</strong></p>`;

                    // ==============================================

                    html += `
                            <div class="d-flex flex-row margin-top" style="padding:0; width:100%;">
                                <div style="width:50%">
                                    <p class="gral-font" style="color:#33326C;">${response[0].nombre_completo}</p>
                                </div>
                    `;
                                if (response[0].nivel_descripcion) {
                                    if (response[0].nivel_descripcion == "LOW") {
                                        html += `<div class="d-flex flex-row" style="padding:0; width:50%;">
                                                    <p class="gral-font w50">LEVEL:</p>
                                                    <p class="color-low center-align w50">${response[0].nivel_descripcion}</p>
                                                 </div>
                                        `;
                                    } else if (response[0].nivel_descripcion == "MID") {
                                        html += `<div class="d-flex flex-row" style="padding:0; width:50%;">
                                                    <p class="gral-font w50">LEVEL:</p>
                                                    <p class="color-mid center-align w50">${response[0].nivel_descripcion}</p>
                                                 </div>
                                        `;
                                    } else if (response[0].nivel_descripcion == "HI") {
                                        html += `<div class="d-flex flex-row" style="padding:0; width:50%;">
                                                    <p class="gral-font w50">LEVEL:</p>
                                                    <p class="color-hi center-align w50">${response[0].nivel_descripcion}</p>
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
                        html += `<p class="gral-font w50">PHONE: ${response[0].celular}</p>`;
                    } else {
                        html += `<p class="gral-font w50">PHONE: </p>`;
                    }

                    if (response[0].correo) {
                        html += `<p class="gral-font w50">EMAIL: ${response[0].correo}</p>`;
                    } else {
                        html += `<p class="gral-font w50">EMAIL: </p>`;
                    }

                    // ==============================================

                    html += `
                            <div class="d-flex flex-row" style="padding:0; width:100%">
                                <div style="margin-right:1rem;">
                    `;
                                    if (response[0].zoom) {
                                        html += `<p class="gral-font">ZOOM: ${response[0].zoom}</p>`;
                                    } else {
                                        html += `<p class="gral-font">ZOOM: </p>`;
                                    }
                    html += `   </div>`;

                    html += `   <div>`;
                                    if (response[0].zoom_clave) {
                                        html += `<p class="gral-font">ZOOM PASS: ${response[0].zoom_clave}</p>`;
                                    } else {
                                        html += `<p class="gral-font">PASS: </p>`;
                                    }
                    html += `   </div>`;
                    html += `
                            </div>
                    `;
                    
                    // ==============================================

                    html += `<p class="gral-font center-align margin-y">SESSION INFO</p>`;

                    
                    if (response[0].id_primer_contacto == 1) { // Phone
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="gral-font w50">1ST CONTACT:</p>
                                        <p class="gral-font w50">
                                            <img src="{{asset('img/icons8-phone-48.png')}}" width="20" height="20" alt="phone"></img>
                                            ${response[0].primer_telefono}
                                        </p>
                                    </div>
                        `;
                    } else if (response[0].id_primer_contacto == 2) { // Whatsapp-Celular
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="gral-font w50">1ST CONTACT:</p>
                                        <p class="gral-font w50">
                                            <img src="{{asset('img/icons8-whatsapp-48.png')}}" width="20" height="20" alt="whatsapp"></img>
                                            ${response[0].primer_celular}
                                        </p>
                                    </div>
                        `;
                    } else if (response[0].id_primer_contacto == 3) { // Skype
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="gral-font w50">1ST CONTACT:</p>
                                        <p class="gral-font w50">
                                            <img src="{{asset('img/icons8-skype-48.png')}}" width="20" height="20" alt="skype"></img>
                                            ${response[0].primer_skype}
                                        </p>
                                    </div>
                        `;
                    } else if (response[0].id_primer_contacto == 4) { // Email
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="gral-font w50">1ST CONTACT:</p>
                                        <p class="gral-font w50">
                                            <img src="{{asset('img/icons8-email-48.png')}}" width="20" height="20" alt="email"></img>
                                            ${response[0].primer_correo}
                                        </p>
                                    </div>
                        `;
                    } else if (response[0].id_primer_contacto == 5) { // Zoom
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="gral-font w50">1ST CONTACT:</p>
                                        <p class="gral-font w50">
                                            <img src="{{asset('img/icons8-zoom-48.png')}}" width="20" height="20" alt="zoom"></img>
                                            ${response[0].primer_zoom}
                                        </p>
                                    </div>
                        `;
                    } else { // Null
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="gral-font w50">1ST CONTACT:</p>
                                        <p class="gral-font w50"></p>
                                    </div>
                        `;
                    }

                    // ==============================================

                    if (response[0].id_segundo_contacto == 1) { // Phone
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="gral-font w50">2ND CONTACT:</p>
                                        <p class="gral-font w50">
                                            <img src="{{asset('img/icons8-phone-48.png')}}" width="20" height="20" alt="phone"></img>
                                            ${response[0].segundo_telefono}
                                        </p>
                                    </div>
                        `;
                    } else if (response[0].id_segundo_contacto == 2) { // Whatsapp-Celular
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="gral-font w50">2ND CONTACT:</p>
                                        <p class="gral-font w50">
                                            <img src="{{asset('img/icons8-whatsapp-48.png')}}" width="20" height="20" alt="whatsapp"></img>
                                            ${response[0].segundo_celular}
                                        </p>
                                    </div>
                        `;
                    } else if (response[0].id_segundo_contacto == 3) { // Skype
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="gral-font w50">2ND CONTACT:</p>
                                        <p class="gral-font w50">
                                            <img src="{{asset('img/icons8-skype-48.png')}}" width="20" height="20" alt="skype"></img>
                                            ${response[0].segundo_skype}
                                        </p>
                                    </div>
                        `;
                    } else if (response[0].id_segundo_contacto == 4) { // Email
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="gral-font w50">2ND CONTACT:</p>
                                        <p class="gral-font w50">
                                            <img src="{{asset('img/icons8-email-48.png')}}" width="20" height="20" alt="email"></img>
                                            ${response[0].segundo_correo}
                                        </p>
                                    </div>
                        `;
                    } else if (response[0].id_segundo_contacto == 5) { // Zoom
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="gral-font w50">2ND CONTACT:</p>
                                        <p class="gral-font w50">
                                            <img src="{{asset('img/icons8-zoom-48.png')}}" width="20" height="20" alt="zoom"></img>
                                            ${response[0].segundo_zoom}
                                        </p>
                                    </div>
                        `;
                    } else { // Null
                        html += `   <div class="d-flex flex-row w100" style="">
                                        <p class="gral-font w50">2ND CONTACT:</p>
                                        <p class="gral-font w50"></p>
                                    </div>
                        `;
                    }

                    // ==============================================

                    html += `   <p class="gral-font margin-y">INTERNAL EVALUATION (NOTES)</p>`;
                    html += `   {!! Form::open(['method' => 'POST', 'route' => ['evaluacion_interna_entrenador'],'class'=>['form-horizontal form-bordered']]) !!}`;
                    html += `   @csrf`;
                    
                    html += `   <input type="text" name="id_estudiante" id="id_estudiante" value="${response[0].id_user}"/>`;
                    html += `   <textarea name="evaluacion_interna" id="evaluacion_interna" class="w100" rows="10"></textarea>`;
                    html += `   <div class="margin-top flex flex-end">
                                    <button type="submit" class="btn-evaluation">SAVE EVALUATION</button>
                                </div>
                    `;
                                    /*// {!! Form::submit(trans('global.app_add'), ['class' => 'btn btn-success']) !!}*/
                    html += `   {!! Form::close() !!}`;

                    html += `   <div class="flex flex-start" style="margin-top:3rem;">
                                    <button class="btn-evaluation">OLD EVALUATION</button>
                                </div>
                    `;

                    Swal.fire({
                        html: html,
                        showCloseButton: true,
                        showCancelButton: false,
                        showConfirmButton: false,
                        focusConfirm: false,
                        allowOutsideClick: false,
                        width: 850,
                        padding: '5em',
                        background: '#fff',
                    });
                }
            });
        }
    </script>
@endsection
