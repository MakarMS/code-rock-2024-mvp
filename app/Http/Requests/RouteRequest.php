<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RouteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'departure_point' => 'required|integer|min:1',
            'arrival_point' => 'required|integer|min:1',
            'cost' => 'required|integer|min:0',
            'length_delivery' => 'required|integer|min:0',
            'distance' => 'required|integer|min:0',
        ];
    }
}
