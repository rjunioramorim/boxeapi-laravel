<?php

namespace App\Http\Controllers\Api\Schedules;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Services\SchedulesService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    private $service;
    
    public function __construct(SchedulesService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $day = $request->day !== null ? Carbon::createFromFormat('Y-m-d', $request->day) : now();
        $today = now()->today();

        if($day->isPast()) {
            $schedules = Schedule::where('weekday', $day->weekday())->get();
        }

        dd($schedules->toArray());
    }
}
