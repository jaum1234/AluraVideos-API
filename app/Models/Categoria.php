<?php

namespace App\Models;

use App\Models\Video;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Database\Eloquent\Model;

Class Categoria extends Model
{
   protected $table = 'categorias';

    protected $fillable = [
        'titulo',
        'cor',
    ];

    protected $perPage = 5;

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}