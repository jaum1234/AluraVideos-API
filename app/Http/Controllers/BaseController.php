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

        return response()->json([
            'status' => 'listado',
            'conteudo' => $recursos,
            'mensagem' => 'Todos os itens foram listados.'
        ], 200);
    }

    public function show(int $id)
    {
        $recurso = $this->classe::find($id);

        try {
            if (is_null($recurso)) {
                throw new \Exception('Esse recurso nao existe');
            };
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }

        return response()->json([
            'status' => 'exibido',
            'conteudo' => $recurso,
            'mensagem' => 'O recurso foi exibido'
        ], 200);
    }
    
    public function store(Request $request)
    {
        $validador = $this->classeService->validar($request);

        if ($validador->fails()) {
            return response()->json($validador->errors());
        }

        $dadosValidados = $validador->validated();

        $recurso = $this->classe::create($dadosValidados);

        return response()->json([
            'status' => 'criado',
            'conteudo' => $recurso,
            'mensagem' => 'Recurso foi criado.'
        ], 201);
    }
    
    public function update(Request $request, int $id)
    {
        $validador = $this->classeService->validar($request);

        if ($validador->fails()) {
            return response()->json($validador->errors());
        }

        $dadosValidados = $validador->validated();

        $recurso = $this->classe::find($id);

        try {
            if (is_null($recurso)) {
                throw new \Exception('Esse recurso nao existe');
            };
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }

        $recursoAtualizado = $this->classeService->atualizar($dadosValidados, $recurso);

        return response()->json([
            'status' => 'atualizado',
            'conteudo' => $recursoAtualizado,
            'mensagem' => 'O recurso foi atualizado.'
        ], 200);
    }

    public function delete(int $id)
    {
        $recurso = $this->classe::find($id);

        try {
            if (is_null($recurso)) {
                throw new \Exception('Esse recurso nao existe');
            };
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }

        $nomeRecursoExcluido = $this->classeService->excluir($recurso);

        return response()->json([
            'status' => 'excluido',
            'conteudo' => '',
            'mensagem' => $nomeRecursoExcluido . ' foi excluido' 
        ], 200);
    }
    

}