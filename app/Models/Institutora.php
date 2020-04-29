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
    public $table = 'institutora';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'institutora_cod';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'institutora_descricao',
        'institutora_status'
    ];

}
