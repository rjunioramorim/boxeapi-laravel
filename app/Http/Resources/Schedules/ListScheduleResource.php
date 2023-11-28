<?php

namespace App\Http\Resources\Schedules;

use App\Enums\ScheduleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userId = auth()->user()->id;
        

        return [
            'id' => $this->id,
            'day' => $request->day->format('Y-m-d'),
            'hour' => $this->hour,
            'professor' => $this->professor,
            'description' => $this->description,
            'limit' => $this->limit,
            'vacancies' => $this->limit - $this->checkins->count(),
            'limit' => $this->limit,
            'userScheduled' => $this->checkins->contains('user_id', $userId),
        ];
    }
}
