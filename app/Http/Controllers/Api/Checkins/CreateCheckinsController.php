<?php

namespace App\Http\Controllers\Api\Checkins;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkins\CreateCheckinRequest;
use App\Models\Checkin;
use App\Models\Schedule;
use Carbon\Carbon;

class CreateCheckinsController extends Controller
{
    public function __invoke(CreateCheckinRequest $request)
    {
        $data = $request->all();
        $clientId = auth()->user()->client->id;

        

        if (auth()->user()->active == false) {
            return response()->json(['message' => 'Não foi possível realizar o agendamento. Entre em contato com a administração.'], 422);
        }

        $day = Carbon::createFromFormat('Y-m-d', $data['checkin_date']);

        $schedule = Schedule::with('checkins')->where('day_of_week', $day->dayOfWeek)->where('hour', $data['hour'])->first();

        $request['hour'] = $day->addHour(1)->format('H:i');
        $open = ($day->isToday() && $schedule->hour > $request['hour']) || (!$day->isToday());

        
        $checkinVerify = Checkin::where('client_id', $clientId)->where('checkin_date', $day->format('Y-m-d'))->where('hour', $schedule->hour)->where('canceled_at', null)->count();
        
        if ($checkinVerify >= 1 ) {
            return response()->json(['message' => 'Aula já agendada, tente outro horário'], 422);
        }

        if (! $open) {
            return response()->json(['message' => 'Aula não está mais disponível, tente outro horário'], 422);
        }

        if ($schedule->checkins->count() >= $schedule->limit) {
            return response()->json(['message' => 'Aula está com limite completo, tente outro horário'], 422);
        }

        $data['client_id'] = $clientId;
        $checkin = Checkin::create($data);

        return response()->json(['data' => $checkin], 201);
    }
}
