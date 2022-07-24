@extends('layouts.layout')
@section('title', 'Trainers Agenda')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/fixedHeader.bootstrap.min.css')}}">

<link rel="stylesheet" href="{{asset('fullcalendar/css/font-awesome.min.css')}}">
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> --}}
<link rel="stylesheet" href="{{asset('fullcalendar/css/styles.css')}}">
<link rel='stylesheet' type='text/css' href="{{asset('fullcalendar/css/fullcalendar.css')}}" />
@stop
@section('content')

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
                <div class="row">
                    <div id="content" class="col-lg-12">
                        <div id="calendar"></div>

                        {{-- Inicio Modal --}}
                        <div class="modal fade" id="modal_event" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="event-title"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="event-description"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                            </div>
                        </div>
                        </div>
                        {{-- Fin modal --}}
                    </div>
                </div>
        </div>
    </div>
</div>

@stop
@section('scripts')
{{-- <script src="https://code.jquery.com/jquery-3.2.1.js"></script> --}}
<script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> --}}
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}
<script type='text/javascript' src="{{asset('fullcalendar/js/moment.min.js')}}"></script>
<script type='text/javascript' src="{{asset('fullcalendar/js/fullcalendar.min.js')}}"></script>
<script type='text/javascript' src="{{asset('fullcalendar/js/locale/es.js')}}"></script>

<script>

    let min = '06:00:00';
    let max = '22:00:00';

    function addZero(i) {
        if (i < 10) {
            i = '0' + i;
        }
        return i;
    }

    var hoy = new Date();
    var dd = hoy.getDate();
    if(dd<10) {
        dd='0'+dd;
    }

    if(mm<10) {
        mm='0'+mm;
    }

    var mm = hoy.getMonth()+1;
    var yyyy = hoy.getFullYear();

    dd=addZero(dd);
    mm=addZero(mm);

    $(document).ready(function() {

        $('#calendar').fullCalendar({
            height: 560,
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'agendaDay,agendaWeek,month'
            },
            locale: 'en',
            timezone: 'local',
            defaultView: 'agendaWeek',
            editable: true,
            allDaySlot: false, // true, false
            eventLimit: true,
            selectable: true,
            eventDurationEditable: true,
            disableDragging: false,
            disableResizing: false,
            lazyFetching: false, // Don't change this to true or month view wont work.
            filter: false,
            quickSave: false,
            timeFormat: 'h:mma',
            defaultColor: '#554079',
            eventColor: '#554079',
            weekType: 'agendaWeek',
            dayType: 'agendaDay',
            firstDay: 1, // Monday (0=sunday)
            hiddenDays: [], // [0,1,2,3,4,5,6] to hide days as you wish
            aspectRatio: 5.35, // will make day boxes bigger
            weekends: true, // show (true) the weekend or not (false)
            weekNumbers: false, // show week numbers (true) or not (false)
            fixedWeekCount: 'true', // true, false
            slotEventOverlap: true,
            slotLabelFormat: 'h:mma',
            slotDuration: "00:15:00",
            slotLabelInterval: 10,
            minTime: min,
            maxTime: max,
            eventOverlap: true,
            nowIndicator:true,
            select: function (start, end, jsEvent)
            {
                let event = {"start": start, "end": end};

                if (!calendar.checkTime(event) || event.start.isBefore(event.end, 'day')) {
                    calendar.fullCalendar('refetchEvents');
                    return false;
                }
                if(event.end > Date.now())
                {
                    alert("event select");

                }else{
                    $('#calendar').fullCalendar('unselect');
                    swal({
                        title: 'Error',
                        text: "No Events Can Be Created On Past Dates",
                        type: 'error'
                    });
                }
            },
            dayClick: function (date, jsEvent, view)
            {
                $('#calendar').fullCalendar('unselect');
               alert("event day click: " + date.format());
            },
            eventClick: function (calEvent, jsEvent, view)
            {
                if (!calendar.checkTime(calEvent) ||
                     calEvent.start.isBefore(event.end, 'day'))
                {
                    $('#calendar').fullCalendar('unselect');
                    return false;
                }

                alert("event click");
            },
            eventDrop: function (calEvent, delta, revertFunc, jsEvent, ui, view)
            {
                if (!calendar.checkTime(calEvent) ||
                    calEvent.start.isBefore(event.end, 'day') &&
                    calEvent.start > Date.now())
                {
                    $('#calendar').fullCalendar('unselect');
                    revertFunc();
                    return false;
                }
            },
            eventResize: function (calEvent, delta, revertFunc) {
                if (!calendar.checkTime(calEvent) ||
                     calEvent.start.isBefore(calEvent.end, 'day'))
                {
                    $('#calendar').fullCalendar('unselect');
                    revertFunc();
                    return false;
                }
            },
            // events: {
            //     url: "",
            //     type: 'GET',
            //     data: {},
            //     error: function () {
            //         swal({
            //             title: 'Error!',
            //             text: "Ha ocurrido un error",
            //             type: 'error'
            //         });
            //     }
            // }
            events: []
        });

        calendar.checkTime = function (calEvent)
        {
            if ( calEvent.end.isBefore(Date.now(), 'day') ) {
                swal({
                    title: 'Error!',
                    text: "You cannot create or modify events in the past.",
                    type: 'error'
                });
                return false;
            }
            if (calEvent.start.toDate().getHours() < min.split(':')[0] ||
                calEvent.end.toDate().getHours() > max.split(':')[0]) {
                swal({
                    title: 'Error!',
                    text: "Events Cannot Be Created At This Time",
                    type: 'error'
                });
                return false;
            }
            return true;
        }
    });

</script>
@endsection

