<?php

namespace App\Http\Responses\administrador;

use App\Models\entrenador\EventoAgendaEntrenador;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DisponibilidadUpdate implements Responsable
{
    public function toResponse($request)
    {
        $id_disponibilidad = request('disponibilidad_id', null);
        $id_evento = request('evento_id', null);
        DB::connection('mysql')->beginTransaction();

        try
        {
            $disponibilidad_update = EventoAgendaEntrenador::find($id_disponibilidad);

            if($id_evento == 4 || $id_evento == "4")
            {
                $disponibilidad_update->deleted_at = Carbon::parse(now())->format('Y-m-d H:i:s');

            } else
            {
                $disponibilidad_update->deleted_at = null;
            }

            $disponibilidad_update->state = $id_evento;
            $disponibilidad_update->save();

            if($disponibilidad_update)
            {
                DB::connection('mysql')->commit();
                return response()->json("success");
            } else
            {
                DB::connection('mysql')->commit();
                return response()->json("error_update");
            }

        } catch (Exception $e)
        {
            DB::connection('mysql')->rollback();
            return response()->json("error_exception");
        }
    }
}
