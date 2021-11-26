@extends('layout')

@section('conteudo')

    <form action="/api/login" method="POST" class="d-flex flex-column align-items-center mt-5">
        <div class="d-flex flex-column mb-3">
            <label class="form-label">E-mail</label>
            <input class="form-control" name="email" type="text">
        </div>
        <div class="d-flex flex-column">
            <label class="form-label">Senha</label>
            <input class="form-control" name="password" type="password">
        </div>
        <button class="btn btn-primary mt-4">
            Enviar
        </button>
    </form>
    
@endsection