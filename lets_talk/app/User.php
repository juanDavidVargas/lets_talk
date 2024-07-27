<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class User extends Authenticatable implements AuditableContract
{
    use Notifiable;
    use Auditable;

    protected $connection = 'mysql';
    protected $table = 'usuarios';
    protected $primaryKey = 'id_user';
    public $timestamps = true;
    protected $fillable = [
        'usuario',
        'password',
        'nombres',
        'apellidos',
        'numero_documento',
        'id_tipo_documento',
        'id_municipio_nacimiento',
        'fecha_nacimiento',
        'genero',
        'estado',
        'telefono',
        'celular',
        'correo',
        'direccion_residencia',
        'id_municipio_residencia',
        'fecha_ingreso_sistema',
        'id_rol',
        'skype',
        'zoom',
        'zoom_clave',
        'id_nivel',
        'id_tipo_ingles',
        'clave_fallas'
    ];

    protected $hidden = [
        'password'
    ];
}
