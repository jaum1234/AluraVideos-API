<?php 

namespace App\Http\Services;

use App\Models\Categoria;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaService 
{
    public function atualizar(array $dados, Categoria $categoria) 
    {
        if ($categoria->id == 1) {
            throw new \Exception('Essa categoria nao pode ser alterada.');
        }

        $categoria->titulo = $dados['titulo'];
        $categoria->cor = $dados['cor'];

        $categoria->save();

        return $categoria;
    }

    public function excluir(Categoria $categoria)
    {
        if ($categoria->id == 1) {
            throw new \Exception('Essa categoria nao pode ser excluida.');
        }       
        
        $videos = $categoria->videos;

        foreach ($videos as $video) {
            $video->categoria_id = 1;
            $video->save();
        }
        
        $categoria->delete();
        return $categoria->titulo;
    }

    public function buscarVideoPorCategoria(int $id)
    {
        $categoria = Categoria::find($id);
        if (is_null($categoria)) {
            throw new \DomainException('Categoria nao foi encontrada.');
        }

        $videos = Video::where('categoria_id', $id)->paginate(4);
        return $videos;
    }

    public function validar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'cor' => 'required'
        ], [
            'required' => 'O campo :attribute é obrigatório.'
        ]);

        return $validator;
    }
}