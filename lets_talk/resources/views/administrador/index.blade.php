@extends('layouts.layout')
@section('title', 'Index')
@section('css')
    <link href="{{asset('DataTables/datatables.min.css')}}"/>
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
            <table class="table table-striped table-bordered table-hover dt-button" id="tbl_users" aria-describedby="tabla usuarios">
                <thead>
                    <tr class="header-table">
                        <th>Name</th>
                        <th>Lastname</th>
                        <th>Username</th>
                        <th>Document Type</th>
                        <th>Document Number</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>English Level</th>
                        <th>English Type</th>
                        <th>State</th>
                        <th>View Details</th>
                        <th>Edit</th>
                        <th>Change State</th>
                        <th>Update Password</th>
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

                            @if($usuario->id_rol == 3 || $usuario->id_rol == "3")
                                    <td>
                                        <span class="badge badge-warning">
                                            {{$usuario->niveles}}
                                        </span>
                                    </td>
                                    <td>---</td>
                            @else
                                <td>---</td>
                                <td>
                                        <span class="badge badge-info">
                                            {{$usuario->desc_tip_ing}}
                                        </span>
                                </td>
                            @endif

                            @if($usuario->estado == 1 || $usuario->estado)
                                    <td><span class='badge badge-success'>Active</span></td>
                            @else
                                    <td><span class='badge badge-danger'>Inactive</span></td>
                            @endif
                            <td>
                                    <a href="{{route('administrador.show', $usuario->id_user)}}" class="btn btn-secondary" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                            <td>
                                    <a href="{{route('administrador.edit', $usuario->id_user)}}" class="btn btn-primary" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <input type="hidden" name="id_user" id="id_user" value="{{$usuario->id_user}}">
                            </td>
                            <td>
                                @if($usuario->id_rol == 2 || $usuario->id_rol == "2")
                                        <a href="#" class="btn btn-warning" title="Change Status" disabled>
                                            <i class="fa fa-refresh" aria-hidden="true" id="cambiar_estado"></i>
                                        </a>
                                @else
                                        <a href="#" class="btn btn-warning" title="Change Status">
                                            <i class="fa fa-refresh" aria-hidden="true" id="cambiar_estado"></i>
                                        </a>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-info" title="Update Password" id="pass_update_{{$usuario->id_user}}"><i class="fa fa-key" aria-hidden="true" onclick="updatePassword({{$usuario->id_user}})"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('administrador.modal')

<div id="loaderGif" class="ocultar">
    <img src="{{asset('img/processing.gif')}}" alt="processing">
</div>

@stop
@section('scripts')
    <script src="{{asset('DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js')}}"></script>

<script>

    $( document ).ready(function() {

        $('#tbl_users').DataTable({
            'ordering': false,
            "lengthMenu": [[25,50,100, -1], [25,50,100, 'ALL']],
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

    $("#cambiar_estado").click(function(){

        let id_user = $("#id_user").val();

        Swal.fire({
            title: 'You really want',
            html: 'to change the status of this user?',
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    async: true,
                    url: "{{route('cambiar_estado')}}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'id_user': id_user
                    },
                    beforeSend: function()
                    {
                        $("#loaderGif").show();
                        $("#loaderGif").removeClass('ocultar');
                    },
                    success: function(response)
                    {
                        if(response == "-1")
                        {
                            Swal.fire({
                                position: 'center',
                                title: 'Error!',
                                html:  'An error occurred, try again, if the problem persists contact support.',
                                type: 'info',
                                showCancelButton: false,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey:false,
                                timer: 6000
                            });

                            $("#loaderGif").hide();
                            return;
                        }

                        if(response == 0 || response == "0")
                        {
                            Swal.fire({
                                position: 'center',
                                title: 'Error!',
                                html:  'An error occurred, try again, if the problem persists contact support.',
                                type: 'info',
                                showCancelButton: false,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey:false,
                                timer: 6000
                            });

                            $("#loaderGif").hide();
                            return;
                        }

                        if(response == "success")
                        {
                            Swal.fire({
                                position: 'center',
                                title: 'Success!',
                                html:  "The user's status has been successfully updated",
                                type: 'success',
                                showCancelButton: false,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey:false,
                                timer: 2000
                            });

                            $("#loaderGif").hide();

                            setTimeout(function(){
                                window.location.reload();
                            }, 3000);
                            return;
                        }
                    }
                });
            }
        });
    });

    function updatePassword(id_user)
    {
        // let id_user = $("#id_user").val();

        Swal.fire({
            title: 'Update Password',
            html: '<input class="form-control" placeholder="Entered the new password" type="password" name="change_clave" id="change_clave">',
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Cancel',
            cancelButtonClassName: 'color-cancel-button'
        }).then((result) =>
        {
            let new_clave = $("#change_clave").val();

            if (result.value)
            {
                $.ajax({
                    async: true,
                    url: "{{route('actualizar_clave')}}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'id_user': id_user,
                        'clave': new_clave
                    },
                    beforeSend: function()
                    {
                        $("#loaderGif").show();
                        $("#loaderGif").removeClass('ocultar');
                    },
                    success: function(response)
                    {
                        if(response == "-1")
                        {
                            Swal.fire({
                                position: 'center',
                                title: 'Error!',
                                html:  'The password is required',
                                type: 'error',
                                showCancelButton: false,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey:false,
                                timer: 3000
                            });

                            $("#loaderGif").hide();
                        }

                        if(response == 0 || response == "0")
                        {
                            Swal.fire({
                                position: 'center',
                                title: 'Error!',
                                html:  'An error occurred, try again, if the problem persists contact support.',
                                type: 'info',
                                showCancelButton: false,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey:false,
                                timer: 5000
                            });

                            $("#loaderGif").hide();
                        }

                        if(response == "success")
                        {
                            Swal.fire({
                                position: 'center',
                                title: 'Success!',
                                html:  "The user's password has been successfully updated",
                                type: 'success',
                                showCancelButton: false,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey:false,
                                timer: 2000
                            });

                            $("#loaderGif").hide();

                            setTimeout(function(){
                                window.location.reload();
                            }, 3000);
                        }
                    }
                });
            }
        });
    }

</script>
@endsection
