<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Let's Talk - Trainer's Agenda</title>

    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/404.css')}}">

    <link rel="stylesheet" href="{{asset('eventos/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('eventos/css/main.min.css')}}">
    <link rel="stylesheet" href="{{asset('eventos/css/styles.css')}}">

    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/animsition/css/animsition.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/select2/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/daterangepicker/daterangepicker.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">

    <link rel="stylesheet" href="{{ asset('font-awesome-4.5.0/css/font-awesome.min.css') }}">

    <style>
        .footer {
            background-color: #21277B !important;
            bottom: 0;
            color: #fff !important;
            width: 100%;
            margin: 0;
            text-decoration: none;
        }
    </style>

    <script src="{{ asset('js/modernizr.custom.js') }}"></script>
    <script src="{{ asset('js/jquery-2.1.3.min.js') }}"></script>

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="logo-box">
                <img src="{{asset('img/logo.png')}}" alt="logo" class="logo logo-img">
            </div>
        </div>

        @if(Request::path() == '/' || Request::path() == "login" ||
            Request::path() == "login_estudiante")

            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="sign-out">
                    &nbsp;
                </div>
            </div>
        @else

        {{-- Inicio Menu --}}
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="sign-out">
                {{-- Rol Entrenador --}}
                @if(!is_null(session('rol')) && (session('rol') == 1 || session('rol') == "1"))
                    <ul class="nav nav-tabs">
                        @if(Request::path() == "trainer")
                            <li class="nav-item">
                                <a href="{{route('trainer.create')}}" class="nav-link active" aria-current="page">Trainer's Agenda</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('trainer.index')}}" class="nav-link" aria-current="page">Trainer's Sessions</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{route('trainer.create')}}" class="nav-link" aria-current="page">Trainer's Agenda</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('trainer.index')}}" class="nav-link" aria-current="page">Trainer's Sessions</a>
                            </li>
                        @endif
                        <li>
                            <a href="{{route('logout')}}" title="Cerrar Sesión">
                                <i class="fa fa-sign-out fa-3x" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                {{-- Rol Estudiante --}}
                @elseif(!is_null(session('rol')) && (session('rol') == 3 || session('rol') == "3"))
                    <ul class="nav nav-tabs">
                        @if(Request::path == "student")
                            <li class="nav-item">
                                <a href="#" class="nav-link" aria-current="page">Diponibilidad Entrenadores</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" aria-current="page">Reservas</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="#" class="nav-link" aria-current="page">Diponibilidad Entrenadores</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" aria-current="page">Reservas</a>
                            </li>
                        @endif
                        <li>
                            <a href="{{route('logout')}}" title="Cerrar Sesión">
                                <i class="fa fa-sign-out fa-3x" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                    {{-- Rol Administrador --}}
                @else
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="pointer" href="{{route('administrador.index')}}" class="nav-link" aria-current="page">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('trainer.create')}}" class="nav-link active" aria-current="page">Trainer's Agenda</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('trainer.index')}}" class="nav-link" aria-current="page">Trainer's Sessions</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" aria-current="page">Availability Trainer's</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" aria-current="page">Reservations</a>
                        </li>
                        <li>
                            <a href="{{route('logout')}}" title="Cerrar Sesión">
                                <i class="fa fa-sign-out fa-3x" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
        {{-- Fin Menu --}}
        @endif
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-center text-uppercase">Trainer's Agenda</h1>
        </div>
    </div>

    <div class="row p-b-20 float-left">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <a href="{{route('trainer.index')}}" class="btn btn-primary">See My Sessions</a>
        </div>
    </div>

    <div class="row p-t-30">
        <div class="col-12">
            <div class="border_div">
                <div id="calendar"></div>

                {{-- Inicio Modal --}}
                <div class="modal" data-backdrop="static" data-keyboard="false" id="myModal" tabindex="-1" aria-labelledby="Label" aria-hidden="true" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-center">
                                <h5 class="modal-title" id="titulo">Event Registration</h5>
                            </div>

                            {!! Form::open(['id' => 'formulario', 'autocomplete' => 'off', 'class' => 'login100-form validate-form']) !!}
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        @foreach($horarios as $key => $value)
                                            <div class="col-md-4 form-floating mb-3">
                                                <div class="cat action">
                                                    <label>
                                                    <input type="checkbox" value="{{$key}}" name="horas" id="{{$key}}"
                                                            onclick="llenarArrayDatos()"><span>{{$value}}</span>
                                                    </label>
                                                </div> {{-- FIN cat action --}}
                                            </div> {{-- FIN form-floating --}}
                                        @endforeach

                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" name="horarios" id="horarios" value="">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" name="fecha_evento" id="fecha_evento" value="">
                                            </div>
                                        </div>
                                    </div> {{-- FIN modal-body row --}}

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            @if(session('rol') == 2 || session('rol') == "2")
                                            <div class="wrap-input100 validate-input" data-validate="This Field is Required">
                                                {!! Form::select('trainer_id', $trainers, null, ['class' => 'input100', 'id' => 'trainer_id']) !!}
                                                <span class="focus-input100" data-placeholder=""></span>
                                            </div>
                                            @endif
                                        </div>
                                    </div> {{-- FIN row --}}
                                </div> {{-- FIN modal-body --}}

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnClose">Close</button>
                                    <button type="submit" class="btn btn-success" id="btnAccion">Save</button>
                                </div> {{-- FIN modal-footer --}}
                            {!! Form::close() !!}
                        </div> {{-- FIN modal-content --}}
                    </div> {{-- FIN modal-dialog --}}
                </div> {{-- FIN modal --}}
                {{-- Fin Modal --}}
            </div> {{-- FIN border_div --}}
        </div> {{-- FIN col-12 --}}
    </div> {{-- FIN row p-t-30 --}}
