<?php

namespace App\Http\Resources\Clients;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->client->phone,
            'plan_name' => $this->client->plan->name,
            'plan_qtd_days' => $this->client->plan->qtd_days,
            'total_checkins' => $this->client->checkins->count(),
            'active' => $this->client->verified_at,
            'avatar_url' => url($this->avatar_url) ?? url('avatar_default.jpg'),
            'due_date' => $this->client->due_date,
            'member_of' => $this->client->created_at->format('d/m/y'),
        ];
    }
}
