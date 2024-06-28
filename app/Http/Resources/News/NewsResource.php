<?php

namespace App\Http\Resources\News;

use App\Http\Resources\User\RoleResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'content' => $this->content,
            'created_at' => $this->created_at,
            'creator' => [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
                'short_name' => $this->creator->short_name,
                'email' => $this->creator->email,
                'avatar' => $this->creator->avatar,
                'role' => new RoleResource($this->creator->role)
            ],
        ];
    }
}
