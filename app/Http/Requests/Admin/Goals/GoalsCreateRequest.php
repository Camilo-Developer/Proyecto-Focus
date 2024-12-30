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
            'users' => ['array', 'exists:users,id'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'NOMBRE',
            'state_id' => 'ESTADO PORTERIA',
            'setresidencial_id' => 'CONJUNTO',
            'users' => 'USUARIO',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'EL NOMBRE ES OBLIGATORIO',
            'state_id.required' => 'EL ESTADO ES OBLIGATORIO',
            'setresidencial_id.required' => 'EL CONJUNTO ES OBLIGATORIO',
        ];
    }




}
