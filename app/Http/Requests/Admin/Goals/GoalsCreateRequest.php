<?php

namespace App\Http\Requests\Admin\Goals;

use Illuminate\Foundation\Http\FormRequest;

class GoalsCreateRequest extends FormRequest
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
            'setresidencial_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'state_id' => 'Estado Goal',
            'setresidencial_id' => 'Goals Set residenciasl',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nombre',
            'state_id.required' => 'Estado Goal',
            'setresidencial_id.required' => 'Goals Set residenciasl',
        ];
    }




}
