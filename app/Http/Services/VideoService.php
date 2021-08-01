<?php 

namespace App\Http\Services;

class VideoService 
{
    public function excluirVideo($Video)
    {
        try {
            if (is_null($Video)) {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            return response()->json('Video nao encontrado', 404);
        }
        
        $Video->delete();
        return response()->json('Video excluido', 410);
    }
}