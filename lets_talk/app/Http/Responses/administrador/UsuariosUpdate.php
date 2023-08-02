<?php

namespace App\Http\Responses\administrador;

use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Responses\administrador\UsuariosShow;
use Illuminate\Support\Facades\Hash;
use App\Models\usuarios\Contacto;

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
        $skype = request('skype', null);
        $zoom = request('zoom', null);
        $zoomClave = request('zoom_clave', null);
        $id_user = request('id_usuario', null);
        $id_nivel = request('id_nivel', null);
        $id_tipo_ingles = request('id_tipo_ingles', null);
        $id_primer_contacto = request('id_primer_contacto_edit', null);

        if(isset($id_rol) && $id_rol == 3) {
            $nivel_ingles = $id_nivel;
            $tipo_ingles = null;
        } else {
            $nivel_ingles = null;
            $tipo_ingles = $id_tipo_ingles;
        }

        // ==========================================================================
        // ==========================================================================

        $idPrimerContacto = request('id_primer_contacto', null);

        if (isset($idPrimerContacto) && $idPrimerContacto != "-1") {
            $idPrimerContacto = request('id_primer_contacto', null);

            if ($idPrimerContacto == 1) { // Phone
                $primerTelefono = request('primer_telefono', null);
                $primerCelular = null;
                $primerCorreo = null;
                $primerSkype = null;
                $primerZoom = null;
            } elseif ($idPrimerContacto == 2) { // Whatsapp - Celular
                $primerTelefono = null;
                $primerCelular = request('primer_celular', null);
                $primerCorreo = null;
                $primerSkype = null;
                $primerZoom = null;
            } elseif ($idPrimerContacto == 3) { // Skype
                $primerTelefono = null;
                $primerCelular = null;
                $primerCorreo = null;
                $primerSkype = request('primer_skype', null);
                $primerZoom = null;
            }
            elseif ($idPrimerContacto == 4) { // Email
                $primerTelefono = null;
                $primerCelular = null;
                $primerCorreo = request('primer_correo', null);
                $primerSkype = null;
                $primerZoom = null;
            } else { // Zoom
                $primerTelefono = null;
                $primerCelular = null;
                $primerCorreo = null;
                $primerSkype = null;
                $primerZoom = request('primer_zoom', null);
            }
        } else {
            $idPrimerContacto = null;
            $primerTelefono = null;
            $primerCelular = null;
            $primerCorreo = null;
            $primerSkype = null;
            $primerZoom = null;
        }

        // =====================================

        $idSegundoContacto = request('id_segundo_contacto', null);

        if (isset($idSegundoContacto) && $idSegundoContacto != "-1") {
            $idSegundoContacto = request('id_segundo_contacto', null);

            if ($idSegundoContacto == 1) { // Phone
                $segundoTelefono = request('segundo_telefono', null);
                $segundoCelular = null;
                $segundoCorreo = null;
                $segundoSkype = null;
                $segundoZoom = null;
            } elseif ($idSegundoContacto == 2) { // Whatsapp - Celular
                $segundoTelefono = null;
                $segundoCelular = request('segundo_celular', null);
                $segundoCorreo = null;
                $segundoSkype = null;
                $segundoZoom = null;
            } elseif ($idSegundoContacto == 3) { // Skype
                $segundoTelefono = null;
                $segundoCelular = null;
                $segundoCorreo = null;
                $segundoSkype = request('segundo_skype', null);
                $segundoZoom = null;
            }
            elseif ($idSegundoContacto == 4) { // Email
                $segundoTelefono = null;
                $segundoCelular = null;
                $segundoCorreo = request('segundo_correo', null);
                $segundoSkype = null;
                $segundoZoom = null;
            } else { // Zoom
                $segundoTelefono = null;
                $segundoCelular = null;
                $segundoCorreo = null;
                $segundoSkype = null;
                $segundoZoom = request('segundo_zoom', null);
            }
        } else {
            $idSegundoContacto = null;
            $segundoTelefono = null;
            $segundoCelular = null;
            $segundoCorreo = null;
            $segundoSkype = null;
            $segundoZoom = null;
        }

        // =====================================

        $idOpcionalContacto = request('id_opcional_contacto', null);
        $opcionalZoom = request('opcional_zoom', null);

        if (isset($idOpcionalContacto) && $idOpcionalContacto != "-1") {
            $idOpcionalContacto = request('id_opcional_contacto', null);

            if ($idOpcionalContacto == 1) { // Phone
                $opcionalTelefono = request('opcional_telefono', null);
                $opcionalCelular = null;
                $opcionalCorreo = null;
                $opcionalSkype = null;
                $opcionalZoom = null;
            } elseif ($idOpcionalContacto == 2) { // Whatsapp - Celular
                $opcionalTelefono = null;
                $opcionalCelular = request('opcional_celular', null);
                $opcionalCorreo = null;
                $opcionalSkype = null;
                $opcionalZoom = null;
            } elseif ($idOpcionalContacto == 3) { // Skype
                $opcionalTelefono = null;
                $opcionalCelular = null;
                $opcionalCorreo = null;
                $opcionalSkype = request('opcional_skype', null);
                $opcionalZoom = null;
            }
            elseif ($idOpcionalContacto == 4) { // Email
                $opcionalTelefono = null;
                $opcionalCelular = null;
                $opcionalCorreo = request('opcional_correo', null);
                $opcionalSkype = null;
                $opcionalZoom = null;
            } else { // Zoom
                $opcionalTelefono = null;
                $opcionalCelular = null;
                $opcionalCorreo = null;
                $opcionalSkype = null;
                $opcionalZoom = request('opcional_zoom', null);
            }
        } else {
            $idOpcionalContacto = null;
            $opcionalTelefono = null;
            $opcionalCelular = null;
            $opcionalCorreo = null;
            $opcionalSkype = null;
            $opcionalZoom = null;
        }

        // ==========================================================================
        // ==========================================================================

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
            try
            {
                $usuarioUpdate = User::where('id_user', $id_user)
                                    ->update(
                                        [
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
                                            'id_rol' => $id_rol,
                                            'skype' => $skype,
                                            'zoom' => $zoom,
                                            'zoom_clave' => $zoomClave,
                                            'id_nivel' => $nivel_ingles,
                                            'id_tipo_ingles' => $tipo_ingles,
                                        ]
                                    );

                $usuarioUpdateContacto = Contacto::where('id_user', $id_user)
                                    ->update(
                                        [
                                            'id_primer_contacto' => $idPrimerContacto,
                                            'primer_telefono' => $primerTelefono,
                                            'primer_celular' => $primerCelular,
                                            'primer_correo' => $primerCorreo,
                                            'primer_skype' => $primerSkype,
                                            'primer_zoom' => $primerZoom,
                                            'id_segundo_contacto' => $idSegundoContacto,
                                            'segundo_telefono' => $segundoTelefono,
                                            'segundo_celular' => $segundoCelular,
                                            'segundo_correo' => $segundoCorreo,
                                            'segundo_skype' => $segundoSkype,
                                            'segundo_zoom' => $segundoZoom,
                                            'id_opcional_contacto' => $idOpcionalContacto,
                                            'opcional_telefono' => $opcionalTelefono,
                                            'opcional_celular' => $opcionalCelular,
                                            'opcional_correo' => $opcionalCorreo,
                                            'opcional_skype' => $opcionalSkype,
                                            'opcional_zoom' => $opcionalZoom
                                        ]
                                    );

                if($usuarioUpdate || $usuarioUpdateContacto)
                {
                    DB::connection('mysql')->commit();
                    alert()->success('Successfull Process', 'User updated correctly.');
                    return redirect()->to(route('administrador.index'));

                } else {
                    DB::connection('mysql')->rollback();
                    alert()->error('error', 'An error occurred updating the user, try again, if the problem persists contact support.');
                    return redirect()->to(route('administrador.index'));
                }

            } catch (Exception $e)
            {
                // dd($e);
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
        try
        {
            $estado_usuario = DB::table('usuarios')
                                ->where('id_user', $id_usuario)
                                ->update([
                                    'estado' => DB::raw($estado)
                                ]);

            if($estado_usuario)
            {
                DB::connection('mysql')->commit();
                sleep(2);
                return response()->json("success");
            } else {
                DB::connection('mysql')->rollback();
                return response()->json(0);
            }

        } catch (Exception $e) {
            DB::connection('mysql')->rollback();
            return response()->json(-1);
        }
    }

    public function cambiarClave($request)
    {
        DB::connection('mysql')->beginTransaction();

        try {
            $id_usuario = request('id_user', null);
            $clave_nueva = request('clave', null);

            if(empty($clave_nueva) || is_null($clave_nueva)) {
                return response()->json(-1);
            }

            $user = User::all()->find($id_usuario);
            $user->password = Hash::make($clave_nueva);
            $user->save();

            if($user) {
                DB::connection('mysql')->commit();
                sleep(2);
                return response()->json("success");

            } else {
                DB::connection('mysql')->rollback();
                return response()->json(0);
            }

        } catch (Exception $e) {
            DB::connection('mysql')->rollback();
            return response()->json(0);
        }
    }

    // ======================================================

    public function consultarUserUpdate($idUser)
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
}
