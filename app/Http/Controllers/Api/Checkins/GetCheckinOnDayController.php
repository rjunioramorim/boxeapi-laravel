<?php

namespace App\Http\Controllers\Api\Checkins;

use App\Http\Controllers\Controller;
use App\Http\Resources\Checkins\ListCheckinsResource;
use App\Models\Checkin;
use App\Services\CheckinsService;
use Illuminate\Http\Request;

class GetCheckinOnDayController extends Controller
{
    private $service;

    public function __construct(CheckinsService $service)
    {
        $this->service = $service;
    }
    public function __invoke(Request $request)
    {
        $checkins = $this->service->listCheckinOnlyDay();
      
        return ListCheckinsResource::collection($checkins);
    }
}
