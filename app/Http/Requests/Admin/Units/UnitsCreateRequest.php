<?php

namespace App\Http\Requests\Admin\Units;

use Illuminate\Foundation\Http\FormRequest;

class UnitsCreateRequest extends FormRequest
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
            'agglomeration_id' => 'required',
            'visitors' => ['array', 'exists:visitors,id'],
            'vehicles' => ['array', 'exists:vehicles,id'],

        ];
    }

    public function attributes()
    {
        return [
            'name' => 'NOMBRE',
            'state_id' => 'ESTADO',
            'agglomeration_id' => 'AGLOMERACIÓN',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'EL NOMBRE DE LA UNIDAD ES OBLIGATORIO',
            'state_id.required' => 'EL ESTADO ES OBLIGATORIO',
            'agglomeration_id.required' => 'LA AGLOMERACIÓN ES OBLIGATORIA',
        ];
    }
}
