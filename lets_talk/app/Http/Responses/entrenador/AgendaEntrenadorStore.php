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
        $todo_el_dia = request('all_day', null);
        $inicio = request('starts', null);
        $fin = request('ends', null);
        $color = request('color', null);
        $status_free = request('status_free', null);
        $status_busy = request('status_busy', null);

        // Reemplazamos los slash por guiones intermedios
        $fecha_inicio = str_replace("/", "-", $inicio);
        $fecha_fin = str_replace("/", "-", $fin);

        $fecha_inicio_formato = substr($fecha_inicio, 0, 10);
        $fecha_fin_formato = substr($fecha_fin, 0, 10);

        DB::connection('mysql')->beginTransaction();

        try
        {
            if($todo_el_dia === true || $todo_el_dia === "true")
            {
                $hora_inicio = "00:00";
                $hora_fin = "23:59";
            } else {
                $hora_inicio = substr($fecha_inicio, 10);
                $hora_fin = substr($fecha_fin, 10);
            }

            $insert_evento = EventoAgendaEntrenador::create([
                'title' => trim($titulo),
                'description' => !is_null($descripcion) ? trim($descripcion) : null,
                'all_day' => $todo_el_dia === "true" ? 1 : 0,
                'start_date' => trim($fecha_inicio_formato),
                'start_time' => trim($hora_inicio),
                'end_date' => trim($fecha_fin_formato),
                'end_time' => trim($hora_fin),
                'color' => $color,
                'status_busy' => $status_busy === "true" ? 1 : 0,
                'status_free' => $status_free === "true" ? 1 : 0,
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
