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
<<<<<<< HEAD
<<<<<<< HEAD
                    @foreach ($disponibilidades as $disponibilidad)
                        @php
                            $idDisponibilidad = $disponibilidad->id;
                        @endphp
                    @endforeach
=======
                    {{-- @foreach ($disponibilidades as $disponibilidad)
                        @php
                            $idDisponibilidad = $disponibilidad->id;
                        @endphp
                    @endforeach --}}
>>>>>>> b06c5352d758d0d26b1b213472846647ec746300
=======
                    {{-- @foreach ($disponibilidades as $disponibilidad)
                        @php
                            $idDisponibilidad = $disponibilidad->id;
                        @endphp
                    @endforeach --}}
>>>>>>> 11d4bcededddfd3fc5701d32d307dd6cf3319b52
                    <a href="#" class="btn btn-sm btn-success" id="btn_aprove_all">Approve All</a>
                    <a href="#" class="btn btn-sm btn-warning" id="btn_reject_all">Reject All</a>
                    <a href="#" class="btn btn-sm btn-danger" id="btn_delete_all">Delete All</a>
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

            // ========================================

            // if ($('#select_pending').is(':not(:checked)')) {
<<<<<<< HEAD
<<<<<<< HEAD
            //     // $("input:checkbox[id^='pending_']").attr('checked',false);

=======
>>>>>>> 11d4bcededddfd3fc5701d32d307dd6cf3319b52
            //     $('#btn_aprove_all').on('click', function() {
            //         Swal.fire(
            //             'Info',
            //             'Select all option must be checked',
            //             'info'
            //         )
            //     });
                
            //     $('#btn_reject_all').on('click', function() {
            //         Swal.fire(
            //             'Info',
            //             'Select all option must be checked',
            //             'info'
            //         )
            //     });
                
            //     $('#btn_delete_all').on('click', function() {
<<<<<<< HEAD
            //         alert('Select all option must be checked');
=======
            //     $('#btn_aprove_all').on('click', function() {
=======
>>>>>>> 11d4bcededddfd3fc5701d32d307dd6cf3319b52
            //         Swal.fire(
            //             'Info',
            //             'Select all option must be checked',
            //             'info'
            //         )
<<<<<<< HEAD
            //     });
                
            //     $('#btn_reject_all').on('click', function() {
            //         Swal.fire(
            //             'Info',
            //             'Select all option must be checked',
            //             'info'
            //         )
            //     });
                
            //     $('#btn_delete_all').on('click', function() {
            //         Swal.fire(
            //             'Info',
            //             'Select all option must be checked',
            //             'info'
            //         )
>>>>>>> b06c5352d758d0d26b1b213472846647ec746300
=======
>>>>>>> 11d4bcededddfd3fc5701d32d307dd6cf3319b52
            //     });
            // }
        });

        // ===========================================

        function actualizarEstadoEvento(id_evento, id_disponibilidad) {
            $.ajax({
                async: true
                , url: "{{route('actualizar_evento')}}"
                , type: "POST"
                , dataType: "JSON"
                , data: {
                    'disponibilidad_id': id_disponibilidad,
                    'evento_id': id_evento
                }
                , beforeSend: function() {
                    $("#loaderGif").show();
                    $("#loaderGif").removeClass('ocultar');
                }
                , success: function(response) {
                    if (response == "error_exception") {
                        Swal.fire({
                            position: 'center'
                            , title: 'Error!'
                            , html: 'An error occurred, try again, if the problem persists contact support.'
                            , type: 'info'
                            , showCancelButton: false
                            , showConfirmButton: false
                            , allowOutsideClick: false
                            , allowEscapeKey: false
                            , timer: 5000
                        });

                        $("#loaderGif").hide();

                        return;
                    }

                    if (response == "error_update") {
                        Swal.fire({
                            position: 'center'
                            , title: 'Error!'
                            , html: 'An error occurred, try again, if the problem persists contact support.'
                            , type: 'info'
                            , showCancelButton: false
                            , showConfirmButton: false
                            , allowOutsideClick: false
                            , allowEscapeKey: false
                            , timer: 5000
                        });

                        $("#loaderGif").hide();

                        return;
                    }

                    if (response == "success") {
                        Swal.fire({
                            position: 'center'
                            , title: 'Success!'
                            , html: "The state has been successfully updated"
                            , type: 'success'
                            , showCancelButton: false
                            , showConfirmButton: false
                            , allowOutsideClick: false
                            , allowEscapeKey: false
                            , timer: 3000
                        });

                        $("#loaderGif").hide();

                        setTimeout(function() {
                            window.location.reload();
                        }, 3500);
                        return;
                    }
                }
            });
        }

<<<<<<< HEAD
<<<<<<< HEAD
        // ===========================================
=======
        // =================================================================
        // =================================================================
        // =================================================================
