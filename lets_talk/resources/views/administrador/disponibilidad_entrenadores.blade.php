@extends('layouts.layout')
@section('title', 'Availability Trainers')

{{-- ===================================== --}}

@section('css')
<link href="{{asset('DataTable/datatables.min.css')}}" rel="stylesheet">
@stop

{{-- ===================================== --}}

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        @if(session('rol') == 3)
        <h1 class="text-center text-uppercase">Disponibilidad Entrenadores</h1>
        @else

        <h1 class="text-center text-uppercase">Trainer's Availability</h1>

        <div class="mt-5">
            <a href="#" class="btn btn-sm btn-success" id="btn_aprove_all" onclick="actualizacionMasiva(1)">Approve All</a>
            <a href="#" class="btn btn-sm btn-warning" id="btn_reject_all" onclick="actualizacionMasiva(3)">Reject All</a>
            <a href="#" class="btn btn-sm btn-danger" id="btn_delete_all" onclick="actualizacionMasiva(4)">Delete All</a>

            @foreach ($disponibilidades as $disponibilidad)
            @php
            $idDisponibilidad = $disponibilidad->id;
            @endphp
            @endforeach

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
                            <input type="checkbox" name="select_pending" id="select_pending" class="ml-3 form-check-input" style="margin-left:2rem;" onchange="seleccionarTodos()">
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

@include('layouts.loader')
@stop

{{-- ===================================== --}}

@section('scripts')
<script src="{{asset('DataTable/pdfmake.min.js')}}"></script>
<script src="{{asset('DataTable/vfs_fonts.js')}}"></script>
<script src="{{asset('DataTable/datatables.min.js')}}"></script>

