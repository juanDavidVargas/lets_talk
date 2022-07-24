<?php

namespace App\Http\Responses\entrenador;

use App\Models\entrenador\EventoAgendaEntrenador;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AgendaEntrenadorStore implements Responsable
{
    public function toResponse($request)
    {
        $titulo = request('title', null);
        $descripcion = request('description', null);
        $inicio = request('start', null);
        $fin = request('end', null);
        $hora_inicio = request('start_time', null);
        $hora_fin = request('end_time', null);
        $color = request('color', null);

        $fecha_inicio_formato = Carbon::parse($inicio)->timestamp;
        $fecha_fin_formato = Carbon::parse($fin)->timestamp;

        DB::connection('mysql')->beginTransaction();

        try
        {
            $insert_evento = EventoAgendaEntrenador::create([
                'title' => trim($titulo),
                'description' => !is_null($descripcion) ? trim($descripcion) : null,
                'start_date' => $fecha_inicio_formato,
                'start_time' => trim($hora_inicio),
                'end_date' => $fecha_fin_formato,
                'end_time' => trim($hora_fin),
                'color' => $color,
                'state' => 1,
                'id_usuario' => session('usuario_id')
            ]);

            if($insert_evento)
            {
                DB::connection('mysql')->commit();
                return response()->json("success_evento");
            } else {
                DB::connection('mysql')->rollback();
                return response()->json("error_evento");
            }

        } catch (Exception $e)
        {
            dd($e);
            DB::connection('mysql')->rollback();
            return response()->json('exception_evento');
        }
    }

    public function eliminarEvento()
    {
        $id_evento = request('id', null);

        try {

            $evento = EventoAgendaEntrenador::find($id_evento);
            $evento->delete();

            return response()->json("success");

        } catch (Exception $e)
        {
            return response()->json("error_exception");
        }

    }
}
