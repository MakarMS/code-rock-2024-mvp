<?php

namespace App\Enums;

enum AuthCodes: int
{
    case NOT_UNIQUE_EMAIL = 1;
    case WRONG_LOGIN = 2;
}
