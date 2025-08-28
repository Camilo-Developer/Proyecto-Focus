<?php

namespace App\Http\Requests\Admin\Visitors;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VisitorsUpdateRequest extends FormRequest
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
            'phone' => 'nullable',
            'address' => 'nullable',
            'document_number' => [
                'required',
                Rule::unique('visitors')
                    ->where(function ($query) {
                        return $query->where('setresidencial_id', $this->setresidencial_id);
                    })
                    ->ignore($this->route('visitor')), 
            ],
            'confirmation' => 'required',
            'imagen' => 'nullable|required_without:imagen_file',
            'imagen_file' => 'nullable|required_without:imagen|image|mimes:jpeg,png,jpg',
            'state_id' => 'required',
            'type_user_id' => 'required',
            'company_id' => 'nullable',
            'setresidencial_id' => 'required',
            'units' => ['array', 'exists:units,id'],
            'vehicles' => ['array', 'exists:vehicles,id'],
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'NOMBRE',
            'phone' => 'TELÉFONO',
            'address' => 'DIRECCIÓN',
            'document_number' => 'NÚMERO DOCUMENTO',
            'confirmation' => 'CONFIRMACIÓN',
            'imagen' => 'IMAGEN',
            'imagen_file' => 'ARCHIVO DE IMAGEN',
            'state_id' => 'ESTADO',
            'type_user_id' => 'TIPO DE USAURIO',
            'company_id' => 'EMPRESA',
            'setresidencial_id' => 'CONJUNTO',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'EL NOMBRE ES OBLIGATORIO',
            'phone.nullable' => 'EL TELÉFONO ES OBLIGATORIO',
            'address.nullable' => 'LA DIRECCIÓN ES OBLIGATORIA',
            'document_number.required' => 'EL NÚMERO DE DOCUMENTO ES OBLIGATORIO',
            'document_number.unique' => 'YA EXISTE UN VISITANTE CON ESTE NÚMERO DE DOCUMENTO EN EL MISMO CONJUNTO.',
            'confirmation.required' => 'LA CONFIRMACIÓN ES OBLIGATORIA',
            'imagen.required_without' => 'DEBE TOMAR UNA FOTO, SUBIR UNA IMAGEN O CONSERVAR LA ACTUAL.',
            'imagen_file.required_without' => 'DEBE TOMAR UNA FOTO, SUBIR UNA IMAGEN O CONSERVAR LA ACTUAL.',
            'imagen_file.image' => 'EL ARCHIVO DEBE SER UNA IMAGEN.',
            'imagen_file.mimes' => 'LA IMAGEN DEBE SER DE TIPO: jpeg, jpg o png.',
            'state_id.required' => 'EL ESTADO ES OBLIGATORIO',
            'type_user_id.required' => 'EL TIPO DE DOCUMENTO ES OBLIGATORIO',
            'company_id.nullable' => 'LA EMPRESA ES OBLIGATORIA',
            'setresidencial_id.required' => 'EL CONJUNTO ES OBLIGATORIO',
        ];
    }
}
