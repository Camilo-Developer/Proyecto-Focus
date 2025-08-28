<?php

namespace App\Http\Requests\Admin\Vehicles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class VehiclesCreateRequest extends FormRequest
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
            'placa' => [
                'required',
                Rule::unique('vehicles')
                    ->where(function ($query) {
                        return $query->where('setresidencial_id', $this->setresidencial_id);
                    }),
            ],
            'imagen' => 'required_without:imagen_file',
            'imagen_file' => 'required_without:imagen|image|mimes:jpeg,png,jpg',
            'state_id' => 'required',
            'units' => ['array', 'exists:units,id'],
            'visitors' => ['array', 'exists:visitors,id'],
            'setresidencial_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'imagen' => 'IMAGEN',
            'imagen_file' => 'ARCHIVO DE IMAGEN',
            'placa' => 'PLACA',
            'state_id' => 'ESTADO',
            'setresidencial_id' => 'CONJUNTO',
        ];
    }

    public function messages()
    {
        return [
            'imagen.required_without' => 'DEBE TOMAR UNA FOTO O SUBIR UNA IMAGEN.',
            'imagen_file.required_without' => 'DEBE TOMAR UNA FOTO O SUBIR UNA IMAGEN.',
            'imagen_file.image' => 'EL ARCHIVO DEBE SER UNA IMAGEN.',
            'imagen_file.mimes' => 'LA IMAGEN DEBE SER DE TIPO: jpeg, jpg o png.',
            'state_id.required' => 'EL ESTADO ES OBLIGATORIO',
            'setresidencial_id.required' => 'EL CONJUNTO ES OBLIGATORIO',
            'placa.required' => 'LA PLACLA DEL VEHICULO ES OBLIGATORIO',
            'placa.unique' => 'YA EXISTE UN VEHICULO CON ESTÁ PLACA EN EL MISMO CONJUNTO.',
        ];
    }
}
