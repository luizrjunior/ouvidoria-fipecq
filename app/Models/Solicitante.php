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
    public $table = 'solicitante';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'solicitante_cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'solicitante_nome',
        'solicitante_cpf',
        'solicitante_email',
        'solicitante_telefone',
        'solicitante_celular',
        'solicitante_uf',
        'solicitante_cidade',
        'institutora_cod',
        'tipo_solicitante_cod'
    ];

    public function tipoSolicitante()
    {
        return $this->belongsTo('App\Models\TipoSolicitante', 'tipo_solicitante_cod');
    }

    public function institutora()
    {
        return $this->belongsTo('App\Models\Institutora', 'institutora_cod');
    }

}