</div> {{-- FIN container --}}

<!-- Include Footer -->
{{-- @include('layouts.footer') --}}

<!-- Footer -->
<footer class="text-center text-white footer">
    <!-- Grid container -->
    <div class="pt-4" style="padding-left:2rem;padding-right:2rem;">
        <!-- Section: Links -->
        <section class="mb-4">
            <!-- Grid row-->
            <div class="row text-center d-flex justify-content-center p-0">
                <!-- Grid column -->
                <div class="col-md-2 col-md-offset-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="{{route('about_us')}}" class="text-white fw-bold" style="text-decoration: none;">About us</a>
                    </h6>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="{{route('services')}}" class="text-white fw-bold" style="text-decoration: none;">Services</a>
                    </h6>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="#" class="text-white fw-bold" style="text-decoration: none;">Help</a>
                    </h6>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="mailto:letstalkmedellin@gmail.com" class="text-white fw-bold" target="_blank" style="text-decoration: none;">Contact</a>
                    </h6>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row-->
        </section>
        <!-- Section: Links -->

        <hr class="mt-3 bg-white"/>

        <!-- Section: Social -->
        <section class="text-center mb-0 p-0">
            <a href="" class="text-white fa-2x facebook">
                <i class="fa fa-facebook-f"></i>
            </a>
            <a href="" class="text-white fa-2x insta">
                <i class="fa fa-instagram"></i>
            </a>
        </section>
        <!-- Section: Social -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-2 copy-footer">
        <p class="d-flex justify-content-center align-items-center">
            All Rights Reserved ©
            <a class="text-white" href="#" style="text-decoration: none;">Let's Talk</a> {{date('Y')}}
        </p>
    </div>
    <!-- Copyright -->
</footer>
{{-- FIN footer --}}

