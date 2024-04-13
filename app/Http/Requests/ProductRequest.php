<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_name' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|file',
            'cost' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'depth' => 'required|numeric|min:0',
            'mass' => 'required|numeric|min:0',
        ];
    }
}
