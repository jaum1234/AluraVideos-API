<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class CategoriaTest extends TestCase
{
    use DatabaseTransactions;
    
    private $url = '/api/categorias';

    public function testListarCategorias()
    {
        $this->get($this->url, []);
        $this->seeJsonStructure(['*' => [
            'titulo',
            'cor',
            'created_at',
            'updated_at',
        ]]);
        $this->seeStatusCode(200);
        
    } 

    public function testCriarCategorias()
    {
        $parametros = [
            'titulo' => 'titulo',
            'cor' => 'cor'
        ];

        $this->post($this->url, $parametros, []);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'titulo',
            'cor',
            'created_at',
            'updated_at',
        ]);
        $this->seeInDatabase('categorias', $parametros);

    }

    public function testAtualizarCategoria()
    {
        $parametros = [
            'titulo' => 'titulo',
            'cor' => 'cor'
        ];

        $this->put($this->url . '/5', $parametros, []);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'titulo',
            'cor',
        ]);
        $this->seeInDatabase('categorias', $parametros);
    }
//
    public function testMostarCategoria()
    {
        $this->get($this->url . '/5', []);
        $this->seeJsonStructure([
            'titulo',
            'cor',
            'created_at',
            'updated_at',
        ]);
        $this->seeStatusCode(200);
    }
//
    public function testDeletarCategoria()
    {
       $this->delete($this->url . '/5', []);
       $this->seeJsonStructure([]);
       $this->seeStatusCode(410);
    }

    public function testBuscarVideoPorCategoria()
    {
        $this->get($this->url . '/1/videos');
        $this->seeStatusCode(200);
    }

    
}