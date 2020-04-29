<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPrestador extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'tipo_prestador';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'tipo_prestador_cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_prestador_descricao',
        'tipo_prestador_status'
    ];

}
