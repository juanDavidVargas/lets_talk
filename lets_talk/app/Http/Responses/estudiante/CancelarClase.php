<?php

namespace App\Http\Responses\estudiante;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\usuarios\Reserva;
use App\Models\estudiante\Credito;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Session;

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

        if (isset($idClaseReservada) && !is_null($idClaseReservada) && !empty($idClaseReservada))
        {
            try
            {
                $claseReservada = Reserva::findOrFail($idClaseReservada->id_reserva);

                if (isset($claseReservada) && !is_null($claseReservada) && !empty($claseReservada))
                {
                    // Aquí comienza el código para eliminar el evento del Google Calendar
                    // try {
                    //     $client = new Google_Client();
                    //     $client->setAccessToken(Session::get('google_access_token'));

                    //     // Configurar el cliente Guzzle para desactivar la verificación SSL
                    //     $client->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));

                    //     $service = new Google_Service_Calendar($client);

                    //     // Aquí debes obtener el ID del evento asociado con el horario, instructor y estudiante específicos que están siendo cancelados
                    //     $idReservaLink = $idClaseReservada->id_reserva;
                    //     $service->events->delete('primary', $idReservaLink);

                    // } catch (Exception $e) {
                    //     DB::rollback();
                    //     dd($e->getMessage());
                    //     return response()->json("error_link");
                    // }

                    $claseCancelada = $claseReservada->forceDelete();

                    if ($claseCancelada) {
                        $idCreditoConsumido = Credito::select('id_credito')
                        ->where('id_estado',$idEstado)
                        ->where('id_estudiante',$idEstudiante)
                        ->where('id_instructor',$idInstructor)
                        ->where('id_trainer_agenda',$idHorario)
                        ->orderBy('id_credito','desc')
                        ->first();

                        if (isset($idCreditoConsumido) && !is_null($idCreditoConsumido) && !empty($idCreditoConsumido))
                        {
                            $idCreditoLiberado = Credito::where('id_credito', $idCreditoConsumido->id_credito)
                            ->update(
                                [
                                    'id_estado' => 7,
                                    'id_instructor' => null,
                                    'id_trainer_agenda' => null,
                                    'fecha_consumo_credito' => null,
                                ]
                            );

                            if ( (isset($claseReservada) && !is_null($claseReservada) && !empty($claseReservada)) && (isset($idCreditoLiberado) && !is_null($idCreditoLiberado) && !empty($idCreditoLiberado)) )
                            {
                                DB::connection('mysql')->commit();
                                return response()->json("clase_cancelada");
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                dd($e);
                DB::connection('mysql')->rollback();
                return response()->json("error_exception");
            } // FIN catch
        } // FIN If
    } // FIN toResponse
} // FIN Class CancelarClase()