>>>>>>> 11d4bcededddfd3fc5701d32d307dd6cf3319b52

        // jQuery(document).on('change', '#select_pending', function() {
        // $('#select_pending').on('click', function() {
        $('#select_pending').on('change', function() {
<<<<<<< HEAD
            if ($('#select_pending').is(':checked')) {
=======
        // =================================================================
        // =================================================================
        // =================================================================

        // jQuery(document).on('change', '#select_pending', function() {
        // $('#select_pending').on('click', function() {
        $('#select_pending').on('change', function() {
=======
>>>>>>> 11d4bcededddfd3fc5701d32d307dd6cf3319b52
            $("#select_pending").attr('checked',true);

            checked = $('#select_pending').is(':checked');
            
            if (checked == true) {
                console.log(`checked ${checked}`);
<<<<<<< HEAD
>>>>>>> b06c5352d758d0d26b1b213472846647ec746300
=======
>>>>>>> 11d4bcededddfd3fc5701d32d307dd6cf3319b52
                $("input:checkbox[id^='pending_']").attr('checked',true);

                var idEventos;
                idEventos = $("input:checkbox[id^='pending_']:checked").map(function() {
                    return $(this).attr('id');
                }).get();
<<<<<<< HEAD
<<<<<<< HEAD
                // alert('IDS: ' + idEventos);
=======
>>>>>>> b06c5352d758d0d26b1b213472846647ec746300
=======
>>>>>>> 11d4bcededddfd3fc5701d32d307dd6cf3319b52

                arrayIds = [];

                idEventos.forEach(id => {
                    eventoId = id.substr(8);
                    arrayIds.push(eventoId);
                });

                console.log(arrayIds);

<<<<<<< HEAD
<<<<<<< HEAD
                on = $('#select_pending').val();
                console.log(`encendido ${on}`);

=======
>>>>>>> 11d4bcededddfd3fc5701d32d307dd6cf3319b52
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
                $("input:checkbox[id^='pending_']").attr('checked',false);
                $("#select_pending").attr('checked',false);

<<<<<<< HEAD
                off = $('#select_pending').val();
                console.log(`apagado ${off}`);
=======
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
                $("input:checkbox[id^='pending_']").attr('checked',false);
                $("#select_pending").attr('checked',false);

                console.log(`checked ${checked}`);
>>>>>>> b06c5352d758d0d26b1b213472846647ec746300
=======
                console.log(`checked ${checked}`);
>>>>>>> 11d4bcededddfd3fc5701d32d307dd6cf3319b52

                $('#btn_aprove_all').on('click', function() {
                    Swal.fire(
                        'Info',
                        'Select all option must be checked',
                        'info'
                    )
                });
                
                $('#btn_reject_all').on('click', function() {
                    Swal.fire(
                        'Info',
                        'Select all option must be checked',
                        'info'
                    )
                });
                
                $('#btn_delete_all').on('click', function() {
                    Swal.fire(
                        'Info',
                        'Select all option must be checked',
                        'info'
                    )
                });
            }
        });

        // ===========================================
<<<<<<< HEAD
<<<<<<< HEAD

        // $('#select_pending').on('change', function() {
        //     if( $(this).is(':checked') ){
        //         $("input:checkbox[id^='pending_']").attr('checked',true);

        //         var idEventos;
        //         idEventos = $("input:checkbox[id^='pending_']:checked").map(function() {
        //             return $(this).attr('id');
        //         }).get();
        //         alert('IDS: ' + idEventos);

        //         arrayIds = [];

        //         idEventos.forEach(id => {
        //             eventoId = id.substr(8);
        //             arrayIds.push(eventoId);
        //         });

        //         console.log(arrayIds);

        //         $('#btn_aprove_all').on('click', function() {
        //             alert('click en aprobar todo');
        //         });

        //         $('#btn_reject_all').on('click', function() {
        //             alert('click en rechazar todo');
        //         });

        //         $('#btn_delete_all').on('click', function() {
        //             alert('click en eliminar todo');
        //         });
                

        //     } else {
        //         console.log($(this).val());
        //         // $("input:checkbox[id^='pending_']").attr('checked',false);
                
        //         if ($('#select_pending').is(':not(:checked)')) {

        //             $("input:checkbox[id^='pending_']").attr('checked',false);

        //             $('#btn_aprove_all').on('click', function() {
        //                 alert('Select all option must be checked');
        //             });
                    
        //             $('#btn_reject_all').on('click', function() {
        //                 alert('Select all option must be checked');
        //             });
                    
        //             $('#btn_delete_all').on('click', function() {
        //                 alert('Select all option must be checked');
        //             });
        //         }
        //     }
        // })

        // ===========================================

=======
>>>>>>> b06c5352d758d0d26b1b213472846647ec746300
=======
>>>>>>> 11d4bcededddfd3fc5701d32d307dd6cf3319b52
        
    </script>
@endsection
