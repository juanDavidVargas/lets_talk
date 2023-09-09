<?php

namespace App\Http\Controllers\entrenador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\admin\AdministradorController;
use App\Http\Responses\entrenador\AgendaEntrenadorShow;
use App\Http\Responses\entrenador\AgendaEntrenadorStore;
use App\Http\Responses\entrenador\AgendaEntrenadorUpdate;
use App\Models\entrenador\DisponibilidadEntrenadores;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Responses\administrador\DisponibilidadShow;
use App\Models\usuarios\Nivel;
use App\Models\usuarios\Contacto;
use App\Models\entrenador\EvaluacionInterna;
use App\Models\entrenador\EventoAgendaEntrenador;
use App\Http\Responses\entrenador\EvaluacionInternaStore;
use App\Http\Responses\entrenador\DiponibilidadesMasivaUpdate;
use App\Traits\MetodosTrait;
use Carbon\Carbon;

class EntrenadorController extends Controller
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
            $vista = 'entrenador.index';
            $checkConnection = $this->checkDatabaseConnection($vista);

            if($checkConnection->getName() == "database_connection") {
                return view('database_connection');
            } else {
                view()->share('students', $this->cargarTrainerSession());
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
            $vista = 'entrenador.create';
            $checkConnection = $this->checkDatabaseConnection($vista);

            if($checkConnection->getName() == "database_connection") {
                return view('database_connection');
            } else {
                $array_horarios = DisponibilidadEntrenadores::select('id_horario', 'horario')->pluck('horario', 'id_horario');

                $entrenadores = User::select('id_user', DB::raw("CONCAT(nombres, ' ', apellidos, ' - ', usuario) AS usuario"))
                            ->whereIn('id_rol', [1])
                            ->where('estado', 1)
                            ->whereNull('deleted_at')
                            ->pluck('usuario', 'id_user');

                view()->share('horarios', $array_horarios);
                view()->share('trainers', $entrenadores);
                return view($vista);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

            return new AgendaEntrenadorStore();
        }
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

            return new AgendaEntrenadorUpdate($id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function cargarEventos(Request $request)
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
            $agendaEntrenadorShow = new AgendaEntrenadorShow();
            return $agendaEntrenadorShow->cargarEventosPorEntrenador();
        }
    }

    public function deleteEvent(Request $request)
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
            $agendaEntrenadorStore = new AgendaEntrenadorStore();
            return $agendaEntrenadorStore->eliminarEvento();
        }
    }

    public function cargarInfoEventoPorId(Request $request)
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
            $agendaEntrenadorShow = new AgendaEntrenadorShow();
            return $agendaEntrenadorShow->cargarInfoEventoPorId($request);
        }
    }

    // ==================================================

    public function cargarTrainerSession()
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
            $agendaEntrenadorShow = new AgendaEntrenadorShow();
            return $agendaEntrenadorShow->traerSesionesEntrenadores();
        }
    }

    // ==================================================

    public function cargaDetalleSesion(Request $request)
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
            $idUser = $request->id_user;
            $trainerShow = new AgendaEntrenadorShow();
            $query = $trainerShow->detalles($idUser);
            return response()->json([$query]);
        }
    }

    // ==================================================

    public function evaluacionInternaEntrenador(Request $request)
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
            return new EvaluacionInternaStore();
        }
    }

    // ==================================================

    public function consultaEvaluacionInterna(Request $request)
    {
        $idEstudiante = intval($request->id_estudiante);
        // $idInstructor = intval($request->id_instructor); // Se habilita al estar listo el módulo de estudiante

        return DB::table('evaluacion_interna')
                    ->leftjoin('usuarios as estudiante', 'estudiante.id_user', '=', 'evaluacion_interna.id_estudiante')
                    ->leftjoin('usuarios as instructor', 'instructor.id_user', '=', 'evaluacion_interna.id_instructor')
                    ->where('evaluacion_interna.id_estudiante', $idEstudiante)
                    ->where('evaluacion_interna.id_instructor', 7)
                    ->select(
                        DB::raw("CONCAT(estudiante.nombres, ' ', estudiante.apellidos) AS nombre_estudiante"),
                        'evaluacion_interna.evaluacion_interna',
                        DB::raw("CONCAT(instructor.nombres, ' ', instructor.apellidos) AS nombre_instructor"),
                        'evaluacion_interna.created_at'
                    )
                    ->orderBy('evaluacion_interna.created_at','DESC')
                    ->get();
    }

    // ==================================================

    public function actualizacionMasivaDiponibilidades(Request $request)
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
            return new DiponibilidadesMasivaUpdate();
        }
    }

    // ==================================================

    public function studentResume(Request $request)
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
            $vista = 'entrenador.student_resume_index';
            $checkConnection = $this->checkDatabaseConnection($vista);

            if($checkConnection->getName() == "database_connection") {
                return view('database_connection');
            } else {
                $estudiantes = DB::table('usuarios')
                            ->leftjoin('roles', 'roles.id_rol', '=', 'usuarios.id_rol')
                            ->leftjoin('tipo_documento', 'tipo_documento.id', '=', 'usuarios.id_tipo_documento')
                            ->select('id_user',
                                        DB::raw("CONCAT(nombres, ' ', apellidos) AS nombre_completo"),
                                        'usuario',
                                        'celular',
                                        'roles.descripcion as rol',
                                        'usuarios.id_tipo_documento',
                                        'tipo_documento.descripcion as tipo_documento',
                                        'numero_documento',
                                        'correo',
                                        'fecha_ingreso_sistema'
                                    )
                            ->where('usuarios.id_rol', 3)
                            ->where('usuarios.estado', 1)
                            ->whereNull('usuarios.deleted_at')
                            ->get();

                return view($vista, compact('estudiantes'));
            }
        }
    }
    
    // ==================================================

    public function estudianteHojaVida(Request $request)
    {
        $idEstudiante = request('id_estudiante', null);
        // dd($idEstudiante);

        $queryEstudiante = DB::table('usuarios')
                        ->leftjoin('roles', 'roles.id_rol', '=', 'usuarios.id_rol')
                        ->leftjoin('tipo_documento', 'tipo_documento.id', '=', 'usuarios.id_tipo_documento')
                        ->leftjoin('niveles', 'niveles.id_nivel', '=', 'usuarios.id_nivel')
                        ->select('id_user',
                                    DB::raw("CONCAT(nombres, ' ', apellidos) AS nombre_completo"),
                                    'usuario',
                                    'celular',
                                    'roles.descripcion as rol',
                                    'usuarios.id_tipo_documento',
                                    'tipo_documento.descripcion as tipo_documento',
                                    'numero_documento',
                                    'correo',
                                    'fecha_ingreso_sistema',
                                    'nivel_descripcion',
                                    'telefono',
                                    'fecha_nacimiento',
                                    'genero'
                                )
                        ->where('usuarios.id_user', $idEstudiante)
                        ->where('usuarios.id_rol', 3)
                        ->where('usuarios.estado', 1)
                        ->whereNull('usuarios.deleted_at')
                        ->first();
        // dd($queryEstudiante);
        return response()->json($queryEstudiante);
    }
}
