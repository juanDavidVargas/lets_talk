<?php

namespace App\Models\usuarios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrimerContacto extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'primer_contacto';
    protected $primaryKey = 'id_primer_contacto';
    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $fillable = [
       'contacto_descripcion'
    ];
}
