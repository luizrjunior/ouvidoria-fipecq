<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubClassificacao extends Model
{

    public $table = 'fv_ouv_sub_classificacao';

    protected $fillable = [
        'classificacao_id',
        'descricao',
        'status'
    ];

    public function classificacao()
    {
        return $this->belongsTo('App\Models\Classificacao', 'classificacao_id');
    }

}
