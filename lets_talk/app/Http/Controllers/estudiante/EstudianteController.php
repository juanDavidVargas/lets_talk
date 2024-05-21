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
use Illuminate\Support\Facades\Session;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

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

    public function redirectToGoogle()
    {
        $client = $this->getGoogleClient();
        return redirect($client->createAuthUrl());
    }

    // ==============================================================

    public function handleGoogleCallback(Request $request)
    {
        $client = $this->getGoogleClient();
        $client->authenticate($request->input('code'));
        $accessToken = $client->getAccessToken();

        Session::put('google_access_token', $accessToken);

        return redirect()->route('createMeet');
    }

    // ==============================================================

    public function createMeet()
    {
        $client = $this->getGoogleClient();
        $client->setAccessToken(Session::get('google_access_token'));

        $service = new Google_Service_Calendar($client);

        $event = new Google_Service_Calendar_Event([
            'summary' => 'Google Meet Meeting',
            'start' => ['dateTime' => '2024-05-25T10:00:00-07:00'],
            'end' => ['dateTime' => '2024-05-25T11:00:00-07:00'],
            'conferenceData' => [
                'createRequest' => [
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                    'requestId' => 'some-random-string'
                ]
            ]
        ]);

        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

        echo 'Join the meeting at: ' . $event->getHangoutLink();
    }

    // ==============================================================

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
}
