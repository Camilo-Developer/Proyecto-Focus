<?php

namespace App\Http\Requests\Admin\ElementEntries;

use Illuminate\Foundation\Http\FormRequest;

class ElemententriesCreateRequest extends FormRequest
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
            'admission_date' => 'required',
            'departure_date' => 'required',
            'note' => 'required',
            'element_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'admission_date' => 'Fecha ingreso',
            'departure_date' => 'Fecha salida',
            'note' => 'Nota',
            'element_id' => 'Elemento',
        ];
    }

    public function messages()
    {
        return [
            'admission_date.required' => 'La fecha de ingreso es obligatorio',
            'departure_date.required' => 'La fecha de salida es obligatorio',
            'note.required' => 'La nota es obligatorio',
            'element_id.required' => 'El elemento es obligatorio',
        ];
    }
}
