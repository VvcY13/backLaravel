<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuejasCreateRequest extends FormRequest
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
            'id_personal' => 'required|exists:users,id',
            'asunto' => 'required|in:Quejas,Sugerencias,Opiniones',
            'comentario' => 'required|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'id_personal.required' => 'El campo id_personal es obligatorio.',
            'id_personal.exists' => 'El id_personal especificado no existe.',
            'asunto.required' => 'El campo asunto es obligatorio.',
            'asunto.in' => 'El asunto debe ser uno de: Quejas, Sugerencias, Opiniones.',
            'comentario.required' => 'El campo comentario es obligatorio.',
            'comentario.string' => 'El campo comentario debe ser una cadena de texto.',
            'comentario.max' => 'El campo comentario no debe exceder los 255 caracteres.',
        ];
    }
}
