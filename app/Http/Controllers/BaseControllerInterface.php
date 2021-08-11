<?php 

use Illuminate\Http\Request;

interface BaseControllerInterface
{
    public function index($request);

    public function show(int $id);
    
    public function store(Request $request);
    
    public function update(Request $request, int $id);

    public function delete(int $id);
    
}