<?php

namespace App\Http\Requests\Admin\ElementEntrys;

use Illuminate\Foundation\Http\FormRequest;

class ElementEntryCreateRequest extends FormRequest
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
            'admission_date' => 'Fecha de ingreso',
            'departure_date' => 'Fecha de retiro',
            'note' => 'Nota',
            'element_id' => 'Elemento',
        ];
    }

    public function messages()
    {
        return [
            'admission_date.required' => 'Fecha obligatoria',
            'departure_date.required' => 'Fecha obligatoria',
            'note.required' => 'Nota obligatoria',
            'element_id.required' => '***',
        ];
    }

}
