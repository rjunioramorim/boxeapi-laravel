<?php

namespace App\Http\Resources\Schedules;

use App\Enums\ScheduleType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $open = ($request->isToday && $this->hour > $request->hour) || (!$request->isToday);

        return [
            'id' => $this->id,
            'day' => $request->day,
            'hour' => $this->hour,
            'description'=> $this->description,
            'limit' => $this->limit,
            'vacancies' => $this->limit - $this->checkins->count(),
            'clients' => DetailClientScheduleResource::collection($this->checkins),

            // id' => $schedule->id,
        //     'day' => $date,
        //     'hour'=> $schedule->hour,
        //     'professor'=> $schedule->professor,
        //     'limit'=> $schedule->limit ,
        //     'vacancies'=> $schedule->limit - $schedule->checkins->count(),
        //     'clients' => $this->listCheckins($schedule->checkins, $clientId) ,
        ];
    }
}
