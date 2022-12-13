<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|max:255'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.max' => 'Este campo debe contener un máximo de 255 caracteres',
            'email.required' => 'El correo es requerido',
            'email.email' => 'El correo debe tener un formato válido',
            'email.max' => 'El correo debe tener un máximo de 255 caracteres',
            'email.unique' => 'Este correo ya se encuentra registrado',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe contener un mínimo de 8 caracteres',
            'password.max' => 'La contraseña debe contener un máximo de 255 caracteres',
        ];
    }
}
