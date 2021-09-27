<?php


use Laravel\Lumen\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testDeveRegistrarUmUsuario()
    {
        $dados = [
            'email' => 'email@domain.com',
            'name' => 'name',
            'password' => '123'
        ];

        $this->post('/api/register', $dados);
        $this->seeJsonStructure([
            'status',
            'conteudo' => [
                'name',
                'email',
                'created_at',
                'updated_at',
                'id'
            ],
            'mensagem'
        ]);
        $this->seeStatusCode(201);
        $this->seeInDatabase('users', [
            'email' => $dados['email'],
            'name' => $dados['name'],
        ]); 
    }
}
