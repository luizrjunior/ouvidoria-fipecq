<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{

    public $table = 'fv_ouv_solicitante';

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'telefone',
        'celular',
        'uf',
        'cidade',
        'institutora_id',
        'tipo_solicitante_id'
    ];

    public function tipoSolicitante()
    {
        return $this->belongsTo('App\Models\TipoSolicitante', 'tipo_solicitante_id');
    }

    public function institutora()
    {
        return $this->belongsTo('App\Models\Institutora', 'institutora_id');
    }

}
