<?php

use App\Http\Controllers\VideoController;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Video;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tymon\JWTAuth\Facades\JWTAuth;

class VideoTest extends TestCase
{
    use DatabaseTransactions;
    
    private $url = '/api/videos/';
    
    public function testDeveListaTodosOsVideos()
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        
        $cateogoria = Categoria::factory()->create();
        $categoriaId = $cateogoria->id;

        for ($i = 0; $i < 3; $i++) {
            Video::factory()->create([
                'titulo' => 'titulo do video',
                'descricao' => 'descricao do video',
                'url' => 'url do video',
                'categoria_id' => $categoriaId
            ]);
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
                        'titulo',
                        'descricao',
                        'url',
                        'created_at',
                        'updated_at',
                        'categoria_id'
                    ]
                ]
            ],
            'mensagem'
        ]); 
    }

    public function testDeveCriarUmVideo()
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $cateogoria = Categoria::factory()->create();
        $categoriaId = $cateogoria->id;

        $parametros = [
            'titulo' => 'titulo do video',
            'descricao' => 'descricao do video',
            'url' => 'url do video',
            'categoria_id' => $categoriaId
        ];
    
        //Act
        $this->post($this->url, $parametros, ['Authorization' => 'Bearer ' . $token]);

        //Assert
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'status',
            'conteudo' => [
                'titulo',
                'descricao',
                'url',
                'created_at',
                'updated_at',
                'categoria_id'
            ],
            'mensagem'
        ]);
        $this->seeInDatabase('videos', $parametros);
    }

    public function testDeveAtualizarUmVideo()
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $cateogoria = Categoria::factory()->create();
        $categoriaId = $cateogoria->id;

        $parametros = [
            'titulo' => 'titulo do video',
            'descricao' => 'descricao do video',
            'url' => 'url do video',
            'categoria_id' => $categoriaId
        ];

        $video = Video::factory()->create($parametros);

        $id = $video->id;

        $novosDados = [
            'titulo' => 'novo titulo',
            'descricao' => 'nova descricao',
            'url' => 'nova url',
            'categoria_id' => $categoriaId
        ];
        
        //Act
        $this->put($this->url . $id, $novosDados, ['Authorization' => 'Bearer ' . $token]);

        //Assert
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'status',
            'conteudo' => [
                'titulo',
                'descricao',
                'url',
                'created_at',
                'updated_at',
                'categoria_id'
            ],
            'mensagem'
        ]);
        $this->seeInDatabase('videos', $novosDados);
        $this->notSeeInDatabase('videos', $parametros);
    }

    public function testDeveMostrarUmVideo()
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $cateogoria = Categoria::factory()->create();
        $categoriaId = $cateogoria->id;

        $video = Video::factory()->create([
            'titulo' => 'titulo do video',
            'descricao' => 'descricao do video',
            'url' => 'url do video',
            'categoria_id' => $categoriaId
        ]);
        $id = $video->id;

        //Act
        $response = $this->get($this->url . $id, ['Authorization' => 'Bearer ' . $token]);

        //Assert
        $response->seeJsonStructure([
            'status',
            'conteudo' => [
                'id',
                'titulo',
                'descricao',
                'url',
                'categoria_id'
            ],
            'mensagem'
        ]);
        $response->seeStatusCode(200);
    
    }
    
    public function testDeveDeletarUmVideo()
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $cateogoria = Categoria::factory()->create();
        $categoriaId = $cateogoria->id;

        $parametros = [
            'titulo' => 'titulo do video',
            'descricao' => 'descricao do video',
            'url' => 'url do video',
            'categoria_id' => $categoriaId
        ];

        $video = Video::factory()->create($parametros);

        $id = $video->id;

        //Act
        $this->delete($this->url . $id, [],['Authorization' => 'Bearer ' . $token]);

        //Assert
        $this->seeStatusCode(200);
        $this->notSeeInDatabase('videos', $parametros);
        $this->seeJsonStructure([
            'status',
            'conteudo',
            'mensagem'
        ]);
    }
 
    public function testDeveBuscarVideosParaUsuarioNaoAutenticado()
    {
        //Arrange
        $cateogoria = Categoria::factory()->create();
        $categoriaId = $cateogoria->id;

        for ($i = 0; $i < 5; $i++) {
            Video::factory()->create([
                'titulo' => 'titulo do video',
                'descricao' => 'descricao do video',
                'url' => 'url do video',
                'categoria_id' => $categoriaId
            ]);
        }
       
        //Act
        $response = $this->get($this->url . 'free');

        //Assert
        $response->seeStatusCode(200);
        $response->seeJsonStructure([
            'status',
            'conteudo' => [
                '*' => [
                    'titulo',
                    'descricao',
                    'url',
                    'created_at',
                    'updated_at',
                    'categoria_id',
                ],
            ],
            'status'
        ]);
    } 
}