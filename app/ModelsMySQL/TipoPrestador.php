<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPrestador extends Model
{

    public $table = 'fv_ouv_tp_prestador';

    protected $fillable = [
        'descricao',
        'status'
    ];

}
