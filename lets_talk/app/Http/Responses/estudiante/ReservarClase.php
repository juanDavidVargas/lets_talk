<?php

namespace App\Http\Responses\estudiante;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\usuarios\Reserva;

class ReservarClase implements Responsable
{
    public function toResponse($request)
    {
        $idEstudiante =  session('usuario_id');
        $idInstructor = intval(request('id_instructor', null));
        $idHorario = intval(request('id_horario', null));

        DB::connection('mysql')->beginTransaction();

        try {
            $reservarClaseCreate = Reserva::create([
                'id_estudiante' => $idEstudiante,
                'id_instructor' => $idInstructor,
                'id_trainer_horario' => $idHorario
            ]);

            if($reservarClaseCreate) {
                DB::connection('mysql')->commit();
                return response()->json("clase_reservada");
            } else {
                DB::connection('mysql')->rollback();
                return response()->json("clase_no_reservada");
            }
        } catch (Exception $e) {
            DB::connection('mysql')->rollback();
            return response()->json("error");
        }
    }
}
