<?php

namespace App\Http\Requests\Admin\Shifts;

use Illuminate\Foundation\Http\FormRequest;

class ShiftsCreateRequest extends FormRequest
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
            'setresidencial_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'state_id' => 'Estado',
            'setresidencial_id' => 'Conjunto',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del turno es obligatorio',
            'state_id.required' => 'El estado del turno es obligatorio',
            'setresidencial_id.required' => 'El conjunto del turno es obligatorio',
        ];
    }
}
