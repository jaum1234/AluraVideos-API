<?php 

namespace App\Http\Services;

class BuscadorQuery
{
    public function buscarQuery($classe)
    {
        $busca = request('q');
        $resultado = $classe::query()
            ->where('titulo', 'like', '%' . $busca . '%')
            ->get();
            
        return $resultado;
    }
}