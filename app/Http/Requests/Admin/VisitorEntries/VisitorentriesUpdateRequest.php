<?php

namespace App\Http\Requests\Admin\VisitorEntries;

use Illuminate\Foundation\Http\FormRequest;

class VisitorentriesUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'admission_date' => 'required',
            'departure_date' => 'required',
            'visit_type' => 'required',
            'note' => 'nullable',
            'unit_id' => 'required',
            'state_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'admission_date' => 'Ingreso',
            'departure_date' => 'Salida',
            'visit_type' => 'Tipo de visita',
            'note' => 'Nota',
            'unit_id' => 'Unidad',
            'state_id' => 'Estado',
        ];
    }

    public function messages()
    {
        return [
            'admission_date.required' => 'El ingreso del visitante es obligatorio',
            'departure_date.required' => 'La salida del visitante  es obligatoria',
            'visit_type.required' => 'El tipo de visita es obligatorio',
            'note.nullable' => 'La nota no es obligatoria',
            'unit_id.required' => 'La unidad es obligatoria',
            'state_id.required' => 'El estado es obligatorio',
        ];
    }
}
