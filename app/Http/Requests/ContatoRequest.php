<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ContatoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'nome' => 'required|max:200',
            'email' => 'required|email|unique:contatos,email'
        ];
    }
    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => 'O campo nome cliente deve ter no máximo :max caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.unique' => 'Já possui um contato com este e-mail cadastrado',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação',
            'errors' => $errors
        ], 422));


    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

}
