<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRoleRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('gerenciar-usuarios');
    }

    public function rules()
    {
        return [
            'role' => ['required', 'string', 'in:admin,editor,viewer'],
        ];
    }

    public function messages()
    {
        return [
            'role.required' => 'Informe a permissão.',
            'role.in' => 'Permissão inválida. Use: admin, editor ou viewer.',
        ];
    }
}
