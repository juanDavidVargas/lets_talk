@extends('layouts.layout')
@section('title', 'Reservas')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/fixedHeader.bootstrap.min.css')}}">
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // dd($misSesiones);
                    @endphp
                    <tr>
                        <td>Nombre del Entrenador</td>
                        <td>March, 6TH</td>
                        <td>00:00 HRS</td>
                        <td>
                        <a href="" class="btn btn-sm btn-info" title="Details" id="btn_details">
                            
                        </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('layouts.loader')
@stop
@section('scripts')
<script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('js/dataTables.fixedHeader.min.js')}}"></script>

<script>

    $( document ).ready(function() {

        $('#tbl_reservas').DataTable({
            'ordering': false
        });
    });

</script>
@endsection
