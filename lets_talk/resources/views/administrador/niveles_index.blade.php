@extends('layouts.layout')
@section('title', 'Leveles')

@section('css')
    <link href="{{asset('DataTable/datatables.min.css')}}" rel="stylesheet">

    <style>
        .div-level-name{
            margin-top: 1rem;
            margin-bottom: 2rem;
        }
        .level-name{
            border: 2px solid lightgray;
            border-radius: 5px;
            width: 70%;
            text-align:center;
            text-transform: uppercase;
            font-size: 14px;
        }
        .div-new-level{
            margin-top: 5rem;
            padding-right: 5rem !important;
        }
        #btn_editar_nivel {
            display: block;
            margin-top: 2rem;
            margin-bottom: 2rem;
            margin-left: auto;
            margin-right: auto;
        }

        .font14{
            font-size: 14px;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-center text-uppercase">List Levels</h1>
        </div>
    </div>

    <div class="row div-new-level">
        <div class="col-12">
            <button class="btn btn-primary float-right" onclick="crearNivel()">Create New Level</button>
        </div>
    </div>

    <div class="row p-t-30">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dt-button"
                        id="tbl_levels" aria-describedby="tabla niveles">
                    <thead>
                        <tr class="header-table">
                            <th>ID</th>
                            <th>Level</th>
                            <th>File</th>
                            <th>State</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($niveles as $nivel)
                            <tr>
                                <td>{{$nivel->id_nivel}}</td>
                                <td>
                                    {{$nivel->nivel_descripcion}}
                                    <input type="hidden" value="{{$nivel->id_nivel}}" id="levelId{{$nivel->id_nivel}}" name="levelId{{$nivel->id_nivel}}">
                                    <input type="hidden" value="{{$nivel->nivel_descripcion}}"
                                            id="levelName{{$nivel->id_nivel}}" name="levelName{{$nivel->id_nivel}}">
                                </td>

                                @if ($nivel->ruta_pdf_nivel != null || $nivel->ruta_pdf_nivel != "")
                                    <td>
                                        <a href="/storage/{{$nivel->ruta_pdf_nivel}}" target="_blank">Level File</a>
                                    </td>
                                @else
                                    <td></td>
                                @endif

                                @if ($nivel->deleted_at == null || $nivel->deleted_at == "")
                                    <td>Active</td>
                                @else
                                    <td>Inactive</td>
                                @endif

                                <td>
                                    @if ($nivel->deleted_at == null || $nivel->deleted_at == "")
                                        @if ($nivel->id_nivel == 0)
                                            <span class="badge badge-primary">No Edition Allowed</span>
                                        @else
                                            <a href="#" class="btn btn-info"
                                                id="level_update_{{$nivel->id_nivel}}"
                                                onclick="editarNivel({{$nivel->id_nivel}})">Edit Level</a>
                                            <a href="#" class="btn btn-warning" id="level_inactive_{{$nivel->id_nivel}}"
                                                onclick="inactivarNivel({{$nivel->id_nivel}})">Inactive Level</a>
                                        @endif
                                    @else
                                        <a href="#" class="btn btn-success" id="level_active_{{$nivel->id_nivel}}"
                                            onclick="activarNivel({{$nivel->id_nivel}})">Active Level</a>
                                    @endif
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
        $( document ).ready(function()
        {
            setTimeout(() => {
                $("#loaderGif").hide();
                $("#loaderGif").addClass('ocultar');
            }, 1500);

            $('#tbl_levels').DataTable({
                'ordering': false,
                "lengthMenu": [[10,25,50,100, -1], [10,25,50,100, 'ALL']],
                dom: 'Blfrtip',
                "info": "Showing page _PAGE_ de _PAGES_",
                "infoEmpty": "No registers",
                "buttons": [
                    {
                        extend: 'copyHtml5',
                        text: 'Copy',
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

        function crearNivel()
        {
            html = ``;
            html +=     `<label class="font14">This option creates a new level</label>`;
            html +=     `<div class="div-level-name">
                            <label for="crear_nivel">Level Name</label>
                            <input type="text" name="crear_nivel" id="crear_nivel" class="level-name" required />
                        </div>
            `;
            html += `
                    <div class="alert alert-danger ocultar" role="alert" id="level_alert">
                      The field Level Name is required
                    </div>
            `;
            html +=     `<div class="div-level-name div-file">
                            <input type="file" name="file_crear_nivel" id="file_crear_nivel" class="file" />
                        </div>
            `;
            html += `<img  class="ocultar" src="{{asset('img/loading.gif')}}"
                            id="loading_ajax"
                            alt="loading..." />
                    `;

            html += `<div class="div-level-name">
                            <input type="button" value="Create Level" class="btn btn-primary" id="btn_crear_nivel">
                        </div>
                    `;

            Swal.fire({
                title: 'Create Level',
                html: html,
                icon: 'success',
                type: 'success',
                showConfirmButton: false,
                focusConfirm: false,
                showCloseButton: true,
                showCancelButton: false,
                cancelButtonText: 'Cancel',
                allowOutsideClick: false,
            });

            $('#btn_crear_nivel').on('click', function ()
            {
                let nuevoNivel = $('#crear_nivel').val();
                let fileCrearNivel = $('#file_crear_nivel').val();

                if (nuevoNivel == "" || nuevoNivel == undefined)
                {
                    $('#crear_nivel').attr('required', true);
                    $("#level_alert").show();
                    $("#level_alert").removeClass('ocultar');
                } else
                {
                    $('#btn_crear_nivel').attr('disabled',true);
                    $("#level_alert").hide();
                    $("#level_alert").addClass('ocultar');

                    $.ajax({
                        async: true,
                        url: "{{route('crear_nivel')}}",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'nuevo_crear_nivel': nuevoNivel,
                            'file_crear_nivel': fileCrearNivel,
                        },
                        beforeSend: function ()
                        {
                            $("#loading_ajax").show();
                            $("#loading_ajax").removeClass('ocultar');
                        },
                        success: function (respuesta)
                        {
                            $("#loading_ajax").hide();
                            $("#loading_ajax").addClass('ocultar');

                            if(respuesta == "to_home")
                            {
                                $("#loading_ajax").hide();
                                $("#loading_ajax").addClass('ocultar');

                                window.location.href = "http://localhost:8000";
                                return;
                            }
                            
                            if (respuesta == "nivel_creado")
                            {
                                $("#loading_ajax").hide();
                                $("#loading_ajax").addClass('ocultar');

                                Swal.fire(
                                    'Great!',
                                    'New level has been created successfully!',
                                    'success'
                                );

                                window.location.reload();
                                return;
                            }

                            if (respuesta == "nivel_existe")
                            {
                                $("#loading_ajax").hide();
                                $("#loading_ajax").addClass('ocultar');

                                Swal.fire(
                                    'Warning!',
                                    'This level already exists!',
                                    'warning'
                                );
                                return;
                            }

                            if (respuesta == "error_exception")
                            {
                                $("#loading_ajax").hide();
                                $("#loading_ajax").addClass('ocultar');

                                Swal.fire(
                                    'Wrong!',
                                    'An error has ocurred, please contact support!',
                                    'error'
                                );
                                return;
                            }
                        }
                    })
                }
            });

            setTimeout(() => {
                $("#level_alert").hide();
                $("#level_alert").addClass('ocultar');
            }, 6000);
        }

        function editarNivel(idNivel)
        {
            let nameLevel = $("#levelName"+idNivel).val();
            let idLevel = $("#levelId"+idNivel).val();
            
            let html = "";
            html += `{!! Form::open(['method' => 'POST', 'route' => ['editar_nivel'],
                                'class'=>['form-horizontal form-bordered'], 'enctype' => 'multipart/form-data',
                                'id'=>'form_edit_nivel', 'autocomplet'=>'off']) !!}`;
            html += `@csrf`;
            html +=     `<input type="hidden" name="id_nivel" id="id_nivel" value="${idNivel}" required />`;
            html +=     `<label class="font14">Enter the new level name</label>`;
            html +=     `<div class="div-level-name">
                            <input type="text" name="editar_nivel" id="editar_nivel"
                                    class="level-name" value="${nameLevel}" autocomplete="off" required />
                        </div>
            `;
            html += `
                        <div class="alert alert-danger ocultar" role="alert" id="alert_edit">
                            The field Level Name is required
                        </div>
                    `;

            html +=     `<div class="div-file">
                            <input type="file" name="file_editar_nivel" id="file_editar_nivel" class="file" />
                        </div>
            `;
            html += `<img  class="ocultar" src="{{asset('img/loading.gif')}}"
                    id="loading_ajax"
                    alt="loading..." />
            `;
            html += `{!! Form::close() !!}`;

            Swal.fire({
                title: 'Update Level',
                html: html,
                icon: 'info',
                type: 'info',
                showCancelButton: true,
                confirmButtonText: 'Update',
                cancelButtonText: 'Cancel',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) =>
            {
                if(result.value) {
                    
                    let editarNivel = $('#editar_nivel').val();
                    let formulario = $('#form_edit_nivel');
    
                    if (editarNivel == "" || editarNivel == undefined)
                    {
                        $('#editar_nivel').attr('required', true);
                        
                        Swal.fire(
                            'Wrong!',
                            'The field Level Name is required',
                            'error'
                        );
                        return;
    
                    } else
                    {
                        formulario.submit();
                    }
                }
            });
        }

        function inactivarNivel(idNivel)
        {
            html = ``;
            html += `{!! Form::open(['method' => 'POST', 'route' => ['inactivar_nivel'],
                                'class'=>['form-horizontal form-bordered'], 'id'=>'form_inactivar_nivel']) !!}`;
            html += `@csrf`;
            html +=     `<input type="hidden" name="id_nivel" id="id_nivel" value="${idNivel}" required />`;
            html +=     `<label class="font14">This option inactive this level, ¿Are you sure?</label>`;
            html +=     `<div class="div-level-name">
                            <input type="submit" value="Yes, inactivate"
                                    class="btn btn-primary" id="btn_inactivar_nivel">
                        </div>
            `;
            html += `{!! Form::close() !!}`;

            Swal.fire({
                title: 'Inactive Level',
                html: html,
                icon: 'warning',
                type: 'warning',
                showConfirmButton: false,
                focusConfirm: false,
                showCloseButton: true,
                showCancelButton: false,
                cancelButtonText: 'Cancel',
                allowOutsideClick: false,
            });
        }

        function activarNivel(idNivel)
        {
            html = ``;
            html += `{!! Form::open(['method' => 'POST', 'route' => ['activar_nivel'],
                            'class'=>['form-horizontal form-bordered'], 'id'=>'form_activar_nivel']) !!}`;
            html += `@csrf`;
            html +=     `<input type="hidden" name="id_nivel" id="id_nivel" value="${idNivel}" required />`;
            html +=     `<label class="font14">This option active this level, ¿Are you sure?</label>`;
            html +=     `<div class="div-level-name">
                            <input type="submit" value="Yes, activate" class="btn btn-primary" id="btn_activar_nivel">
                        </div>
            `;
            html += `{!! Form::close() !!}`;

            Swal.fire({
                title: 'Active Level',
                html: html,
                icon: 'success',
                type: 'success',
                showConfirmButton: false,
                focusConfirm: false,
                showCloseButton: true,
                showCancelButton: false,
                cancelButtonText: 'Cancel',
                allowOutsideClick: false,
            });
        }
    </script>
@endsection
