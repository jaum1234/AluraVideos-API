<?php

use App\Models\Categoria;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CategoriaTest extends TestCase
{
    use DatabaseTransactions;
    
    private $url = '/api/categorias/';

    /**
    * @dataProvider criarParametros
    */
    public function testDeveListarCategorias($parametros)
    {
        $categoria = Categoria::create($parametros);
        $this->seeInDatabase('categorias', $parametros);
        $this->get($this->url);
        $this->seeStatusCode(200);
    } 

    /**
     * @dataProvider criarParametros
     */
    public function testDeveCriarCategoria($parametros)
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
    public function testDeveAtualizarCategoria($parametros)
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
    /**
    * @dataProvider criarParametros
    */
    public function testDeveBuscarUmaUnicaCategoria($parametros)
    {
        $categoria = Categoria::create($parametros);
        $id = $categoria->id;
        $this->seeInDatabase('categorias', $parametros);

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
    /**
     * @dataProvider criarParametros
     */
    public function testDeveDeletarCategoria($parametros)
    {
        $categoria = Categoria::create($parametros);
        $id = $categoria->id;
        $this->seeInDatabase('categorias', $parametros);

        $this->delete($this->url . $id);
        $this->seeJsonStructure(['sucesso']);
        $this->seeStatusCode(410);
    }

    /**
     * @dataProvider criarParametros
     */
    public function testDeveBuscarVideoPorCategoria($parametros)
    { 
        $categoria = Categoria::create($parametros);
        $id = $categoria->id;
        $categoria->videos()->create([
            'titulo' => 'titulo',
            'descricao' => 'descricao',
            'url' => 'url',
        ]);
        
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

    //public function criarParametrosVideos()
    //{
    //    $parametros = [
    //        'titulo' => 'titulo',
    //        'descricao' => 'descricao',
    //        'url' => 'url',
    //        'categoria_id' => 1
    //    ];
    //}
}