<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Video;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriaFormRequest;
use App\Http\Requests\VideoFormRequest;
use Illuminate\Database\QueryException;
use App\Http\Controllers\BaseController;
use App\Http\Services\BuscadorQuery;

Class CategoriaController extends Controller
{
    use BuscadorQuery;

    protected string $classe;

    public function index(Request $request)
    {
        $requestTemQuery = $request->has('q');
        
        if ($requestTemQuery) {
            $resultadoQuery = $this->buscarQuery(Categoria::class);
            return response()->json($resultadoQuery);
        }

        $recursos = Categoria::paginate($request->per_page);

        return response()->json($recursos);
    }

    public function store(CategoriaFormRequest $request)
    {
        try {
            $recursos = $request->all();
            $recurso = Categoria::create($recursos);
        } catch (QueryException $e) {
            return response()->json("Os campo nao foram preenchidos corretamente", 404);
        }

        return response()->json($recurso, 201);
    }

    public function show($id)
    {   
        $recursos = Categoria::find($id);

        if (is_null($recursos)) {
            return response()->json([
                'Recurso nao encontrado'
            ], 404);
        };

        return response()->json($recursos, 200);
    }

    public function delete($id)
    {
        $recurso = Categoria::find($id);

        try {
            if ($id == 1) {
                throw new Exception();
            }
        } catch (Exception $e) {
            return response()->json("Essa categoria nao pode ser excluida");
        }

        $videos = $recurso->videos;

        foreach ($videos as $video) {
            $video->categoria_id = 1;
            $video->save();
        }
        
        try {
            if (is_null($recurso)) {
                throw new Exception('Recurso nao encontrado.');
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
        
        $recurso->delete();
        return response()->json('Recurso excluido', 410);
    }

    public function update(CategoriaFormRequest $request, $id)
    {
        try {
            if ($id == 1) {
                throw new Exception();
            }
        } catch (Exception $e) {
            return response()->json("Essa categoria nao pode ser alterada");
        }

        $recursos = Categoria::find($id);
        $recursos->titulo = $request->titulo;
        $recursos->cor = $request->cor;

        $recursos->save();

        return response()->json([
            'titulo' => $recursos->titulo,
            'cor' => $recursos->cor,
        ], 201);
    }

    public function buscarVideoPorCategoria(int $id)
    {
        $categoria = Categoria::find($id);
        $categoria->videos;
        return response()->json($categoria);
    }
}