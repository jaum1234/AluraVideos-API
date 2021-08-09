<?php 

namespace App\Http\Services;

use App\Http\Requests\CategoriaFormRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaService 
{
    public function buscarTodosOsCategorias($categoriasPorPagina)
    {
        $categorias = Categoria::paginate($categoriasPorPagina);
        return $categorias;
    }

    public function criarCategoria($request)
    {
        $categoria = Categoria::create($request->all());
        return $categoria;
    }

    public function buscarCategoria($id)
    {
        $categoria = Categoria::find($id);

        if (is_null($categoria)) {
           throw new \Exception("Essa categoria nao existe");
        };

        return $categoria;
    }

    public function atualizarCategoria(CategoriaFormRequest $request, int $categoriaId) 
    {
        $categoria = Categoria::find($categoriaId);

        $categoria->titulo = $request->titulo;
        $categoria->descricao = $request->descricao;
        $categoria->url = $request->url;
        $categoria->categoria_id = $request->categoria_id;

        $categoria->save();

        return $categoria;
    }

    public function excluirCategoria($categoriaId)
    {
        $recurso = Categoria::find($categoriaId);

        $videos = $recurso->videos;

        foreach ($videos as $video) {
            $video->categoria_id = 1;
            $video->save();
        }
        
        if (is_null($recurso)) {
            throw new \Exception('Recurso nao encontrado.');
        }
        
        $recurso->delete();
        return $recurso->titulo;
    }

    public function buscarCategoriasParaUsuarioNaoAutenticado()
    {
        $categorias = Categoria::query()->limit(5)->get();
        return $categorias;
    }

    private function verificarSeCategoriaIdIgualUm() {
        
    }

}