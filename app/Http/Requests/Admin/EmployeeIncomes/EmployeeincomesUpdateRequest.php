<?php

namespace App\Http\Requests\Admin\EmployeeIncomes;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeincomesUpdateRequest extends FormRequest
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
            'contractoremployee_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'admission_date' => 'Fecha ingreso',
            'departure_date' => 'Fecha salida',
            'contractoremployee_id' => 'empleado del contratista',
        ];
    }

    public function messages()
    {
        return [
            'admission_date.required' => 'La fecha de ingreso es obligatorio',
            'departure_date.required' => 'La fecha de salida es obligatorio',
            'contractoremployee_id.required' => 'El empleado del contratista es obligatorio',
        ];
    }
}
