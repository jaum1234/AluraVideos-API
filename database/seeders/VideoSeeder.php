<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('videos')->insert([
            'titulo' => 'titulo' . rand(0, 100),
            'descricao' => 'descricao' . rand(0, 100),
            'url' => 'http://' . Str::random(10) . '.com',
            'categoria_id' => 1
        ]);
    }
}
