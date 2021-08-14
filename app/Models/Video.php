<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class Video extends Model
{
    protected $table = 'videos';

    protected $fillable = [
        'titulo',
        'descricao',
        'url',
        'categoria_id'
    ];

    protected $attributes = [
        'categoria_id' => 1
    ];

    protected $perPage = 5;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}