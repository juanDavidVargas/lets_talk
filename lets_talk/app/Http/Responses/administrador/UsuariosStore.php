<?php

namespace App\Http\Responses\administrador;

use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        // Consultamos si ya existe un usuario con la cedula ingresada
        $consulta_cedula = $this->consultarCedula($numero_documento);

        if(isset($consulta_cedula) && !empty($consulta_cedula) &&
           !is_null($consulta_cedula))
        {
            alert()->info('Info', 'La cédula ingresada ya existe');
            return back();
        } else {

            // Contruimos el nombre de usuario
            $separar_apellidos = explode(" ", $apellidos);
            $usuario = substr($this->quitarCaracteresEspeciales(trim($nombres)), 0,1) . trim($this->quitarCaracteresEspeciales($separar_apellidos[0]));
            $usuario = preg_replace("/(Ñ|ñ)/", "n", $usuario);
            $usuario = strtolower($usuario);
            $complemento = "";

            while($this->consultaUsuario($usuario.$complemento))
            {
                $complemento++;
            }

            $fecha_nacimiento = strtotime($fecha_nacimiento);
            $fecha_ingreso_sistema = Carbon::now()->timestamp;

            DB::connection('mysql')->beginTransaction();

            try {

                $nuevo_usuario = User::create([
                    'usuario' => $usuario.$complemento,
                    'password' => Hash::make($numero_documento),
                    'nombres' => strtoupper($nombres),
                    'apellidos' => strtoupper($apellidos),
                    'numero_documento' => $numero_documento,
                    'id_tipo_documento' => $id_tipo_documento,
                    'id_municipio_nacimiento' => $id_municipio_nacimiento,
                    'fecha_nacimiento' => $fecha_nacimiento,
                    'genero' => $genero,
                    'estado' => $estado,
                    'telefono' => $telefono,
                    'celular' => $celular,
                    'correo' => $correo,
                    'direccion_residencia' => $direccion_residencia,
                    'id_municipio_residencia' => $id_municipio_residencia,
                    'fecha_ingreso_sistema' => $fecha_ingreso_sistema,
                    'id_rol' => $id_rol,
                    'clave_fallas' => 0
                ]);

                if($nuevo_usuario)
                {
                    DB::connection('mysql')->commit();
                    alert()->success('Proceso Exitoso', 'Usuario creado correctamente, el nombre de usuario es: ' . $nuevo_usuario->usuario);
                    return redirect()->to(route('administrador.index'));

                } else {
                    DB::connection('mysql')->rollback();
                }

            } catch (Exception $e)
            {
                DB::connection('mysql')->rollback();
                alert()->error('Error', 'Ha ocurrido un error creando el usuario, íntente de nuevo, si el problema persiste contácte a soporte');
                return back();
            }
        }
    }

    private function consultarCedula($numero_documento)
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
            alert()->error('Error', 'Ha ocurrido un error, contácte el administrador');
            return back();
        }
    }

    private function consultaUsuario($usuario)
    {
        try {

            $usuario = User::where('usuario', $usuario)
                            ->get()
                            ->first();
            return $usuario;

        } catch (Exception $e) {
            alert()->error('Error', 'Ha ocurrido un error, contácte el administrador');
            return back();
        }
    }

    private function quitarCaracteresEspeciales($cadena)
    {
        $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ",
                               "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”",
                               "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹", "ñ", "Ñ", "*");

        $permitidas = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U",
                            "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U",
                            "u", "o", "O", "i", "a", "e", "U", "I", "A", "E", "n", "N", "");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }
}
