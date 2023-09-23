@extends('layouts.layout')
@section('title', 'Create')
@section('css')
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-center text-uppercase">Semana</h1>
            <h2 class="text-center text-uppercase">Disponibilidad Entrenadores</h2>
        </div>
    </div>

<div class="row p-b-20 float-left">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <a href="#" class="btn btn-primary">Reservas</a>
    </div>
</div>

    <div class="row m-b-30 m-t-30">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="border">
                <div class="row">
                    @foreach($arrayDias AS $key => $dias)
                        <div class="col-sm-3 col-xs-12 col-md-2 col-lg-2">
                            <div class="card text-center" style="width: 18rem;">
                                <button class="btn btn-info padding border margin-bottom-10 width-140" onclick="modalHoras({{$key}}, '{{$dias}}')">{{$dias}}</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('layouts.loader')
@stop

@section('scripts')
    <script>

        let horarios = @json($horarios);

        function modalHoras (id, dia) {

           let horas = Object.values(horarios);
           let cuerpo = "";
           
           horas.forEach((element, index) => {
                cuerpo += `
                    <div class="col-md-4 form-floating mb-3">
                        <div class="cat action">
                            <label>
                                <input type="checkbox" value="${index}" name="horas"><span>${element}</span>
                            </label>
                            </div>
                    </div>
                `;
            });

            Swal.fire({
                title: `${dia}`,
                html: cuerpo,
                type: 'info',
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: 'Cerrar',
                customClass: 'swal-class',
        }).then((result) => {

            if (result.value) {

                $.ajax({
                    url: "",
                    data: {
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function(response){
                    }
                });
            }
        })

    }
    </script>
@endsection