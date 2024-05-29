<?php

namespace App\Http\Controllers\estudiante;

use App\Http\Controllers\admin\AdministradorController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\MetodosTrait;
use App\Models\entrenador\DisponibilidadEntrenadores;
use App\Models\entrenador\EventoAgendaEntrenador;
use App\Http\Responses\administrador\DisponibilidadShow;
use App\Http\Responses\estudiante\ReservarClase;
use App\Http\Responses\estudiante\ComprarCreditos;
use App\Models\estudiante\Credito;
use App\Models\usuarios\Reserva;
use Exception;
use Illuminate\Support\Facades\DB;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class EstudianteController extends Controller
{
    use MetodosTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminCtrl = new AdministradorController();
        $sesion = $adminCtrl->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           empty($sesion[3]) || is_null($sesion[3]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $vista = 'estudiante.index';
            $checkConnection = $this->checkDatabaseConnection($vista);

            if($checkConnection->getName() == "database_connection") {
                return view('database_connection');
            } else {
                $idEstudiante = session('usuario_id');
                $misSesiones = $this->misSesiones($idEstudiante);

                return view($vista, compact('misSesiones'));
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // private function share_data()
    // {
    //     view()->share('disponibilidadEntrenadores', $this->disponibilidadEntrenadores());
    // }
    
    public function disponibilidadEntrenadores()
    {
        $adminCtrl = new AdministradorController();
        $sesion = $adminCtrl->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           empty($sesion[3]) || is_null($sesion[3]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $vista = 'estudiante.disponibilidad';
            $checkConnection = $this->checkDatabaseConnection($vista);

            if($checkConnection->getName() == "database_connection") {
                return view('database_connection');
            } else {
                $disponibilidadEntrenadores = EventoAgendaEntrenador::leftjoin('usuarios','usuarios.id_user','=','evento_agenda_entrenador.id_instructor')
                            ->select('evento_agenda_entrenador.id as id_evento',
                                'evento_agenda_entrenador.id_instructor',
                                'id_user',
                                DB::raw("CONCAT(nombres, ' ', apellidos) AS nombre_completo"),
                                'start_date',
                                'start_time'
                            )
                            ->orderBy('evento_agenda_entrenador.id', 'desc')
                            ->get();
                return view($vista, compact('disponibilidadEntrenadores', $disponibilidadEntrenadores));
            }
        }
    }


    // public function disponibilidad()
    // {
    //     $adminCtrl = new AdministradorController();
    //     $sesion = $adminCtrl->validarVariablesSesion();

    //     if(empty($sesion[0]) || is_null($sesion[0]) &&
    //        empty($sesion[1]) || is_null($sesion[1]) &&
    //        empty($sesion[2]) || is_null($sesion[2]) &&
    //        empty($sesion[3]) || is_null($sesion[3]) &&
    //        $sesion[2] != true)
    //     {
    //         return redirect()->to(route('home'));
    //     } else {
    //         $vista = 'estudiante.disponibilidad';
    //         $checkConnection = $this->checkDatabaseConnection($vista);

    //         if($checkConnection->getName() == "database_connection") {
    //             return view('database_connection');
    //         } else {
    //             $arrayDias = array(
    //                 1 => "MARTES",
    //                 2 => "MIÉRCOLES",
    //                 3 => "JUEVES",
    //                 4 => "VIERNES",
    //                 5 => "SÁBADO",
    //                 6 => "DOMINGO",
    //                 7 => "LUNES"
    //             );
    //             $arrayHorarios = DisponibilidadEntrenadores::select('id_horario', 'horario')
    //                                 ->pluck('horario', 'id_horario');
    //             view()->share('arrayDias', $arrayDias);
    //             view()->share('horarios', $arrayHorarios);
    //             return view($vista);
    //         }
    //     }
    // }

    // public function traerDisponibilidades(Request $request)
    // {
    //     try {
            
    //         $adminCtrl = new AdministradorController();
    //         $sesion = $adminCtrl->validarVariablesSesion();
    
    //         if(empty($sesion[0]) || is_null($sesion[0]) &&
    //            empty($sesion[1]) || is_null($sesion[1]) &&
    //            empty($sesion[2]) || is_null($sesion[2]) &&
    //            empty($sesion[3]) || is_null($sesion[3]) &&
    //            $sesion[2] != true)
    //         {
    //             return redirect()->to(route('home'));
    //         } else {
            
    //             $disponibilidadShow = new DisponibilidadShow();
    //             return $disponibilidadShow->disponibilidadPorID($request);
    //         }

    //     } catch (Exception $e) {
    //         return response()->json("error_exception");
    //     }
    // }

    public function misCreditos(Request $request)
    {
        try {
            // $adminCtrl = new AdministradorController();
            // $sesion = $adminCtrl->validarVariablesSesion();
    
            // if(empty($sesion[0]) || is_null($sesion[0]) &&
            //    empty($sesion[1]) || is_null($sesion[1]) &&
            //    empty($sesion[2]) || is_null($sesion[2]) &&
            //    empty($sesion[3]) || is_null($sesion[3]) &&
            //    $sesion[2] != true)
            // {
                // return redirect()->to(route('home'));

                $idEstudiante = session('usuario_id');

                $misCreditos = Credito::select(
                    DB::raw('DATE_FORMAT(FROM_UNIXTIME(fecha_credito), "%d-%m-%Y") as fecha_credito'),
                    'paquete',
                    DB::raw('COUNT(*) as cantidad')
                )
                ->where('id_estudiante', $idEstudiante)
                ->where('id_estado', 7)
                ->groupBy(DB::raw('DATE_FORMAT(FROM_UNIXTIME(fecha_credito), "%d-%m-%Y")'), 'paquete')
                ->get();

                $totalCantidad = $misCreditos->sum('cantidad');

                return view('estudiante.mis_creditos', compact('misCreditos', 'totalCantidad'));
            // } else {
            //     $disponibilidadShow = new DisponibilidadShow();
            //     return $disponibilidadShow->disponibilidadPorID($request);
            // }

        } catch (Exception $e) {
            dd($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    public function creditosDisponibles(Request $request)
    {
        try {
            
            // $adminCtrl = new AdministradorController();
            // $sesion = $adminCtrl->validarVariablesSesion();
    
            // if(empty($sesion[0]) || is_null($sesion[0]) &&
            //    empty($sesion[1]) || is_null($sesion[1]) &&
            //    empty($sesion[2]) || is_null($sesion[2]) &&
            //    empty($sesion[3]) || is_null($sesion[3]) &&
            //    $sesion[2] != true)
            // {
                // return redirect()->to(route('home'));
                return view('estudiante.creditos_disponibles');
            // } else {
            
            //     $disponibilidadShow = new DisponibilidadShow();
            //     return $disponibilidadShow->disponibilidadPorID($request);
            // }

        } catch (Exception $e) {
            return response()->json("error_exception");
        }
    }
        
    public function reservarClase(Request $request)
    {
        try {
            // $adminCtrl = new AdministradorController();
            // $sesion = $adminCtrl->validarVariablesSesion();
    
            // if(empty($sesion[0]) || is_null($sesion[0]) &&
            //    empty($sesion[1]) || is_null($sesion[1]) &&
            //    empty($sesion[2]) || is_null($sesion[2]) &&
            //    empty($sesion[3]) || is_null($sesion[3]) &&
            //    $sesion[2] != true)
            // {
                // return redirect()->to(route('home'));
                return new ReservarClase();
            // } else {
            
            //     $disponibilidadShow = new DisponibilidadShow();
            //     return $disponibilidadShow->disponibilidadPorID($request);
            // }

        } catch (Exception $e) {
            return response()->json("error_exception");
        }
    }

    public function comprarCreditos(Request $request)
    {
        try {
            // $adminCtrl = new AdministradorController();
            // $sesion = $adminCtrl->validarVariablesSesion();
    
            // if(empty($sesion[0]) || is_null($sesion[0]) &&
            //    empty($sesion[1]) || is_null($sesion[1]) &&
            //    empty($sesion[2]) || is_null($sesion[2]) &&
            //    empty($sesion[3]) || is_null($sesion[3]) &&
            //    $sesion[2] != true)
            // {
                // return redirect()->to(route('home'));
                return new ComprarCreditos();
            // } else {
            
            //     $disponibilidadShow = new DisponibilidadShow();
            //     return $disponibilidadShow->disponibilidadPorID($request);
            // }

        } catch (Exception $e) {
            return response()->json("error_exception");
        }
    }

    public function misSesiones($idEstudiante)
    {
        try {
            // $adminCtrl = new AdministradorController();
            // $sesion = $adminCtrl->validarVariablesSesion();
    
            // if(empty($sesion[0]) || is_null($sesion[0]) &&
            //    empty($sesion[1]) || is_null($sesion[1]) &&
            //    empty($sesion[2]) || is_null($sesion[2]) &&
            //    empty($sesion[3]) || is_null($sesion[3]) &&
            //    $sesion[2] != true)
            // {
                // return redirect()->to(route('home'));

                // select
                //     reservas.id_estudiante,
                //     reservas.id_instructor,
                //     CONCAT(instructor.nombres, ' ', instructor.apellidos) AS nombre_instructor,
                //     reservas.id_trainer_horario,
                //     start_date,
                //     start_time
                // from
                //     reservas
                    
                // left join evento_agenda_entrenador on evento_agenda_entrenador.id = reservas.id_trainer_horario
                // /*left join usuarios as estudiante on estudiante.id_user = reservas.id_estudiante*/
                // left join usuarios as instructor on instructor.id_user = reservas.id_instructor

                // where
                //     id_estudiante = 14
                    
                return Reserva::leftjoin('evento_agenda_entrenador','evento_agenda_entrenador.id','=','reservas.id_trainer_horario')
                ->leftjoin('usuarios as instructor','instructor.id_user','=','reservas.id_instructor')
                ->select(
                    'reservas.id_estudiante',
                    'reservas.id_instructor',
                    DB::raw("CONCAT(instructor.nombres, ' ', instructor.apellidos) AS nombre_instructor"),
                    'reservas.id_trainer_horario',
                    'start_date',
                    'start_time'
                )
                ->where('id_estudiante', $idEstudiante)
                ->orderBy('start_date', 'desc')
                ->get();
            // } else {
            
            //     $disponibilidadShow = new DisponibilidadShow();
            //     return $disponibilidadShow->disponibilidadPorID($request);
            // }

        } catch (Exception $e) {
            return response()->json("error_exception");
        }
    }
    
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

    private function getGoogleClient()
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

    /*
    Redirige al usuario a la página de inicio de sesión de Google para autenticarse y autorizar a tu aplicación a acceder a sus datos de Google Calendar.
    1. Obtiene una instancia de Google_Client usando el método getGoogleClient().
    2. Llama a createAuthUrl() en el cliente de Google, que genera la URL de autenticación de Google.
    3. Redirige al usuario a esta URL, donde Google le pedirá que inicie sesión y autorice a tu aplicación.
    */
    public function redirectToGoogle()
    {
        $client = $this->getGoogleClient();
        return redirect($client->createAuthUrl());
        // return redirect()->route('auth.google');
    }

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
        $client->authenticate($request->input('code'));
        $accessToken = $client->getAccessToken();

        Session::put('google_access_token', $accessToken);

        // return redirect()->route('createMeet');
        
        $vista = 'estudiante.disponibilidad';

        $disponibilidadEntrenadores = EventoAgendaEntrenador::leftjoin('usuarios','usuarios.id_user','=','evento_agenda_entrenador.id_instructor')
        ->select('evento_agenda_entrenador.id as id_evento',
            'evento_agenda_entrenador.id_instructor',
            'id_user',
            DB::raw("CONCAT(nombres, ' ', apellidos) AS nombre_completo"),
            'start_date',
            'start_time'
        )
        ->orderBy('evento_agenda_entrenador.id', 'desc')
        ->get();

        return view($vista, compact('disponibilidadEntrenadores', $disponibilidadEntrenadores));
        // return redirect('http://localhost:8000/auth/google');
    }

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

    // public function createMeet($fechaClase, $horaClase)
    public function createMeet()
    {
        // dd($fechaClase, $horaClase);

        $client = $this->getGoogleClient();
        $client->setAccessToken(Session::get('google_access_token'));
        $service = new Google_Service_Calendar($client);

        // $timeZone = 'America/Bogota';
        // $timeZone = '00-05:00';

        // Crear la fecha y hora de inicio y fin del evento
        // $startDateTime = $fechaClase . 'T' . $horaClase . ':00-05:00'; // Ajusta la zona horaria según corresponda
        // $endDateTime = Carbon::parse($startDateTime)->addHour()->format('Y-m-d\TH:i:sP');

        // ===========================================

        // $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $fechaClase . ' ' . $horaClase, 'America/Bogota');
        // $endDateTime = $startDateTime->copy()->addHour();

        // $startDateTime = "2024-04-30";
        // $endDateTime = "18:00";

        // dd($startDateTime);
        // dd($endDateTime);


        // $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $fechaClase . ' ' . $horaClase, $timeZone);
        // $startDateTime = $fechaClase . 'T' . $horaClase . ':00-07:00';
        // $endDateTime = $startDateTime->copy()->addMinutes(30);

        // ===========================================

        $event = new Google_Service_Calendar_Event([
            'summary' => 'Google Meet Meeting',
            'start' => ['dateTime' => '2024-04-30T18:00:00-05:00'],
            'end' => ['dateTime' => '2024-04-30T18:30:00-05:00'],

            // 'start' => ['dateTime' => $startDateTime->toRfc3339String(), 'timeZone' => $timeZone],
            // 'end' => ['dateTime' => $endDateTime->toRfc3339String(), 'timeZone' => $timeZone],

            // 'start' => ['dateTime' => $startDateTime],
            // 'end' => ['dateTime' => $endDateTime],

            'conferenceData' => [
                'createRequest' => [
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                    'requestId' => 'some-random-string'
                ]
            ]
        ]);

        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

        // echo 'Join the meeting at: ' . $event->getHangoutLink();
        $linkMeet = $event->getHangoutLink();

        // $vista = 'estudiante.disponibilidad';

        // $disponibilidadEntrenadores = EventoAgendaEntrenador::leftjoin('usuarios','usuarios.id_user','=','evento_agenda_entrenador.id_instructor')
        // ->select('evento_agenda_entrenador.id as id_evento',
        //     'evento_agenda_entrenador.id_instructor',
        //     'id_user',
        //     DB::raw("CONCAT(nombres, ' ', apellidos) AS nombre_completo"),
        //     'start_date',
        //     'start_time'
        // )
        // ->orderBy('evento_agenda_entrenador.id', 'desc')
        // ->get();

        // return view($vista, compact('disponibilidadEntrenadores', $disponibilidadEntrenadores, 'linkMeet'));

        // return view('estudiante.disponibilidad');

        // $hangoutLink = $event->getHangoutLink();
        // Redirigir a una vista y pasar el enlace de la reunión
        // return view('disponibilidad', ['hangoutLink' => $hangoutLink]);
    }
}
