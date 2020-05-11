<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institutora extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'fv_ouv_institutora';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    // protected $primaryKey = 'institutora_cod';

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