<script src="{{asset('js/jquery-2.1.3.min.js') }}"></script>
<script src="{{asset('eventos/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('eventos/js/main.min.js')}}"></script>
<script src="{{asset('eventos/js/moment.js')}}"></script>
<script src="{{asset('eventos/js/es.js')}}"></script>
<script src="{{asset('eventos/js/sweetalert2.all.min.js')}}"></script>
<script>

    $( document ).ready(function()
    {
        window.$("#trainer_id").prepend(new Option("Select Trainer...", "-1"));
        $("#trainer_id").trigger('focus');
        $("#trainer_id").trigger('change');
        cargarEventosPorEntrenador();
    });

    let calendarEl = document.getElementById('calendar');
    let frm = document.getElementById('formulario');
    let myModal = new bootstrap.Modal(document.getElementById('myModal'));
    let min = '06:00:00';
    let max = '22:00:00';
    const url_store = "{{route('trainer.store')}}";
    let  myData = [];
    let numDay = [];

    document.addEventListener('DOMContentLoaded', function ()
    {
        calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'local',
            initialView: 'dayGridMonth',
            locale: 'en',
            headerToolbar: {
                left: 'prev next today',
                center: 'title',
                // right: 'dayGridMonth listWeek'
                right: 'dayGridMonth'
            },
            events: myData,
            displayEventTime: false,
            buttonText: {
            month: "Month",
            list: "Week",
            },
            editable: true,
            dateClick: function (info)
            {
                let hoy = moment().format('YYYY-MM-DD');
                let fechaEvento = moment(info.dateStr).format('YYYY-MM-DD');
                let daysArray = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                let day = new Date(fechaEvento).getDay() + 1;
                let dayName = '';

                numDay.shift();
                numDay.push(day);

                let fecha = new Date();
                let dias = 14; // Número de días a agregar
                let nueva_fecha = fecha.setDate(fecha.getDate() + dias);
                let nueva_fecha_formato = moment(nueva_fecha).format('YYYY-MM-DD');

                if(day === 7 || day == 7 || day == '7')
                {
                    dayName = 'Sunday';

                } else {

                    dayName = daysArray[day];
                }

                // Validamos que no se puedan crear eventos más de 15 dias en el futurotrainer_id
                if(fechaEvento > nueva_fecha_formato)
                {
                    Swal.fire(
                        'Error',
                        'Events cannot be created more than 15 days in advance.',
                        'error'
                    )
                    return false;
                }

                if (hoy <= fechaEvento)
                {
                    frm.reset();
                    document.getElementById('btnAccion').textContent = 'Save';
                    document.getElementById('titulo').textContent = dayName;
                    document.getElementById('fecha_evento').value = fechaEvento;
                    document.getElementById('btnAccion').style.display = 'inline-block';
                    myModal.show();
                }
                else
                {
                    Swal.fire(
                        'Error',
                        'You cannot create events in the past',
                        'error'
                    )
                    return false;
                }
            },

            eventClick: function (info)
            {
                let horario_id = info.event.id
                let evento_id = info.event.extendedProps.id_evento;

                console.log(`Id Horario ${horario_id}`);
                console.log(`Id Evento ${evento_id}`);
                
                $("#trainer_id").val('-1');
                $(`#${horario_id}`).attr('checked', false);
                $(`#${horario_id}`).prop('checked',false);

                $.ajax({
                    async: false,
                    url: "{{route('cargar_info_evento')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id_evento': evento_id,
                        'id_horario': horario_id,
                    },
                    success: function (response)
                    {
                    
                        if(response == "error_exception")
                        {
                            Swal.fire(
                                'Error!',
                                'An error occurred, try again, if the problem persists contact support.!',
                                'error'
                            );
                            return;
                        }

                        if(response == "error_query_eventos")
                        {
                            Swal.fire(
                                'Error!',
                                'An error occurred, try again, if the problem persists contact support.!',
                                'error'
                            );
                            return;
                        }

                        document.getElementById('titulo').textContent = 'Details Trainer Availability';
                        document.getElementById('btnAccion').style.display = 'none';

                        $(`#${evento_id}`).attr('checked', true);
                        $(`#${evento_id}`).prop('checked',true);

                        myModal.show();
                    }
                });
            },
            eventDrop: function (info){}
        });

        calendar.render();
        frm.addEventListener('submit', function (e)
        {
            e.preventDefault();
            let horas = $("#horarios").val();
            let fecha_evento = $("#fecha_evento").val();
            let trainer = $("#trainer_id").val();

            if ((horas == '' || horas == null || horas == undefined) ||
                (fecha_evento == '' || fecha_evento == null || fecha_evento == undefined))
            {
                Swal.fire(
                    'Error',
                    'Please, selected a range of hour',
                    'error'
                );
                return;
            } else if (trainer == '' || trainer == null || trainer == undefined ||
                    trainer == '-1' || trainer == -1)
            {
                Swal.fire(
                    'Error',
                    'Please, selected a trainer',
                    'error'
                );
                return;
            } else
            {
                $("#btnAccion").attr('disabled', 'disabled');

                $.ajax({
                    async: true,
                    url: url_store,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'hrs_disponibilidad': horas,
                        'fecha_evento': fecha_evento,
                        'numero_dia': numDay,
                        'trainer_id': trainer
                    },
                    beforeSend: function()
                    {
                        $("#loaderGif").show();
                        $("#loaderGif").removeClass('ocultar');
                        $("#btnAccion").attr('disabled', 'disabled');
                    },
                    success: function(response)
                    {
                        $("#loaderGif").show();
                        $("#loaderGif").removeClass('ocultar');

                        if(response == "exception_evento")
                        {
                            $("#loaderGif").hide();
                            $("#loaderGif").addClass('ocultar');
                            myModal.hide();
                            $("#loaderGif").hide();
                            Swal.fire(
                                'Error',
                                'An error occurred, contact support.',
                                'error'
                            );
                            return;
                        }

                        if(response == "error_evento")
                        {
                            $("#loaderGif").hide();
                            $("#loaderGif").addClass('ocultar');
                            myModal.hide();
                            $("#loaderGif").hide();
                            Swal.fire(
                                'Error',
                                'An error occurred, try again, if the problem persists contact support.',
                                'error'
                            );
                            return;
                        }

                        if(response == "error_horas")
                        {
                            $("#loaderGif").hide();
                            $("#loaderGif").addClass('ocultar');
                            myModal.hide();
                            $("#loaderGif").hide();
                            Swal.fire(
                                'Error',
                                'Not availability schedule was selected.',
                                'error'
                            );
                            return;
                        }

                        if(response == "success_evento")
                        {
                            $("#loaderGif").hide();
                            $("#loaderGif").addClass('ocultar');
                            Swal.fire(
                                'Successfully!',
                                'Event successfully created!',
                                'success'
                            );
                            setTimeout(() => {
                                window.location.reload();
                            }, 3500);
                        }
                    }
                });
            }
        });
    });

    function llenarArrayDatos()
    {
    //Creamos un array que almacenará los valores de los input "checked"
        var checked = [];

        //Recorremos todos los input checkbox con name = hr y que se encuentren "checked"
        $("input[name='horas']:checked").each(function ()
        {
            //Mediante la función push agregamos al arreglo los values de los checkbox
            checked.push(($(this).attr("id")));
        });

        $("#horarios").val(checked);
    }

    $("#btnClose").click(function(info){

        let datos = myData;
        let array_datos = Object.values(datos);

        array_datos.forEach(element =>
        {
            $(`#${element.id}`).removeAttr('checked', false);
            $(`#${element.id}`).css('background-color', "#21277B");
        });

    });

    function cargarEventosPorEntrenador()
    {
        $.ajax({
            async: false,
            url: "{{route('cargar_eventos_entrenador')}}",
            type: "POST",
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(response)
            {
                if(response == "error_exception")
                {
                    Swal.fire(
                        'Error!',
                        'An error occurred, contact support.!',
                        'error'
                    );
                    return;
                }

                if(response == "error_query_eventos")
                {
                    Swal.fire(
                        'Error!',
                        'An error occurred, contact support.!',
                        'error'
                    );
                    return;
                }

                $.each(response.agenda, function(index, element)
                {
                    myData.push(
                        {
                            id: element.id_horario + element.id,
                            // id_evento: element.id,
                            start: `${element.start_date}`,
                            title: element.title + ' - ' + element.start_time,
                            color: element.color,
                            textColor: '#FFFFFF'
                        }
                    );
                });
            }
        });
    }
</script>
</body>
</html>