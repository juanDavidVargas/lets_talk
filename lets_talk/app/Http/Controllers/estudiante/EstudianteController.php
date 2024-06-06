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
use App\Http\Responses\estudiante\CancelarClase;
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

    // ==============================================================
    // ==============================================================

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    // ==============================================================
    // ==============================================================

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

    // ==============================================================
    // ==============================================================

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

    // ==============================================================
    // ==============================================================

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

    // ==============================================================
    // ==============================================================

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

    // ==============================================================
    // ==============================================================

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

    // ==============================================================
    // ==============================================================

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
                $idEstudiante = session('usuario_id');

                $disponibilidadEntrenadores = EventoAgendaEntrenador::leftJoin('usuarios', 'usuarios.id_user', '=', 'evento_agenda_entrenador.id_instructor')
                    ->leftJoin('creditos', function($join) use ($idEstudiante) {
                        $join->on('creditos.id_trainer_agenda', '=', 'evento_agenda_entrenador.id')
                            ->where(function($query) use ($idEstudiante) {
                                $query->where('creditos.id_estudiante', $idEstudiante)
                                    ->orWhereNull('creditos.id_estado');
                            });
                    })
                    ->leftJoin('reservas', 'reservas.id_trainer_horario', '=', 'evento_agenda_entrenador.id')
                    ->select(
                        'evento_agenda_entrenador.id as id_evento',
                        'evento_agenda_entrenador.id_instructor',
                        DB::raw("CONCAT(usuarios.nombres, ' ', usuarios.apellidos) AS nombre_completo"),
                        'evento_agenda_entrenador.start_date',
                        'evento_agenda_entrenador.start_time',
                        'evento_agenda_entrenador.end_date',
                        'evento_agenda_entrenador.end_time',
                        DB::raw('COALESCE(creditos.id_estado, 7) AS id_estado'),
                        'creditos.id_estudiante',
                        'link_meet'
                    )
                    ->where(function ($query) {
                        $query->whereNull('creditos.id_estado')
                            ->orWhereIn('creditos.id_estado', [7, 8]);
                    })
                    ->orderBy('evento_agenda_entrenador.start_date', 'desc')
                    ->get();

                // $this->createMeet();

                return view($vista, compact('disponibilidadEntrenadores'));
            }
        }
    }

    // ==============================================================
    // ==============================================================

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

    // ==============================================================
    // ==============================================================
    
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

    // ==============================================================
    // ==============================================================

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

    // ==============================================================
    // ==============================================================

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
            // } else {
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
            // }

        } catch (Exception $e) {
            return response()->json("error_exception");
        }
    }

    // ==============================================================
    // ==============================================================
        
    public function reservarClase(Request $request)
    {
        try
        {
            // $adminCtrl = new AdministradorController();
            // $sesion = $adminCtrl->validarVariablesSesion();
    
            // if(empty($sesion[0]) || is_null($sesion[0]) &&
            //    empty($sesion[1]) || is_null($sesion[1]) &&
            //    empty($sesion[2]) || is_null($sesion[2]) &&
            //    empty($sesion[3]) || is_null($sesion[3]) &&
            //    $sesion[2] != true)
            // {
                // return redirect()->to(route('home'));
                // } else {
                return new ReservarClase();
            // }

        } catch (Exception $e) {
            return response()->json("error_exception");
        }
    }

    // ==============================================================
    // ==============================================================
    // ==============================================================
    // ==============================================================
    // ==============================================================

    public function getGoogleClient()
    {
        $reservarClase = new ReservarClase();
        return $reservarClase->getGoogleClient();
    }

    // ==============================================================
    // ==============================================================

    public function redirectToGoogle()
    {
        $redirectToGoogle = new ReservarClase();
        return $redirectToGoogle->redirectToGoogle();
    }

    // ==============================================================
    // ==============================================================

    public function handleGoogleCallback(Request $request)
    {
        $handleGoogleCallback = new ReservarClase();
        return $handleGoogleCallback->handleGoogleCallback($request);
    }

    // ==============================================================
    // ==============================================================

    public function createMeet()
    {
        $createMeet = new ReservarClase();
        return $createMeet->createMeet();
    }

    // ==============================================================
    // ==============================================================
    // ==============================================================
    // ==============================================================
    // ==============================================================

    public function cancelarClase(Request $request)
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
                // } else {
                return new CancelarClase();
            // }

        } catch (Exception $e) {
            dd($e);
            return response()->json("error_exception");
        }
    }
}
