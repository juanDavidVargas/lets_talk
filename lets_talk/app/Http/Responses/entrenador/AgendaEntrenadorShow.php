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
                                    'id_horario')
                        ->whereNull('deleted_at')
                        ->where('state', 1)
                        // ->where('id_usuario', $usuario_id)
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
}
