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
			'titulo' => 'required|sometimes',
            'descricao' => 'required|sometimes',
            'url' => 'required|sometimes',
		];
    }

	public function messages()
	{
		return [
			'required' => 'Esse campo é obrigatório'
		];
	}
}
	