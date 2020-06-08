<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classificacao extends Model
{

    public $table = 'fv_ouv_classificacao';

    protected $fillable = [
        'assunto_id',
        'descricao',
        'status'
    ];

    public function assunto()
    {
        return $this->belongsTo('App\Models\Assunto', 'assunto_id');
    }

}
