<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UF extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'uf';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'uf_cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uf_sigla',
        'uf_descricao'
    ];

}
