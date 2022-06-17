<?php

namespace App\Http\Responses\entrenador;

use App\Models\entrenador\EventoAgendaEntrenador;
use Exception;
use Illuminate\Contracts\Support\Responsable;

class AgendaEntrenadorShow implements Responsable
{
    public function toResponse($request)
    {}

    public function cargarEventosPorEntrenador()
    {
        $usuario_id = session('usuario_id');

        try
        {
            $eventos = EventoAgendaEntrenador::select('id', 'title', 'description',
                                    'all_day', 'start_date', 'start_time', 'end_date',
                                    'end_time', 'color', 'status_busy', 'status_free')
                        ->whereNull('deleted_at')
                        ->where('state', 1)
                        ->where('id_usuario', $usuario_id)
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
}
