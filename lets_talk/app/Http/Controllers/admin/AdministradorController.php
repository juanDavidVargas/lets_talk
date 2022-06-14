<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\administrador\UsuariosShow;
use App\Http\Responses\administrador\UsuariosStore;
use App\Http\Responses\administrador\UsuariosUpdate;
use App\User;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
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

            $this->share_data();
            return view('administrador.index');
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
            $usuario = User::find($id);
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
            $usuario = User::find($id);
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
}
