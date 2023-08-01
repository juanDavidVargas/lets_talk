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
            <button class="btn btn-primary">Create New User</button>
        </div>
    </div>
    
    <div class="row p-t-30">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="">
                
            </div>
        </div>
    </div>

    <div id="loaderGif" class="ocultar">
        <img src="{{asset('img/processing.gif')}}" alt="processing">
    </div>
@stop

{{-- ==================================================================================== --}}

@section('scripts')
    <script>
        $( document ).ready(function() {

            
        });
    </script>
@endsection
