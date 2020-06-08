<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{

    public $table = 'fv_ouv_assunto';

    protected $fillable = [
        'setor_id',
        'descricao',
        'status'
    ];

    public function setor()
    {
        return $this->belongsTo('App\Models\Setor', 'setor_id');
    }

}
