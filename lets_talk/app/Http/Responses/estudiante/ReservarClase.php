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
        // dd($request);

        $idEstudiante =  session('usuario_id');
        $idInstructor = request('id_instructor', null);
        $idHorario = request('id_horario', null);

        // dd($idInstructor, $idHorario);

        DB::connection('mysql')->beginTransaction();

        try {
            $reservarClaseCreate = Reserva::create([
                'id_estudiante' => $idEstudiante,
                'id_instructor' => $idInstructor,
                'id_horario' => $idHorario,
            ]);

            if($reservarClaseCreate)
            {
                DB::connection('mysql')->commit();
                return response()->json("clase_reservada");
            } else
            {
                DB::connection('mysql')->rollback();
                return response()->json("clase_no_reservada");
            }
        } catch (Exception $e) {
            DB::connection('mysql')->rollback();
            return response()->json("error");
        }
    }
}
