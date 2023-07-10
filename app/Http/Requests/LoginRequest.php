<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            "required" => 'O campo :attribute é obrigatório.',
            "string" => 'O campo :attribute deve ser uma string.',
            "max" => 'O campo :attribute deve conter no máximo :max caracteeres',
            "email" => 'O campo :attribute é inválido.',
        ];
    }
}
