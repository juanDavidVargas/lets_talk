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
        <a href="{{route('estudiante.index')}}" class="btn btn-primary">Reservas</a>
    </div>
</div>

    <div class="row m-b-30 m-t-30">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="border">
                <div class="row">
                    @foreach($arrayDias AS $key => $dias)
                        <div class="col-sm-3 col-xs-12 col-md-2 col-lg-2">
                            <div class="card text-center">
                                <button class="btn btn-info padding border margin-bottom-5 width-200" onclick="modalHoras({{$key}}, '{{$dias}}')">{{$dias}}</button>
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
                                <input type="checkbox" value="${index}" name="disp_trainers" onclick="traerDisponibilidades(${index+1}, ${id})"><span>${element}</span>
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

    function traerDisponibilidades(index, id)
    {
        $.ajax(
            {
                async: true,
                url: "{{route('estudiante.traer_disponibilidades')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id_diponibilidad': index,
                    'numero_dia': id
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
                                <br/>
                                <div class="row">
                                    <div class="cols-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="card card-reservation">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="cols-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                        <img src="{{asset('img/profile.png')}}" class="profile" width="100" height="100" alt="profile" />
                                                    </div>
                                                    <div class="cols-xs-12 col-sm-12 col-md-9 col-lg-9">
                                                        <h4 class="card-title">${value.nombres} ${value.apellidos}</h4>
                                                        <h5>Ingles: `;
                                                        if(value.descripcion == null || value.descripcion == undefined ||
                                                        value.descripcion == '')
                                                        {
                                                            cuerpo += `NO Especificado</h5>`;

                                                        } else {
                                                            cuerpo += `${value.descripcion}</h5>`;
                                                            
                                                        }
                                            cuerpo += ` <h6>Español: SI</h6>
                                                        <a href="https://www.pse.com.co/persona" target="_blank" class="btn btn-sm btn-primary align">Reservar ya</a>
                                                    </div>
                                                </div>
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