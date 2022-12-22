<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'title' => 'required|unique:posts,title',
            'content' => 'required',
            'photo' => 'required|image'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'El título es requerido',
            'title.unique' => 'Ya existe otro post con este título',
            'content.required' => 'El contenido es requerido',
            'photo.required' => 'Debe subir una foto para el post',
            'photo.image' => 'Debe subir una imagen'
        ];
    }
}
