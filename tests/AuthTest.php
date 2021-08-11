<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseTransactions;

Class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function testDeveRegistrarUmUsuario()
    {
        $user = new User();
        $email = $user->email = 'email@domain.com';
        $nome = $user->name = 'name';
        $senha = $user->password = Hash::make('senha');
        $dados = [
            'email' => $email,
            'name' => $nome,
            'password' => $senha
        ];

        $this->post('/api/register', $dados);
        $this->seeInDatabase('users', ['email' => 'email@domain.com']);
        $this->seeStatusCode(201);
        
    }
    
    public function testDeveLogarUmUsuario()
    {
        $user = new User();
        $email = $user->email = 'jon@domain.com';
        $nome = $user->name = 'name';
        $senha = $user->password = Hash::make('senha');
        $user->save();

        $this->post('/api/login', ['email' => $email, 'password' => 'senha']);
        $this->seeJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
        $this->seeStatusCode(200);
    }

}