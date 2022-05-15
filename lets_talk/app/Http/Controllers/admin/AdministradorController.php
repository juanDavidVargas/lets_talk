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
        $this->share_data();
        return view('administrador.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->share_data();
        return view('administrador.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return new UsuariosStore();
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
        $usuario = User::find($id);
        view()->share('usuario', $usuario);
        $this->share_data();
        return view('administrador.edit');
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
        return new UsuariosUpdate();
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

    private function share_data()
    {
        view()->share('usuarios', $this->usuarios());
        view()->share('tipo_documento', $this->tipos_documento());
        view()->share('municipios', $this->municipios());
        view()->share('roles', $this->roles());
    }

    public function usuarios()
    {
       $usuariosShow = new  UsuariosShow();
       return $usuariosShow->todosLosUsuarios();
    }

    public function tipos_documento()
    {
        $usuariosShow = new  UsuariosShow();
       return $usuariosShow->tiposDocumento();
    }

    public function municipios()
    {
        $usuariosShow = new  UsuariosShow();
       return $usuariosShow->municipios();
    }

    public function roles()
    {
        $usuariosShow = new  UsuariosShow();
       return $usuariosShow->roles();
    }

    public function validarCedula(Request $request)
    {
        $usuariosShow = new  UsuariosShow();
       return $usuariosShow->validarDocumento($request);
    }

    public function validarCorreo(Request $request)
    {
        $usuariosShow = new  UsuariosShow();
       return $usuariosShow->validarCorreo($request);
    }

    public function cambiarEstadoUsuario(Request $request)
    {
       $usuariosUpd = new UsuariosUpdate();
        return $usuariosUpd->cambiarEstado($request);
    }
}
