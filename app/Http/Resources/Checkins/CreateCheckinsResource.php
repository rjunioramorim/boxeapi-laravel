<?php

namespace App\Http\Resources\Checkins;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateCheckinsResource extends JsonResource
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
            'schedule_id' => $this->schedule_id,
            'user_id' => $this->user_id,
            'checkin_date' => $this->checkin_date,
            'hour' => $this->hour,
        ];
    }
}
