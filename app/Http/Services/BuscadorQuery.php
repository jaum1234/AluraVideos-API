<?php 

namespace App\Http\Services;

class BuscadorQuery
{
    public function buscarQuery($classe)
    {
        $busca = request('q');
        $recurso = $classe::query()
            ->where('titulo', 'like', '%' . $busca . '%')
            ->get();
            
        return $recurso;
    }
}