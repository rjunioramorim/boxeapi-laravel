<?php

namespace App\Enums;

enum ScheduleType: string
{
    case SCHEDULED = 'scheduled';
    case CONFIRMED = 'confirmed';
    case CANCELED = 'canceled';
    case OFF = 'off';
}
