<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Urameshibr\Requests\FormRequest;

class LoginFormRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
            'email' => 'email|required',
            'password' => 'required',
		];
    }

	public function messages()
	{
		return [
			'required' => 'Esse campo é obrigatório',
            'email' => 'O e-mail nao é valido',
		];
	}
}
	