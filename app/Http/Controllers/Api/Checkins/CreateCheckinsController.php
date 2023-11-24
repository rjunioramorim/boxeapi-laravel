<?php

namespace App\Http\Controllers\Api\Checkins;

use App\Enums\ScheduleType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkins\CreateCheckinRequest;
use App\Http\Resources\Checkins\CreateCheckinsResource;
use App\Models\Checkin;
use App\Models\Schedule;
use App\Services\CheckinsService;
use Carbon\Carbon;

class CreateCheckinsController extends Controller
{
    private $service;

    public function __construct(CheckinsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(CreateCheckinRequest $request)
    {
        $data = $request->all();
        try {
            $checkin = $this->service->createCheckin($data);
            //code...
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 422);
        }
        return new CreateCheckinsResource($checkin);
    }
}
