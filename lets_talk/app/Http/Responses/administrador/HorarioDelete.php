<?php

namespace App\Http\Responses\administrador;

use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\entrenador\DisponibilidadEntrenadores;

class HorarioDelete implements Responsable
{
    public function toResponse($request)
    {
        try {
            $idHorario = $request->id_horario;

            $consultaIdHorario = DisponibilidadEntrenadores::where('id_horario', $idHorario)->first();

            if ($consultaIdHorario) {
                $consultaIdHorario->delete();
                return response()->json('deleted');
            } else {
                return response()->json('no_deleted');
            }
        } catch (Exception $e) {
            alert()->error('Error', 'An error has occurred deleting the Schedule, try again, if the problem persists contact support.');
            return back();
        }
    }
}
