<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'username' => $this->username,
            'contactNo' => $this->contact_no,
            'email' => $this->email,
            'status' => $this->status,
            'imageUrl' => $this->image,
            'fullName' => $this->first_name . " " . $this->last_name,
        ];
    }
}
