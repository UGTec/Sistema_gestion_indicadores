<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndicadorStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('indicadores.crear');
    }

    public function rules(): array
    {
        return [
            'indicador'          => 'required|string|max:4098',
            'objetivo'           => 'required|string|max:4098',
            'cod_tipo_indicador' => 'required|integer',
            'parametro1'         => 'nullable|string|max:1024',
            'parametro2'         => 'nullable|string|max:1024',
            'meta'               => 'required|numeric|min:0|max:100',
            'cod_usuario'        => 'required|integer|exists:usuario,cod_usuario',
        ];
    }
}
