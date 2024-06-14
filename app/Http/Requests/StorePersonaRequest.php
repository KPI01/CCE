<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaRequest extends FormRequest
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
            //
            'nombres' => ['required', 'string', 'max:50'],
            'apellidos' => ['required', 'string', 'max:50'],
            'tipo_id_nac' => ['required', 'string', 'max:3'],
            'id_nac' => ['required', 'string', 'max:12', 'unique:personas'],
            'email' => ['required', 'string', 'email', 'max:254', 'unique:personas'],
            'tel' => ['nullable', 'string', 'max:20'],
            'perfil' => ['nullable', 'string', 'max:10'],
            'observaciones' => ['nullable', 'string', 'max:300'],

        ];
    }
}
