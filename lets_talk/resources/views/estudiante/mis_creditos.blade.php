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

    {{-- <hr class="border border-1 border-secondary p-0 rounded-0"> --}}

    <div class="row border w-75 ms-auto me-auto mt-5 mb-5 p-5">
        <div class="col-12 col-md-4">
            fecha de la compra
        </div>

        <div class="col-12 col-md-4">
            6 de marzo
        </div>

        <div class="col-12 col-md-4">
            cantidad: 5
        </div>
    </div>

    <div class="d-flexswal m-t-30 m-b-30">
        <button type="button" class="btn btn-primary text-uppercase" onclick="misCreditos()">10 créditos disponibles</button>
    </div>

    <div class="d-flex justify-content-center">
        <a href="https://www.pse.com.co/persona" target="_blank" class="btn btn-primary text-uppercase">comprar más créditos</a>
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


        
    </script>
@endsection