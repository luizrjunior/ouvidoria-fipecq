<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoOuvidoria extends Model
{

    public $table = 'fv_ouv_tp_ouvidoria';

    protected $fillable = [
        'nome',
        'descricao',
        'icone',
        'cor',
        'sla',
        'status'
    ];

}
