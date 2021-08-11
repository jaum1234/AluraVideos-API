<?php

use App\Http\Controllers\VideoController;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VideoTest extends TestCase
{
    use DatabaseTransactions;
    
    private $url = 'api/videos/';
    
    /**
     * @dataProvider criarParametros
     */
    public function testDeveListaTodosOsVideos($parametros)
    {

        $video1 = Video::create($parametros);
        $video2 = Video::create($parametros);
        $video3 = Video::create($parametros);

        $this->get($this->url);
        $this->seeStatusCode(200);   
    }

    /**
     * @dataProvider criarParametros
     *
     */
    public function testDeveCriarUmVideo($parametrosVideo)
    {
        $this->post($this->url, $parametrosVideo);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'titulo',
            'descricao',
            'url',
            'created_at',
            'updated_at',
            'categoria_id'
        ]);
        $this->seeInDatabase('videos', $parametrosVideo);
    }

    /**
     * @dataProvider criarParametros
     */
    public function testDeveAtualizarUmVideo($parametros)
    {
        $video = Video::create($parametros);
        $id = $video->id;

        $this->put($this->url . $id, $parametros);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'titulo',
            'descricao',
            'url',
            'created_at',
            'updated_at',
            'categoria_id'
        ]);
        $this->seeInDatabase('videos', $parametros);
    }

   /**
    *  @dataProvider criarParametros
    */
    public function testDeveMostrarUmVideo($parametros)
    {
        $video = Video::create($parametros);
        $id = $video->id;

        $this->get($this->url . $id);
        $this->seeJsonStructure([
            'titulo',
            'descricao',
            'url',
            'categoria_id'
        ]);
        $this->seeStatusCode(200);
    }
//

    /**
     *  @dataProvider criarParametros
     */
    public function testDeveDeletarUmVideo($parametros)
    {
        $video = Video::create($parametros);
        $id = $video->id;

        $this->delete($this->url . $id);
        $this->seeJsonStructure(['Mensagem']);
        $this->seeStatusCode(410);
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