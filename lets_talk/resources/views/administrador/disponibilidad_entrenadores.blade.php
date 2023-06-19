@extends('layouts.layout')
@section('title', 'Availability Trainers')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/fixedHeader.bootstrap.min.css')}}">
@stop
@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        @if(session('rol') == 3)
        <h1 class="text-center text-uppercase">Disponibilidad Entrenadores</h1>
        @else
        <h1 class="text-center text-uppercase">Availability Trainer's</h1>
        @endif
    </div>
</div>

<div class="row p-b-20 float-right">
    <div class="col-xs-12 col-sm-12 col-md-12">

    </div>
</div>
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
@section('scripts')
<script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('js/dataTables.fixedHeader.min.js')}}"></script>

<script>
    $(document).ready(function() {

        $('#tbl_availability').DataTable({
            'ordering': false
        });
    });

    function actualizarEstadoEvento(id_evento, id_disponibilidad) {
        $.ajax({
            async: true
            , url: "{{route('actualizar_evento')}}"
            , type: "POST"
            , dataType: "JSON"
            , data: {
                'disponibilidad_id': id_disponibilidad
                , 'evento_id': id_evento
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

</script>
@endsection
