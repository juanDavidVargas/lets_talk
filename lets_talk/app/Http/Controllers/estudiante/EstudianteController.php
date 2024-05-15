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
use Exception;
use Illuminate\Support\Facades\DB;

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
                return view($vista);
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

                // $misCreditos = Credito::selectRaw(
                //     'DATE(fecha_credito) as fecha_credito',
                //     'paquete',
                //     DB::raw('COUNT(*) as cantidad')
                // )
                // ->groupBy('paquete')
                // // ->get();
                // ->toSql();

                $idEstudiante = session('usuario_id');

                $misCreditos = Credito::select(
                    DB::raw('DATE_FORMAT(FROM_UNIXTIME(fecha_credito), "%d-%m-%Y") as fecha_credito'),
                    'paquete',
                    DB::raw('COUNT(*) as cantidad')
                )
                ->where('id_estudiante', $idEstudiante)
                ->groupBy(DB::raw('DATE_FORMAT(FROM_UNIXTIME(fecha_credito), "%d-%m-%Y")'),'paquete')
                ->get();

                return view('estudiante.mis_creditos', compact('misCreditos'));
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
}
