<?php

namespace App\Http\Responses\entrenador;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;

class AgendaEntrenadorStore implements Responsable
{
    public function toResponse($request)
    {
        $titulo = request('title', null);
        $descripcion = request('description', null);
        $todo_el_dia = request('all_day', null);
        $inicio = request('starts', null);
        $fin = request('ends', null);
        $color = request('color', null);
        $estado1 = request('status_free', null);
        $estado2 = request('status_busy', null);

        DB::connection('mysql')->beginTransaction();

        try {


        } catch (Exception $e)
        {
            DB::connection('mysql')->rollback();
            return response()->json('exception_evento');
        }
    }
}
