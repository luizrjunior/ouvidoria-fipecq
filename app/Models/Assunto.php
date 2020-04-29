<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'assunto';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'assunto_cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assunto_descricao',
        'assunto_status'
    ];

}
