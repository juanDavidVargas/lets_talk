<?php

namespace App\Http\Responses\estudiante;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\estudiante\Credito;
use GuzzleHttp\Client;
use App\Models\estudiante\Paquete;
use App\User;
use Carbon\Carbon;

class ComprarCreditos implements Responsable
{
    public function toResponse($request)
    {
        $idEstudiante = session('usuario_id');
        $idPaquete = intval(request('cantidad_creditos', null));
        $paqueteActual = Credito::where('id_estudiante', $idEstudiante)->max('paquete') ?? 0;
        $infoPaquete = $this->getInfoPaquete($idPaquete);
        $datosUsuario = $this->getDatosUsuario($idEstudiante);
        $messageError = "";

        if(is_null($idPaquete) || empty($idPaquete) ||
           $infoPaquete == "error_paquete" || $datosUsuario == "error_usuario")
        {
           $messageError .= 'Ha ocurrido un error inesperado, íntente de nuevo';
        } else
        {
            $body = $this->construirJsonDatos($infoPaquete, $datosUsuario);

            $client = new Client([
                'base_uri' => env('URL_API_PAYVALIDA'),
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8'
                ],
                'body' => json_encode($body)
            ]);

            $response = $client->request('POST');
            $resultado = json_decode($response->getBody()->getContents(), true);
            
            if($resultado['CODE'] != "0000" ||
            $resultado['DESC'] != "OK" || is_null($resultado['DATA']))
            {
               alert()->error('Error', $resultado['DESC']);
               return back();
            }

            DB::connection('mysql')->beginTransaction();
            
            try
            {
                for ($i=1; $i <= $idPaquete ; $i++)
                {
                    $paquete = $paqueteActual + 1; // Calcular el valor del paquete para esta iteración

                    $compraCredito = Credito::create([
                        'id_estado' => 7,
                        'id_estudiante' => $idEstudiante,
                        'paquete' => $paquete,
                        'fecha_credito' => time()
                    ]);
                }

                if($compraCredito)
                {
                    DB::connection('mysql')->commit();
                    alert()->success('Proceso Exitoso', 'Créditos comprados');
                    return back();

                } else
                {
                    DB::connection('mysql')->rollback();
                    $messageError .= 'Ocurrió un error comprando los créditos, por favor contacte a soporte.';
                }

           
            } catch (Exception $e)
            {
                DB::connection('mysql')->rollback();
                $messageError .= 'Ocurrió un error, intente de nuevo, si el problema persiste, contacte a soporte.!';
            }
        }

        if(empty($messageError) || $messageError != "")
        {
            alert()->error('Error', $messageError);
            return back();
        }
    }

    private function construirJsonDatos($paquete, $usuario)
    {
        $data = array();

        $email = $usuario->correo;
        $pais = env('COUNTRY');
        $orden = $paquete->nombre_paquete;
        $moneda = env('MONEY');
        $monto = $paquete->valor_paquete;
        $cheksum = $email . $pais . $orden . $moneda . $monto . env('FIXED_HASH');
        $hashed = hash('sha512', $cheksum);

        $datos = [
            "merchant" => env('MERCHANT'),
            "email" => $email,
            "country" => $pais,
            "order" => $orden,
            "reference" => "",
            "money" => $moneda,
            "amount" => $monto,
            "description" => $orden,
            "method" => "",
            "language" => "es",
            "recurrent" => false,
            "expiration" => Carbon::now()->addDays('5')->format('d/m/Y'),
            "iva" => "0",
            "checksum" => $hashed,
            "user_di" => $usuario->numero_documento,
            "user_type_di" => $usuario->documento->abreviatura,
            "user_name" => $usuario->nombres . ' ' . $usuario->apellidos,
            "redirect_timeout" => "300000"
        ];

        array_push($data, $datos);
        return $data;
    }

    private function getInfoPaquete($idPaquete)
    {
        try
        {
            return Paquete::where('id_paquete', $idPaquete)->first();

        } catch (Exception $e) {
            return "error_paquete";
        }
    }

    private function getDatosUsuario($idEstudiante)
    {
        try
        {
            return User::with('documento')->where('id_user', $idEstudiante)->first();

        } catch (Exception $e) {
            return "error_usuario";
        }
    }
}
