<?php

namespace App\Http\Controllers\Api\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Resources\Schedules\DetailScheduleResource;
use App\Models\Schedule;
use Illuminate\Http\Request;

class DetailSchedulesController extends Controller
{
    public function __invoke(Schedule $schedule, Request $request)
    {
        $day = $request->day;
        $schedule = Schedule::with(['checkins.client.user'], function ($query) use ($day) {
            return $query->where('checkins.checkin_date', $day)->where('checkins.canceled_at', null);
        })->where('id', $schedule->id)->first();

        return new DetailScheduleResource($schedule);
    }
}
