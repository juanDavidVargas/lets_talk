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

class EntrenadorController extends Controller
{
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
            view()->share('students', $this->cargarTrainerSession());
            return view('entrenador.index');
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

            $array_horarios = DisponibilidadEntrenadores::select('id_horario', 'horario')->pluck('horario', 'id_horario');

            $entrenadores = User::select('id_user', DB::raw("CONCAT(nombres, ' ', apellidos, ' - ', usuario) AS usuario"))->whereIn('id_rol', [1,3])->where('estado', 1)->whereNull('deleted_at')->pluck('usuario', 'id_user');

            view()->share('horarios', $array_horarios);
            view()->share('trainers', $entrenadores);
            return view('entrenador.create');
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
        return DB::table('usuarios')
                    ->leftjoin('evento_agenda_entrenador', 'evento_agenda_entrenador.id_usuario', '=', 'usuarios.id_user')
                    ->leftjoin('estados', 'estados.id_estado', '=', 'evento_agenda_entrenador.state')
                    ->select(
                        'usuarios.id_user',
                        'evento_agenda_entrenador.id AS id_sesion',
                        'evento_agenda_entrenador.start_date',
                        'evento_agenda_entrenador.start_time',
                        'evento_agenda_entrenador.state',
                        DB::raw("CONCAT(usuarios.nombres, ' ', usuarios.apellidos) AS nombre_completo"),
                        'estados.descripcion_estado'
                    )
                    ->where('usuarios.estado', 1)
                    ->where('usuarios.id_rol', 3)
                    ->whereNull('usuarios.deleted_at')
                    ->whereNull('evento_agenda_entrenador.deleted_at')
                    ->whereIn('evento_agenda_entrenador.state', [1])
                    ->orderBy('evento_agenda_entrenador.id', 'DESC')
                    ->get();
    }

    // ==================================================

    public function cargaDetalleSesion(Request $request)
    {
        $idUser = $request->id_user;

        $query = DB::table('usuarios')
                    ->leftjoin('niveles', 'niveles.id_nivel', '=', 'usuarios.id_nivel')
                    ->leftjoin('contactos', 'contactos.id_user', '=', 'usuarios.id_user')
                    ->select(
                        DB::raw("CONCAT(usuarios.nombres, ' ', usuarios.apellidos) AS nombre_completo"),
                        'usuarios.id_user',
                        'usuarios.celular',
                        'usuarios.correo',
                        'usuarios.zoom',
                        'usuarios.zoom_clave',
                        'usuarios.id_nivel',
                        'niveles.nivel_descripcion',
                        'contactos.id_primer_contacto',
                        'contactos.primer_telefono',
                        'contactos.primer_celular',
                        'contactos.primer_correo',
                        'contactos.primer_skype',
                        'contactos.primer_zoom',
                        'contactos.id_segundo_contacto',
                        'contactos.segundo_telefono',
                        'contactos.segundo_celular',
                        'contactos.segundo_correo',
                        'contactos.segundo_skype',
                        'contactos.segundo_zoom',
                        'contactos.id_opcional_contacto',
                        'contactos.opcional_telefono',
                        'contactos.opcional_celular',
                        'contactos.opcional_correo',
                        'contactos.opcional_skype',
                        'contactos.opcional_zoom'
                    )
                    ->where('usuarios.id_user', $idUser)
                    ->where('usuarios.estado', 1)
                    ->where('usuarios.id_rol', 3)
                    ->whereNull('usuarios.deleted_at')
                    ->first();

        return response()->json([$query]);
    }

    // ==================================================

    public function evaluacionInternaEntrenador(Request $request)
    {
        $evaluacionInterna = request('evaluacion_interna', null);
        $idEstudiante = request('id_estudiante', null);
        $idInstructor = request('id_instructor', null);

        DB::connection('mysql')->beginTransaction();

        try {
            $evaluacionInternaCreate = EvaluacionInterna::create([
                'evaluacion_interna' => $evaluacionInterna,
                'id_estudiante' => $idEstudiante,
                'id_instructor' => 7,
            ]);

            if ($evaluacionInternaCreate) {
                DB::connection('mysql')->commit();
                alert()->success('Successful Process', 'Internal valuation created');
                return redirect()->to(route('trainer.index'));
            } else {
                DB::connection('mysql')->rollback();
                alert()->error('Error', 'An error has occurred creating the user, please contact support.');
                return redirect()->to(route('entrenador.index'));
            }

        } catch (Exception $e) {
            DB::connection('mysql')->rollback();
            alert()->error('Error', 'An error has occurred creating the user, try again, if the problem persists contact support.');
            return back();
        }
    }

    // ==================================================

    public function consultaEvaluacionInterna(Request $request)
    {
        $idEstudiante = intval($request->id_estudiante);
        // $idInstructor = intval($request->id_instructor);

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

    public function aprobarEvento(Request $request)
    {
        $idEvento = $request['id_evento'];
        $idEvento = str_replace('"','',$idEvento);
        $idEvento = explode(",", $idEvento);

        DB::connection('mysql')->beginTransaction();

        try {
            $eventoAprobado = EventoAgendaEntrenador::whereIn('id', $idEvento)
                    ->update(
                        [
                            'state' => 1,
                        ]
                    );

            if($eventoAprobado) {
                DB::connection('mysql')->commit();
                return response()->json("exito");
            } else {
                DB::connection('mysql')->rollback();
                return response()->json("error");
            }

        } catch (Exception $e) {
            dd($e);
            DB::connection('mysql')->rollback();
            return back();
        }
    }

    // ==================================================

    public function rechazarEvento(Request $request)
    {
        $idEvento = $request['id_evento'];
        $idEvento = str_replace('"','',$idEvento);
        $idEvento = explode(",", $idEvento);

        DB::connection('mysql')->beginTransaction();

        try {
            $eventoAprobado = EventoAgendaEntrenador::whereIn('id', $idEvento)
                    ->update(
                        [
                            'state' => 3,
                        ]
                    );

            if($eventoAprobado) {
                DB::connection('mysql')->commit();
                return response()->json("exito");
            } else {
                DB::connection('mysql')->rollback();
                return response()->json("error");
            }

        } catch (Exception $e) {
            dd($e);
            DB::connection('mysql')->rollback();
            return back();
        }
    }

    // ==================================================

    public function eliminarEvento(Request $request)
    {
        $idEvento = $request['id_evento'];
        $idEvento = str_replace('"','',$idEvento);
        $idEvento = explode(",", $idEvento);

        DB::connection('mysql')->beginTransaction();

        try {
            $eventoAprobado = EventoAgendaEntrenador::whereIn('id', $idEvento)
                    ->update(
                        [
                            'state' => 4,
                        ]
                    );

            if($eventoAprobado) {
                DB::connection('mysql')->commit();
                return response()->json("exito");
            } else {
                DB::connection('mysql')->rollback();
                return response()->json("error");
            }

        } catch (Exception $e) {
            dd($e);
            DB::connection('mysql')->rollback();
            return back();
        }
    }
}
