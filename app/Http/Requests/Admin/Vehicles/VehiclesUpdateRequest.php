<?php

namespace App\Http\Requests\Admin\Vehicles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'imagen' => 'nullable',
            'placa' => [
                'required',
                Rule::unique('vehicles')
                    ->where(function ($query) {
                        return $query->where('setresidencial_id', $this->setresidencial_id);
                    })
                    ->ignore($this->route('vehicle')), 
            ],
            'state_id' => 'required',
            'units' => ['array', 'exists:units,id'],
            'visitors' => ['array', 'exists:visitors,id'],
            'setresidencial_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'placa' => 'PLACA',
            'state_id' => 'ESTADO',
            'setresidencial_id' => 'CONJUNTO',
        ];
    }

    public function messages()
    {
        return [
            'state_id.required' => 'EL ESTADO ES OBLIGATORIO',
            'setresidencial_id.required' => 'EL CONJUNTO ES OBLIGATORIO',
            'placa.required' => 'LA PLACA DEL VEHICULO ES OBLIGATORIA',
            'placa.unique' => 'YA EXISTE UN VEHICULO CON ESTÁ PLACA EN EL MISMO CONJUNTO.',
        ];
    }
}
