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
    public $table = 'fv_ouv_assunto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descricao',
        'status'
    ];

}
