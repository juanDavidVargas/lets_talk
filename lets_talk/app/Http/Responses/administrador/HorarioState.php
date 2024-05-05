<?php

namespace App\Http\Responses\administrador;

use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\entrenador\DisponibilidadEntrenadores;

class HorarioState implements Responsable
{
    public function toResponse($request)
    {
        $idHorario = request('id_horario', null);
        $estado = " (CASE WHEN id_estado = 1 THEN 6 ELSE 1 END) ";
        DB::connection('mysql')->beginTransaction();

        try
        {
            $estadoDisponibilidad = DB::table('disponibilidad_entrenadores')
                                        ->where('id_horario', $idHorario)
                                        ->update([
                                            'id_estado' => DB::raw($estado)
                                        ]);

            if ($estadoDisponibilidad)
            {
                DB::connection('mysql')->commit();
                sleep(2);
                return response()->json("success");
            } else
            {
                DB::connection('mysql')->rollback();
                return response()->json('no_inactived');
            }
        } catch (Exception $e)
        {
            DB::connection('mysql')->rollback();
            return response()->json('error_exception');
        }
    }
}