<script>
    $(document).ready(function() {

        setTimeout(() => {
            $("#loaderGif").hide();
            $("#loaderGif").addClass('ocultar');
        }, 1500);

        $('#tbl_availability').DataTable({
            'ordering': false
            , "lengthMenu": [
                [10, 25, 50, 100, -1]
                , [10, 25, 50, 100, 'ALL']
            ]
            , dom: 'Blfrtip'
            , "info": "Showing page _PAGE_ de _PAGES_"
            , "infoEmpty": "No hay registros"
            , "buttons": [{
                    extend: 'copyHtml5'
                    , text: 'Copiar'
                    , className: 'waves-effect waves-light btn-rounded btn-sm btn-primary'
                    , init: function(api, node, config) {
                        $(node).removeClass('dt-button')
                    }
                }
                , {
                    extend: 'excelHtml5'
                    , text: 'Excel'
                    , className: 'waves-effect waves-light btn-rounded btn-sm btn-primary'
                    , init: function(api, node, config) {
                        $(node).removeClass('dt-button')
                    }
                }
            , ]
        });
    });

    function seleccionarTodos() {
        if ($("#select_pending").is(':checked')) {

            $('.checke').prop('checked', true);
            $('.btn-pending').hide();

        } else {
            $('.checke').prop('checked', false);
            $('.btn-pending').show();
        }
    }

    // ===========================================

    function actualizarEstadoEvento(id_estado, id_disponibilidad) {
        $.ajax({
            async: true
            , url: "{{route('actualizar_evento')}}"
            , type: "POST"
            , dataType: "JSON"
            , data: {
                'disponibilidad_id': id_disponibilidad
                , 'estado_id': id_estado
            }
            , beforeSend: function() {
                $("#loaderGif").show();
                $("#loaderGif").removeClass('ocultar');
            }
            , success: function(response) {
                if (response == "success") {
                    $("#loaderGif").hide();
                    $("#loaderGif").addClass('ocultar');
                    Swal.fire({
                        position: 'center'
                        , title: 'Success!'
                        , html: "The state has been successfully updated"
                        , icon: 'success'
                        , type: 'success'
                        , showCancelButton: false
                        , showConfirmButton: false
                        , allowOutsideClick: false
                        , allowEscapeKey: false
                        , timer: 3000
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 3500);
                    return;
                }

                if (response == "error_update") {
                    $("#loaderGif").hide();
                    $("#loaderGif").addClass('ocultar');
                    Swal.fire({
                        position: 'center'
                        , title: 'Error!'
                        , html: 'An error occurred, try again, if the problem persists contact support.'
                        , icon: 'error'
                        , type: 'error'
                        , showCancelButton: false
                        , showConfirmButton: false
                        , allowOutsideClick: false
                        , allowEscapeKey: false
                        , timer: 5000
                    });
                    return;
                }

                if (response == "error_exception") {
                    $("#loaderGif").hide();
                    $("#loaderGif").addClass('ocultar');
                    Swal.fire({
                        position: 'center'
                        , title: 'Error!'
                        , html: 'An error_exception occurred, try again, if the problem persists contact support.'
                        , icon: 'error'
                        , type: 'error'
                        , showCancelButton: false
                        , showConfirmButton: false
                        , allowOutsideClick: false
                        , allowEscapeKey: false
                        , timer: 5000
                    });
                    return;
                }
            }
        });
    }

    $('#select_pending').on('change', function() {

        if ($('#select_pending').is(':checked')) {

            $('#select_pending').on('change', function() {

                $("#select_pending").attr('checked', true);

                checked = $('#select_pending').is(':checked');

                if (checked == true) {

                    $("input:checkbox[id^='pending_']").attr('checked', true);

                    var idEventos;
                    idEventos = $("input:checkbox[id^='pending_']:checked").map(function() {
                        return $(this).attr('id');
                    }).get();

                    if (arrayIds == [] || arrayIds.length == 0 || arrayIds == undefined) {

                        Swal.fire({
                            text: "An error occurred, one checkbox must be selected at least."
                            , icon: 'error'
                            , type: 'error'
                            , showCancelButton: false
                            , confirmButtonText: 'Ok'
                        , }).then((result) => {
                            if (result.value == true) {
                                window.location.reload();
                            }
                        });

                        return;
                    }

                    $.ajax({
                        async: true
                        , url: "{{route('actualizacion_masiva_diponibilidades')}}"
                        , type: "POST"
                        , dataType: "JSON"
                        , data: {
                            'id_evento': arrayIds
                            , 'estado': estado
                        }
                        , beforeSend: function() {
                            $("#loaderGif").show();
                            $("#loaderGif").removeClass('ocultar');
                        }
                        , success: function(response) {
                            if (response == 'exito') {
                                $("#loaderGif").hide();
                                $("#loaderGif").addClass('ocultar');
                                Swal.fire({
                                    text: "Event updated succesfully!"
                                    , icon: 'success'
                                    , type: 'success'
                                    , showCancelButton: false
                                    , confirmButtonText: 'Ok'
                                , }).then((result) => {
                                    if (result.value == true) {
                                        window.location.reload();
                                    }
                                });
                            }

                            if (response == "error") {
                                $("#loaderGif").hide();
                                $("#loaderGif").addClass('ocultar');
                                Swal.fire({
                                    text: "An error occurred, try again, if the problem persists contact support."
                                    , icon: 'error'
                                    , type: 'error'
                                    , showCancelButton: false
                                    , confirmButtonText: 'Ok'
                                , }).then((result) => {
                                    if (result.value == true) {
                                        window.location.reload();
                                    }
                                });
                            }
                        }
                    });
                }
            });

            on = $('#select_pending').val();
            console.log(`encendido ${on}`);

            $('#btn_aprove_all').on('click', function() {
                alert('aprove all');
            });

            $('#btn_reject_all').on('click', function() {
                alert('reject all');
            });

            $('#btn_delete_all').on('click', function() {
                alert('delete all');
            });

        } else {
            $("input:checkbox[id^='pending_']").attr('checked', false);
            $("#select_pending").attr('checked', false);

            $('#btn_aprove_all').on('click', function() {
                alert('aprove all');
            });

            $('#btn_reject_all').on('click', function() {
                alert('reject all');
            });

            $('#btn_delete_all').on('click', function() {
                alert('delete all');
            });

        } else {
            $("input:checkbox[id^='pending_']").attr('checked', false);
            $("#select_pending").attr('checked', false);

            $('#btn_aprove_all').on('click', function() {
                Swal.fire(
                    'Info'
                    , 'Select all option must be checked'
                    , 'info'
                )
            });

            $('#btn_reject_all').on('click', function() {
                Swal.fire(
                    'Info'
                    , 'Select all option must be checked'
                    , 'info'
                )
            });

            $('#btn_delete_all').on('click', function() {
                Swal.fire(
                    'Info'
                    , 'Select all option must be checked'
                    , 'info'
                )
            });
        }
    });

</script>
@endsection
