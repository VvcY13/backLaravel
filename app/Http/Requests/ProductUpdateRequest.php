<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'nombreProd' => 'required|string|max:255',
            'marcaProd' => 'required|string|max:255',
            'presentacionProd' => 'required|string|max:255',
            'precioCompraProd' => 'required|numeric',
            'precioVentaProd' => 'required|numeric',
            'stockProd' => 'required|numeric',
            'imagenProd' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'nombreProd.required' => 'El campo nombre del producto es obligatorio.',
            'marcaProd.required' => 'El campo marca del producto es obligatorio.',
            'presentacionProd.required' => 'El campo presentación del producto es obligatorio.',
            'precioCompraProd.required' => 'El campo precio de compra es obligatorio.',
            'precioVentaProd.required' => 'El campo precio de venta es obligatorio.',
            'stockProd.required' => 'El campo stock es obligatorio.',
            'imagenProd.image' => 'El campo imagen debe ser una imagen válida.',
        ];
    }
}
