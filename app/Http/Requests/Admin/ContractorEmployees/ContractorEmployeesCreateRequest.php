<?php

namespace App\Http\Requests\Admin\ContractorEmployees;

use Illuminate\Foundation\Http\FormRequest;

class ContractorEmployeesCreateRequest extends FormRequest
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
            'name' => 'required',
            'state_id' => 'required',
            'contractor_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'state_id' => 'Estado',
            'contractor_id' => 'Contratista',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del empleado es obligatorio',
            'state_id.required' => 'El estado del empleado es obligatorio',
            'contractor_id.required' => 'El contratista es obligatorio',
        ];
    }
}
