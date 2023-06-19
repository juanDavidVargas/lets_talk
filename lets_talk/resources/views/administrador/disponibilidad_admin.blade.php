@extends('layouts.layout')
@section('title', 'Trainers Schedule')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/fixedHeader.bootstrap.min.css')}}">
@stop
@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <h2 class="text-center text-uppercase">Trainer's Schedule</h2>
    </div>
</div>

<div class="row p-b-20 float-left">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <button class="btn btn-primary" id="btn_create_schedule">Create New Schedule</button>
    </div>
</div>

<div class="row p-t-30">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tbl_trainer_sessions" aria-describedby="tabla horarios entrenadores">
                <thead>
                    <tr class="header-table">
                        <th>ID</th>
                        <th>Schedule</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($todasDisponibilidades as $horario)
                    <tr>
                        <td>{{$horario['id_horario']}}</td>
                        <td>{{$horario['horario']}}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-danger" id="btn_delete_schedule_{{$horario['id_horario']}}" onclick="deleteSchedule('{{$horario['id_horario']}}')">Delete Schedule</a>
                        </td>
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
    $(document).ready(function() {

        $('#tbl_trainer_sessions').DataTable({
            'ordering': false
        });

        let form_store_shedule = ''

        form_store_shedule += `
            {!! Form::open(['method' => 'POST', 'route' => ['administrador.disponibilidad_admin_store'], 'id' => 'form_store_shedule', 'class' => 'login100-form validate-form', 'autocomplete' => 'off']) !!}
            @csrf
        `;

        form_store_shedule += `
                <div>
                    <label>Initial Hour</label>
                    <input type="text" minlength="4" manlength="4" name = "initial_hour" placeholder="09:00">
                </div>

                <div>
                    <label>Final Hour</label>
                    <input type="text" minlength="4" manlength="4" name = "final_hour" placeholder="10:00">
                </div>
            `;

        form_store_shedule += `
                <input type="submit" class="btn btn-primary mt-5" id="btn_store_shedule" value="Create Schedule" >
            `;

        form_store_shedule += `
                {!! Form::close() !!}
            `;

        $('#btn_create_schedule').click(function() {
            Swal.fire({
                position: 'center'
                , title: 'Info!'
                , html: form_store_shedule
                , type: 'info'
                , showCancelButton: true
                , showConfirmButton: false
                , allowOutsideClick: false
                , allowEscapeKey: false
            });
        });
    });

    function deleteSchedule(idHorario) {

        let idHorarioDelete = idHorario;

        Swal.fire({
            position: 'center'
            , title: 'Are you sure you want to delete this schedule?'
            , text: 'You will not be able to revert this!'
            , type: 'warning'
            , showCancelButton: true
            , showConfirmButton: true
            , allowOutsideClick: false
            , allowEscapeKey: false
            , confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!'
            , cancelButtonText: '<i class="fa fa-thumbs-down"></i> Cancel'
            , cancelButtonColor: '#d33'
            , confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.value == true) {
                $.ajax({
                    async: false
                    , url: "{{route('administrador.disponibilidad_admin_delete')}}"
                    , type: "POST"
                    , dataType: "json"
                    , data: {
                        'id_horario': idHorarioDelete
                    }
                    , success: function(response) {
                        if (response == "deleted") {
                            Swal.fire({
                                position: 'center'
                                , title: 'Info!'
                                , html: 'The Schedule has been deleted!'
                                , type: 'info'
                                , showCancelButton: false
                                , showConfirmButton: false
                                , allowOutsideClick: false
                                , allowEscapeKey: false
                                , timer: 3000
                            });
                            refrescarSchedule();
                            return;
                        }

                        if (response == "no_deleted") {
                            Swal.fire({
                                position: 'center'
                                , title: 'Error!'
                                , html: 'There was a problem deleting the Schedule!'
                                , type: 'error'
                                , showCancelButton: false
                                , showConfirmButton: false
                                , allowOutsideClick: false
                                , allowEscapeKey: false
                                , timer: 3000
                            });
                            return;
                        }
                    }
                });
            } else {
                Swal.fire({
                    position: 'center'
                    , title: 'Info!'
                    , html: 'No changes were made!'
                    , type: 'info'
                    , showCancelButton: false
                    , showConfirmButton: false
                    , allowOutsideClick: false
                    , allowEscapeKey: false
                    , timer: 3000
                });
                return;
            }
        });
    }

    function refrescarSchedule() {
        setTimeout('window.location.reload()', 3000);
    }

</script>
@endsection
