<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanalAtendimento extends Model
{

    public $table = 'fv_ouv_canal_atendimento';

    protected $fillable = [
        'descricao',
        'status'
    ];

}
