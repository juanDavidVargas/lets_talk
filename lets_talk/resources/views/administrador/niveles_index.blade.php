@extends('layouts.layout')
@section('title', 'Leveles')

@section('css')
    <link href="{{asset('DataTables/datatables.min.css')}}"/>
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
    </style>
@stop

{{-- ==================================================================================== --}}

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
                <table class="table table-striped table-bordered table-hover dt-button" id="tbl_levels" aria-describedby="tabla niveles">
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

                                {{-- =========================== --}}

                                <td>{{$nivel->nivel_descripcion}}</td>

                                {{-- =========================== --}}
                                
                                @if ($nivel->ruta_pdf_nivel != null || $nivel->ruta_pdf_nivel != "")
                                    <td>
                                        <a href="/storage/{{$nivel->ruta_pdf_nivel}}" target="_blank">Level File</a>
                                    </td>
                                @else
                                    <td></td>
                                @endif

                                {{-- =========================== --}}

                                @if ($nivel->deleted_at == null || $nivel->deleted_at == "")
                                    <td>Active</td>
                                @else
                                    <td>Inactive</td>
                                @endif

                                {{-- =========================== --}}

                                <td>
                                    @if ($nivel->deleted_at == null || $nivel->deleted_at == "")
                                        @if ($nivel->id_nivel == 0)
                                            <a href="#" class="btn btn-primary" id="">No Edition Allwed</a>
                                        @else
                                            <a href="#" class="btn btn-info" id="level_update_{{$nivel->id_nivel}}" onclick="editarNivel({{$nivel->id_nivel}})">Edit Level</a>
                                            <a href="#" class="btn btn-warning" id="level_inactive_{{$nivel->id_nivel}}" onclick="inactivarNivel({{$nivel->id_nivel}})">Inactive Level</a>
                                        @endif
                                    @else
                                        <a href="#" class="btn btn-success" id="level_active_{{$nivel->id_nivel}}" onclick="activarNivel({{$nivel->id_nivel}})">Active Level</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="loaderGif" class="ocultar">
        <img src="{{asset('img/processing.gif')}}" alt="processing">
    </div>
@stop

{{-- ==================================================================================== --}}

@section('scripts')
    <script src="{{asset('DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('DataTables/Buttons-2.3.4/js/buttons.html5.min.js')}}"></script>

    <script>
        $( document ).ready(function() {
            $('#tbl_levels').DataTable({
                'ordering': false,
                "lengthMenu": [[25,50,100, -1], [25,50,100, 'ALL']],
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

        // ===========================================

        function crearNivel() {
            html = ``;
            html += `{!! Form::open(['method' => 'POST', 'route' => ['crear_nivel'], 'class'=>['form-horizontal form-bordered'], 'id'=>'form_crear_nivel', 'enctype'=>'multipart/form-data']) !!}`;
            html += `@csrf`;
            html +=     `<label class="">This option creates a new level</label>`;
            html +=     `<div class="div-level-name">
                            <input type="text" name="crear_nivel" id="crear_nivel" class="level-name" required />
                        </div>
            `;
            html +=     `<div class="div-level-name div-file">
                            <input type="file" name="file_crear_nivel" id="file_crear_nivel" class="file" />
                        </div>
            `;
            html +=     `<div class="div-level-name">
                            <input type="submit" value="Create Level" class="btn btn-primary" id="btn_crear_nivel">
                        </div>
            `;
            html += `{!! Form::close() !!}`;

            // =========================================
            
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
        }

        // ===========================================
        
        function editarNivel(idNivel) {
            $.ajax({
                url:"{{route('consultar_nivel')}}",
                type:"POST",
                dataType: "JSON",
                data: {'id_nivel': idNivel},
                success: function (respuesta) {
                    // console.log(respuesta.nivel_descripcion);
                    nivel = respuesta.nivel_descripcion;

                    html = ``;
                    html += `{!! Form::open(['method' => 'POST', 'route' => ['editar_nivel'], 'class'=>['form-horizontal form-bordered'], 'id'=>'form_edit_nivel', 'enctype'=>'multipart/form-data']) !!}`;
                    html += `@csrf`;
                    html +=     `<input type="hidden" name="id_nivel" id="id_nivel" value="${idNivel}" required />`;
                    html +=     `<label class="">Enter the new level name</label>`;
                    html +=     `<div class="div-level-name">
                                    <input type="text" name="editar_nivel" id="editar_nivel" class="level-name" value="${nivel}" required />
                                </div>
                    `;
                    html +=     `<div class="div-file">
                                    <input type="file" name="file_editar_nivel" id="file_editar_nivel" class="file" />
                                </div>
                    `;
                    html +=     `<input type="submit" value="Update" class="btn btn-primary" id="btn_editar_nivel">`;
                    html += `{!! Form::close() !!}`;

                    // =========================================
                    
                    Swal.fire({
                        title: 'Edit Level',
                        html: html,
                        icon: 'info',
                        type: 'info',
                        showConfirmButton: false,
                        focusConfirm: false,
                        showCloseButton: true,
                        showCancelButton: false,
                        cancelButtonText: 'Cancel',
                        allowOutsideClick: false,
                    });
                }
            });
        }

        // ===========================================

        function inactivarNivel(idNivel) {
            html = ``;
            html += `{!! Form::open(['method' => 'POST', 'route' => ['inactivar_nivel'], 'class'=>['form-horizontal form-bordered'], 'id'=>'form_inactivar_nivel']) !!}`;
            html += `@csrf`;
            html +=     `<input type="hidden" name="id_nivel" id="id_nivel" value="${idNivel}" required />`;
            html +=     `<label class="">This option inactive this level</label>`;
            html +=     `<div class="div-level-name">
                            <input type="submit" value="Inactive" class="btn btn-primary" id="btn_inactivar_nivel">
                        </div>
            `;
            html += `{!! Form::close() !!}`;

            // =========================================
            
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
        
        // ===========================================

        function activarNivel(idNivel) {
            html = ``;
            html += `{!! Form::open(['method' => 'POST', 'route' => ['activar_nivel'], 'class'=>['form-horizontal form-bordered'], 'id'=>'form_activar_nivel']) !!}`;
            html += `@csrf`;
            html +=     `<input type="hidden" name="id_nivel" id="id_nivel" value="${idNivel}" required />`;
            html +=     `<label class="">This option active this level</label>`;
            html +=     `<div class="div-level-name">
                            <input type="submit" value="Active" class="btn btn-primary" id="btn_activar_nivel">
                        </div>
            `;
            html += `{!! Form::close() !!}`;

            // =========================================
            
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
