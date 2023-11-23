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

        return [
            'id' => $this->id,
            'day' => $request->day,
            'hour' => $this->hour,
            'description'=> $this->description,
            'limit' => $this->limit,
            'vacancies' => $this->limit - $this->checkins->count(),
            'clients' => DetailClientScheduleResource::collection($this->checkins),
        ];
    }
}
