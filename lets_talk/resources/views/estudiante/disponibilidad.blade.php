@extends('layouts.layout')
@section('title', 'Create')
@section('css')
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-center text-uppercase">Semana</h1>
            <h2 class="text-center text-uppercase">Disponibilidad Entrenadores</h2>
        </div>
    </div>

    <div class="row p-b-20 float-left">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <a href="{{route('estudiante.index')}}" class="btn btn-primary">Reservas</a>
        </div>
    </div>

    <div class="row p-b-20 float-left">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <a href="{{route('estudiante.mis_creditos')}}" class="btn btn-primary">Mis Créditos</a>
        </div>
    </div>

    <div class="row m-b-30 m-t-30">
        <div class="col-12">
            <div class="border">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="tbl_disponibilidades" aria-describedby="sesiones entrenadores">
                        <thead>
                            <tr class="header-table">
                                <th>Entrenador</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($disponibilidadEntrenadores as $disponibilidad)
                                @php
                                    $idEvento = $disponibilidad->id_evento;
                                    $idInstructor = $disponibilidad->id_instructor;
                                @endphp
                                <tr>
                                    <td>{{$disponibilidad->nombre_completo}}</td>
                                    <td>{{$disponibilidad->start_date}}</td>
                                    <td>{{$disponibilidad->start_time}}</td>
                                    <td>
                                        <button type="button" class="text-white p-5" onclick="reservarClase('{{$idEvento}}', '{{$idInstructor}}')" style="background-color: #434C6A; padding:0.5em">RESERVAR YA</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.loader')
@stop

@section('scripts')
    <script src="{{asset('DataTable/pdfmake.min.js')}}"></script>
    <script src="{{asset('DataTable/vfs_fonts.js')}}"></script>
    <script src="{{asset('DataTable/datatables.min.js')}}"></script>

    <script>
        $( document ).ready(function() {
            $('#tbl_disponibilidades').DataTable({
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

        function reservarClase(idHorario, idInstructor){

            console.log(`ID Horario: ${idHorario}`);
            console.log(`ID Instructor: ${idInstructor}`);

            $.ajax({
                async: true,
                url: "{{route('estudiante.reservar_clase')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id_instructor': idInstructor,
                    'id_horario': idHorario
                },
                beforeSend: function() {
                    $("#loaderGif").show();
                    $("#loaderGif").removeClass('ocultar');
                },
                success: function(response)
                {
                    $("#loaderGif").hide();
                    $("#loaderGif").addClass('ocultar');

                    if(response == "clase_reservada")
                    {
                        $("#loaderGif").hide();
                        $("#loaderGif").addClass('ocultar');

                        Swal.fire(
                            'Info!',
                            'Clase Reservada!',
                            'success'
                        );
                        return;
                    } else if (response == "clase_no_reservada") {
                        $("#loaderGif").hide();
                        $("#loaderGif").addClass('ocultar');

                        Swal.fire(
                            'Info!',
                            'Clase No Reservada!',
                            'error'
                        );
                        return;
                    }
                    else {
                        $("#loaderGif").hide();
                        $("#loaderGif").addClass('ocultar');

                        Swal.fire(
                            'Error!',
                            'Ocurrio un error, íntente de nuevo, si el problema persiste, comuniquese con el administrador!',
                            'error'
                        );
                        return;
                    }
                }
            });
        }
    </script>
@endsection