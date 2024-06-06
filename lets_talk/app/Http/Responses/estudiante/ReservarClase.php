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

class ReservarClase implements Responsable
{
    public function toResponse($request)
    {
        $idEstudiante =  session('usuario_id');
        $idInstructor = intval(request('id_instructor', null));
        $idHorario = intval(request('id_horario', null));
        $fechaClase = request('fecha_clase', null);
        $horaClaseInicio = request('hora_clase_inicio', null);

        $queryDisponibilidadCreditos = Credito::select('id_credito', 'paquete')
                                    ->where('id_estado', 7)
                                    ->where('id_estudiante',$idEstudiante)
                                    ->orderBy('id_credito','asc')
                                    ->first();

        if (isset($queryDisponibilidadCreditos) && !is_null($queryDisponibilidadCreditos) && !empty($queryDisponibilidadCreditos))
        {
            try
            {
                if (!Session::has('google_access_token')) {
                    $authUrl = $this->getGoogleClient()->createAuthUrl();
                    return response()->json(['status' => 'auth_required', 'auth_url' => $authUrl]);
                }

                $createLinkMeet = $this->createMeet($fechaClase, $horaClaseInicio);

                if (isset($createLinkMeet) && !is_null($createLinkMeet) && !empty($createLinkMeet))
                {
                    DB::connection('mysql')->beginTransaction();

                    $reservarClaseCreate = Reserva::create([
                        'id_estudiante' => $idEstudiante,
                        'id_instructor' => $idInstructor,
                        'id_trainer_horario' => $idHorario
                    ]);
    
                    if(isset($reservarClaseCreate) && !is_null($reservarClaseCreate) && !empty($reservarClaseCreate)) {
                        DB::connection('mysql')->commit();

                        $queryEventoAgendaEntrenador = EventoAgendaEntrenador::select('id', 'start_date','start_time')
                                                        ->where('id',$idHorario)
                                                        ->first();

                        $fechaClase = $queryEventoAgendaEntrenador->start_date;
                        $horaClase = $queryEventoAgendaEntrenador->start_time;

                        $fechaHora = Carbon::createFromFormat('Y-m-d H:i', $fechaClase . ' ' . $horaClase)->timestamp;
                        $idCredito = $queryDisponibilidadCreditos->id_credito;

                        Credito::where('id_credito', $idCredito)
                                ->update([
                                        'id_estado' => 8,
                                        'id_instructor' => $idInstructor,
                                        'id_trainer_agenda' => $idHorario,
                                        'fecha_consumo_credito' => $fechaHora,
                                ]);

                        DB::connection('mysql')->commit();
                        // Después de realizar la reserva con éxito
                        Session::forget('google_access_token');
                        return response()->json(['status' => 'clase_reservada', 'meet_link' => $createLinkMeet]);
                    }
                }
            } catch (Exception $e)
            {
                dd($e);
                DB::connection('mysql')->rollback();
                return response()->json(['status' => 'error']);
            }
        } else {
            DB::connection('mysql')->rollback();
            return response()->json(['status' => 'creditos_no_disponibles']);
        }
    } // FIN toResponse

    // ==============================================================
    // ==============================================================
    // ==============================================================
    // ==============================================================
    // ==============================================================

    /*
        Configura y devuelve una instancia de Google_Client con las credenciales y configuraciones necesarias para interactuar con las APIs de Google.
        1. Crea una nueva instancia de Google_Client.
        2. Configura el client_id, client_secret y redirect_uri usando las variables de entorno (env()).
        3. Establece el alcance necesario para acceder a los eventos del calendario (Google_Service_Calendar::CALENDAR_EVENTS).
        4. Configura el tipo de acceso como offline para obtener un token de actualización.
        5. Establece el prompt como consent para asegurarse de que se solicita el consentimiento del usuario cada vez que se autentica.
        3. Devuelve la instancia de Google_Client configurada.
    */

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

    // ==============================================================
    // ==============================================================

    /*
        Redirige al usuario a la página de inicio de sesión de Google para autenticarse y autorizar a tu aplicación a acceder a sus datos de Google Calendar.
        1. Obtiene una instancia de Google_Client usando el método getGoogleClient().
        2. Llama a createAuthUrl() en el cliente de Google, que genera la URL de autenticación de Google.
        3. Redirige al usuario a esta URL, donde Google le pedirá que inicie sesión y autorice a tu aplicación.
    */
    public function redirectToGoogle()
    {
        $client = $this->getGoogleClient();
        $authUrl = $client->createAuthUrl();
        return redirect()->away($authUrl);
    }

    // ==============================================================
    // ==============================================================

    /*
        Maneja la redirección de vuelta desde Google después de que el usuario haya autenticado y autorizado la aplicación. Intercambia el código de autorización por un token de acceso y lo guarda en la sesión.
        1. Obtiene una instancia de Google_Client usando el método getGoogleClient().
        2. Llama a authenticate() en el cliente de Google con el código de autorización recibido en la solicitud (obtenido de request->input('code')).
        3. Obtiene el token de acceso llamando a getAccessToken().
        4. Guarda el token de acceso en la sesión usando Session::put('google_access_token', $accessToken).
        5. Redirige al usuario a la ruta createMeet para crear una reunión en Google Meet.
    */

    public function handleGoogleCallback(Request $request)
    {
        $client = $this->getGoogleClient();

        if ($request->has('code')) {
            $client->authenticate($request->get('code'));
            $accessToken = $client->getAccessToken();
            Session::put('google_access_token', $accessToken);

            return redirect()->route('estudiante.disponibilidad')->with('status', 'Google authentication successful!');
        }

        return redirect()->route('estudiante.disponibilidad')->with('error', 'Failed to authenticate with Google');
    }

    // ==============================================================
    // ==============================================================

    /*
        Crea una nueva reunión en Google Meet y proporciona el enlace para unirse a la reunión.
        1. Obtiene una instancia de Google_Client usando el método getGoogleClient().
        2. Establece el token de acceso en el cliente de Google usando setAccessToken() con el token guardado en la sesión.
        3. Crea una instancia de Google_Service_Calendar con el cliente autenticado.
        4. Define un evento de Google Calendar, incluyendo los detalles de la reunión (resumen, hora de inicio y fin, y datos de la conferencia para crear una reunión de Google Meet).
        5. Inserta el evento en el calendario primario (primary) usando events->insert().
        6. Imprime el enlace para unirse a la reunión (getHangoutLink()).
    */

    public function createMeet($fechaClase, $horaClaseInicio)
    {
        $client = $this->getGoogleClient();
        $client->setAccessToken(Session::get('google_access_token'));
        $service = new Google_Service_Calendar($client);
        
        // Crear la fecha y hora de inicio y fin del evento
        $startDateTime = $fechaClase . 'T' . $horaClaseInicio . ':00-05:00';
        $endDateTime = Carbon::parse($startDateTime)->addMinutes(30)->format('Y-m-d\TH:i:sP');

        $event = new Google_Service_Calendar_Event([
            'summary' => 'Clase Google Meet',
            'start' => ['dateTime' => $startDateTime],
            'end' => ['dateTime' => $endDateTime],
            'conferenceData' => [
                'createRequest' => [
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                    'requestId' => 'some-random-string'
                ]
            ]
        ]);

        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

        return $event->getHangoutLink();
    }
} // FIN class ReservarClase
