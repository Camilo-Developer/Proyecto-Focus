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
            'phone' => 'required',
            'address' => 'required',
            'document_number' => [
                'required',
                Rule::unique('visitors')
                    ->where(function ($query) {
                        return $query->where('setresidencial_id', $this->setresidencial_id);
                    })
                    ->ignore($this->route('visitor')), 
            ],
            'confirmation' => 'required',
            'imagen' => 'nullable',
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
            'phone.required' => 'EL TELÉFONO ES OBLIGATORIO',
            'address.required' => 'LA DIRECCIÓN ES OBLIGATORIA',
            'document_number.required' => 'EL NÚMERO DE DOCUMENTO ES OBLIGATORIO',
            'document_number.unique' => 'YA EXISTE UN VISITANTE CON ESTE NÚMERO DE DOCUMENTO EN EL MISMO CONJUNTO.',
            'confirmation.required' => 'LA CONFIRMACIÓN ES OBLIGATORIA',
            'imagen.nullable' => 'LA IMAGEN ES OBLIGATORIA',
            'state_id.required' => 'EL ESTADO ES OBLIGATORIO',
            'type_user_id.required' => 'EL TIPO DE DOCUMENTO ES OBLIGATORIO',
            'company_id.nullable' => 'LA EMPRESA ES OBLIGATORIA',
            'setresidencial_id.required' => 'EL CONJUNTO ES OBLIGATORIO',
        ];
    }
}
