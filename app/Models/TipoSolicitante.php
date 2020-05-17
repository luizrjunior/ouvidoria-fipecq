<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSolicitante extends Model
{

    public $table = 'fv_ouv_tipo_solicitante';

    protected $fillable = [
        'descricao',
        'status'
    ];

}
