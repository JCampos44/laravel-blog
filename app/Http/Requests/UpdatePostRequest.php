<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'id' => 'required|exists:posts,id',
            'title' => 'required|unique:posts,title,' . $this->id,
            'content' => 'required',
            'status' => 'required|integer|between:1,2',
            'photo' => 'image'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Debe especificar cual post editar',
            'id.exists' => 'El post indicado no existe',
            'title.required' => 'El título es requerido',
            'title.unique' => 'Ya existe otro post con este título',
            'content.required' => 'El contenido es requerido',
            'status.required' => 'Debe seleccionar un estado',
            'status.integer' => 'Debe seleccionar un estado',
            'status.between' => 'Debe seleccionar un estado',
            'photo.image' => 'Debe subir una imagen'
        ];
    }
}
