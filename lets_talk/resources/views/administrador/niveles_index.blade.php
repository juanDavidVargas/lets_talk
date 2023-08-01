@extends('layouts.layout')
@section('title', 'Leveles')

@section('css')
    <link href="{{asset('DataTables/datatables.min.css')}}"/>
@stop

{{-- ==================================================================================== --}}

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-center text-uppercase">List Levels</h1>
        </div>
    </div>

    <div class="row p-b-20 float-right">
        <div class="col-xs-12 col-sm-12 col-md-12">
            {{-- <a href="{{route('administrador.niveles_create')}}" class="btn btn-primary">Create New User</a> --}}
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($niveles as $nivel)
                            <tr>
                                <td>{{$nivel->id_nivel}}</td>
                                <td>{{$nivel->nivel_descripcion}}</td>
                                <td>
                                    <a href="#" class="btn btn-info" id="level_update_{{$nivel->id_nivel}}" onclick="editarNivel({{$nivel->id_nivel}})">Edit Level</a>
                                    <a href="#" class="btn btn-warning" id="level_inactive_{{$nivel->id_nivel}}" onclick="inactivarNivel({{$nivel->id_nivel}})">Inactive Level</a>
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
        

        function editarNivel(idNivel) {
            
            html = ``;
            html += `{!! Form::open(['method' => 'POST', 'route' => ['editar_nivel'], 'class'=>['form-horizontal form-bordered'], 'id'=>'form_edit_nivel']) !!}`;
            html += `@csrf`;
            html +=     `<input type="text" name="id_nivel" id="id_nivel" value="${idNivel}" required />`;
            html +=     `<input type="text" name="descripcion_nivel" id="descripcion_nivel" placeholder="Level name" required />`;
            html +=     `<input type="submit" value="Update" class="" id="btn_editar_nivel">`;
            html += `{!! Form::close() !!}`;

            // =========================================
            
            Swal.fire({
                title: 'Edit Level',
                html: html,
                type: 'info',
                showCloseButton: true,
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                allowOutsideClick: false,
            });
        }

        // ===========================================

        function inactivarNivel(idNivel) {
            alert(idNivel);
        }
    </script>
@endsection
