<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PointRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'city' => 'required|integer|exists:cities,id',
            'type' => 'required|integer|between:1,2',
        ];
    }
}
