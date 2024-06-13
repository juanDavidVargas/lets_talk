<?php

namespace App\Mail\Reservas;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class MailReservaClase extends Mailable //implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $instructor;
    public $estudiante;
    public $eventoAgendaEntrenador;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($instructor,$estudiante,$eventoAgendaEntrenador)
    {
        $this->instructor = $instructor;
        $this->estudiante = $estudiante;
        $this->eventoAgendaEntrenador = $eventoAgendaEntrenador;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reservar_clase.reservar_clase')->subject('Clase Reservada por ' . $this->estudiante->nombres . " " . $this->estudiante->apellidos);

        // return $this->markdown('emails.administracion.polizas.mtto_vehiculos')->subject("Placas de vehículos con Mantenimiento tipo Preventivo próximo a vencer");
    }
}
