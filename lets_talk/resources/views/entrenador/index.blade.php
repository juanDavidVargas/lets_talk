@extends('layouts.layout')
@section('title', 'Trainers Sessions')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/fixedHeader.bootstrap.min.css')}}">
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-center text-uppercase">Trainer's Sessions</h1>
        </div>
    </div>

    <div class="row p-b-20 float-right">
        <div class="col-xs-12 col-sm-12 col-md-12">
            {{-- <a href="{{route('administrador.create')}}" class="btn btn-primary">Create New User</a> --}}
        </div>
    </div>
    <div class="row p-t-30">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="tbl_trainer_sessions" aria-describedby="sesiones entrenadores">
                    <thead>
                        <tr class="header-table">
                            <th>Student's Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{$student->nombre_completo}}</td>
                                <td>{{$student->start_date}}</td>
                                <td>{{$student->start_time}}</td>
                                <td><a href="#" id="trainer_sesion_detail_{{$student->id_sesion}}" onclick="seeDetails({{$student->id_sesion}},{{$student->id_user}})">SEE DETAILS</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('js/dataTables.fixedHeader.min.js')}}"></script>

    <script>
        $( document ).ready(function() {

            $('#tbl_trainer_sessions').DataTable({
                'ordering': false
            });
        });

        function seeDetails(idSesion,idUser) {
            // console.log(idUser);
            // alert(`el id de la sesión es: ${id_sesion}`);

            $.ajax({
                url: "{{route('detalle_sesion_entrenador')}}",
                type: "POST",
                dataType: "json",
                data: {
                    'id_user': idUser
                },
                success: function(response) {
                    console.log(response[0].nombre_completo);

                    html = `<p><strong>SESSION DETAILS</strong></p>`;
                    html += `<p>el id del usuario es: ${response[0].id_user}</p>`;
                    html += `<p>${response[0].nombre_completo}</p>`;

                    if (response[0].celular) {
                        html += `<p>PHONE ${response[0].celular}</p>`;
                    } else {
                        html += `<p>PHONE</p>`;
                    }

                    if (response[0].correo) {
                        html += `<p>EMAIL ${response[0].correo}</p>`;
                    } else {
                        html += `<p>EMAIL</p>`;
                    }

                    if (response[0].zoom) {
                        html += `<p>ZOOM ${response[0].zoom}</p>`;
                    } else {
                        html += `<p>ZOOM</p>`;
                    }

                    if (response[0].zoom_clave) {
                        html += `<p>ZOOM PASS ${response[0].zoom_clave}</p>`;
                    } else {
                        html += `<p>ZOOM PASS</p>`;
                    }

                    if (response[0].nivel_descripcion) {
                        html += `<p>LEVEL ${response[0].nivel_descripcion}</p>`;
                    } else {
                        html += `<p>LEVEL</p>`;
                    }

                    html += `<p>SESSION INFO</p>`;

                    if (response[0].id_primer_contacto = 1) {
                        html += `<p>1ST CONTACT ${response[0].primer_telefono}</p>`; // Phone
                    } else if (response[0].id_primer_contacto = 2) {
                        html += `<p>1ST CONTACT ${response[0].primer_celular}</p>`; // Whatsapp-Celular
                    } else if (response[0].id_primer_contacto = 3) {
                        html += `<p>1ST CONTACT ${response[0].primer_skype}</p>`; // Skype
                    } else if (response[0].id_primer_contacto = 4) {
                        html += `<p>1ST CONTACT ${response[0].primer_correo}</p>`; // Email
                    } else if (response[0].id_primer_contacto = 5) {
                        html += `<p>1ST CONTACT ${response[0].primer_zoom}</p>`; // Zoom
                    } else {
                        html += `<p>1ST CONTACT</p>`; // Null
                    }

                    if (response[0].id_segundo_contacto = 1) {
                        html += `<p>2ND CONTACT ${response[0].segundo_telefono}</p>`; // Phone
                    } else if (response[0].id_primer_contacto = 2) {
                        html += `<p>2ND CONTACT ${response[0].segundo_celular}</p>`; // Whatsapp-Celular
                    } else if (response[0].id_primer_contacto = 3) {
                        html += `<p>2ND CONTACT ${response[0].segundo_skype}</p>`; // Skype
                    } else if (response[0].id_primer_contacto = 4) {
                        html += `<p>2ND CONTACT ${response[0].segundo_correo}</p>`; // Email
                    } else if (response[0].id_primer_contacto = 5) {
                        html += `<p>2ND CONTACT ${response[0].segundo_zoom}</p>`; // Zoom
                    } else {
                        html += `<p>2ND CONTACT</p>`; // Null
                    }

                    html += `<p>INTERNAL EVALUATION (NOTES)</p>`;
                    html += `<p>BOTÓN SAVE EVALUATION</p>`;
                    html += `<p>BOTÓN OLD EVALUATION</p>`;

                    Swal.fire({
                        html: html,
                        showCloseButton: true,
                        showCancelButton: true,
                        focusConfirm: false,
                        allowOutsideClick: false,
                        confirmButtonText:
                            '<i class="fa fa-thumbs-up"></i> Great!',
                        confirmButtonAriaLabel: 'Thumbs up, great!',
                        cancelButtonText:
                            '<i class="fa fa-thumbs-down"></i>',
                        cancelButtonAriaLabel: 'Thumbs down'
                    })
                }
            });
        }
    </script>
@endsection
