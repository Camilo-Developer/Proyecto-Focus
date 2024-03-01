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
            'plate' => 'required',
            'owner' => 'required',
            'state_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'plate' => 'Placa',
            'owner' => 'Propietario',
            'state_id' => 'Estado',
        ];
    }

    public function messages()
    {
        return [
            'plate.required' => 'La placa es obligatorio',
            'owner.required' => 'El propietario es obligatorio',
            'state_id.required' => 'El estado es obligatorio',
        ];
    }
}
