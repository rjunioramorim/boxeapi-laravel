<?php

namespace App\Http\Controllers\Api\Checkins;

use App\Enums\ScheduleType;
use App\Http\Controllers\Controller;
use App\Models\Checkin;
use App\Services\CheckinsService;

class CancelCheckinsController extends Controller
{
    private $service;

    public function __construct(CheckinsService $service)
    {
        $this->service = $service;    
    }
    public function __invoke(Checkin $checkin)
    {
        try {
            $this->service->cancelCheckin($checkin);
            return response()->json([], 204);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 422);
        }
    }
}
