<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classificacao extends Model
{

    public $table = 'internet.fv_ouv_classificacao';

    protected $fillable = [
        'descricao',
        'status'
    ];

}
