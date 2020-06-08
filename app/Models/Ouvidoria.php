<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ouvidoria extends Model
{

    public $table = 'internet.fv_ouv_ouvidoria';

    protected $fillable = [
        'protocolo',
        'mensagem',
        'observacao',
        'anexo',
        'tp_ouvidoria_id',
        'tipo_solicitante_id',
        'solicitante_id',
        'situacao_id',
        'categoria_id',
        'setor_id',
        'assunto_id',
        'classificacao_id',
        'sub_classificacao_id',
        'canal_atendimento_id',
    ];

    public function tipoOuvidoria()
    {
        return $this->belongsTo('App\Models\TipoOuvidoria', 'tp_ouvidoria_id');
    }
    
    public function tipoSolicitante()
    {
        return $this->belongsTo('App\Models\TipoSolicitante', 'tipo_solicitante_id');
    }
    
    public function solicitante()
    {
        return $this->belongsTo('App\Models\Solicitante', 'solicitante_id');
    }
    
    public function situacao()
    {
        return $this->belongsTo('App\Models\Situacao', 'situacao_id');
    }

}
