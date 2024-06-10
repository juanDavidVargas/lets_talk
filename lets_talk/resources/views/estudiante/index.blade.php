@extends('layouts.layout')
@section('title', 'Mis Sesiones')
@section('css')
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-center text-uppercase">Mis Sesiones</h1>
        </div>
    </div>

    <div class="row p-b-20 float-left">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <a href="{{route('estudiante.disponibilidad')}}" class="btn btn-primary">Atrás Disponibilidad</a>
        </div>
    </div>

    <div class="row p-t-30">
        <div class="col-2">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="tbl_reservas">
                    <thead>
                        <tr class="header-table">
                            <th>Entrenador</th>
                            <th>Fecha</th>
                            <th>Horario</th>
                            <th>Link Meet</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($misSesiones as $sesion)
                            @php
                                $idEvento = $sesion->id_trainer_horario;
                                $idInstructor = $sesion->id_instructor;
                                $idEstudiante = $sesion->id_estudiante;
                                $idEstado = 8;
                            @endphp

                            <tr>
                                <td>{{$sesion->nombre_instructor}}</td>
                                <td>{{$sesion->start_date}}</td>
                                <td>{{$sesion->start_time}}</td>
                                <td><a href="{{$sesion->link_meet}}" target="_blank" class="text-primary">{{$sesion->link_meet}}</a></td>
                                <td>
                                    <button type="button" class="text-white btn btn-warning" onclick="cancelarClase('{{$idEvento}}','{{$idInstructor}}','{{$idEstudiante}}','{{$idEstado}}')">CANCELAR</button>
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

@section('scripts')
    <script src="{{asset('DataTable/pdfmake.min.js')}}"></script>
    <script src="{{asset('DataTable/vfs_fonts.js')}}"></script>
    <script src="{{asset('DataTable/datatables.min.js')}}"></script>

    <script>
        $(document).ready(function()
        {
            $('#tbl_reservas').DataTable({
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

        // ===============================================================

        function cancelarClase(idHorario, idInstructor, idEstudiante, idEstado)
        {
            console.log(`ID Horario: ${idHorario}`);
            console.log(`ID Instructor: ${idInstructor}`);
            console.log(`ID idEstudiante: ${idEstudiante}`);
            console.log(`ID idEstado: ${idEstado}`);

            Swal.fire({
                title: '¿Realmente quiere cancelar esta clase?',
                html: 'Deberá crearla nuevamente si cambia de opinión',
                // icon: 'warning',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value)
                {
                    $.ajax({
                        async: true,
                        url: "{{route('estudiante.cancelar_clase')}}",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id_horario': idHorario,
                            'id_instructor': idInstructor,
                            'id_estudiante': idEstudiante,
                            'id_estado': idEstado
                        },
                        beforeSend: function() {
                            $("#loaderGif").show();
                            $("#loaderGif").removeClass('ocultar');
                        },
                        success: function(response)
                        {
                            console.log(response);

                            $("#loaderGif").hide();
                            $("#loaderGif").addClass('ocultar');

                            if(response == "clase_cancelada")
                            {
                                $("#loaderGif").hide();
                                $("#loaderGif").addClass('ocultar');

                                Swal.fire(
                                    'Info!',
                                    'Clase Cancelada!',
                                    'success'
                                );

                                setTimeout(() => {
                                    window.location.reload();
                                }, 3000);
                                return;
                            }

                            if(response == "error_link")
                            {
                                $("#loaderGif").hide();
                                $("#loaderGif").addClass('ocultar');

                                Swal.fire(
                                    'Error!',
                                    'Link Meet NO Cancelado!',
                                    'error'
                                );

                                setTimeout(() => {
                                    window.location.reload();
                                }, 3000);
                                return;
                            }

                            if(response == "error_exception")
                            {
                                $("#loaderGif").hide();
                                $("#loaderGif").addClass('ocultar');

                                Swal.fire(
                                    'Error!',
                                    'Clase NO Cancelada!',
                                    'error'
                                );

                                setTimeout(() => {
                                    window.location.reload();
                                }, 3000);
                                return;
                            }
                        } // FIN Success
                    }); // Fin ajax
                } // FIN if
            }); // FIN then de Swal.Fire
        } // FIN reservarClase
    </script>
@endsection
