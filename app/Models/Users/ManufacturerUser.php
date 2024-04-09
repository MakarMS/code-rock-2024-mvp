<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManufacturerUser extends User
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'email',
        'email_verified_at',
        'password'
    ];
}
