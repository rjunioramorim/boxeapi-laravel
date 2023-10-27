<?php

namespace App\Http\Controllers\Api\Checkins;

use App\Http\Controllers\Controller;
use App\Http\Resources\Checkins\ListCheckinsResource;
use App\Models\Checkin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ListCheckinsController extends Controller
{
    public function __invoke(Request $request)
    {
        $day = $request->day == null ? now() : Carbon::createFromFormat('Y-m-d', $request->day);

        $clientId = auth()->user()->client->id;

        $checkins = Checkin::with('schedule')
            ->where('client_id', $clientId)
            ->where('checkin_date', '>=', $day->format('Y-m-d'))
            ->where('canceled_at', null)
            // ->where('confirmed_at', null)
            // ->where(function($query) use ($day) {
            //     $query->where('checkin_date', '>', $day->format('Y-m-d'))
            //         ->orWhere(function($subquery) use ($day) {
            //             $subquery->where('checkin_date', $day->format('Y-m-d'))
            //                 ->where('hour', '>', $day->format('H:i'));
            //         });
            // })
            ->orderBy('checkin_date')
            ->orderBy('hour')
            ->get();

        return ListCheckinsResource::collection($checkins);
    }
}
