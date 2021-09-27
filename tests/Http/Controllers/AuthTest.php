<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseTransactions;

Class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function testDeveLogarUmUsuario()
    {
        $user = User::factory()->create();

        $this->post('/api/login', ['email' => $user->email, 'password' => '123']);
        $this->seeJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
        $this->seeStatusCode(200);
        $this->assertTrue(Hash::check('123', $user->password));
    }
}