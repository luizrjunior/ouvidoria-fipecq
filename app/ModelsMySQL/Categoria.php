<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

    public $table = 'fv_ouv_categoria';

    protected $fillable = [
        'descricao',
        'status'
    ];

}
