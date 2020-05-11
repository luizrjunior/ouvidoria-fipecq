<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitacaoOuvidoria extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'fv_ouv_solicitacao_ouvidoria';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    // protected $primaryKey = 'cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'protocolo',
        'mensagem',
        'anexo',
        'tipo_solicitacao_id',
        'solicitante_id',
        'tipo_prestador_id',
        'sub_classificacao_id',
        'assunto_id',
        'canal_atendimento_id'
    ];

    /**
     * Tipo de Solicitacao
     *
     * @return void
     */
    public function tipoSolicitacao()
    {
        return $this->belongsTo('App\Models\TipoSolicitacao', 'tipo_solicitacao_id');
    }
    
    /**
     * Solicitante
     *
     * @return void
     */
    public function solicitante()
    {
        return $this->belongsTo('App\Models\Solicitante', 'solicitante_id');
    }


}
