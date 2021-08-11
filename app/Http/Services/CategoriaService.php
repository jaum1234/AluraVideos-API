<?php 

namespace App\Http\Services;

use App\Http\Requests\CategoriaFormRequest;
use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class CategoriaService 
{
    public function buscarTodosAsCategorias($categoriasPorPagina)
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
           throw new \DomainException("Essa categoria nao existe");
        };

        return $categoria;
    }

    public function atualizarCategoria(CategoriaFormRequest $request, int $categoriaId) 
    {
        if ($categoriaId == 1) {
            throw new \Exception('Essa categoria nao pode ser alterada.');
        }

        $categoria = Categoria::find($categoriaId);
        
        if (is_null($categoria)) {
            throw new \DomainException('Recurso nao encontrado.');
        }

        $categoria->titulo = $request->titulo;
        $categoria->cor = $request->cor;
        $categoria->save();

        return $categoria;
    }

    public function excluirCategoria($categoriaId)
    {
        if ($categoriaId == 1) {
            throw new \Exception('Essa categoria nao pode ser alterada.');
        }
        
        $categoria = Categoria::find($categoriaId);
        
        if (is_null($categoria)) {
            throw new \DomainException('Recurso nao foi encontrado.');
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
            throw new \DomainException('Recurso nao foi encontrada.');
        }

        $videos = $categoria->videos;

        return $videos;
    }

    public function buscarCategoriasParaUsuarioNaoAutenticado()
    {
        $categorias = Categoria::query()->limit(5)->get();
        return $categorias;
    }


}