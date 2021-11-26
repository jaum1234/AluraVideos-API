<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Urameshibr\Requests\FormRequest;

class RegistroFormRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'name' => 'required',
            'email' => 'email|unique:users,email|required',
            'password' => 'required',
		];
    }

	public function messages()
	{
		return [
			'required' => 'Esse campo é obrigatório',
            'email' => 'O e-mail nao é valido',
            'unique' => 'Esse e-mail já foi cadastrado'
		];
	}
}
	