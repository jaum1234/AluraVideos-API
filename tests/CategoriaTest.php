<?php

use App\Models\Categoria;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CategoriaTest extends TestCase
{
    use DatabaseTransactions;
    
    private $url = '/api/categorias/';

    public function testListarCategorias()
    {
        $this->get($this->url);
        $this->seeStatusCode(200);
    } 

    /**
     * @dataProvider criarParametros
     */
    public function testCriarCategorias($parametros)
    {
        $this->post($this->url, $parametros);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'titulo',
            'cor',
            'created_at',
            'updated_at',
        ]);
        $this->seeInDatabase('categorias', $parametros);

    }
    
    /**
     * @dataProvider criarParametros
     */
    public function testAtualizarCategoria($parametros)
    {
        $categoria = Categoria::create($parametros);

        $id = $categoria->id;

        $this->put($this->url . $id, $parametros);
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
        $categoria = Categoria::create([
            'titulo' => 'titulo',
            'cor' => 'color'
        ]);

        $id = $categoria->id;

        $this->get($this->url . $id);
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
        $categoria = Categoria::create([
            'titulo' => 'titulo',
            'cor' => 'color'
        ]);

        $id = $categoria->id;

       $this->delete($this->url . $id);
       $this->seeJsonStructure([]);
       $this->seeStatusCode(410);
    }

    public function testBuscarVideoPorCategoria()
    {
        $categoria = Categoria::create([
            'titulo' => 'titulo',
            'cor' => 'color'
        ]);

        $id = $categoria->id;

        $this->get($this->url . $id . '/videos');
        $this->seeStatusCode(200);
    }

    public function criarParametros()
    {
        $parametros = [
            'titulo' => 'titulo',
            'cor' => 'color'
        ];

        return [
            'parametros' => [$parametros]
        ];
    }
}