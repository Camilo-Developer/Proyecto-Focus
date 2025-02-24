<?php

namespace App\Http\Requests\Admin\Visitors;

use Illuminate\Foundation\Http\FormRequest;

class VisitorsCreateRequest extends FormRequest
{
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
            'document_number' => 'required',
            'confirmation' => 'required',
            'imagen' => 'required',
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
            'phone.nullable' => 'EL TELÉFONO ES OBLIGATORIO',
            'address.nullable' => 'LA DIRECCIÓN ES OBLIGATORIA',
            'document_number.required' => 'EL NÚMERO DE DOCUMENTO ES OBLIGATORIO',
            'confirmation.required' => 'LA CONFIRMACIÓN ES OBLIGATORIA',
            'imagen.required' => 'LA IMAGEN ES OBLIGATORIA',
            'state_id.required' => 'EL ESTADO ES OBLIGATORIO',
            'type_user_id.required' => 'EL TIPO DE DOCUMENTO ES OBLIGATORIO',
            'company_id.nullable' => 'LA EMPRESA ES OBLIGATORIA',
            'setresidencial_id.required' => 'EL CONJUNTO ES OBLIGATORIO',
        ];
    }
}
