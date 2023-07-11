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

            view()->share('horarios', $array_horarios);
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

    public function cargaDetalleSesion($idUser)
    {
        return DB::table('usuarios')
                    ->leftjoin('evento_agenda_entrenador', 'evento_agenda_entrenador.id_usuario', '=', 'usuarios.id_user')
                    ->leftjoin('estados', 'estados.id_estado', '=', 'evento_agenda_entrenador.state')
                    ->select(
                        DB::raw("CONCAT(usuarios.nombres, ' ', usuarios.apellidos) AS nombre_completo"),
                        'usuarios.id_nivel',
                        'usuarios.celular',
                        'usuarios.correo',
                        'usuarios.zoom',
                        'evento_agenda_entrenador.start_date',
                        'evento_agenda_entrenador.start_time',
                        'evento_agenda_entrenador.state',
                        'estados.descripcion_estado'
                    )
                    ->where('usuarios.id_user', $idUser)
                    ->where('usuarios.estado', 1)
                    ->where('usuarios.id_rol', 3)
                    ->whereNull('usuarios.deleted_at')
                    ->whereNull('evento_agenda_entrenador.deleted_at')
                    ->whereIn('evento_agenda_entrenador.state', [1])
                    ->orderBy('evento_agenda_entrenador.id', 'DESC')
                    ->get();
    }
}
