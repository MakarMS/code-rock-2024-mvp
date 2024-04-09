<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class ManufacturerRegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|max:50'
        ];
    }
}
