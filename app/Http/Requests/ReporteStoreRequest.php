<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReporteStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('reportes.informar');
    }

    public function rules(): array
    {
        return [
            'numerador' => 'required|numeric|min:0',
            'denominador' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
            'adjuntos.*' => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png,svg,gif',
        ];
    }
}
