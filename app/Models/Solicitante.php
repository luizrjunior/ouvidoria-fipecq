<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'fv_ouv_solicitante';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    // protected $primaryKey = 'solicitante_cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
