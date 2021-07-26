<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Video extends Model
{
   protected $table = 'videos';

    protected $fillable = [
        'titulo',
        'descricao',
        'url'
    ];
}