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
        $nuevoNivel = strtoupper(request('crear_nivel', null));

        $baseFileName = "{$nuevoNivel}"; //nombre base para los archivos
        $carpetaArchivos = '/upfiles/niveles';
        
        DB::connection('mysql')->beginTransaction();
        
        try {
            $archivoNivel= '';
            if ($request->hasFile('file_crear_nivel')) {
                $archivoNivel = $this->upfileWithName($baseFileName, $carpetaArchivos, $request, 'file_crear_nivel', 'file_crear_nivel');
            } else {
                $archivoNivel = null;
            }

            $crearNivel = Nivel::create([
                                'nivel_descripcion' => $nuevoNivel,
                                'ruta_pdf_nivel' => $archivoNivel
                            ]);

            if($crearNivel) {
                DB::connection('mysql')->commit();
                alert()->success('Successful Process', 'New Level created');
                return redirect()->to(route('administrador.niveles_index'));
            } else {
                DB::connection('mysql')->rollback();
                alert()->error('Error', 'An error has occurred creating the new level, please contact support.');
                return redirect()->to(route('administrador.niveles_index'));
            }
        } catch (Exception $e) {
            DB::connection('mysql')->rollback();
            return response()->json(-1);
        }
    }
}
