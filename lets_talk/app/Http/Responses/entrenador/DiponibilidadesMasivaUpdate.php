<?php

namespace App\Http\Responses\entrenador;

use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Log\Logger;
use App\Models\entrenador\EventoAgendaEntrenador;

class DiponibilidadesMasivaUpdate implements Responsable
{
    public function toResponse($request)
    {
        $estado = request("idEstado", null);
        $idEvento = $request['idsDisponibilidades'];

        DB::connection('mysql')->beginTransaction();

        try {
            $actualizacionMasivaDiponibilidades = EventoAgendaEntrenador::whereIn('id', $idEvento)
                    ->update(
                        [
                            'state' => $estado,
                        ]
                    );

            if($actualizacionMasivaDiponibilidades)
            {
                DB::connection('mysql')->commit();
                return response()->json("exito");
            } else
            {
                DB::connection('mysql')->rollback();
                return response()->json("error");
            }

        } catch (Exception $e)
        {
            DB::connection('mysql')->rollback();
            return response()->json("error_exception");
        }
    }
}
