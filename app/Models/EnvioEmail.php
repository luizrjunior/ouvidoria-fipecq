<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnvioEmail extends Model
{

    public $table = 'internet.fv_ouv_envio_email';

    protected $fillable = [
        'tipo_email_id',
        'ouvidoria_id'
    ];

}
