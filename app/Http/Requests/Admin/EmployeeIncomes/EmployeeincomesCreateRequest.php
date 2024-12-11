<?php

namespace App\Http\Requests\Admin\EmployeeIncomes;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeincomesCreateRequest extends FormRequest
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
            'departure_date' => 'nullable',
            'nota' => 'nullable',
            'visitor_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'admission_date' => 'FECHA INGRESO',
            'departure_date' => 'FECHA SALIDA',
            'nota' => 'NOTA',
            'visitor_id' => 'VISITANTE',
        ];
    }

    public function messages()
    {
        return [
            'admission_date.required' => 'LA FECHA DE INGRESO ES OBLIGATORIA',
            'departure_date.nullable' => 'LA FECHA DE SALIDA ES OBLIGATORIA',
            'nota.nullable' => 'LA NOTA ES OBLIGATORIA',
            'visitor_id.required' => 'EL VISITANTE ES OBLIGATORIO',
        ];
    }
}
