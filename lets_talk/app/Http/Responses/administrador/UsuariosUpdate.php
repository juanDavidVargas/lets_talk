<?php

namespace App\Http\Responses\administrador;

use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Responses\administrador\UsuariosShow;

class UsuariosUpdate implements Responsable
{
    public function toResponse($request)
    {
        $usuarioShow = new UsuariosShow();
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
        $id_user = request('id_usuario', null);

        // Consultamos si ya existe un usuario con la cedula ingresada
        $consulta_cedula = $usuarioShow->consultarCedula2($numero_documento, $id_user);

        if(isset($consulta_cedula) && !empty($consulta_cedula) &&
           !is_null($consulta_cedula))
        {
            alert()->info('Info', 'The document number already exists.');
            return back();
        } else {

            $fecha_nacimiento = Carbon::parse($fecha_nacimiento)->timestamp;

            DB::connection('mysql')->beginTransaction();

            try {

                $usuario_update = User::find($id_user);
                $usuario_update->nombres = strtoupper($nombres);
                $usuario_update->apellidos = strtoupper($apellidos);
                $usuario_update->numero_documento = $numero_documento;
                $usuario_update->id_tipo_documento = $id_tipo_documento;
                $usuario_update->id_municipio_nacimiento = $id_municipio_nacimiento;
                $usuario_update->fecha_nacimiento = $fecha_nacimiento;
                $usuario_update->genero = $genero;
                $usuario_update->estado = $estado;
                $usuario_update->telefono = $telefono;
                $usuario_update->celular = $celular;
                $usuario_update->correo = $correo;
                $usuario_update->direccion_residencia = $direccion_residencia;
                $usuario_update->id_municipio_residencia = $id_municipio_residencia;
                $usuario_update->id_rol = $id_rol;
                $usuario_update->save();

                if($usuario_update)
                {
                    db::connection('mysql')->commit();
                    alert()->success('Successfull Process', 'User updated correctly.');
                    return redirect()->to(route('administrador.index'));

                } else {
                    db::connection('mysql')->rollback();
                    alert()->error('error', 'An error occurred updating the user, try again, if the problem persists contact support.');
                    return redirect()->to(route('administrador.index'));
                }

            } catch (Exception $e)
            {
                DB::connection('mysql')->rollback();
                alert()->error('Error', 'An error occurred updating the user, try again, if the problem persists contact support.');
                return back();
            }
        }
    }

    public function cambiarEstado($request)
    {
        $id_usuario = request('id_user', null);
        $estado = " (CASE WHEN estado = 1 THEN 0 ELSE 1 END) ";

        DB::connection('mysql')->beginTransaction();

        try {

            $estado_usuario = DB::table('usuarios')
                                ->where('id_user', $id_usuario)
                                ->update([
                                    'estado' => DB::raw($estado)
                                ]);

            if($estado_usuario)
            {
                DB::connection('mysql')->commit();
                return response()->json("success");
            } else {
                DB::connection('mysql')->rollback();
                return response()->json(0);
            }

        } catch (Exception $e)
        {
            dd($e);
            DB::connection('mysql')->rollback();
            return response()->json(-1);
        }
    }
}
