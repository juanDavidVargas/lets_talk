@extends('layouts.layout')
@section('title', 'Mis Créditos')
@section('css')
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
        {{-- <button type="button" class="btn btn-primary text-uppercase" onclick="misCreditos()">10 créditos disponibles</button> --}}
        <a href="{{route('estudiante.creditos_disponibles')}}" class="btn btn-primary text-uppercase">10 créditos disponibles</a>
    </div>

    <div class="d-flex justify-content-center">
        <a href="https://www.pse.com.co/persona" target="_blank" class="btn btn-primary text-uppercase">comprar más créditos</a>
        {{-- <a href="https://www.pse.com.co/persona" target="_blank" class="btn btn-primary text-uppercase">comprar más créditos</a> --}}
        <a href="https://www.pse.com.co/persona" class="btn btn-primary text-uppercase">comprar más créditos</a>
    </div>

    @include('layouts.loader')
@stop

@section('scripts')
    <script>

    function misCreditos() {
        Swal.fire(
            'Info',
            'mis creditos.',
            'info'
        );
    }


        
    </script>
@endsection