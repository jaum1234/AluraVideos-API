<?php

namespace Database\Factories;

use App\Model;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    public function definition(): array
    {
    	return [
    	    'titulo' => 'titulo da categoria',
            'cor' => 'cor da categoria'
    	];
    }
}
