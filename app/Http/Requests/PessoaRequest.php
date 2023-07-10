<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PessoaRequest extends FormRequest
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
            'nome' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'endereco' => 'required|string',
            'telefone' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            "required" => 'O campo :attribute é obrigatório.',
            "string" => 'O campo :attribute deve ser uma string.',
            "max" => 'O campo :attribute deve conter no máximo :max caracteeres',
            "email" => 'O campo :attribute é inválido.',
            "unique" => 'O :attribute já existe.',
        ];
    }
}
