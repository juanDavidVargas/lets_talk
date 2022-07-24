<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fullcalendar</title>
<meta name="description" content="Fullcalendar ejemplo..."/>
<link rel="stylesheet" href="css/font-awesome.min.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="css/styles.css">
<link rel='stylesheet' type='text/css' href='css/fullcalendar.css' />
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script type='text/javascript' src='js/moment.min.js'></script>
<script type='text/javascript' src='js/fullcalendar.min.js'></script>
<script type='text/javascript' src='js/locale/es.js'></script>
<script>
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
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: yyyy+'-'+mm+'-'+dd,
        buttonIcons: true, // show the prev/next text
        weekNumbers: false,
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: [
            {
                title: 'All Day Event',
                description: 'Lorem ipsum 1...',
                start: yyyy+'-'+mm+'-01',
                color: '#3A87AD',
                textColor: '#ffffff',
            },
            {
                title: 'Long Event',
                description: 'Lorem ipsum 2...',
                start:  yyyy+'-'+mm+'-07',
                end:  yyyy+'-'+mm+'-10',
                color: '#3A87AD',
                textColor: '#ffffff',
            },
            {
                title: 'Repeating Event',
                description: 'Lorem ipsum 3...',
                start:  yyyy+'-'+mm+'-09T16:00:00',
                color: '#3A87AD',
                textColor: '#ffffff',
            },
            {
                title: 'Repeating Event',
                description: 'Lorem ipsum 4...',
                start:  yyyy+'-'+mm+'-16T16:00:00',
                color: '#3A87AD',
                textColor: '#ffffff',
            },
            {
                title: 'Conference',
                description: 'Lorem ipsum 5...',
                start:  yyyy+'-'+mm+'-11',
                end:  yyyy+'-'+mm+'-13',
                color: '#3A87AD',
                textColor: '#ffffff',
            },
            {
                title: 'Meeting',
                description: 'Lorem ipsum 6...',
                start:  yyyy+'-'+mm+'-12T10:30:00',
                end:  yyyy+'-'+mm+'-12T12:30:00',
                color: '#3A87AD',
                textColor: '#ffffff',
            },
            {
                title: 'Lunch',
                description: 'Lorem ipsum 7...',
                start:  yyyy+'-'+mm+'-12T12:00:00',
                color: '#3A87AD',
                textColor: '#ffffff',
            },
            {
                title: 'Meeting',
                description: 'Lorem ipsum 8...',
                start:  yyyy+'-'+mm+'-12T14:30:00',
                color: '#3A87AD',
                textColor: '#ffffff',
            },
            {
                title: 'Happy Hour',
                description: 'Lorem ipsum 9...',
                start:  yyyy+'-'+mm+'-12T17:30:00',
                color: '#3A87AD',
                textColor: '#ffffff',
            },
            {
                title: 'Dinner',
                description: 'Lorem ipsum 10...',
                start:  yyyy+'-'+mm+'-12T20:00:00',
                color: '#3A87AD',
                textColor: '#ffffff',
            },
            {
                title: 'Birthday Party',
                description: 'Lorem ipsum 11...',
                start:  yyyy+'-'+mm+'-13T07:00:00',
                color: '#3A87AD',
                textColor: '#ffffff',
            },
            {
                title: 'Event with link',
                description: 'Lorem ipsum 12...',
                url: 'http://www.jose-aguilar.com/',
                start:  yyyy+'-'+mm+'-28',
                color: '#3A87AD',
                textColor: '#ffffff',
            }
        ],
        dayClick: function (date, jsEvent, view) {
            alert('Has hecho click en: '+ date.format());
        },
        eventClick: function (calEvent, jsEvent, view) {
            $('#event-title').text(calEvent.title);
            $('#event-description').html(calEvent.description);
            $('#modal-event').modal();
        },
	});
});

</script>
</head>

<body>
<div class="container">
    <h1>Fullcalendar Demo</h1>
    <h2 class="lead">Simple demo</h2>

    <div class="row">
        <div id="content" class="col-lg-12">
            <div id="calendar"></div>
            <div class="modal fade" id="modal-event" tabindex="-1" role="dialog" aria-labelledby="modal-eventLabel" aria-hidden="true">
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
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- Bloque de anuncios adaptable -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-6676636635558550"
                 data-ad-slot="8523024962"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header">Comparte en las redes sociales</h5>
        <div class="card-body">
            <h5 class="card-title">¿Te ha servido este ejemplo? Comparte con tus amigos</h5>
            <!-- Go to www.addthis.com/dashboard to customize your tools -->
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4ecc1a47193e29e4" async="async"></script>
            <!-- Go to www.addthis.com/dashboard to customize your tools -->
            <div class="addthis_sharing_toolbox"></div>
        </div>
    </div>
</div>
</body>
</html>
