<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Situacao extends Model
{

    public $table = 'fv_ouv_situacao';

    protected $fillable = [
        'descricao',
        'status'
    ];

}
