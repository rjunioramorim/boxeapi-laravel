<?php

namespace App\Http\Controllers\Api\Schedules;

use App\Enums\ScheduleType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Schedules\ListScheduleResource;
use App\Models\Schedule;
use App\Services\SchedulesService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ListSchedulesController extends Controller
{
    private $service;

    public function __construct(SchedulesService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        $request['day'] = $request->day != null ? Carbon::createFromFormat('Y-m-d', $request->day) : now();

        $schedules = $this->service->listSchedules($request['day']->format('Y-m-d'));

        if (count($schedules) <= 0) {
            return response()->json(['data' => []]);
        }
        return ListScheduleResource::collection($schedules);
    }
}
