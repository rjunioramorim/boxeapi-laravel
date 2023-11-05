<?php

namespace App\Http\Resources\Schedules;

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
        // dd($request->all());
        $request->day;
        return [
            'day' => $request->day,
            'hour' => $this->hour,
            'limit' => $this->limit,
            'checkins' => $this->checkins->count(),
            'clients' => DetailClientScheduleResource::collection($this->checkins),
        ];
    }
}
