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
    public $table = 'tipo_solicitacao';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'tipo_solicitacao_cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_solicitacao_nome',
        'tipo_solicitacao_descricao',
        'tipo_solicitacao_icone',
        'tipo_solicitacao_cor',
        'tipo_solicitacao_sla',
        'tipo_solicitacao_status'
    ];

}
