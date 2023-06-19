<?php

namespace App\Http\Responses\administrador;

use App\Models\usuarios\Roles;
use App\Models\usuarios\Nivel;
use App\Models\usuarios\TipoDocumento;
use App\Models\entrenador\TipoIngles;
use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;

class UsuariosShow implements Responsable
{
    public function toResponse($request) {}

    public function todosLosUsuarios()
    {
       try {

            $usuarios = DB::table('usuarios')
                            ->join('tipo_documento', 'tipo_documento.id', '=', 'usuarios.id_tipo_documento')
                            ->join('municipios', 'municipios.id_municipio', '=', 'usuarios.id_municipio_nacimiento')
                            ->join('municipios as residencia', 'residencia.id_municipio', '=', 'usuarios.id_municipio_residencia')
                            ->join('roles', 'roles.id_rol', '=', 'usuarios.id_rol')
                            ->leftJoin('niveles', 'niveles.id_nivel', '=', 'usuarios.id_nivel')
                            ->leftJoin('tipo_ingles', 'tipo_ingles.id', '=', 'usuarios.id_tipo_ingles')
                            ->select('usuarios.id_user', 'usuarios.usuario',
                                     'usuarios.nombres', 'usuarios.apellidos',
                                     'usuarios.numero_documento',
                                     'usuarios.fecha_nacimiento',
                                     'usuarios.genero', 'usuarios.estado',
                                     'usuarios.telefono', 'usuarios.celular',
                                     'usuarios.correo', 'usuarios.direccion_residencia',
                                     'usuarios.contacto2', 'usuarios.contacto_opcional',
                                     'usuarios.skype', 'usuarios.zoom',
                                     'usuarios.fecha_ingreso_sistema AS fecha_ingreso',
                                     'tipo_documento.descripcion AS tipo_documento',
                                     'municipios.descripcion AS ciudad_nacimiento',
                                     'residencia.descripcion AS ciudad_residencia',
                                     'roles.descripcion AS nombre_rol', 'roles.id_rol',
                                     'niveles.nivel_descripcion AS niveles',
                                     'niveles.id_nivel',
                                     'tipo_ingles.id AS id_tip_ing',
                                     'tipo_ingles.descripcion AS desc_tip_ing'
                                    )
                            ->whereNull('usuarios.deleted_at')
                            ->whereNull('tipo_documento.deleted_at')
                            ->whereNull('municipios.deleted_at')
                            ->whereNull('residencia.deleted_at')
                            ->whereNull('roles.deleted_at')
                            ->whereNull('niveles.deleted_at')
                            ->orderBy('usuarios.id_user', 'DESC')
                            ->get()
                            ->toarray();

            return $usuarios;

       } catch (Exception $e)
       {
           alert()->error('Error', 'An error has occurred, try again, if the problem persists contact support.');
           return back();
       }
    }

    public function tiposDocumento()
    {
        try {

            $tipos_documento = TipoDocumento::select('id', 'descripcion')
                                            ->get()
                                            ->pluck('descripcion', 'id');

            return $tipos_documento;

        } catch (Exception $e)
         {
            alert()->error('Error', 'An error has occurred, try again, if the problem persists contact support.');
            return back();
        }
    }

    public function tiposIngles()
    {
        try {

            $tipos_ingles= TipoIngles::select('id', 'descripcion')
                                            ->get()
                                            ->pluck('descripcion', 'id');

            return $tipos_ingles;

        } catch (Exception $e)
         {
            alert()->error('Error', 'An error has occurred, try again, if the problem persists contact support.');
            return back();
        }
    }

    public function municipios()
    {
        try {

            $municipios = DB::table('municipios')
                        ->join('departamentos', 'departamentos.id_departamento', '=', 'municipios.id_departamento')
                        ->select('municipios.id_municipio', DB::raw("CONCAT(municipios.descripcion, ' - ', departamentos.descripcion) AS nombre_ciudad"))
                        ->whereNull('municipios.deleted_at')
                        ->where('municipios.estado', 1)
                        ->orderBy('municipios.id_municipio', 'DESC')
                        ->get()
                        ->pluck('nombre_ciudad', 'id_municipio');

            return $municipios;

        } catch (Exception $e)
         {
            alert()->error('Error', 'An error has occurred, try again, if the problem persists contact support.');
            return back();
        }
    }

    public function roles()
    {
        try {

            $roles = Roles::select('id_rol', 'descripcion')
                                ->where('estado', 1)
                                ->orderBy('descripcion', 'ASC')
                                ->get()
                                ->pluck('descripcion', 'id_rol');

            return $roles;

        } catch (Exception $e)
         {
            alert()->error('Error', 'An error has occurred, try again, if the problem persists contact support.');
            return back();
        }
    }

    public function validarDocumento($request)
    {
        $numero_documento = request('numero_documento', null);
        try
        {
            $documento = User::select('numero_documento')
                                ->where('numero_documento', $numero_documento)
                                ->get()
                                ->first();

            if(isset($documento) && !empty($documento) && !is_null($documento))
            {
                return response()->json("existe_doc");
            }

        } catch (Exception $e)
        {
            return response()->json("error_exception");
            exit;
        }
    }

    public function validarDocumentoEdicion($request)
    {
        $numero_documento = request('numero_documento', null);
        $usuario_id = request('id_usuario', session('usuario_id'));

        try {

            $documento = User::select('numero_documento')
                                ->where('numero_documento', $numero_documento)
                                ->whereNotIn('id_user', array($usuario_id))
                                ->get()
                                ->first();

            if(isset($documento) && !empty($documento) && !is_null($documento))
            {
                return response()->json("existe_doc");
            }

        } catch (Exception $e)
        {
            return response()->json("error_exception");
            exit;
        }
    }

    public function validarCorreo($request)
    {
        $correo = request('email', null);

        try {

            $correo = User::select('correo')
                                ->where('correo', $correo)
                                ->get()
                                ->first();

            if(isset($correo) && !empty($correo) && !is_null($correo))
            {
                return response()->json("existe_correo");
            }

        } catch (Exception $e)
        {
            return response()->json("error_exception_correo");
            exit;
        }
    }

    public function validarCorreoEdicion($request)
    {
        $correo = request('email', null);
        $usuario_id = request('id_usuario', session('usuario_id'));

        try {

            $correo = User::select('correo')
                                ->where('correo', $correo)
                                ->whereNotIn('id_user', array($usuario_id))
                                ->get()
                                ->first();

            if(isset($correo) && !empty($correo) && !is_null($correo))
            {
                return response()->json("existe_correo");
            }

        } catch (Exception $e)
        {
            return response()->json("error_exception_correo");
            exit;
        }
    }

    public function consultarCedula($numero_documento)
    {
        try {

            $cedula = User::where('numero_documento', $numero_documento)
                            ->get()
                            ->first();

            if(isset($cedula) && !empty($cedula) && !is_null($cedula))
            {
                return $cedula;
            } else {
                return null;
            }

        } catch (Exception $e)
        {
            alert()->error('Error', 'An error has occurred, try again, if the problem persists contact support.');
            return back();
        }
    }

    public function consultarCedula2($numero_documento, $id_user)
    {
        try {

            $cedula = User::where('numero_documento', $numero_documento)
                            ->whereNotIn('id_user', array($id_user))
                            ->get()
                            ->first();

            if(isset($cedula) && !empty($cedula) && !is_null($cedula))
            {
                return $cedula;
            } else {
                return null;
            }

        } catch (Exception $e)
        {
            alert()->error('Error', 'An error has occurred, try again, if the problem persists contact support.');
            return back();
        }
    }
}
