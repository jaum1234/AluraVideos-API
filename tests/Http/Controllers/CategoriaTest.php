<?php

use App\Models\User;
use App\Models\Categoria;
use Tymon\JWTAuth\Facades\JWTAuth;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CategoriaTest extends TestCase
{
    use DatabaseTransactions;
    
    private $url = '/api/categorias/';


    public function testDeveListarCategorias()
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        for ($i = 0; $i < 10; $i++) {
            Categoria::factory()->create();
        }
        
        //Act
        $response = $this->get($this->url, ['Authorization' => 'Bearer ' . $token]);

        //Assert
        $response->seeStatusCode(200);
        $response->seeJsonStructure([
            'status',
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
            ],
            'mensagem'
        ]);
    } 

    public function testDeveCriarCategoria()
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $parametros = [
            'titulo' => 'titulo da categoria',
            'cor' => 'cor da categoria'
        ];

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
    
    public function testDeveAtualizarCategoria()
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $parametros = [
            'titulo' => 'titulo da categoria',
            'cor' => 'cor da categoria'
        ];

        $categoria = Categoria::factory()->create($parametros);
        $id = $categoria->id;

        $novosDados = [
            'titulo' => 'novo titulo',
            'cor' => 'nova cor'
        ];

        //Act
        $this->put($this->url . $id, $novosDados, ['Authorization' => 'Bearer ' . $token]);

        //Assert
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'status',
            'conteudo' => [
                'id',
                'titulo',
                'cor',
            ],
            'mensagem'
        ]);
        $this->seeInDatabase('categorias', $novosDados);
        $this->notSeeInDatabase('categorias', $parametros);
    }
//
    public function testDeveBuscarUmaUnicaCategoria()
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $categoria = Categoria::factory()->create();
        $id = $categoria->id;

        //Act
        $this->get($this->url . $id, ['Authorization' => 'Bearer ' . $token]);

        //Assert
        $this->seeJsonStructure([
            'status',
            'conteudo' => [
                'titulo',
                'cor',
                'created_at',
                'updated_at',
            ],
            'mensagem'
        ]);
        $this->seeStatusCode(200);
    }
//
    
    public function testDeveDeletarCategoria()
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $parametros = [
            'titulo' => 'titulo do categoria',
            'cor' => 'cor da categoria'
        ];

        $categoria = Categoria::factory()->create($parametros);
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
        $this->notSeeInDatabase('categorias', $parametros);
    }

    
    public function testDeveBuscarVideoPorCategoria()
    { 
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $categoria = Categoria::factory()->create();
        $id = $categoria->id;
        $categoria->videos()->create([
            'titulo' => 'titulo',
            'descricao' => 'descricao',
            'url' => 'url',
        ]);
        
        //Act
        $response = $this->get($this->url . $id . '/videos', ['Authorization' => 'Bearer ' . $token]);

        //Assert
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'status',
            'conteudo' => [
                'data' => [
                '*' => [
                    'id',
                    'titulo',
                    'created_at',
                    'updated_at',
                    'categoria_id'
                    ]
                ]
            ],
            'mensagem'
        ]);
    }
}