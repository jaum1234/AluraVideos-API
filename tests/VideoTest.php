<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class VideoTest extends TestCase
{
    use DatabaseTransactions;
    
    private $url = 'api/videos';
    
    public function testListarVideos()
    {
        $this->get($this->url, []);
        $this->seeStatusCode(200);
    }

    /**
     * @dataProvider criarParametrosVideo
     */
    public function testCriarVideos($parametros)
    {
        $this->post($this->url, $parametros, []);
        $this->seeStatusCode(201);
        $this->seeInDatabase('videos', $parametros);
        $this->seeJsonStructure([
            'titulo',
            'descricao',
            'url',
            'created_at',
            'updated_at',
            'categoria_id'
        ]);

    }

    /**
     * @dataProvider criarParametrosVideo
     */
    public function testAtualizarVideo($parametros)
    {
        $this->put($this->url . '/2', $parametros, []);
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
//
    public function testMostarVideo()
    {
        $this->get($this->url . '/2', []);
        $this->seeJsonStructure([
            'titulo',
            'descricao',
            'url',
            'categoria_id'
        ]);
        $this->seeStatusCode(200);
    }
//
    public function testDeletarVideo()
    {
       $this->delete($this->url . '/2', []);
       $this->seeJsonStructure([]);
       $this->seeStatusCode(410);
    }


    public function criarParametrosVideo()
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