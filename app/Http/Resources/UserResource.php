<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request) :array
    {
        return [
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'username' => $this->user_name,
            'contactNo' => $this->contact_no,
            'email' => $this->email,
            'status' => $this->status,
        ];
    }
}
