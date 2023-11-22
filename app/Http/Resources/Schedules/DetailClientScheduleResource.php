<?php

namespace App\Http\Resources\Schedules;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailClientScheduleResource extends JsonResource
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
            'avatar_url' => url($this->client->user->avatar_url),
            'name' => $this->client->user->name,
            'checked' => $this->client->user_id == $userId,
            'checkin_id' => $this->id,
            'status'=> $this->status,
        ];
    }
}
