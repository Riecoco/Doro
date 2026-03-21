<?php

namespace App\Models\Enums;

enum Role: string
{
    case Admin = 'admin';
    case User = 'user';
}
