<?php

namespace App\Http\Requests\Admin\Visitors;

use Illuminate\Foundation\Http\FormRequest;

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
            'lastname' => 'required',
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Nombre visitante',
            'lastname' => 'apellido visitante',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre del visitante es obligatorio',
            'lastname.required' => 'El apellido del visitante es obligatorio',
        ];
    }
}
