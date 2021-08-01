//<?php
//
//namespace App\Http\Controllers;
//
//use Exception;
//use App\Models\Video;
//use App\Models\recursos;
//use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
//use App\Http\Services\BuscadorQuery;
//use App\Http\Requests\BaseFormRequest;
//use Illuminate\Database\QueryException;
//use App\Http\Requests\recursosFormRequest;
//
//Class BaseController extends Controller
//{
//    protected string $classe;
//
//    public function index(BuscadorQuery $buscadorQuery,Request $request)
//    {
//        if ($request->has('q')) {
//            $recurso = $buscadorQuery->buscarQuery($this->classe);
//            return response()->json($recurso);
//        }
//
//        $recursos = $this->classe::all();
//
//        return response()->json($recursos);
//    }
//
//    public function store(BaseFormRequest $request)
//    {
//        try {
//            $recursos = $request->all();
//            $recurso = $this->classe::create($recursos);
//        } catch (QueryException $e) {
//            return response()->json("Os campo nao foram preenchidos corretamente", 404);
//        }
//
//        return response()->json($recurso, 201);
//    }
//
//    public function show($id)
//    {   
//        $recursos = $this->classe::find($id);
//
//        if (is_null($recursos)) {
//            return response()->json([
//                'Recurso nao encontrado'
//            ], 404);
//        };
//
//        return response()->json($recursos, 200);
//    }
//
//    public function delete($id)
//    {
//        $recursos = $this->classe::find($id);
//    
//        
//        try {
//            if (is_null($recursos)) {
//                throw new Exception();
//            }
//        } catch (Exception $e) {
//            return response()->json('Recurso nao encontrado', 404);
//        }
//        
//        $recursos->delete();
//        return response()->json('Recurso excluido', 410);
//    }
//}