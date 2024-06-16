<?php

namespace App\Http\Responses\administrador;

use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\entrenador\DisponibilidadEntrenadores;

class HorarioStore implements Responsable
{
    public function toResponse($request)
    {
        DB::connection('mysql')->beginTransaction();

        $initialHour = request('hora_inicial', null);
        $finalHour = request('hora_final', null);
        $horario = $initialHour.' - '.$finalHour;

        $consultaHorario = DisponibilidadEntrenadores::select('horario')
                            ->where('horario', $horario)
                            ->first();

        if (isset($consultaHorario) && !is_null($consultaHorario) && !empty($consultaHorario))
        {
            return response()->json('schedule_exist');
        } else
        {
            try
            {
                $nuevoHorario = DisponibilidadEntrenadores::create([
                    'horario' => $horario,
                    'id_estado' => 1
                ]);

                if ($nuevoHorario)
                {
                    DB::connection('mysql')->commit();
                    return response()->json('success');
                } else
                {
                    DB::connection('mysql')->rollback();
                    return response()->json('error');
                }

            } catch (Exception $e)
            {
                DB::connection('mysql')->rollback();
                return response()->json('exception');
            }
        }
    }
}
