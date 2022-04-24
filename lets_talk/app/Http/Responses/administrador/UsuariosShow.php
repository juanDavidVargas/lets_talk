<?php

namespace App\Http\Responses\administrador;

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
                            ->select('usuarios.id_user', 'usuarios.usuario',
                                     'usuarios.nombres', 'usuarios.apellidos',
                                     'usuarios.numero_documento',
                                     'usuarios.fecha_nacimiento',
                                     'usuarios.genero', 'usuarios.estado',
                                     'usuarios.telefono', 'usuarios.celular',
                                     'usuarios.correo', 'usuarios.direccion_residencia',
                                     'usuarios.fecha_ingreso_sistema AS fecha_ingreso',
                                     'tipo_documento.descripcion AS tipo_documento',
                                     'municipios.descripcion AS ciudad_nacimiento',
                                     'residencia.descripcion AS ciudad_residencia',
                                     'roles.descripcion AS nombre_rol')
                            ->whereNull('usuarios.deleted_at')
                            ->whereNull('tipo_documento.deleted_at')
                            ->whereNull('municipios.deleted_at')
                            ->whereNull('residencia.deleted_at')
                            ->whereNull('roles.deleted_at')
                            ->get()
                            ->toarray();

            return $usuarios;

       } catch (Exception $e)
       {
           alert()->error('Error', 'Ha ocurrido un error, contácte el administrador');
       }
    }
}
