<?php

namespace App\Enums;

enum UserType: string
{
    case MANAGER = 'manager';
    case CLIENT = 'client';
}
