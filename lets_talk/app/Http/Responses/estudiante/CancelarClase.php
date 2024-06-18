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
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\Reservas\MailCancelarClase;
use Illuminate\Log\Logger;

class CancelarClase implements Responsable
{
    public function toResponse($request)
    {
        $idEstudiante =  intval(request('id_estudiante', null));
        $idInstructor = intval(request('id_instructor', null));
        $idHorario = intval(request('id_horario', null));
        $idEstado = intval(request('id_estado', null));

        DB::connection('mysql')->beginTransaction();

        $idClaseReservada = Reserva::select('id_reserva','google_event_id')
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
                    try
                    {
                        // Verificar si el token de acceso está en la sesión
                        if (!Session::has('google_access_token')) {
                            return $this->redirectToGoogle();
                        }

                        // Crear un cliente de Google con las credenciales del archivo JSON
                        $client = $this->getGoogleClient();
                        $accessToken = Session::get('google_access_token');

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
                                return $this->redirectToGoogle();
                            }
                        }

                        // Crear una instancia del servicio de Google Calendar
                        $service = new Google_Service_Calendar($client);

                        // Obtener el ID del evento asociado con el horario, instructor y estudiante específicos que están siendo cancelados
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

                            $idEventoLiberado = EventoAgendaEntrenador::where('id', $idHorario)
                                ->update([
                                        'clase_estado' => 10,
                                        'color' => '#157347',
                                ]);

                            if ( (isset($claseReservada) && !is_null($claseReservada) && !empty($claseReservada)) 
                            && (isset($idCreditoLiberado) && !is_null($idCreditoLiberado) && !empty($idCreditoLiberado)) 
                            && (isset($idEventoLiberado) && !is_null($idEventoLiberado) && !empty($idEventoLiberado)) )
                            {
                                DB::connection('mysql')->commit();

                                // Enviar correo de cancelación de la clase
                                $this->enviarCorreoCancelarClase($idEstudiante, $idInstructor, $idHorario);

                                // Después de realizar la reserva con éxito, reiniciar la sesión
                                Session::forget('google_access_token');

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

    // ================================================================

    public function getGoogleClient()
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setScopes([Google_Service_Calendar::CALENDAR_EVENTS]);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        // Ignorar verificación de SSL solo para desarrollo local
        $client->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));

        // Ó Usar el archivo de certificados CA
        // $client->setHttpClient(new \GuzzleHttp\Client(['verify' => 'ruta/a/tu/cacert.pem']));

        return $client;
    }

    // ================================================================

    public function redirectToGoogle()
    {
        $client = $this->getGoogleClient();
        $authUrl = $client->createAuthUrl();
        return response()->json(['status' => 'auth_required', 'auth_url' => $authUrl]);
    }

    // ================================================================
    // ================================================================

    public function enviarCorreoCancelarClase($idEstudiante, $idInstructor, $idHorario)
    {
        $instructor = $this->datosInstructor($idInstructor);
        $estudiante = $this->datosEstudiante($idEstudiante);
        $eventoAgendaEntrenador = $this->eventoAgendaEntrenador($idHorario);

        if(
            (isset($instructor) && !empty($instructor) && !is_null($instructor)) &&
            (isset($estudiante) && !empty($estudiante) && !is_null($estudiante)) &&
            (isset($eventoAgendaEntrenador) && !empty($eventoAgendaEntrenador) && !is_null($eventoAgendaEntrenador))
        )
        {
            //Envio del correo
            Mail::to($instructor->correo)->send(new MailCancelarClase($instructor,$estudiante,$eventoAgendaEntrenador));
        }
    }

    // ================================================================
    // ================================================================
    
    public function datosInstructor($idInstructor)
    {
        try
        {
            return User::find($idInstructor);

        } catch (Exception $e)
        {
            Logger("Error consultando los datos del usuario administrador: {$e}");
            return "error_datos_admin";
        }
    }

    // ================================================================
    // ================================================================

    public function datosEstudiante($idEstudiante)
    {
        try
        {
            return User::find($idEstudiante);

        } catch (Exception $e)
        {
            Logger("Error consultando los datos del usuario: {$e}");
            return "error_datos_estudiante";
        }
    }

    // ================================================================
    // ================================================================


    public function eventoAgendaEntrenador($idHorario)
    {
        try
        {
            return EventoAgendaEntrenador::find($idHorario);
        } catch (Exception $e)
        {
            dd($e);
            Logger("Error consultando los datos del usuario administrador: {$e}");
            return "error_datos_disponibilidad";
        }
    }
} // FIN Class CancelarClase()
