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

class NivelesUpdate implements Responsable
{
    use FileUploadTrait;
    
    public function toResponse($request)
    {
        DB::connection('mysql')->beginTransaction();

        $idNivel = intval(request('id_nivel', null));
        $newNameNivel = strtoupper(request('editar_nivel', null));

        $carpetaArchivos = '/upfiles/niveles';
        $baseFileNameEdit = "{$newNameNivel}_".time(); //nombre base para los archivos

        // =============================================

        try {
            $archivoNivelEditar = "";

            if ($request->hasFile('file_editar_nivel')) {
                $archivoNivelEditar = $this->upfileWithName($baseFileNameEdit, $carpetaArchivos, $request, 'file_editar_nivel', 'file_editar_nivel');
            }

            // =============================================

            if (isset($archivoNivelEditar) && !is_null($archivoNivelEditar) && !empty($archivoNivelEditar)) {
                $editarNivel = Nivel::where('id_nivel', $idNivel)
                            ->update([
                                'nivel_descripcion' => $newNameNivel,
                                'ruta_pdf_nivel' => $archivoNivelEditar,
                            ]);
            } else {
                $editarNivel = Nivel::where('id_nivel', $idNivel)
                            ->update([
                                'nivel_descripcion' => $newNameNivel
                            ]);
            }

            // =============================================
            
            if ($editarNivel) {
                DB::connection('mysql')->commit();
                alert()->success('Successful Process', 'Level updated');
                return redirect()->to(route('administrador.niveles_index'));
            } else {
                DB::connection('mysql')->rollback();
                alert()->error('Error', 'An error has occurred updating the level, please contact support.');
                return redirect()->to(route('administrador.niveles_index'));
            }
        } catch (Exception $e) {
            dd($e);
            DB::connection('mysql')->rollback();
            return response()->json(-1);
        }
    }
}
