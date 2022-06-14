<?php

namespace App\Http\Responses\inicio_sesion;

use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Hash;

class LoginStore implements Responsable
{
    public function toResponse($request)
    {
        $username = request('username', null);
        $pass = request('pass', null);

        if(!isset($username) || empty($username) || is_null($username) ||
           !isset($pass) || empty($pass) || is_null($pass))
        {
            alert()->error('Error','El nombre de usuario y la contraseña son obligatorios!');
            return back();
        }

        $user = $this->consultarUsuario($username);

        if(isset($user) && !empty($user) && !is_null($user))
        {
            $cont_clave_erronea = $user->clave_fallas;

            if($user->clave_fallas >= 4)
            {
                $this->inactivarUsuario($user->id_user);
            }

            if($user->estado == 0 || $user->estado == false ||
                $user->estado == "false")
            {
                alert()->error('Error','El usuario ' . $username . ' se encuentra bloqueado, por favor contácte el administrador para desbloquearlo');
                return back();
            }

            if(Hash::check($pass, $user->password))
            {
                // Rol entrenador
                if($user->id_rol == 1 || $user->id_rol == "1")
                {
                    // Creamos las variables de sesion
                    $this->crearVariablesSesion($user);
                    return redirect()->to(route('trainer.index'));

                   // Rol Estudiante
                } else if($user->id_rol == 3 || $user->id_rol == "3")
                {
                    dd("vista estudiante");

                  // Rol Administrador
                } else if($user->id_rol == 2 || $user->id_rol == "2")
                {
                    // Creamos las variables de sesion
                    $this->crearVariablesSesion($user);
                    return redirect()->to(route('administrador.index'));
                } else {

                    // Si el rol es diferente a los mencionados, mostramos mensaje
                    alert()->error('Error','El usuario ' . $username . 'tiene un rol no válido!');
                    return back();
                }

            } else {
                $cont_clave_erronea += 1;
                $this->actualizarClaveFallas($user->id_user, $cont_clave_erronea);
                alert()->error('Error','Credenciales inválidas');
                return back();
            }

        } else {
            alert()->error('Error','No se encontraron registros para el usuario ' . $username);
            return back();
        }
    }

    private function crearVariablesSesion($user)
    {
        // Creamos las variables de sesion
        session()->put('usuario_id', $user->id_user);
        session()->put('username', $user->usuario);
        session()->put('sesion_iniciada', true);
        session()->put('rol', $user->id_rol);
    }

    private function consultarUsuario($username)
    {
        try {

            return User::where('usuario', $username)
                        ->whereNull('deleted_at')
                        ->get()
                        ->first();

        } catch (Exception $e)
        {
            alert()->error('Error','Ha ocurrido un error, contácte el administrador para solucionarlo');
            return back();
        }
    }

    private function inactivarUsuario($id_user)
    {
        try {

            $user = User::find($id_user);
            $user->estado = 0;
            $user->save();

        } catch (Exception $e)
        {
            alert()->error('Error', 'Ha ocurrido un error, contácte el administrador para solucionarlo');
            return back();
        }
    }

    private function actualizarClaveFallas($usuario_id, $contador)
    {
        try {
            $user = User::find($usuario_id);
            $user->clave_fallas = $contador;
            $user->save();

        } catch (Exception $e) {
            alert()->error('Error', 'Ha ocurrido un error, contácte el administrador para solucionarlo');
            return back();
        }
    }
}
