<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classificacao extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'classificacao';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'classificacao_cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'classificacao_descricao',
        'classificacao_status'
    ];

}
