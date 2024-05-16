<?php

namespace App\Http\Responses\estudiante;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\estudiante\Credito;

class ComprarCreditos implements Responsable
{
    public function toResponse($request)
    {
        $idEstudiante = session('usuario_id');
        $cantidadCreditos = intval(request('cantidad_creditos', null));
        // $paqueteActual = Credito::max('paquete') ?? 0;
        $paqueteActual = Credito::where('id_estudiante', $idEstudiante)->max('paquete') ?? 0;


        DB::connection('mysql')->beginTransaction();
        
        try {
            for ($i=1; $i <= $cantidadCreditos ; $i++) {
                $paquete = $paqueteActual + 1; // Calcular el valor del paquete para esta iteración

                $compraCredito = Credito::create([
                    'id_estado' => 7,
                    'id_estudiante' => $idEstudiante,
                    'paquete' => $paquete,
                    'fecha_credito' => time()
                ]);
            }

            if($compraCredito) {
                DB::connection('mysql')->commit();
                alert()->success('Proceso Exitoso', 'Créditos comprados');
                return redirect()->to(route('estudiante.mis_creditos'));
            } else {
                DB::connection('mysql')->rollback();
                alert()->error('Error', 'Ocurrió un error comprando los créditos, por favor contacte a soporte.');
                return redirect()->to(route('estudiante.mis_creditos'));
            }
        } catch (Exception $e) {
            dd($e);
            DB::connection('mysql')->rollback();
            alert()->error("Error', 'Ocurrió un error, intente de nuevo, si el problema persiste, contacte a soporte.!");
            return back();
        }
    }
}
