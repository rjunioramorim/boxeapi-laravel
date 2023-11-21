<?php

namespace App\Http\Controllers\Api\Schedules;

use App\Enums\ScheduleType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Schedules\ListScheduleResource;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ListSchedulesController extends Controller
{
    public function __invoke(Request $request)
    {
        $date = $request->day ? Carbon::createFromFormat('Y-m-d', $request->day) : now();

        $request['isToday'] = $date->isToday();
        $request['hour'] = $date->addMinutes(10)->format('H:i');
        $request['day'] = $date->format('Y-m-d');

        $dayOfWeek = $date->dayOfWeek;

        if ($date->isPast()) {
            return response()->json(['data' => []]);
        }
        
        $schedules = Schedule::with(['checkins'], function ($query) use ($date) {
            return $query->where('checkins.status', '!==', ScheduleType::CANCELED->value)->where('checkins.checkin_date', $date->format('Y-m-d'));
        })->where('day_of_week', $dayOfWeek)->get();

        
        $clientId = auth()->user()->client->id;
        $schedules->each(function ($schedule) use ($clientId) {
           $schedule->status = $schedule->checkins->where('client_id', $clientId)->pluck('status')->last();
        });
        
        $isEvent = $schedules->whereNotNull('event_date');

        if ($isEvent->count() > 0) {
            return ListScheduleResource::collection($isEvent);
        }

        $schedules = $schedules->whereNull('event_date')->all();

        return ListScheduleResource::collection($schedules);
    }
}
