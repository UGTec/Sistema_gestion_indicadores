<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'usuario' => [
                'required',
                'string',
                'max:40',
                Rule::unique('usuario', 'usuario')
            ],
            'nombre'             => 'required|string|max:40',
            'primer_apellido'    => 'required|string|max:40',
            'segundo_apellido'   => 'nullable|string|max:40',
            'correo_electronico' => [
                'required',
                'email',
                'max:70',
                Rule::unique('usuario', 'correo_electronico')
            ],
            'cod_perfil'         => 'required|exists:perfil,cod_perfil',
            'cod_departamento'   => 'required|exists:departamento,cod_departamento',
            'cod_estado_usuario' => 'required|exists:estado_usuario,cod_estado_usuario'
        ];
    }

    public function messages()
    {
        return [
            'usuario.required'            => 'El nombre de usuario es obligatorio.',
            'usuario.unique'              => 'Este nombre de usuario ya está en uso.',
            'nombre.required'             => 'El nombre es obligatorio.',
            'primer_apellido.required'    => 'El primer apellido es obligatorio.',
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.unique'   => 'Este correo electrónico ya está registrado.',
            'cod_perfil.required'         => 'Debe seleccionar un perfil.',
            'cod_departamento.required'   => 'Debe seleccionar un departamento.',
            'cod_estado_usuario.required' => 'Debe seleccionar un estado.'
        ];
    }

    // public function prepareForValidation()
    // {
    //     if ($this->segundo_apellido == null) {
    //         $this->merge([
    //             'segundo_apellido' => ''
    //         ]);
    //     }
    // }
}
