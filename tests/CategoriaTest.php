<?php

use App\Models\User;
use App\Models\Categoria;
use Tymon\JWTAuth\Facades\JWTAuth;
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
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $categoria = Categoria::create($parametros);
        
        //Act
        $response = $this->get($this->url, ['Authorization' => 'Bearer ' . $token]);

        //Assert
        $response->seeStatusCode(200);
        $response->seeJsonStructure([
            'conteudo' => [
                'data' => [
                    '*' => [
                    'id',
                    'titulo',
                    'cor',
                    'created_at',
                    'updated_at'
                    ]
                ]
            ]
        ]);
    } 

    /**
     * @dataProvider criarParametros
     */
    public function testDeveCriarCategoria($parametros)
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        //Act
        $this->post($this->url, $parametros, ['Authorization' => 'Bearer ' . $token]);

        //Assert
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'status',
            'conteudo' => [
                'id',
                'titulo',
                'cor',
                'created_at',
                'updated_at',
            ],
            'mensagem'
        ]);
        $this->seeInDatabase('categorias', $parametros);

    }
    
    /**
     * @dataProvider criarParametros
     */
    public function testDeveAtualizarCategoria($parametros)
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $categoria = Categoria::create($parametros);
        $id = $categoria->id;

        //Act
        $this->put($this->url . $id, $parametros, ['Authorization' => 'Bearer ' . $token]);

        //Assert
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
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $categoria = Categoria::create($parametros);
        $id = $categoria->id;
        $this->seeInDatabase('categorias', $parametros);

        //Act
        $this->get($this->url . $id, ['Authorization' => 'Bearer ' . $token]);

        //Assert
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
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $categoria = Categoria::create($parametros);
        $id = $categoria->id;
        
        //Act
        $this->delete($this->url . $id, [], ['Authorization' => 'Bearer ' . $token]);

        //Assert
        $this->seeJsonStructure([
            'status',
            'conteudo',
            'mensagem'
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * @dataProvider criarParametros
     */
    public function testDeveBuscarVideoPorCategoria($parametros)
    { 
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        //Act
        $categoria = Categoria::create($parametros);
        $id = $categoria->id;
        $categoria->videos()->create([
            'titulo' => 'titulo',
            'descricao' => 'descricao',
            'url' => 'url',
        ]);
        
        //Assert
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