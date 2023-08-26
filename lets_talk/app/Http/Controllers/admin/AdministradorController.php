<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\administrador\DisponibilidadShow;
use App\Http\Responses\administrador\UsuariosShow;
use App\Http\Responses\administrador\UsuariosStore;
use App\Http\Responses\administrador\UsuariosUpdate;
use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Models\usuarios\Nivel;
use App\Models\usuarios\TipoContacto;
use App\Models\entrenador\DisponibilidadEntrenadores;
use App\Models\entrenador\EventoAgendaEntrenador;
use Illuminate\Support\Facades\DB;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Storage;
use App\Http\Responses\niveles\NivelesStore;
use App\Http\Responses\niveles\NivelesUpdate;
use App\Http\Responses\niveles\NivelesInactivar;
use App\Http\Responses\niveles\NivelesActivar;
use App\Http\Responses\administrador\HorarioStore;
use App\Http\Responses\administrador\HorarioDelete;
use App\Http\Responses\administrador\DisponibilidadUpdate;
use App\Http\Controllers\DatabaseConnectionController;
use App\Traits\MetodosTrait;

// ==========================================================

class AdministradorController extends Controller
{
    use MetodosTrait;
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           empty($sesion[3]) || is_null($sesion[3]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            
            $vista = 'administrador.index';
            $checkConnection = $this->checkDatabaseConnection($vista);

            if( $checkConnection->getName() == "database_connection")
            {
                return view('database_connection');
            } else {

                $this->share_data();
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
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $this->share_data();
            return view('administrador.create');
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
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            return new UsuariosStore();
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
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $usuario = $this->consultarUserEdit($id);
            view()->share('usuario', $usuario);
            $this->share_data();
            return view('administrador.show');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $usuario = $this->consultarUserEdit($id);
            view()->share('usuario', $usuario);
            $this->share_data();
            return view('administrador.edit');
        }
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
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            return new UsuariosUpdate();
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
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {

        }
    }

    private function share_data()
    {
        view()->share('usuarios', $this->usuarios());
        view()->share('tipo_documento', $this->tipos_documento());
        view()->share('municipios', $this->municipios());
        view()->share('roles', $this->roles());
        view()->share('niveles', Nivel::orderBy('id_nivel','asc')->whereNull('deleted_at')->pluck('nivel_descripcion', 'id_nivel'));
        view()->share('disponibilidades', $this->traerDisponibilidades());
        view()->share('tipo_ingles', $this->tipoIngles());
        view()->share('tipo_contacto', TipoContacto::orderBy('tipo_contacto','asc')->pluck('tipo_contacto', 'id_tipo_contacto'));
    }

