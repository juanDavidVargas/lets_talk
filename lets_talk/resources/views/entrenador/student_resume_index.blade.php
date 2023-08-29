@extends('layouts.layout')
@section('title', 'Student Resume')

{{-- ============================================================== --}}
{{-- ============================================================== --}}

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
    @php
        use Carbon\Carbon;
    @endphp

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-center text-uppercase">Student Resume</h1>
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
                <table class="table table-striped table-bordered table-hover w-100" id="tbl_student_resume" aria-describedby="Student Resume">
                    <thead>
                        <tr class="header-table">
                            <th>Names</th>
                            <th>User</th>
                            <th>Whatsapp</th>
                            <th>Rol</th>
                            <th>Document Type</th>
                            <th>Document Number</th>
                            <th>Email</th>
                            <th>System Entry Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estudiantes as $estudiante)
                            @php
                                $estudiante->fecha_ingreso_sistema = Carbon::createFromTimestamp($estudiante->fecha_ingreso_sistema)->format('d/m/Y');
                            @endphp
                            <tr>
                                <td>{{$estudiante->nombre_completo}}</td>
                                <td>{{$estudiante->usuario}}</td>
                                <td>{{$estudiante->celular}}</td>
                                <td>{{$estudiante->rol}}</td>
                                <td>{{$estudiante->tipo_documento}}</td>
                                <td>{{$estudiante->numero_documento}}</td>
                                <td>{{$estudiante->correo}}</td>
                                <td>{{$estudiante->fecha_ingreso_sistema}}</td>
                                <td>
                                    <button type="button" class="text-white" onclick="verEstudiante({{$estudiante->id_user}})">
                                        See Student
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

{{-- ============================================================== --}}
{{-- ============================================================== --}}

@section('scripts')
    <script src="{{asset('DataTable/pdfmake.min.js')}}"></script>
    <script src="{{asset('DataTable/vfs_fonts.js')}}"></script>
    <script src="{{asset('DataTable/datatables.min.js')}}"></script>

    <script type="text/javascript">
        $(document ).ready(function() {
            $('#tbl_student_resume').DataTable({
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
        });

        // ===================================================
        // ===================================================

        function verEstudiante(idStudent) {
            console.log(idStudent);
            alert(idStudent);
        }
    </script>
@endsection
