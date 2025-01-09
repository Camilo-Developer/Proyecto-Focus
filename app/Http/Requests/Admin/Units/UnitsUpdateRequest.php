<?php

namespace App\Http\Requests\Admin\Units;

use Illuminate\Foundation\Http\FormRequest;

class UnitsUpdateRequest extends FormRequest
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
            'name' => 'Nombre',
            'state_id' => 'Estado',
            'agglomeration_id' => 'Aglomeración',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre de la unidad es obligatorio',
            'state_id.required' => 'El estado de la unidad es obligatorio',
            'agglomeration_id.required' => 'La aglomeración de la unidad es obligatoria',
        ];
    }
}
