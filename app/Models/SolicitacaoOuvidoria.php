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
    public $table = 'solicitacao_ouvidoria';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'solicitacao_ouvidoria_cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'solicitacao_ouvidoria_protocolo',
        'solicitacao_ouvidoria_mensagem',
        'solicitacao_ouvidoria_anexo',
        'tipo_solicitacao_cod',
        'solicitante_cod',
        'tipo_prestador_cod',
        'sub_classificacao_cod',
        'assunto_cod',
        'canal_atendimento_cod'
    ];

    /**
     * Tipo de Solicitacao
     *
     * @return void
     */
    public function tipoSolicitacao()
    {
        return $this->belongsTo('App\Models\TipoSolicitacao', 'tipo_solicitacao_cod');
    }
    
    /**
     * Solicitante
     *
     * @return void
     */
    public function solicitante()
    {
        return $this->belongsTo('App\Models\Solicitante', 'solicitante_cod');
    }


}
