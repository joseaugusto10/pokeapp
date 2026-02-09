<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PokemonImportRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('importar-pokemon');
    }

    public function rules(): array
    {
        return [
            'api_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:100'],
            'height' => ['nullable', 'integer'],
            'weight' => ['nullable', 'integer'],
            'sprite' => ['nullable', 'string'],
            'types' => ['nullable', 'array'],
            'types.*' => ['string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'api_id.required' => 'Pokémon inválido.',
            'name.required' => 'Nome do Pokémon é obrigatório.',
        ];
    }
}
