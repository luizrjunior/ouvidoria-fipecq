<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{

    public $table = 'fv_ouv_setor';

    protected $fillable = [
        'categoria_id',
        'descricao',
        'status'
    ];

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria', 'categoria_id');
    }

}
