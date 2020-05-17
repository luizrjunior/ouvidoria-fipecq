<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{

    public $table = 'fv_ouv_assunto';

    protected $fillable = [
        'descricao',
        'status'
    ];

}
