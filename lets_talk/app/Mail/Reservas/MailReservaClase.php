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

    // public $info_usuario;
    // public $info_admin;
    // public $disponibilidades;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->info_usuario = $datos_usuario;
        // $this->info_admin = $datos_admin;
        // $this->disponibilidades = $disponibilidad;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reservar_clase.reservar_clase')->subject('Clase Reservada');

        // return $this->markdown('emails.administracion.polizas.mtto_vehiculos')->subject("Placas de vehículos con Mantenimiento tipo Preventivo próximo a vencer");
    }
}
