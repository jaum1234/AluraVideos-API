<?php

use App\Http\Controllers\VideoController;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tymon\JWTAuth\Facades\JWTAuth;

class VideoTest extends TestCase
{
    use DatabaseTransactions;
    
    private $url = 'api/videos/';
    
    /**
     * @dataProvider criarParametros
     */
    public function testDeveListaTodosOsVideos($parametros)
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        for ($i = 0; $i < 3; $i++) {
            Video::create($parametros);
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

    /**
     * @dataProvider criarParametros
     *
     */
    public function testDeveCriarUmVideo($parametrosVideo)
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
    
        //Act
        $this->post($this->url, $parametrosVideo, ['Authorization' => 'Bearer ' . $token]);

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
        $this->seeInDatabase('videos', $parametrosVideo);
    }

    /**
     * @dataProvider criarParametros
     */
    public function testDeveAtualizarUmVideo($parametros)
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $video = Video::create($parametros);
        $id = $video->id;
        
        //Act
        $this->put($this->url . $id, $parametros, ['Authorization' => 'Bearer ' . $token]);

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
        $this->seeInDatabase('videos', $parametros);
    }

   /**
    *  @dataProvider criarParametros
    */
    public function testDeveMostrarUmVideo($parametros)
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $video = Video::create($parametros);
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
//

    /**
     *  @dataProvider criarParametros
     */
    public function testDeveDeletarUmVideo($parametros)
    {
        //Arrange
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $video = Video::create($parametros);
        $id = $video->id;

        //Act
        $this->delete($this->url . $id, [],['Authorization' => 'Bearer ' . $token]);

        //Assert
        $this->seeStatusCode(200);
        $this->notSeeInDatabase('videos', $parametros);
    }

    /**
     *  @dataProvider criarParametros
     */
    public function testDeveBuscarVideosParaUsuarioNaoAutenticado($parametros)
    {
        //Arrange
        for ($i = 0; $i < 5; $i++) {
            Video::create($parametros);
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


    public function criarParametros()
    {
        $parametros = [
            'titulo' => 'titulo',
            'descricao' => 'descricao',
            'url' => 'http://url.com',
            'categoria_id' => 1
        ];


        return [
            'parametros' => [$parametros]
        ];
    }

    
    
}