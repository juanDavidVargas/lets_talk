<?php

namespace App\Http\Responses\estudiante;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\usuarios\Reserva;
use App\Models\estudiante\Credito;
use App\Models\entrenador\EventoAgendaEntrenador;
use Carbon\Carbon;
use App\Http\Controllers\estudiante\EstudianteController;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ReservarClase implements Responsable
{
    public function toResponse($request)
    {
        $idEstudiante =  session('usuario_id');
        $idInstructor = intval(request('id_instructor', null));
        $idHorario = intval(request('id_horario', null));

        DB::connection('mysql')->beginTransaction();

        $queryClaseReservada = Reserva::where('id_estudiante',$idEstudiante)
            ->where('id_instructor',$idInstructor)
            ->where('id_trainer_horario',$idHorario)
            ->first();

        if (isset($queryClaseReservada) && !is_null($queryClaseReservada) && !empty($queryClaseReservada)) {
            DB::connection('mysql')->rollback();
            return response()->json("clase_ya_reservada");
        } else {
            $queryDisponibilidadCreditos = Credito::select('id_credito', 'paquete')
            ->where('id_estado',7)
            ->where('id_estudiante',$idEstudiante)
            ->orderBy('id_credito','asc')
            ->first();

            $idCredito = $queryDisponibilidadCreditos->id_credito;

            if (isset($queryDisponibilidadCreditos) && !is_null($queryDisponibilidadCreditos) && !empty($queryDisponibilidadCreditos)) {
                try {
                    $reservarClaseCreate = Reserva::create([
                        'id_estudiante' => $idEstudiante,
                        'id_instructor' => $idInstructor,
                        'id_trainer_horario' => $idHorario
                    ]);
        
                    if($reservarClaseCreate) {
                        DB::connection('mysql')->commit();

                        $queryEventoAgendaEntrenador = EventoAgendaEntrenador::select('id', 'start_date','start_time')
                        ->where('id',$idHorario)
                        ->first();

                        $fechaClase = $queryEventoAgendaEntrenador->start_date;
                        $horaClase = $queryEventoAgendaEntrenador->start_time;

                        // Llamar al método redirectToGoogle
                        // $createAuthMail = new EstudianteController;
                        // $createAuthMail->redirectToGoogle();
                        // return redirect()->route('auth.google');

                        // Llamar al método createMeeth
                        // $createMeet = new EstudianteController;
                        // $createMeet->createMeet($fechaClase, $horaClase);

                        $fechaHora = $fechaClase . ' ' . $horaClase;
                        $fechaHora = Carbon::createFromFormat('Y-m-d H:i', $fechaHora);
                        $fechaHora = $fechaHora->timestamp;

                        Credito::where('id_credito', $idCredito)
                        ->update(
                            [
                                'id_estado' => 8,
                                'id_instructor' => $idInstructor,
                                'id_trainer_agenda' => $idHorario,
                                'fecha_consumo_credito' => $fechaHora,
                            ]
                        );
                        DB::connection('mysql')->commit();

                        // return redirect()->route('auth.google')->json("clase_reservada");

                        // http://localhost:8000/auth/google
                        // $urlAuthMeet = "http://localhost:8000/auth/google";

                        return response()->json("clase_reservada");

                        // return response()->json([
                        //     'redirect_url' => route('auth.google'),
                        //     'message' => 'clase_reservada'
                        // ]);

                        // return redirect()->route('auth.google')->with('message', 'clase_reservada');

                        // return response()->json([
                        //     'clase_reservada' => 'clase_reservada',
                        //     'urlAuthMeet' => $urlAuthMeet
                        // ]);
                    }
                } catch (Exception $e) {
                    dd($e);
                    DB::connection('mysql')->rollback();
                    return response()->json("error");
                }
            }
        }
    }
}
