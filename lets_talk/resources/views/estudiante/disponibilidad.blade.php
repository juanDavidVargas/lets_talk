@extends('layouts.layout')
@section('title', 'Create')
@section('css')
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <h2 class="text-center" id="linkMeet"></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
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
                            @php
                                // dd($disponibilidadEntrenadores);
                            @endphp
                            
                            @foreach ($disponibilidadEntrenadores as $disponibilidad)
                                @php
                                    $idEvento = $disponibilidad->id_evento;
                                    $idInstructor = $disponibilidad->id_instructor;
                                    $idEstudiante = $disponibilidad->id_estudiante;
                                    $idEstado = $disponibilidad->id_estado;
                                    // dd($disponibilidad);
                                @endphp
                                <tr>
                                    <td>{{$disponibilidad->nombre_completo}}</td>
                                    <td>{{$disponibilidad->start_date}}</td>
                                    <td>{{$disponibilidad->start_time}}</td>

                                    @if ($disponibilidad->id_estado == 7)
                                        <td>
                                            <button type="button" class="text-white" onclick="reservarClase('{{$idEvento}}', '{{$idInstructor}}')" style="background-color: #434C6A; padding:0.5em">RESERVAR YA</button>
                                        </td>
                                    @else
                                        <td>
                                            <button type="button" class="text-white btn btn-warning" onclick="cancelarClase('{{$idEvento}}','{{$idInstructor}}','{{$idEstudiante}}','{{$idEstado}}')">CANCELAR</button>
                                        </td>
                                    @endif
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
                    // if(response.message == "clase_reservada")
                    {
                        $("#loaderGif").hide();
                        $("#loaderGif").addClass('ocultar');

                        // Redirigir a la URL antes de mostrar el SweetAlert
                        window.location.href = 'http://localhost:8000/auth/google';

                        // $("#linkMeet").html(response.linkMeet);
                        
                        setTimeout(function() {
                            Swal.fire(
                                'Info!',
                                'Clase Reservada!',
                                'success'
                            );
                        }, 7000);
                        
                        return;
                    } else if (response == "clase_ya_reservada") {
                        $("#loaderGif").hide();
                        $("#loaderGif").addClass('ocultar');

                        Swal.fire(
                            'Info!',
                            'Ya realizaste reserva de esta clase en este horario!',
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

        function cancelarClase(idHorario, idInstructor, idEstudiante, idEstado) {
            console.log(`ID Horario: ${idHorario}`);
            console.log(`ID Instructor: ${idInstructor}`);
            console.log(`ID idEstudiante: ${idEstudiante}`);
            console.log(`ID idEstado: ${idEstado}`);


            Swal.fire({
                title: '¿Realmente quiere cancelar esta clase?',
                html: 'Deberá crearla nuevamente si cambia de opinión',
                icon: 'info',
                type: 'info',
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
                                return;
                            }

                            if(response == "error")
                            {
                                $("#loaderGif").hide();
                                $("#loaderGif").addClass('ocultar');

                                Swal.fire(
                                    'Error!',
                                    'Clase NO Cancelada!',
                                    'error'
                                );
                                
                                return;
                            }
                        } // FIN Success
                    }); // Fon ajax
                } // FIN if
            }); // FIN then de Swal.Fire
        } // FIN reservarClase
    </script>
@endsection