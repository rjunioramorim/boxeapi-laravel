<?php

namespace App\Http\Controllers\Api\Checkins;

use App\Enums\ScheduleType;
use App\Http\Controllers\Controller;
use App\Models\Checkin;

class CancelCheckinsController extends Controller
{
    public function __invoke(Checkin $checkin)
    {
        $day = now();
        $hour = $day->format('H:m');

        if ($checkin->checkin_date <= $day->format('Y-m-d')) {
            if ($checkin->hour <= $hour) {
                return response()->json(['message' => 'Não é possível cancelar esse agendamento, aula já iniciada.'], 422);
            }
        }
        if ($checkin->status == ScheduleType::CONFIRMED->value) {
            return response()->json(['message' => 'Não é possível cancelar esse agendamento, aula já confirmada.'], 422);
        }


        $checkin->status = ScheduleType::CANCELED->value;
        $checkin->save();

        return response()->noContent();
        // return response()->json([], 204);
    }
}
