<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('gerenciar-usuarios');
    }

    public function rules()
    {
        $id = $this->route('user') ?? $this->route('id') ?? null;

        return [
            'name' => ['required', 'string', 'min:3', 'max:120'],
            'email' => ['required', 'email', 'max:180', 'unique:users,email,' . $id],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Informe o nome.',
            'name.min' => 'O nome precisa ter pelo menos 3 caracteres.',
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Esse e-mail já está em uso.',
        ];
    }
}
