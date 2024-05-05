<?php

namespace App\Http\Responses\entrenador;

use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Log\Logger;
use App\Models\entrenador\EvaluacionInterna;

class EvaluacionInternaStore implements Responsable
{
    public function toResponse($request)
    {
        $evaluacionInterna = request('evaluacion_interna', null);
        $idEstudiante = request('id_estudiante', null);
        $usuLogueado = session('usuario_id');

        DB::connection('mysql')->beginTransaction();

        try {
            $evaluacionInternaCreate = EvaluacionInterna::create([
                'evaluacion_interna' => $evaluacionInterna,
                'id_estudiante' => $idEstudiante,
                'id_instructor' => $usuLogueado,
            ]);

            if ($evaluacionInternaCreate) {
                DB::connection('mysql')->commit();
                alert()->success('Successful Process', 'Internal valuation created');
                return redirect()->to(route('trainer.index'));
            } else {
                DB::connection('mysql')->rollback();
                alert()->error('Error', 'An error has occurred creating the user, please contact support.');
                return redirect()->to(route('entrenador.index'));
            }

        } catch (Exception $e) {
            DB::connection('mysql')->rollback();
            alert()->error('Error', 'An error has occurred creating the user, try again, if the problem persists contact support.');
            return back();
        }
    }
}
