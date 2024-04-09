<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuyerUser extends User
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic',
        'email',
        'email_verified_at',
        'password'
    ];
}
