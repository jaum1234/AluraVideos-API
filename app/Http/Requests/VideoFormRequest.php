<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Urameshibr\Requests\FormRequest;

class VideoFormRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'titulo' => 'required',
            'descricao' => 'required',
            'url' => 'required',
		];
    }

	public function messages()
	{
		return [
			'required' => 'Esse campo é obrigatório'
		];
	}
}
	