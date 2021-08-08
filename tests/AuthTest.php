<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseTransactions;

Class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function testDeveLogarUmUsuario()
    {
        $this->expectException(\Exception::class);

        $user = new User();
        $email = $user->email = 'email@domain.com';
        $nome = $user->name = 'name';
        $senha = $user->password = Hash::make('senha');
        $user->save();

        $this->post('/api/login', ['email' => $email, 'password' => $senha]);

        $this->seeStatusCode(200);
    }

    public function testDeveRegistrarUmUsuario()
    {
        $user = new User();
        $email = $user->email = 'emailll@domain.com';
        $nome = $user->name = 'name';
        $senha = $user->password = Hash::make('senha');
        $dados = [
            'email' => $email,
            'name' => $nome,
            'password' => $senha
        ];

        $this->post('/api/registrar', $dados);
        $this->seeInDatabase('users', ['email' => 'emailll@domain.com']);
        $this->seeStatusCode(308);
    }
}