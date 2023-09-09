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

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:300,400,700,900' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic' rel='stylesheet'
         type='text/css'>

    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/404.css') }}">

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

        @if(Request()->path() == '/' || Request()->path() == "login" ||
            Request()->path() == "login_estudiante")
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="sign-out">
                    &nbsp;
                </div>
            </div>
        @else
            @include('layouts.menu')
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
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="border_div">
            <div id="calendar"></div>

            {{-- Inicio Modal --}}
            <div class="modal" data-backdrop="static" data-keyboard="false" id="myModal" tabindex="-1" aria-labelledby="Label" aria-hidden="true" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-center">
                            <h5 class="modal-title" id="titulo">Event Registration</h5>
                        </div>
                        {!! Form::open(['id' => 'formulario', 'autocomplete' => 'off']) !!}
                        @csrf
                            <div class="modal-body">
                                <div class="row">
                                    @for($i = 1; $i <= (24 - 1); $i++)
                                        <div class="col-md-4 form-floating mb-3">
                                            <div class="cat action">
                                                <label>
                                                   <input type="checkbox" value="{{$horarios[$i]}}" name="horas" id="{{$i}}" onclick="llenarArrayDatos()"><span>{{$horarios[$i]}}</span>
                                                </label>
                                             </div>
                                        </div>
                                    @endfor

                                    @if(!is_null(session('rol')) && (session('rol') == 2 || session('rol') == "2"))
                                        <div class="row">
                                            <div class="cl-xs-12 col-sm-12 cl-md-12 col-lg-12">
                                                <div class="wrap-input100">
                                                    {!! Form::select('trainers', $trainers, null, ['class' => 'input100', 'id' => 'trainers']) !!}
                                                    <span class="focus-input100" data-placeholder=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

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
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnClose">Close</button>
                                <button type="submit" class="btn btn-success" id="btnAccion">Save</button>
                            </div>
                        {{-- </form> --}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            {{-- Fin Modal --}}
        </div>
    </div>
</div>
</div>

<!-- Footer -->
<footer class="text-center text-white footer">
    <!-- Grid container -->
    <div class="container">
        <!-- Section: Links -->
        <section class="mt-5">
            <!-- Grid row-->
            <div class="row text-center d-flex justify-content-center pt-5 padding">
                <!-- Grid column -->
                <div class="col-md-2 col-md-offset-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="#!" class="text-white">About us</a>
                    </h6>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="#!" class="text-white">Services</a>
                    </h6>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="#!" class="text-white">Help</a>
                    </h6>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="#!" class="text-white">Contact</a>
                    </h6>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row-->
        </section>
        <!-- Section: Links -->

        <hr class="my-5"/>

        <!-- Section: Text -->
        <section class="mb-5">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8 col-lg-offset-2">
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt
                        distinctio earum repellat quaerat voluptatibus placeat nam,
                        commodi optio pariatur est quia magnam eum harum corrupti
                        dicta, aliquam sequi voluptate quas.
                    </p>
                </div>
            </div>
        </section>
        <!-- Section: Text -->

        <!-- Section: Social -->
        <section class="text-center mb-5">
            <a href="" class="text-white fa-2x facebook">
                <i class="fa fa-facebook-f"></i>
            </a>
            <a href="" class="text-white fa-2x twitter">
                <i class="fa fa-twitter"></i>
            </a>
            <a href="" class="text-white fa-2x google">
                <i class="fa fa-google"></i>
            </a>
            <a href="" class="text-white fa-2x insta">
                <i class="fa fa-instagram"></i>
            </a>
            <a href="" class="text-white fa-2x link">
                <i class="fa fa-linkedin"></i>
            </a>
        </section>
        <!-- Section: Social -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3 copy-footer">
        <p>
            All Rights Reserved ©
            <a class="text-white" href="#">Let's Talk</a> {{date('Y')}}
        </p>
    </div>
    <!-- Copyright -->
</footer>

<script src="{{asset('js/jquery-2.1.3.min.js') }}"></script>
<script src="{{asset('eventos/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('eventos/js/main.min.js')}}"></script>
<script src="{{asset('eventos/js/moment.js')}}"></script>
<script src="{{asset('eventos/js/es.js')}}"></script>
<script src="{{asset('eventos/js/sweetalert2.all.min.js')}}"></script>
<script>

    $( document ).ready(function()
    {
        window.$("#trainers").trigger('focus');
        window.$("#trainers").prepend(new Option("Select User...", "-1"));
        cargarEventosPorEntrenador();
        window.$("#trainers").val("-1");
    });

    let calendarEl = document.getElementById('calendar');
    let frm = document.getElementById('formulario');
    let myModal = new bootstrap.Modal(document.getElementById('myModal'));
    let min = '06:00:00';
    let max = '22:00:00';
    const url_store = "{{route('trainer.store')}}";
    let  myData = [];

document.addEventListener('DOMContentLoaded', function ()
{
    calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'local',
        initialView: 'dayGridMonth',
        locale: 'en',
        headerToolbar: {
            left: 'prev next today',
            center: 'title',
            right: 'dayGridMonth listWeek'
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

            // Validamos que no se puedan crear eventos más de 15 dias en el futuro
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
            let evento_id = info.event.id

            $.ajax({
                async: false,
                url: "{{route('cargar_info_evento')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id_evento': evento_id
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
        eventDrop: function (info)
        {}
    });

    calendar.render();
    frm.addEventListener('submit', function (e)
    {
        e.preventDefault();
        let horas = $("#horarios").val();
        let fecha_evento = $("#fecha_evento").val();
        let user_id = $("#trainers").val();

        if ((horas == '' || horas == null || horas == undefined) ||
            (fecha_evento == '' || fecha_evento == null || fecha_evento == undefined))
        {
             Swal.fire(
                 'Error',
                 'Please, selected a range of hour',
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
                    'trainer_id': user_id
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

                    if(response == "ya_existe")
                    {
                        $("#loaderGif").hide();
                        $("#loaderGif").addClass('ocultar');
                        myModal.hide();
                        $("#loaderGif").hide();
                        Swal.fire({
                            position: 'center'
                            , icon: 'error'
                            , title: 'Error!'
                            , html: 'You already have availabilities pending approval, it is not possible to create the availability.'
                            , type: 'error'
                            , showCancelButton: false
                            , showConfirmButton: false
                            , allowOutsideClick: false
                            , allowEscapeKey: false
                            , timer: 5000
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 5200);
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
                        id: element.id_horario,
                        allDay: false,
                        editable: false,
                        start: `${element.start_date}T${element.start_time}:00`,
                        end: `${element.end_date}T${element.end_time}:00`,
                        title: element.title,
                        color: element.color,
                        textColor: '#FFFFFF',
                    }
                );
            });
        }
    });
}
</script>
</body>
</html>

