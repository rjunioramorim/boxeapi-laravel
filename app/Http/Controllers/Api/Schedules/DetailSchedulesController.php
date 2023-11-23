<?php

namespace App\Http\Controllers\Api\Schedules;

use App\Enums\ScheduleType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Schedules\DetailScheduleResource;
use App\Models\Schedule;
use App\Services\SchedulesService;
use Illuminate\Http\Request;

class DetailSchedulesController extends Controller
{
    private $service;

    public function __construct(SchedulesService $service)
    {
        $this->service = $service;    
    }

    public function __invoke(Schedule $schedule, Request $request)
    {
        $response = $this->service->getSchedule($schedule, $request->day);

        return new DetailScheduleResource($response);
        // return response()->json(['data' => $response]);
        // $day = $request->day;
        // $schedule = Schedule::with(['checkins.client.user'], function ($query) use ($day) {
        //     return $query->where('checkins.checkin_date', $day)->where('checkins.status', '!=', ScheduleType::CANCELED->value);
        // })->where('id', $schedule->id)->first();

    }
}
