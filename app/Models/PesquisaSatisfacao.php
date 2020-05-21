<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesquisaSatisfacao extends Model
{

    public $table = 'fv_ouv_pesquisa_satisfacao';

    protected $fillable = [
        'ouvidoria_id',
        'resposta_1',
        'resposta_2',
        'resposta_3'
    ];

}
