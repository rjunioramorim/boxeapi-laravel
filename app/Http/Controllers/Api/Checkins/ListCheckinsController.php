<?php

namespace App\Http\Controllers\Api\Checkins;

use App\Http\Controllers\Controller;
use App\Http\Resources\Checkins\ListCheckinsResource;
use App\Services\CheckinsService;
use Illuminate\Http\Request;

class ListCheckinsController extends Controller
{
    private $service;

    public function __construct(CheckinsService $service)
    {
        $this->service = $service;
    }
    public function __invoke(Request $request)
    {
        $checkins = $this->service->listCheckins();

        return ListCheckinsResource::collection($checkins);
    }
}
