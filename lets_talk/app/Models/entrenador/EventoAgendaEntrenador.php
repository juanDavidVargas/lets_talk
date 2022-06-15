<?php

namespace App\Models\entrenador;

use Illuminate\Database\Eloquent\Model;

class EventoAgendaEntrenador extends Model
{
    protected $connection = 'mysql';
    protected $table = 'evento_agenda_entrenador';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
       'title',
       'description',
       'all_day',
       'start_date',
       'start_time',
       'end_date',
       'end_time',
       'color',
       'status_busy',
       'status_free',
       'state',
       'id_usuario'
    ];
}
