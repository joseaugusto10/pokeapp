<?php

namespace App\Http\Requests\PokeApi;

use Illuminate\Foundation\Http\FormRequest;

class PokemonSearchRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('listar-pokemon');
    }

    public function rules(): array
    {
        return [
            'pesquisa' => ['nullable', 'string', 'min:1', 'max:40'],
        ];
    }

    public function messages(): array
    {
        return [
            'pesquisa.min' => 'Informe pelo menos 1 caractere para a busca.',
            'pesquisa.max' => 'A busca deve ter no máximo 40 caracteres.',
        ];
    }
}
