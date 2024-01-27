<?php

namespace App\Http\Responses\entrenador;

use App\Models\entrenador\EventoAgendaEntrenador;
use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;

class AgendaEntrenadorShow implements Responsable
{
    public function toResponse($request)
    {}

    public function cargarEventosPorEntrenador()
    {
        $usuario_id = session('usuario_id');
        $rol = User::select('id_rol')->where('id_user', $usuario_id)->first();
        $where= "";

        if($rol->id_rol == 2 || $rol->id_rol == "2")
        {
            $where = " id > 1";
        } else
        {
            $where = " id_usuario = " . $usuario_id;
        }

        try
        {
            $eventos = EventoAgendaEntrenador::select(
                                    'id',
                                    'title',
                                    'description',
                                    'start_date',
                                    'start_time',
                                    'end_date',
                                    'end_time',
                                    'color',
                                    'state',
                                    'id_usuario',
                                    'id_horario',
                                    'num_dia'
                                )
                        ->whereNull('deleted_at')
                        ->where('state', 1)
                        ->whereRaw($where)
                        ->get();

            if(isset($eventos) && !is_null($eventos) && !empty($eventos))
            {
                return response()->json(['agenda' => $eventos]);
            } else {
                return response()->json('error_query_eventos');
            }

        } catch (Exception $e)
        {
            return response()->json("error_exception");
        }
    }

    public function cargarInfoEventoPorId($request)
    {
        try
        {
            $eventos = EventoAgendaEntrenador::select(
                                    'id',
                                    'title',
                                    'description',
                                    'start_date',
                                    'start_time',
                                    'end_date',
                                    'end_time',
                                    'color',
                                    'state',
                                    'id_usuario',
                                    'id_horario')
                        ->whereNull('deleted_at')
                        ->where('state', 1)
                        ->where('id', $request->id_evento)
                        ->get();

            if(isset($eventos) && !is_null($eventos) && !empty($eventos))
            {
                return response()->json($eventos);
            } else {
                return response()->json('error_query_eventos');
            }

        } catch (Exception $e)
        {
            return response()->json("error_exception");
        }
    }

    public function traerSesionesEntrenadores()
    {
        try {
            return DB::table('usuarios')
                    ->leftjoin('evento_agenda_entrenador', 'evento_agenda_entrenador.id_usuario', '=', 'usuarios.id_user')
                    ->leftjoin('estados', 'estados.id_estado', '=', 'evento_agenda_entrenador.state')
                    ->select(
                        'usuarios.id_user',
                        'evento_agenda_entrenador.id AS id_sesion',
                        'evento_agenda_entrenador.start_date',
                        'evento_agenda_entrenador.start_time',
                        'evento_agenda_entrenador.state',
                        DB::raw("CONCAT(usuarios.nombres, ' ', usuarios.apellidos) AS nombre_completo"),
                        'estados.descripcion_estado'
                    )
                    ->where('usuarios.estado', 1)
                    ->where('usuarios.id_rol', 3)
                    ->whereNull('usuarios.deleted_at')
                    ->whereNull('evento_agenda_entrenador.deleted_at')
                    ->whereIn('evento_agenda_entrenador.state', [1])
                    ->orderBy('evento_agenda_entrenador.id', 'DESC')
                    ->get();
        } catch (Exception $e) {
            alert()->error("Error', 'An error has occurred, try again, if the problem persists contact support.!");
            return back();
        }
    }

    public function detalles($idUser)
    {
        try {
            return DB::table('usuarios')
                    ->leftjoin('niveles', 'niveles.id_nivel', '=', 'usuarios.id_nivel')
                    ->leftjoin('contactos', 'contactos.id_user', '=', 'usuarios.id_user')
                    ->select(
                        DB::raw("CONCAT(usuarios.nombres, ' ', usuarios.apellidos) AS nombre_completo"),
                        'usuarios.id_user',
                        'usuarios.celular',
                        'usuarios.correo',
                        'usuarios.zoom',
                        'usuarios.zoom_clave',
                        'usuarios.id_nivel',
                        'niveles.nivel_descripcion',
                        'contactos.id_primer_contacto',
                        'contactos.primer_telefono',
                        'contactos.primer_celular',
                        'contactos.primer_correo',
                        'contactos.primer_skype',
                        'contactos.primer_zoom',
                        'contactos.id_segundo_contacto',
                        'contactos.segundo_telefono',
                        'contactos.segundo_celular',
                        'contactos.segundo_correo',
                        'contactos.segundo_skype',
                        'contactos.segundo_zoom',
                        'contactos.id_opcional_contacto',
                        'contactos.opcional_telefono',
                        'contactos.opcional_celular',
                        'contactos.opcional_correo',
                        'contactos.opcional_skype',
                        'contactos.opcional_zoom'
                    )
                    ->where('usuarios.id_user', $idUser)
                    ->where('usuarios.estado', 1)
                    ->where('usuarios.id_rol', 3)
                    ->whereNull('usuarios.deleted_at')
                    ->first();

        } catch (Exception $e) {
            return response()->json("error_exception");
        }
    }

    public function traerDatosEvalInterna($idEstudiante)
    {
        try {

            return DB::table('evaluacion_interna')
                    ->leftjoin('usuarios as estudiante', 'estudiante.id_user', '=', 'evaluacion_interna.id_estudiante')
                    ->leftjoin('usuarios as instructor', 'instructor.id_user', '=', 'evaluacion_interna.id_instructor')
                    ->where('evaluacion_interna.id_estudiante', $idEstudiante)
                    ->where('evaluacion_interna.id_instructor', 7)
                    ->select(
                        DB::raw("CONCAT(estudiante.nombres, ' ', estudiante.apellidos) AS nombre_estudiante"),
                        'evaluacion_interna.evaluacion_interna',
                        DB::raw("CONCAT(instructor.nombres, ' ', instructor.apellidos) AS nombre_instructor"),
                        'evaluacion_interna.created_at'
                    )
                    ->orderBy('evaluacion_interna.created_at','DESC')
                    ->get();

        } catch (Exception $e) {
            return response()->json("error_exception");
        }
    }
}
