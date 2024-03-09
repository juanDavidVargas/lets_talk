<?php

namespace App\Http\Controllers\estudiante;

use App\Http\Controllers\admin\AdministradorController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\MetodosTrait;
use App\Models\entrenador\DisponibilidadEntrenadores;
use App\Http\Responses\administrador\DisponibilidadShow;
Use Exception;

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

    public function disponibilidad()
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
                $arrayDias = array(
                    1 => "MARTES",
                    2 => "MIÉRCOLES",
                    3 => "JUEVES",
                    4 => "VIERNES",
                    5 => "SÁBADO",
                    6 => "DOMINGO",
                    7 => "LUNES"
                );
                $arrayHorarios = DisponibilidadEntrenadores::select('id_horario', 'horario')
                                    ->pluck('horario', 'id_horario');
                view()->share('arrayDias', $arrayDias);
                view()->share('horarios', $arrayHorarios);
                return view($vista);
            }
        }
    }

    public function traerDisponibilidades(Request $request)
    {
        try {
            
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
            
                $disponibilidadShow = new DisponibilidadShow();
                return $disponibilidadShow->disponibilidadPorID($request);
            }

        } catch (Exception $e) {
            return response()->json("error_exception");
        }
    }
}
