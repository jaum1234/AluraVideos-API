<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Urameshibr\Requests\FormRequest;

class CategoriaFormRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'titulo' => 'required|sometimes',
			'cor' => 'required|sometimes'
		];
    }

	public function messages()
	{
		return [
			'required' => 'Esse campo é obrigatório'
		];
	}
}
	