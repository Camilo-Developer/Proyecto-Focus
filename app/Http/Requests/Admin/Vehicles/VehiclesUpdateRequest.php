<?php

namespace App\Http\Requests\Admin\Vehicles;

use Illuminate\Foundation\Http\FormRequest;

class VehiclesUpdateRequest extends FormRequest
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
            'placa' => 'required',
            'state_id' => 'required',
            'units' => ['array', 'exists:units,id'],
            'visitors' => ['array', 'exists:visitors,id'],
            'setresidencial_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'placa' => 'Placa',
            'state_id' => 'Estado',
            'setresidencial_id' => 'CONJUNTO',
        ];
    }

    public function messages()
    {
        return [
            'placa.required' => 'LA PLACA ES OBLIGATORIA',
            'state_id.required' => 'EL ESTADO ES OBLIGATORIO',
            'setresidencial_id.required' => 'EL CONJUNTO ES OBLIGATORIO',
        ];
    }
}
