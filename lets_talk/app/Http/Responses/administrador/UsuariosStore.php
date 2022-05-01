<?php

namespace App\Http\Responses\administrador;

use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;

class UsuariosStore implements Responsable
{
    public function toResponse($request)
    {
        $nombres = request('nombres', null);
        $apellidos = request('apellidos', null);
        $id_tipo_documento = request('id_tipo_documento', null);
        $numero_documento = request('numero_documento', null);
        $id_municipio_nacimiento = request('id_municipio_nacimiento', null);
        $fecha_nacimiento = request('fecha_nacimiento', null);
        $genero = request('genero', null);
        $estado = request('estado', null);
        $telefono = request('telefono', null);
        $celular = request('celular', null);
        $correo = request('correo', null);
        $direccion_residencia = request('direccion_residencia', null);
        $id_municipio_residencia = request('id_municipio_residencia', null);
        $id_rol = request('id_rol', null);
        $inicial_nombre = substr($nombres, 0,1);
        $apellido = substr($apellidos, 0)


    }
}
