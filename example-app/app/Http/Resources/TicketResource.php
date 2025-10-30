<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'title' => $this->title,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'agent_id' => $this->agent_id,
            'user' => $this->whenLoaded('user'),
            'category' => $this->whenLoaded('category'),
            'status' => $this->whenLoaded('status'),      
            'agent' => $this->whenLoaded('agent'),
        ];
    }
}
