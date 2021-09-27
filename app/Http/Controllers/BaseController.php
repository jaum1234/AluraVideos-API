<?php

namespace App\Http\Controllers;

use App\Http\Services\BuscadorQuery;
use Illuminate\Http\Request;

Class BaseController extends Controller
{
    use BuscadorQuery;

    protected string $classe;
    protected $classeService;

    public function index(Request $request)
    {
        $query = $request->has('q');

        if ($query) {
            $resultadoQuery = $this->buscarQuery($this->classe);
            return response()->json($resultadoQuery);
        }

        $recursos = $this->classe::paginate(4);

        return response()->json($recursos);
    }

    public function show(int $id)
    {
        $recurso = $this->classe::find($id);

        if (is_null($recurso)) {
           throw new \Exception('Esse recurso nao existe');
        };

        return response()->json($recurso);
    }
    
    public function store(Request $request)
    {
        $validador = $this->classeService->validar($request);

        if ($validador->fails()) {
            return response()->json($validador->errors());
        }

        $dadosValidados = $validador->validated();

        $recurso = $this->classe::create($dadosValidados);

        return response()->json($recurso, 201);
    }
    
    public function update(Request $request, int $id)
    {
        $validador = $this->classeService->validar($request);

        if ($validador->fails()) {
            return response()->json($validador->errors());
        }

        $dadosValidados = $validador->validated();

        $recurso = $this->classe::find($id);

        if (is_null($recurso)) {
            throw new \Exception('Esse recurso nao existe');
        }

        $recursoAtualizado = $this->classeService->atualizar($dadosValidados, $recurso);

        return response()->json($recursoAtualizado);
    }

    public function delete(int $id)
    {
        $recurso = $this->classe::find($id);

        $nomeRecursoExcluido = $this->classeService->excluir($recurso);

        return response()->json($nomeRecursoExcluido);
    }
    
}