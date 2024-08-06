<?php

namespace App\Http\Responses\niveles;

use App\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\usuarios\Nivel;
use App\Traits\FileUploadTrait;

class NivelesStore implements Responsable
{
    use FileUploadTrait;

    public function toResponse($request)
    {
        // $messages = [
        //     'file_crear_nivel.file' => 'Por favor, sube un archivo PDF o imagen (jpg, jpeg, png).',
        //     'file_crear_nivel.max' => 'El tamaño máximo permitido para el archivo es de 2MB.',
        // ];

        // $request->validate([
        //     'file_crear_nivel' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        // ], $messages);

        $nuevoNivel = strtoupper(request('nuevo_crear_nivel', null));

        $validarNivel = Nivel::select('nivel_descripcion')
                                ->where('nivel_descripcion', $nuevoNivel)
                                ->first();

        if ($validarNivel)
        {
            return response()->json("nivel_existe");
        } else
        {
            $baseFileName = "{$nuevoNivel}";
            $carpetaArchivos = '/upfiles/niveles';

            DB::connection('mysql')->beginTransaction();

            try {
                $archivoNivel= '';
                if ($request->hasFile('file_crear_nivel')) {
                    $archivoNivel = $this->upfileWithName($baseFileName, $carpetaArchivos, $request,
                                                            'file_crear_nivel', 'file_crear_nivel');
                } else {
                    $archivoNivel = null;
                }

                $crearNivel = Nivel::create([
                                    'nivel_descripcion' => $nuevoNivel,
                                    'ruta_pdf_nivel' => $archivoNivel
                                ]);

                if($crearNivel) {
                    DB::connection('mysql')->commit();
                    return response()->json("nivel_creado");
                } else {
                    DB::connection('mysql')->rollback();
                    return response()->json("nivel_no_creado");
                }
            } catch (Exception $e) {
                DB::connection('mysql')->rollback();
                return response()->json("error_exception");
            }
        }
    }
}
