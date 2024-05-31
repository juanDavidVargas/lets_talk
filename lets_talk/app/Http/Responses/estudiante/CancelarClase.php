<?php

namespace App\Http\Responses\estudiante;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\usuarios\Reserva;
use App\Models\estudiante\Credito;
use App\Models\entrenador\EventoAgendaEntrenador;
use Carbon\Carbon;
use App\Http\Controllers\estudiante\EstudianteController;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CancelarClase implements Responsable
{
    public function toResponse($request)
    {
        $idEstudiante =  intval(request('id_estudiante', null));
        $idInstructor = intval(request('id_instructor', null));
        $idHorario = intval(request('id_horario', null));
        $idEstado = intval(request('id_estado', null));

        DB::connection('mysql')->beginTransaction();

        $idClaseReservada = Reserva::select('id_reserva')
            ->where('id_estudiante',$idEstudiante)
            ->where('id_instructor',$idInstructor)
            ->where('id_trainer_horario',$idHorario)
            ->first();

        if (isset($idClaseReservada) && !is_null($idClaseReservada) && !empty($idClaseReservada)) {
            try {
                $claseReservada = Reserva::findOrFail($idClaseReservada->id_reserva);

                if ($claseReservada) {

                    $claseCancelada = $claseReservada->forceDelete();

                    if ($claseCancelada) {
                        $idCreditoConsumido = Credito::select('id_credito')
                        ->where('id_estado',$idEstado)
                        ->where('id_estudiante',$idEstudiante)
                        ->where('id_instructor',$idInstructor)
                        ->where('id_trainer_agenda',$idHorario)
                        ->orderBy('id_credito','desc')
                        ->first();

                        if (isset($idCreditoConsumido) && !is_null($idCreditoConsumido) && !empty($idCreditoConsumido)) {
                            $idCreditoLiberado = Credito::where('id_credito', $idCreditoConsumido->id_credito)
                            ->update(
                                [
                                    'id_estado' => 7,
                                    'id_instructor' => null,
                                    'id_trainer_agenda' => null,
                                    'fecha_consumo_credito' => null,
                                ]
                            );
    
                            if ( (isset($claseReservada) && !is_null($claseReservada) && !empty($claseReservada)) && (isset($idCreditoLiberado) && !is_null($idCreditoLiberado) && !empty($idCreditoLiberado)) ) {
                                DB::connection('mysql')->commit();
                                return response()->json("clase_cancelada");
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                dd($e);
                DB::connection('mysql')->rollback();
                return response()->json("error");
            } // FIN catch
        } // FIN If
    } // FIN toResponse
} // FIN Class CancelarClase()
