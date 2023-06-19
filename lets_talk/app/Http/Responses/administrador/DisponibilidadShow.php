<?php

namespace App\Http\Responses\administrador;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;

class DisponibilidadShow implements Responsable
{
    public function toResponse($request) {}

    public function traerDisponibilidades()
    {

        try
        {
            $disponibilidad = DB::table('evento_agenda_entrenador')
                                    ->join('usuarios', 'usuarios.id_user', '=', 'evento_agenda_entrenador.id_usuario')
                                    ->join('estados', 'estados.id_estado', '=', 'evento_agenda_entrenador.state')
                                    ->select(
                                        'evento_agenda_entrenador.id',
                                        'evento_agenda_entrenador.title',
                                        'evento_agenda_entrenador.description',
                                        'evento_agenda_entrenador.start_date',
                                        'evento_agenda_entrenador.start_time',
                                        'evento_agenda_entrenador.end_date',
                                        'evento_agenda_entrenador.end_time',
                                        'evento_agenda_entrenador.state',
                                        'usuarios.nombres',
                                        'usuarios.apellidos',
                                        'estados.descripcion_estado'
                                    )
                                    ->where('usuarios.estado', 1)
                                    ->whereNull('usuarios.deleted_at')
                                    ->whereNull('evento_agenda_entrenador.deleted_at')
                                    ->whereIn('evento_agenda_entrenador.state', [1,2,3])
                                    ->orderBy('evento_agenda_entrenador.id', 'DESC')
                                    ->get();
            return $disponibilidad;

        } catch (Exception $e)
        {
            alert()->error("Ha ocurrido un error!");
            return redirect()->to(route('administrador.index'));
        }

    }
}
