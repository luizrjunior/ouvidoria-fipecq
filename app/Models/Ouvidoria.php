<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ouvidoria extends Model
{

    public $table = 'fv_ouv_ouvidoria';

    protected $fillable = [
        'protocolo',
        'mensagem',
        'anexo',
        'tipo_ouvidoria_id',
        'solicitante_id',
        'tipo_prestador_id',
        'sub_classificacao_id',
        'assunto_id',
        'canal_atendimento_id'
    ];

    public function tipoOuvidoria()
    {
        return $this->belongsTo('App\Models\TipoOuvidoria', 'tipo_ouvidoria_id');
    }
    
    public function solicitante()
    {
        return $this->belongsTo('App\Models\Solicitante', 'solicitante_id');
    }

}
