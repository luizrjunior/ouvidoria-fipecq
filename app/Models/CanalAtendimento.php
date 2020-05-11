<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanalAtendimento extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'fv_ouv_canal_atendimento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descricao',
        'status'
    ];

}
