<?php

namespace App\Http\Resources;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuctionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'age' => $this->age,
            'type' => $this->type,
            'color' => $this->color,
            'tagline' => $this->tag_line,
            'description' => $this->description,
            'initialPrice' => $this->initial_price,
            'startTime' => $this->start_time,
            'expiryTime' => $this->expiry_time,
            'is_own' => currentUser() ? currentUserId() === $this->owner : false,
            'medias' => MediaResource::collection($this->medias)
        ];
    }
}