    public function tipoIngles()
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $usuariosShow = new  UsuariosShow();
            return $usuariosShow->tiposIngles();
        }
    }

    public function usuarios()
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $usuariosShow = new  UsuariosShow();
            return $usuariosShow->todosLosUsuarios();
        }
    }

    public function tipos_documento()
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $usuariosShow = new  UsuariosShow();
           return $usuariosShow->tiposDocumento();
        }
    }

    public function municipios()
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $usuariosShow = new  UsuariosShow();
           return $usuariosShow->municipios();
        }
    }

    public function roles()
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $usuariosShow = new  UsuariosShow();
           return $usuariosShow->roles();
        }
    }

    public function validarCedula(Request $request)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $usuariosShow = new  UsuariosShow();
           return $usuariosShow->validarDocumento($request);
        }
    }

    public function validarCedulaEdicion(Request $request)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $usuariosShow = new  UsuariosShow();
           return $usuariosShow->validarDocumentoEdicion($request);
        }
    }

    public function validarCorreo(Request $request)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $usuariosShow = new  UsuariosShow();
           return $usuariosShow->validarCorreo($request);
        }
    }

    public function validarCorreoEdicion(Request $request)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $usuariosShow = new  UsuariosShow();
           return $usuariosShow->validarCorreoEdicion($request);
        }
    }

    public function cambiarEstadoUsuario(Request $request)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $usuariosUpd = new UsuariosUpdate();
             return $usuariosUpd->cambiarEstado($request);
        }
    }

    public function actualizarClave(Request $request)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            $usuariosUpd = new UsuariosUpdate();
            return $usuariosUpd->cambiarClave($request);
        }
    }

    public function validarVariablesSesion()
    {
        $variables_sesion =[];
        $id_usuario = session('usuario_id');
        array_push($variables_sesion, $id_usuario);
        $username = session('username');
        array_push($variables_sesion, $username);
        $sesion_iniciada = session('sesion_iniciada');
        array_push($variables_sesion, $sesion_iniciada);
        $rol_usuario = session('rol');
        array_push($variables_sesion, $rol_usuario);
        return $variables_sesion;
    }

    public function disponibilidades()
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else
        {
            $this->share_data();
            return view('administrador.disponibilidad_entrenadores');
        }
    }

    public function traerDisponibilidades()
    {
        try
        {
            $disponibilidadShow = new DisponibilidadShow();
            return $disponibilidadShow->traerDisponibilidades();

        } catch (Exception $e)
        {
            alert()->error("Ha ocurrido un error!");
            return redirect()->to(route('administrador.index'));
        }
    }

    public function vistaAdminDisponibilidad()
    {
        $todasDisponibilidades = DisponibilidadEntrenadores::select('id_horario', 'horario')->orderBy('horario', 'asc')->get()->toArray();
        return view('administrador.disponibilidad_admin', compact('todasDisponibilidades'));
    }

    public function storeAdminDisponibilidad(Request $request)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            return new HorarioStore();
        }
    }

    public function deleteAdminDisponibilidad(Request $request)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            return new HorarioDelete();
        }
    }

    public function consultarUserEdit($idUser)
    {
        return DB::table('usuarios')
                    ->join('tipo_documento', 'tipo_documento.id', '=', 'usuarios.id_tipo_documento')
                    ->join('municipios', 'municipios.id_municipio', '=', 'usuarios.id_municipio_nacimiento')
                    ->join('municipios as residencia', 'residencia.id_municipio', '=', 'usuarios.id_municipio_residencia')
                    ->join('roles', 'roles.id_rol', '=', 'usuarios.id_rol')
                    ->leftJoin('niveles', 'niveles.id_nivel', '=', 'usuarios.id_nivel')
                    ->leftJoin('tipo_ingles', 'tipo_ingles.id', '=', 'usuarios.id_tipo_ingles')
                    ->leftJoin('contactos', 'contactos.id_user', '=', 'usuarios.id_user')
                    ->leftJoin('tipo_contacto as tipo_primer_contacto', 'tipo_primer_contacto.id_tipo_contacto', '=', 'contactos.id_primer_contacto')
                    ->leftJoin('tipo_contacto as tipo_segundo_contacto', 'tipo_segundo_contacto.id_tipo_contacto', '=', 'contactos.id_segundo_contacto')
                    ->leftJoin('tipo_contacto as tipo_opcional_contacto', 'tipo_opcional_contacto.id_tipo_contacto', '=', 'contactos.id_opcional_contacto')
                    ->select('usuarios.id_user',
                                'usuarios.usuario',
                                'usuarios.nombres',
                                'usuarios.apellidos',
                                'usuarios.id_tipo_documento',
                                'usuarios.numero_documento',
                                'usuarios.id_municipio_nacimiento',
                                'usuarios.fecha_nacimiento',
                                'usuarios.genero',
                                'usuarios.estado',
                                'usuarios.telefono',
                                'usuarios.celular',
                                'usuarios.correo',
                                'usuarios.id_municipio_residencia',
                                'usuarios.direccion_residencia',
                                'usuarios.skype',
                                'usuarios.zoom',
                                'usuarios.zoom_clave',
                                'usuarios.fecha_ingreso_sistema AS fecha_ingreso',
                                'usuarios.id_tipo_ingles',
                                'tipo_documento.descripcion AS tipo_documento',
                                'municipios.descripcion AS ciudad_nacimiento',
                                'residencia.descripcion AS ciudad_residencia',
                                'roles.descripcion AS nombre_rol',
                                'roles.id_rol',
                                'niveles.nivel_descripcion AS niveles',
                                'niveles.id_nivel',
                                'tipo_ingles.id AS id_tip_ing',
                                'tipo_ingles.descripcion AS desc_tip_ing',
                                'tipo_primer_contacto.id_tipo_contacto AS primer_contacto_tipo',
                                'contactos.primer_telefono',
                                'contactos.primer_celular',
                                'contactos.primer_correo',
                                'contactos.primer_skype',
                                'contactos.primer_zoom',
                                'tipo_segundo_contacto.id_tipo_contacto AS segundo_contacto_tipo',
                                'contactos.segundo_telefono',
                                'contactos.segundo_celular',
                                'contactos.segundo_correo',
                                'contactos.segundo_skype',
                                'contactos.segundo_zoom',
                                'tipo_opcional_contacto.id_tipo_contacto AS opcional_contacto_tipo',
                                'contactos.opcional_telefono',
                                'contactos.opcional_celular',
                                'contactos.opcional_correo',
                                'contactos.opcional_skype',
                                'contactos.opcional_zoom'
                            )
                    ->where('usuarios.id_user', $idUser)
                    ->whereNull('usuarios.deleted_at')
                    ->whereNull('tipo_documento.deleted_at')
                    ->whereNull('municipios.deleted_at')
                    ->whereNull('residencia.deleted_at')
                    ->whereNull('roles.deleted_at')
                    ->whereNull('niveles.deleted_at')
                    ->orderBy('usuarios.id_user', 'DESC')
                    ->first();
    }

    // ===================================================

    public function nivelesIndex()
    {
        $niveles = Nivel::select('id_nivel','nivel_descripcion','ruta_pdf_nivel','deleted_at')
                            ->orderBy('nivel_descripcion', 'asc')
                            ->get();
        return view('administrador.niveles_index', compact('niveles'));
    }

    // ===================================================

    public function crearNivel(Request $request)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            return new NivelesStore();
        }
    }

    // ===================================================

    public function editarNivel(Request $request)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            return new NivelesUpdate();
        }
    }

    // ===================================================

    public function inactivarNivel(Request $request)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            return new NivelesInactivar();
        }
    }

    // ===================================================

    public function activarNivel(Request $request)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            return new NivelesActivar();
        }
    }

    // ===================================================

    public function consultarNivel(Request $request)
    {
        $idNivel = intval($request->id_nivel);

        try {
            $consultarNivel = Nivel::select('nivel_descripcion')->where('id_nivel', $idNivel)->first();
            
            if ($consultarNivel) {
                return $consultarNivel;
            } else {
                return response()->json('no_consultado');
            }
        } catch (Exception $e) {
            alert()->error('Error', 'An error has occurred consulting the level, try again, if the problem persists contact support.');
            return back();
        }
    }
    
    
    
    // ===================================================

    public function actualizarDisponibilidad(Request $request)
    {
        $sesion = $this->validarVariablesSesion();

        if(empty($sesion[0]) || is_null($sesion[0]) &&
           empty($sesion[1]) || is_null($sesion[1]) &&
           empty($sesion[2]) || is_null($sesion[2]) &&
           $sesion[2] != true)
        {
            return redirect()->to(route('home'));
        } else {
            return new DisponibilidadUpdate();
        }
    }
}
