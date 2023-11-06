<?php

namespace App\Http\Resources\Checkins;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListCheckinsResource extends JsonResource
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
            'client_id' => $this->client_id,
            'hour' => $this->hour,
            'day' => $this->checkin_date,
            'description' => $this->schedule->description,
            'professor' => $this->schedule->professor,
            'status' => $this->status,
            // 'confirmed_at' => $this->confirmed_at,
            // 'realized_at' => $this->realized_at,
            // 'canceled_at' => $this->canceled_at,
            'schedule_id' => $this->schedule_id,
        ];
    }
}
