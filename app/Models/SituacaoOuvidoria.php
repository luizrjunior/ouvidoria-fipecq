<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SituacaoOuvidoria extends Model
{

    public $table = 'fv_ouv_situacao_ouvidoria';

    protected $fillable = [
        'comentario',
        'ouvidoria_id',
        'situacao_id',
        'usuario_id'
    ];

    public function situacao()
    {
        return $this->belongsTo('App\Models\Situacao', 'situacao_id');
    }

}
