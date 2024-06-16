<?php

namespace App\Http\Responses\administrador;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use App\Models\entrenador\DisponibilidadEntrenadores;
class HorarioStore implements Responsable
{
    public function toResponse($request)
    {
        DB::connection('mysql')->beginTransaction();
        try
        {
            $initialHour = request('hora_inicial', null);
            $finalHour = request('hora_final', null);
            $horario = $initialHour.' - '.$finalHour;

            $consultaHorario = DisponibilidadEntrenadores::selec('horario')
                            ->where('horario', $horario)
                            ->first();

            if (isset($consultaHorario) && !is_null($consultaHorario) && !empty($consultaHorario))
            {
                return response()->json('schedule_exist');
            } else
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
            }
        } catch (Exception $e)
        {
            DB::connection('mysql')->rollback();
            return response()->json('exception');
        }
    }
}
