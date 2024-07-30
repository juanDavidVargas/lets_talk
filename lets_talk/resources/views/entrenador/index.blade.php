@extends('layouts.layout')
@section('title', 'Trainers Sessions')
@section('css')
    <link href="{{asset('DataTable/datatables.min.css')}}" rel="stylesheet">

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
            background: #33326C;
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
        table{
            table-layout: fixed;
            width: 100%;
            border-collapse:separate !important;
            background: #ECF3FF;
            border-spacing: 50px;
            /* cellspacing:100px; */
            /* font-weight:bold; */
        }
        th, td {
            word-wrap: break-word;
        }
        .swal2-cancel {
            background-color: #1D9BF0;
            padding: 1rem !important;
            color: #FFF !important;
            box-shadow: 0px 4px 4px 0px #00000040;
        }
    </style>
@stop

{{-- ============================================================== --}}
{{-- ============================================================== --}}

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center text-uppercase">Trainer's Sessions</h1>
        </div>
    </div>

    <div class="row p-t-30" style="padding-left:5rem;padding-right:5rem;">
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
                                <td>{{$student->nombre_estudiante}}</td>
                                <td>{{$student->start_date}}</td>
                                <td>{{$student->start_time}}</td>
                                <td>
                                    <button onclick="seeDetails({{$student->id_sesion}},{{$student->id_estudiante}},{{$student->id_instructor}})"
                                            class="text-white"
                                            style="backgroundcolor: #434C6A; padding:0.5rem;">SEE DETAILS
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('layouts.loader')
@stop

{{-- ============================================================== --}}
{{-- ============================================================== --}}

