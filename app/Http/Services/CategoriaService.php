<?php 

namespace App\Http\Services;

use App\Models\Categoria;
use Illuminate\Http\Request;
class CategoriaService 
{
    public function atualizar(Request $request, Categoria $categoria) 
    {
        if ($categoria->id == 1) {
            throw new \Exception('Essa categoria nao pode ser alterada.');
        }

        $categoria->titulo = $request->titulo;
        $categoria->cor = $request->cor;

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

        $videos = $categoria->videos;
        return $videos;
    }

}