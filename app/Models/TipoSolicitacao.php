<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSolicitacao extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'fv_ouv_tipo_solicitacao';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    // protected $primaryKey = 'tipo_solicitacao_cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'descricao',
        'icone',
        'cor',
        'sla',
        'status'
    ];

}
