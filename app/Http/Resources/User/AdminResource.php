<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Company\CompanyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'active' => boolval($this->active),
            'name' => $this->name,
            'short_name' => $this->short_name,
            'birth_date' => $this->birth_date,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'created_at' => $this->created_at,
            'role' => new RoleResource($this->role),
            'company' => new CompanyResource($this->company),
        ];
    }
}
