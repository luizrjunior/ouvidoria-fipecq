<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSolicitante extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'tipo_solicitante';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'tipo_solicitante_cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_solicitante_descricao',
        'tipo_solicitante_status'
    ];

}
