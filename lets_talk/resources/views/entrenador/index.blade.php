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

                    console.log(response);
                    
                }
            });

            // html = '<p><strong>SESSION DETAILS</strong></p>';
            // html += `<p>el id de la sesión es: ${id_sesion}</p>`;
            // html += '<p>Student name HERE</p>';
            // html += `<p>PHONE</p>`;
            // html += `<p>EMAIL</p>`;
            // html += `<p>ZOOM</p>`;
            // html += `<p>ZOOM PASS</p>`;
            // html += `<p>LEVEL</p>`;
            // html += `<p>SESSION INFO</p>`;
            // html += `<p>1ST CONACT.............VALOR</p>`;
            // html += `<p>2ND CONACT.............VALOR</p>`;
            // html += `<p>INTERNAL EVALUATION (NOTES)</p>`;
            // html += `<p>BOTÓN SAVE EVALUATION</p>`;
            // html += `<p>BOTÓN OLD EVALUATION</p>`;
            // html += `Fin`;

            // Swal.fire({
            //     html: html,
            //     showCloseButton: true,
            //     showCancelButton: true,
            //     focusConfirm: false,
            //     allowOutsideClick: false,
            //     confirmButtonText:
            //         '<i class="fa fa-thumbs-up"></i> Great!',
            //     confirmButtonAriaLabel: 'Thumbs up, great!',
            //     cancelButtonText:
            //         '<i class="fa fa-thumbs-down"></i>',
            //     cancelButtonAriaLabel: 'Thumbs down'
            // })
        }
    </script>
@endsection
