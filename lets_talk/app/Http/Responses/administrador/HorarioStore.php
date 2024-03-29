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

        $initialHour = request('initial_hour', null);
        $finalHour = request('final_hour', null);
        $horario = $initialHour.'-'.$finalHour;
        // dd($initialHour, $finalHour, $horario);

        $consultaHorario = DisponibilidadEntrenadores::select('horario')->where('horario', $horario)->first();

        if (isset($consultaHorario) && !is_null($consultaHorario) && !empty($consultaHorario)) {
            alert()->error('Error', 'The Schedule already exists, chose another one please');
            return redirect()->to(route('administrador.disponibilidad_admin'));
        } else {
            try {
                $nuevoHorario = DisponibilidadEntrenadores::create([
                    'horario' => $horario,
                ]);

                if ($nuevoHorario) {
                    DB::connection('mysql')->commit();
                    alert()->success('Successful Process', 'Schedule successfully created');
                    return redirect()->to(route('administrador.disponibilidad_admin'));
                }

            } catch (Exception $e) {
                DB::connection('mysql')->rollback();
                alert()->error('Error', 'An error has occurred creating the Schedule, try again, if the problem persists contact support.');
                return back();
            }
        }
    }
}
