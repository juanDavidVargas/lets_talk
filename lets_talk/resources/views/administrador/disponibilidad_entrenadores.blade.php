@extends('layouts.layout')
@section('title', 'Availability Trainers')

{{-- ===================================== --}}

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/fixedHeader.bootstrap.min.css')}}">
@stop

{{-- ===================================== --}}

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            @if(session('rol') == 3)
                <h1 class="text-center text-uppercase">Disponibilidad Entrenadores</h1>
            @else
                <h1 class="text-center text-uppercase">Availability Trainer's</h1>

                <div class="mt-5">
                    <a href="#" class="btn btn-sm btn-success" id="btn_aprove_all" onclick="actualizacionMasiva(1)">Approve All</a>
                    <a href="#" class="btn btn-sm btn-warning" id="btn_reject_all" onclick="actualizacionMasiva(3)">Reject All</a>
                    <a href="#" class="btn btn-sm btn-danger" id="btn_delete_all" onclick="actualizacionMasiva(4)">Delete All</a>
                </div>
            @endif
        </div>
    </div>

    {{-- ==================== --}}

    <div class="row p-b-20 float-right">
        <div class="col-xs-12 col-sm-12 col-md-12">

        </div>
    </div>

    {{-- ==================== --}}

    <div class="row p-t-30">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="tbl_availability">
                    <thead>
                        <tr class="header-table">
                            <th>Id</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>Start Time</th>
                            <th>End Date</th>
                            <th>End Time</th>
                            <th>Trainer</th>
                            <th>State</th>
                            <th>Select all
                                <input type="checkbox" name="select_pending" id="select_pending" class="ml-3" style="margin-left:2rem;">
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($disponibilidades as $disponibilidad)
                            @if(session('rol') == 2)
                                @include('administrador.table_admin')
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

{{-- ===================================== --}}

@section('scripts')
    <script src="{{asset('js/jquery-3.5.1.js') }}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('js/dataTables.fixedHeader.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#tbl_availability').DataTable({
                'ordering': false
            });
        });

        // ===========================================

        function actualizarEstadoEvento(id_estado, id_disponibilidad) {
            $.ajax({
                async: true,
                url: "{{route('actualizar_evento')}}",
                type: "POST",
                dataType: "JSON",
                data: {
                    'disponibilidad_id': id_disponibilidad,
                    'estado_id': id_estado
                },
                success: function(response) {
                    if (response == "success") {
                        Swal.fire({
                            position: 'center',
                            title: 'Success!',
                            html: "The state has been successfully updated",
                            icon: 'success',
                            type: 'success',
                            showCancelButton: false,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            timer: 3000
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 3500);
                        return;
                    }

                    if (response == "error_update") {
                        Swal.fire({
                            position: 'center',
                            title: 'Error!',
                            html: 'An error occurred, try again, if the problem persists contact support.',
                            icon: 'error',
                            type: 'error',
                            showCancelButton: false,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            timer: 5000
                        });
                        return;
                    }
                }
            });
        }

        // =================================================================
        // =================================================================
        // =================================================================

        $("#select_pending").on('change', function () {
            checked = $('#select_pending').is(':checked');

            if (checked == true) {
                console.log(`checked ${checked}`);
                $('.btn-pending').addClass('ocultar');
                
                $("input:checkbox[id^='pending_']").attr('checked',true);

                var idEventos;
                idEventos = $("input:checkbox[id^='pending_']:checked").map(function() {
                    return $(this).attr('id');
                }).get();

                arrayIds = [];

                idEventos.forEach(id => {
                    eventoId = id.substr(8);
                    arrayIds.push(eventoId);
                });

                console.log(arrayIds);
                actualizacionMasiva(estado);

            } else {
                $('.btn-pending').removeClass('ocultar');

                $("input:checkbox[id^='pending_']").attr('checked',false);

                arrayIds = [];

                console.log(`checked ${checked}`);

                $('#btn_aprove_all').on('click', function() {
                    Swal.fire(
                        'Info',
                        'Select all option must be checked',
                        'info'
                    );
                    return;
                });

                $('#btn_reject_all').on('click', function() {
                    Swal.fire(
                        'Info',
                        'Select all option must be checked',
                        'info'
                    );
                    return;
                });

                $('#btn_delete_all').on('click', function() {
                    Swal.fire(
                        'Info',
                        'Select all option must be checked',
                        'info'
                    );
                    return;
                });
            }
        });

        // =================================================================

        function actualizacionMasiva(estado) {
            $.ajax({
                url: "{{route('actualizacion_masiva_diponibilidades')}}",
                type: "POST",
                dataType: "JSON",
                data: {'id_evento': JSON.stringify(arrayIds), 'estado': estado},
                success: function (response) {
                    console.log(response);
                    if (response == 'exito') {
                        Swal.fire({
                            text: "Event updated succesfully!",
                            icon: 'success',
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            console.log(result);
                            if (result.value == true) {
                                window.location.reload();
                            }
                        })
                    }
                }
            });
        }
    </script>
@endsection
