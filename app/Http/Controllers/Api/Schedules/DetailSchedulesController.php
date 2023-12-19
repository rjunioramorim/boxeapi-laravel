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
    }
}
