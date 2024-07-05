<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->route('user'),
            'password' => 'sometimes|string|min:8', // 'sometimes' para permitir omitir la contraseña en la edición
            'direccion' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'distrito' => 'required|string|max:255',
            'tipo_documento' => 'required|in:tipo_documento,DNI,Carnet_Extranjeria',
            'numero_documento' => 'required|string|max:255|unique:users,numero_documento,' . $this->route('user'),
        ];
    }
    public function messages()
    {
        return [
            'nombres.required' => 'El campo nombres es obligatorio.',
            'nombres.string' => 'El campo nombres debe ser una cadena de texto.',
            'nombres.max' => 'El campo nombres no debe exceder los 255 caracteres.',
            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'apellidos.string' => 'El campo apellidos debe ser una cadena de texto.',
            'apellidos.max' => 'El campo apellidos no debe exceder los 255 caracteres.',
            'email.required' => 'El campo email es obligatorio.',
            'email.string' => 'El campo email debe ser una cadena de texto.',
            'email.email' => 'El campo email debe ser una dirección de correo válida.',
            'email.max' => 'El campo email no debe exceder los 255 caracteres.',
            'email.unique' => 'El email ya está registrado.',
            'password.sometimes' => 'El campo password es opcional.',
            'password.string' => 'El campo password debe ser una cadena de texto.',
            'password.min' => 'El campo password debe tener al menos 8 caracteres.',
            'direccion.required' => 'El campo direccion es obligatorio.',
            'direccion.string' => 'El campo direccion debe ser una cadena de texto.',
            'direccion.max' => 'El campo direccion no debe exceder los 255 caracteres.',
            'provincia.required' => 'El campo provincia es obligatorio.',
            'provincia.string' => 'El campo provincia debe ser una cadena de texto.',
            'provincia.max' => 'El campo provincia no debe exceder los 255 caracteres.',
            'distrito.required' => 'El campo distrito es obligatorio.',
            'distrito.string' => 'El campo distrito debe ser una cadena de texto.',
            'distrito.max' => 'El campo distrito no debe exceder los 255 caracteres.',
            'tipo_documento.required' => 'El campo tipo_documento es obligatorio.',
            'tipo_documento.in' => 'El campo tipo_documento debe ser uno de los siguientes: tipo_documento, DNI, Carnet_Extranjeria.',
            'numero_documento.required' => 'El campo numero_documento es obligatorio.',
            'numero_documento.string' => 'El campo numero_documento debe ser una cadena de texto.',
            'numero_documento.max' => 'El campo numero_documento no debe exceder los 255 caracteres.',
            'numero_documento.unique' => 'El numero_documento ya está registrado.',
        ];
    }
}
