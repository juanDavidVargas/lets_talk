@extends('layouts.layout')
@section('title', 'Mis Créditos')
@section('css')
    <style>
        .swal2-cancel {
            background-color: #1D9BF0;
            padding: 1rem !important;
            color: #FFF !important;
            box-shadow: 0px 4px 4px 0px #00000040;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h2 class="text-center text-uppercase">Mis créditos</h2>
        </div>
    </div>

    <div class="row p-b-20 float-left">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <a href="{{route('estudiante.index')}}" class="btn btn-primary text-uppercase">Atrás Disponibilidad</a>
        </div>
    </div>

    <div class="row border w-100 mt-5 mb-5 p-3">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tbl_reservas">
                <thead>
                    <tr class="header-table">
                        <th>Fecha Compra</th>
                        <th>Paquete</th>
                        <th>Cantidad Paquete</th>
                        <th>Créditos Consumidos</th>
                        <th>Créditos Disponibles</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // dd($misCreditos);
                    @endphp
                    @foreach ($misCreditos as $credito)
                        <tr>
                            <td>{{$credito->fecha_credito}}</td>
                            <td>{{$credito->paquete}}</td>
                            <td>{{$credito->cantidad_total_paquete}}</td>
                            <td>{{$credito->cantidad_consumida}}</td>
                            <td>{{$credito->cantidad_disponible}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flexswal m-t-30 m-b-30">
        <button type="button" class="btn btn-primary text-uppercase" onclick="misCreditos()"><span class="text-success">{!!$totalCreditosDisponibles!!}</span> créditos disponibles</button>
    </div>

    <div class="d-flex justify-content-center">
        <a href="https://www.pse.com.co/persona" target="_blank" class="btn btn-primary text-uppercase">comprar más créditos</a>
    </div>

    <div class="m-t-30 m-b-30">
        <button type="button" class="btn btn-primary text-uppercase" onclick="comprarCreditos()">comprar créditos</button>
    </div>

    @include('layouts.loader')
@stop

@section('scripts')
    <script>
        function misCreditos() {
            html = ``;
            html += `<table border=1 style="border-collapse:separate !important" cellspacing="10" id="tbl_old_evaluation" >`;
            html +=     `<thead>`;
            html +=         `<tr style="background-color: #21277B">`;
            html +=             `<th style="text-align:center;width:55%;color:white;font-size:16px;">RESERVA CON</th>`;
            html +=             `<th style="text-align:center;width:15%;color:white;font-size:16px;">CRÉDITOS</th>`;
            html +=             `<th style="text-align:center;width:30%;color:white;font-size:16px;">FECHA</th>`;
            html +=         `</tr>`;
            html +=     `</thead>`;
            html +=     `<body>`;
                                html += `<tr>`;
                                html +=     `<td style="width:55%;font-size:12px;">Sebastian Villamizar</td>`;
                                html +=     `<td style="width:15%;font-size:12px;">1</td>`;
                                html +=     `<td style="width:30%;font-size:12px;">Marzo 20, 2024</td>`;
                                html += `</tr>`;
            html +=     `</body>`;
            html += `<table>`;

            Swal.fire({
                html: html,
                showCloseButton: false,
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: 'GET ME BACK',
                focusConfirm: false,
                allowOutsideClick: false,
                width: 500,
                padding: '3em',
                background: '#fff',
                buttonsStyling: false,
                buttons:{
                    cancelButton: {customClass:'swal2-cancel'}
                }
            });
        }

        // =====================================================

        function comprarCreditos() {
            html = '';
            html += `   <h3 class="gral-font margin-y">Comprar Créditos</h3>`;
            html += `   {!! Form::open(['method' => 'POST', 'route' => ['estudiante.comprar_creditos'],'class'=>['form-horizontal form-bordered']]) !!}`;
            html += `   @csrf`;
            html += `       <div class="col-12">
                                <div class="form-group d-flex align-items-center">
                                    <label for="cantidad_creditos" class="form-label text-uppercase fs-1 w-100">Cargo</label>
                                    <select name="cantidad_creditos" class="form-control select2 w-100" id="cantidad_creditos">
                                        <option value="">Seleccione Paquete...</option>
                                        <option value="5">Paquete 5 Créditos</option>
                                        <option value="10">Paquete 10 Créditos</option>
                                        <option value="15">Paquete 15 Créditos</option>
                                        <option value="20">Paquete 20 Créditos</option>
                                    </select>
                                </div>
                            </div>
            `;
            html += `       <div class="p-3">
                                <button type="submit" class="text-white">Comprar Créditos</button>
                            </div>
            `;
            html += `   {!! Form::close() !!}`;

            Swal.fire({
                html: html,
                showCloseButton: false,
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: 'Regresar',
                focusConfirm: false,
                allowOutsideClick: false,
                width: 500,
                padding: '3em',
                background: '#fff',
                buttonsStyling: false,
                buttons:{
                    cancelButton: {customClass:'swal2-cancel'}
                }
            });
        }
    </script>
@endsection
