@extends('layouts.layout')
@section('title', 'Trainers Sessions')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/fixedHeader.bootstrap.min.css')}}">
@stop
@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <h1 class="text-center text-uppercase">Trainer's Sessions</h1>
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
            <table class="table table-striped table-bordered table-hover" id="tbl_trainer_sessions">
                <thead>
                    <tr class="header-table">
                        <th>Student's Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>juguimeco</td>
                        <td>January, 31 th</td>
                        <td>06:00 HRS</td>
                        <td>SEE DETAILS</td>
                    </tr>
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

    $( document ).ready(function() {

        $('#tbl_trainer_sessions').DataTable({
            'ordering': false
        });
    });

</script>
@endsection
