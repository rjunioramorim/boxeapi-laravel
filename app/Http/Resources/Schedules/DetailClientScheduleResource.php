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
            'status'=> $this->status,
            'isOwner' => $this->user_id == $userId,
            'name' => $this->user->name,
            'avatar_url' => url($this->user->avatar_url),
        ];
    }
}
