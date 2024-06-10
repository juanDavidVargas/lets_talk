<?php

namespace App\Http\Responses\estudiante;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\usuarios\Reserva;
use App\Models\estudiante\Credito;
use App\Models\entrenador\EventoAgendaEntrenador;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class CancelarClase implements Responsable
{
    public function toResponse($request)
    {
        $idEstudiante =  intval(request('id_estudiante', null));
        $idInstructor = intval(request('id_instructor', null));
        $idHorario = intval(request('id_horario', null));
        $idEstado = intval(request('id_estado', null));

        // dd($idEstudiante,$idInstructor,$idHorario,$idEstado);

        // DB::connection('mysql')->beginTransaction();

        $idClaseReservada = Reserva::select('id_reserva','google_event_id')
            ->where('id_estudiante',$idEstudiante)
            ->where('id_instructor',$idInstructor)
            ->where('id_trainer_horario',$idHorario)
            ->first();

        // dd($idClaseReservada);

        if (isset($idClaseReservada) && !is_null($idClaseReservada) && !empty($idClaseReservada))
        {
            try
            {
                $claseReservada = Reserva::findOrFail($idClaseReservada->id_reserva);

                // dd($claseReservada);

                if (isset($claseReservada) && !is_null($claseReservada) && !empty($claseReservada))
                {
                    try
                    {
                        // Crear un cliente de Google con las credenciales del archivo JSON
                        $client = new Google_Client();
                        $client->setClientId(env('GOOGLE_CLIENT_ID'));
                        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
                        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
                        $client->addScope(Google_Service_Calendar::CALENDAR);

                        // Configurar el cliente Guzzle para desactivar la verificación SSL (Provisional etapa desarrollo)
                        $client->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));

                        $accessToken = Session::get('google_access_token');
                        dd($accessToken);

                        if (!$accessToken) {
                            throw new Exception('Access token no encontrado en la sesión.');
                        }

                        $client->setAccessToken($accessToken);

                        // Verificar si el token de acceso ha caducado y refrescarlo si es necesario
                        if ($client->isAccessTokenExpired()) {
                            // Asumiendo que has almacenado el refresh token en la sesión
                            $refreshToken = $client->getRefreshToken();
                            
                            if ($refreshToken) {
                                $client->fetchAccessTokenWithRefreshToken($refreshToken);
                                Session::put('google_access_token', $client->getAccessToken());
                            } else {
                                throw new Exception('Access token expiró y no hay token disponible para refrescar.');
                            }
                        }

                        // Crear una instancia del servicio de Google Calendar
                        $service = new Google_Service_Calendar($client);

                        // Aquí debes obtener el ID del evento asociado con el horario, instructor y estudiante específicos que están siendo cancelados
                        $eventId = $idClaseReservada->google_event_id;
                        $service->events->delete('primary', $eventId);
                    }
                    catch (Exception $e)
                    {
                        DB::rollback();
                        dd($e->getMessage());
                        return response()->json("error_link");
                    }

                    // ====================================================================

                    $claseCancelada = $claseReservada->forceDelete();

                    if ($claseCancelada)
                    {
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
                            ->update([
                                    'id_estado' => 7,
                                    'id_instructor' => null,
                                    'id_trainer_agenda' => null,
                                    'fecha_consumo_credito' => null,
                            ]);

                            if ( (isset($claseReservada) && !is_null($claseReservada) && !empty($claseReservada)) && (isset($idCreditoLiberado) && !is_null($idCreditoLiberado) && !empty($idCreditoLiberado)) )
                            {
                                DB::connection('mysql')->commit();
                                return response()->json("clase_cancelada");
                            }
                        }
                    }
                }
            }
            catch (Exception $e)
            {
                dd($e);
                DB::connection('mysql')->rollback();
                return response()->json("error_exception");
            } // FIN catch
        } // FIN If
    } // FIN toResponse
} // FIN Class CancelarClase()
