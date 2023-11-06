<?php

namespace App\Enums;

enum ScheduleType: string
{
    case REALIZED = 'realized';
    case CONFIRMED = 'confirmed';
    case CANCELED = 'canceled';
}
