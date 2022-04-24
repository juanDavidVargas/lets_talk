@extends('layouts.layout')
@section('title', 'Index')
@section('css')
{{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/fixedHeader.bootstrap.min.css')}}">
@stop
@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <h1 class="text-center text-uppercase">List User's</h1>
    </div>
</div>

<div class="row p-b-20 float-right">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <a href="{{route('administrador.create')}}" class="btn btn-primary">Create New User</a>
    </div>
</div>
<div class="row p-t-30">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tbl_users">
                <thead>
                    <tr class="header-table">
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Username</th>
                        <th>Document Type</th>
                        <th>Document Number</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>State</th>
                        <th>Edit</th>
                        <th>Change Status</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ($usuarios as $usuario)
                       <tr>
                           <td>{{$usuario->nombres}}</td>
                           <td>{{$usuario->apellidos}}</td>
                           <td>{{$usuario->usuario}}</td>
                           <td>{{$usuario->tipo_documento}}</td>
                           <td>{{$usuario->numero_documento}}</td>
                           <td>{{$usuario->correo}}</td>
                           <td>{{$usuario->nombre_rol}}</td>

                           @if($usuario->estado == 1 || $usuario->estado)
                                <td><span class='badge badge-success'>Active</span></td>
                           @else
                                <td><span class='badge badge-danger'>Inactive</span></td>
                           @endif
                           <td>
                               <a href="" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                           </td>
                           <td>
                            <a href="" class="btn btn-warning"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                           </td>
                       </tr>
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

    $( document ).ready(function() {

        $('#tbl_users').DataTable({
            'ordering': false
        });
    });

</script>
@endsection
