<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $authenticatedUser = $request->user();
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_admin' => (bool)$this->is_admin,
            'phone' =>
                ($authenticatedUser && (
                    $authenticatedUser->is_admin ||
                    $authenticatedUser->id === $this->id
                ))
                    ? $this->phone
                    : null,
            'role'  => $this->role->name ?? null,
        ];
    }
}
