<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UsuarioUpdateRequest extends FormRequest
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
        if ($this->filled('password')) {
            return [
                'nome' => 'required|string|max:50',
                'usuario' => [
                    'required',
                    'string',
                    'max:25',
                    Rule::unique('users')->ignore($this->id)
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($this->id)
                ],
                'password' => [
                    'required',
                    'string',
                    'confirmed',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised(),
                ],
                'password_confirmation' => 'required|same:password'
            ];
        } else {
            return [
                'nome' => 'required|string|max:50',
                'usuario' => [
                    'required',
                    'string',
                    'max:25',
                    Rule::unique('users')->ignore($this->id)
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($this->id)
                ],
            ];
        }
    }

    public function messages()
    {
        return [
            "required" => 'O campo :attribute é obrigatório.',
            "string" => 'O campo :attribute deve ser uma string.',
            "max" => 'O campo :attribute deve conter no máximo :max caracteeres',
            "email" => 'O campo :attribute é inválido.',
            "unique" => 'O :attribute já existe.',
            "confirmed" => 'O campo :attribute não confere com o password de confirmação.',
            "min" => 'O campo :attribute deve conter no mínimo :min caracteres.',
            "letters" => 'A :attribute deve conter pelo menos uma letra ',
            "mixed_case" => 'A :attribute deve conter pelo menos uma letra maiúscula e uma minúscula.',
            "numbers" => 'A :attribute deve conter pelo menos um número.',
            "symbols" => 'A :attribute deve conter pelo menos um símbolo.',
            "uncompromised" => 'A :attribute parece ja ter sido vazada.',
            "same" => 'O campo de :attribute não confere com a senha.'
        ];
    }
}
