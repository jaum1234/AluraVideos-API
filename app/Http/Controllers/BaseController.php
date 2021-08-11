<?php

namespace App\Http\Controllers;

use BaseControllerInterface;
use Illuminate\Http\Client\Request;
use App\Http\Services\BuscadorQuery;
Class BaseController extends Controller
{
    use BuscadorQuery;

    protected string $classe;
    protected $recursoService;

    public function index(Request $request)
    {
        $query = $request->has('q');

        if ($query) {
            $resultadoQuery = $this->buscarQuery($this->classe);
            return response()->json($resultadoQuery);
        }

        $recursos = $this->recursoService->buscarTodosOsVideos($request->per_page);

        return response()->json($recursos);
    }

    public function show()
    {

    }
    
    public function store()
    {

    }
    
    public function update()
    {

    }

    public function delete()
    {

    }
    
}