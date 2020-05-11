<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Situacao extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'fv_ouv_situacao';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    // protected $primaryKey = 'situacao_cod';

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
