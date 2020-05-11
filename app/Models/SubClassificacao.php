<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubClassificacao extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'fv_ouv_sub_classificacao';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    // protected $primaryKey = 'sub_classificacao_cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
