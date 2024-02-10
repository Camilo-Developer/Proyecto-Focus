<?php

namespace App\Http\Requests\Admin\Elements;

use Illuminate\Foundation\Http\FormRequest;

class ElementsCreateRequest extends FormRequest
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
            'contractoremployee_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'contractoremployee_id' => 'Empleado contratista',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del elemento es obligatorio',
            'contractoremployee_id.required' => 'El empleado del contratista es obligatorio',
        ];
    }
}
