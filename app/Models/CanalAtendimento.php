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
    public $table = 'canal_atendimento';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'canal_atendimento_cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'canal_atendimento_descricao',
        'canal_atendimento_status'
    ];

}
