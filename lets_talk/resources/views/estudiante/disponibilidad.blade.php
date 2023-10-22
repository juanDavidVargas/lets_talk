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
                        <div class="cat">
                            <label>
                                <input type="checkbox" value="${index}" name="disp_trainers" onclick="traerDisponibilidades(${index+1})"><span>${element}</span>
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
            });
    }

    function traerDisponibilidades(index)
    {
        $.ajax(
            {
                async: true,
                url: "{{route('estudiante.traer_disponibilidades')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id_diponibilidad': index
                },
                beforeSend: function() {
                    $("#loaderGif").show();
                    $("#loaderGif").removeClass('ocultar');
                },
                success: function(response) 
                {
                    $("#loaderGif").hide();
                    $("#loaderGif").addClass('ocultar');

                    if(response == "error_exception") 
                    {
                        $("#loaderGif").hide();
                        $("#loaderGif").addClass('ocultar');
                        Swal.fire(
                            'Error!',
                            'Ha ocurrido un error, íntente de nuevo, si el problema persiste, comuniquese con el administrador!',
                            'error'
                        );
                        return;
                    } else if(response == "no_datos") 
                    {
                        $("#loaderGif").hide();
                        $("#loaderGif").addClass('ocultar');
                        Swal.fire(
                            'Error!',
                            'No se encontraron disponibilidades de entrenadores para el horario seleccionado',
                            'error'
                        );
                        return;
                    } else 
                    {
                        $("#loaderGif").hide();
                        $("#loaderGif").addClass('ocultar');
                        let cuerpo = "";

                        $.each(response, (index, value) =>{
                            cuerpo += `
                                <div class="row">
                                    <div class="cols-xs-12 col-sm-12 col-md-4">
                                    <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <h4 class="card-title">${value.nombres} ${value.apellidos}</h4>
                                        <h5>Ingles: ${value.descripcion}</h5>
                                        <h6>Español: SI</h6>
                                        <a href="https://www.pse.com.co/persona" class="btn btn-sm btn-primary">Reservar ya</a>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                            `; 
                        });

                        Swal.fire({
                            title: `Disponibilidad Entrenadores`,
                            html: cuerpo,
                            type: 'info',
                            showCancelButton: true,
                            showConfirmButton: false,
                            cancelButtonText: 'Cerrar',
                            customClass: 'swal-class',
                        });
                    }
                }
            }
        );
    }
    </script>
@endsection