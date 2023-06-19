<?php

namespace App\Http\Responses\entrenador;

use App\Mail\Disponibilidades\MailAprobacionDisponibilidad;
use App\Models\entrenador\DisponibilidadEntrenadores;
use App\Models\entrenador\EventoAgendaEntrenador;
use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Mail;

class AgendaEntrenadorStore implements Responsable
{
    public function toResponse($request)
    {
        $disponibilidad = request('hrs_disponibilidad', null);
        $fecha_disponibilidad = request('fecha_evento', null);

        $array_otro = [];

        if(isset($disponibilidad) && !is_null($disponibilidad) && !empty($disponibilidad))
        {
            $array_disponibilidad = explode(",", $disponibilidad);
        } else {
            $array_disponibilidad = [];
        }

        if($array_disponibilidad == [] || count($array_disponibilidad) == 0 || empty($array_disponibilidad))
        {
            DB::connection('mysql')->rollback();
            return response()->json("error_horas");
        }

        DB::connection('mysql')->beginTransaction();

        try
        {
            foreach ($array_disponibilidad as $disp)
            {

                $horas_disp= DisponibilidadEntrenadores::select('horario')->where('id_horario', $disp)->first();

                $hora_inicio = substr($horas_disp->horario, 0, 5);
                $hora_fin = substr($horas_disp->horario, 6);

                $insert_evento = EventoAgendaEntrenador::create([
                    'title' => 'Disponibilidad ' . session('username'),
                    'description' => 'Horas de disponibilidad ' . session('username'),
                    'start_date' => $fecha_disponibilidad,
                    'start_time' => trim($hora_inicio),
                    'end_date' => $fecha_disponibilidad,
                    'end_time' => trim($hora_fin),
                    'color' => '#157347',
                    'state' => 2,// Pendiente Aprobación
                    'id_usuario' => session('usuario_id'),
                    'id_horario' => $disp
                ]);
            }

            if($insert_evento)
            {
                DB::connection('mysql')->commit();

                $this->enviarCorreoAdminAprobacion(session('usuario_id'));

                return response()->json("success_evento");
            } else {
                DB::connection('mysql')->rollback();
                return response()->json("error_evento");
            }

        } catch (Exception $e)
        {
            dd($e);
            DB::connection('mysql')->rollback();
            return response()->json('exception_evento');
        }
    }

    public function eliminarEvento()
    {
        $id_evento = request('id_evento', null);

        try {

            $evento = EventoAgendaEntrenador::find($id_evento);
            $evento->delete();

            return response()->json("success");

        } catch (Exception $e)
        {
            return response()->json("error_exception");
        }
    }

    public function enviarCorreoAdminAprobacion($usuario_id)
    {
        // Consultamos la información del usuario logueado
        $datos_usuario = $this->traerDatosUsuario($usuario_id);
        $datos_admin = $this->traerDatosAdministrador();
        $traer_disponibilidad = $this->disponibilidadUsuario($usuario_id);

        if(isset($datos_usuario) && !empty($datos_usuario) && !is_null($datos_usuario)
           && $datos_usuario != "error_datos_usuario" &&
           isset($datos_admin) && !empty($datos_admin) && !is_null($datos_admin)
           && $datos_admin != "error_datos_admin")
        {

            if(isset($traer_disponibilidad) && !empty($traer_disponibilidad) && !is_null($traer_disponibilidad)
               && $traer_disponibilidad != "error_datos_disp")
            {
                //Envio del correo
                Mail::to($datos_admin->correo)->send(new MailAprobacionDisponibilidad($datos_usuario,  $datos_admin, $traer_disponibilidad));
            }
        }
    }

    public function traerDatosUsuario($usuario_id)
    {
        try
        {
            return User::find($usuario_id);

        } catch (Exception $e)
        {
            return "error_datos_usuario";
            Logger("Error consultando los datos del usuario: {$e}");
        }
    }

    public function traerDatosAdministrador()
    {
        try
        {
            return User::where('id_rol', 2)->first();

        } catch (Exception $e)
        {
            return "error_datos_admin";
            Logger("Error consultando los datos del usuario administrador: {$e}");
        }
    }

    public function disponibilidadUsuario($usuario_id)
    {
        try
        {
            return EventoAgendaEntrenador::where('id_usuario', $usuario_id)->get();

        } catch (Exception $e)
        {
            return "error_datos_disp";
            Logger("Error consultando los datos del usuario administrador: {$e}");
        }
    }
}