@section('scripts')
    <script src="{{asset('DataTable/pdfmake.min.js')}}"></script>
    <script src="{{asset('DataTable/vfs_fonts.js')}}"></script>
    <script src="{{asset('DataTable/datatables.min.js')}}"></script>

    <script type="text/javascript">
        $(document ).ready(function()
        {
            setTimeout(() => {
                $("#loaderGif").hide();
                $("#loaderGif").addClass('ocultar');
            }, 1500);

            $('#tbl_trainer_sessions').DataTable({
                'ordering': false,
                "lengthMenu": [[10,25,50,100, -1], [10,25,50,100, 'ALL']],
                dom: 'Blfrtip',
                "info": "Showing page _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros",
                "buttons": [
                    {
                        extend: 'copyHtml5',
                        text: 'Copiar',
                        className: 'waves-effect waves-light btn-rounded btn-sm btn-primary',
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button')
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        className: 'waves-effect waves-light btn-rounded btn-sm btn-primary',
                        init: function(api, node, config) {
                            $(node).removeClass('dt-button')
                        }
                    },
                ]
            });
        }); // FIN Document.ready

        // ===================================================

        function seeDetails(idSesion,idEstudiante,idInstructor)
        {
            // console.log(idSesion);
            // console.log(idEstudiante);
            // console.log(idInstructor);

            $.ajax({
                async: true,
                _token: "{{csrf_token()}}",
                url: "{{route('detalle_sesion_entrenador')}}",
                type: "POST",
                dataType: "json",
                data: {
                    // 'id_clase': idSesion
                    'id_estudiante': idEstudiante
                    // 'id_instructor': idInstructor
                },
                // beforeSend: function()
                // {
                //     $("#loaderGif").show();
                //     $("#loaderGif").removeClass('ocultar');
                // },
                success: function(response)
                {
                    if(response[0].original == "error_exception")
                    {
                        $("#loaderGif").hide();
                        $("#loaderGif").addClass('ocultar');
                        Swal.fire(
                            'Error',
                            'An error occurred, contact support.',
                            'error'
                        );
                        return;
                    }

                    if(response == 404)
                    {
                        $("#loaderGif").hide();
                        $("#loaderGif").addClass('ocultar');
                        Swal.fire(
                            'Error',
                            'You do not have the necessary permissions for this action',
                            'error'
                        );
                        return;
                    }

                    html = `<p class="gral-font center-align"><strong>SESSION DETAILS</strong></p>`;

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

                    if (response[0].celular)
                    {
                        html += `<p class="gral-font w50">PHONE: ${response[0].celular}</p>`;
                    }
                    else
                    {
                        html += `<p class="gral-font w50">PHONE: </p>`;
                    }

                    if (response[0].correo)
                    {
                        html += `<p class="gral-font w50">EMAIL: ${response[0].correo}</p>`;
                    }
                    else
                    {
                        html += `<p class="gral-font w50">EMAIL: </p>`;
                    }

                    // ==============================================

                    html += `   <p class="gral-font margin-y">INTERNAL EVALUATION (NOTES)</p>`;
                    html += `   {!! Form::open(['method' => 'POST', 'route' => ['evaluacion_interna_entrenador'],'class'=>['form-horizontal form-bordered'], 'enctype' => 'multipart/form-data']) !!}`;
                    html += `   @csrf`;
                    html += `       <input type="hidden" name="id_estudiante" id="id_estudiante" value="${response[0].id_user}"/>`;
                    html += `       <input type="hidden" name="id_instructor" id="id_instructor" value="${response[0].id_instructor}"/>`;
                    html += `       <textarea name="evaluacion_interna" class="w100" rows="10" required></textarea>`;
                    html += `   <div class="div-file" style="margin-top:5rem">
                                    <input type="file" name="archivo_evaluacion" id="archivo_evaluacion" class="" />
                                    <p id="fileError" style="color: red; display: none;">Please upload a valid PDF or image file.</p>
                                </div>
                    `;
                    html += `   <div class="margin-top flex flex-end">
                                    <button type="submit" class="btn-evaluation">SAVE EVALUATION</button>
                                </div>
                    `;
                    html += `   {!! Form::close() !!}`;

                    // ==============================================

                    html += `   <div class="flex flex-start" style="margin-top:3rem;">
                                    <button class="btn-evaluation" id="old_valuation">OLD EVALUATION</button>
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

                    // ==========================================================
                    // ==========================================================
                    // ==========================================================

                    $('#old_valuation').on('click', function ()
                    {
                        let idEstudianteEvaluacion = idEstudiante;
                        let idInstructorEvaluacion = idInstructor;
                        let idSesionEvaluacion = idSesion;

                        console.log(idEstudianteEvaluacion);
                        console.log(idInstructorEvaluacion);
                        console.log(idSesionEvaluacion);

                        $.ajax({
                            async: true,
                            url: "{{route('consulta_evaluacion_interna')}}",
                            type: "POST",
                            dataType: "json",
                            data: {
                                'id_clase': idSesion,
                                'id_estudiante': idEstudianteEvaluacion,
                                'id_instructor': idInstructor
                            },
                            // beforeSend: function() {
                            //     $("#loaderGif").show();
                            //     $("#loaderGif").removeClass('ocultar');
                            // },
                            success: function(response) {

                                if(response == 404) {
                                    $("#loaderGif").hide();
                                    $("#loaderGif").addClass('ocultar');
                                    Swal.fire(
                                        'Error',
                                        'You do not have the necessary permissions for this action',
                                        'error'
                                    );
                                    return;
                                }

                                if(response == "error_exception") {
                                    $("#loaderGif").hide();
                                    $("#loaderGif").addClass('ocultar');
                                    Swal.fire(
                                        'Error',
                                        'An error occurred, contact support.',
                                        'error'
                                    );
                                    return;
                                }

                                html = ``;
                                html += `<table border=1 style="border-collapse:separate !important; width:100%" cellspacing="10" id="tbl_old_evaluation" >`;
                                html +=     `<thead>`;
                                html +=         `<tr style="background-color: #21277B">`;
                                html +=             `<th style="text-align:center;width:15%;color:white;font-size:14px;">STUDENT</th>`;
                                html +=             `<th style="text-align:center;width:37%;color:white;font-size:14px;">NOTES</th>`;
                                html +=             `<th style="text-align:center;width:15%;color:white;font-size:14px;">INSTRUCTOR</th>`;
                                html +=             `<th style="text-align:center;width:10%;color:white;font-size:14px;">CLASS DATE</th>`;
                                html +=             `<th style="text-align:center;width:10%;color:white;font-size:14px;">EVIDENCE</th>`;
                                html +=             `<th style="text-align:center;width:13%;color:white;font-size:14px;">EVALUATION</th>`;
                                html +=         `</tr>`;
                                html +=     `</thead>`;
                                html +=     `<body>`;
                                                response.forEach(element => {
                                                    html += `<tr>`;
                                                    html +=     `<td style="width:15%;font-size:12px;">${element.nombre_estudiante}</td>`;
                                                    html +=     `<td style="width:37%;font-size:12px;" class="valuation">${element.evaluacion_interna}</td>`;
                                                    html +=     `<td style="width:15%;font-size:12px;">${element.nombre_instructor}</td>`;
                                                    html +=     `<td style="width:10%;font-size:12px;">${element.created_at}</td>`;

                                                    if (element.archivo_evaluacion != null) {
                                                        html +=     `<td style="width:10%;font-size:12px;"><a href="/storage/${element.archivo_evaluacion}" target="_blank" style="color:blue">File</a></td>`;
                                                    } else {
                                                        html +=     `<td style="width:10%;font-size:12px;"></td>`;
                                                    }
                                                    html +=     `<td style="width:13%;font-size:12px;">${element.created_at}</td>`;
                                                    html += `</tr>`;
                                                });
                                html +=     `</body>`;
                                html += `<table>`;

                                Swal.fire({
                                    html: html,
                                    showCloseButton: false,
                                    showConfirmButton: false,
                                    showCancelButton: true,
                                    cancelButtonText: 'GET ME BACK',
                                    focusConfirm: false,
                                    allowOutsideClick: false,
                                    width: 1000,
                                    padding: '3em',
                                    background: '#fff',
                                    buttonsStyling: false,
                                    buttons:{
                                        cancelButton: {customClass:'swal2-cancel'}
                                    }
                                });

                                $('#tbl_old_evaluation').DataTable({
                                    'paging'      : true,
                                    'lengthChange': true,
                                    'searching'   : true,
                                    'ordering'    : false,
                                    'responsive'  : true,
                                });
                            }
                        });
                    })
                }
            });
        } // FIN seeDetails(idSesion,idUser)
    </script>
@endsection
