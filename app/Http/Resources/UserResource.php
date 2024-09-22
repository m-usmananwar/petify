<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request) :array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->user_name,
            'contact_no' => $this->contact_no,
            'email' => $this->email,
            'status' => $this->status,
        ];
    }
}
