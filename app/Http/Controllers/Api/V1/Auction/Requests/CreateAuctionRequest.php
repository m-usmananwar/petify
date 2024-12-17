<?php

namespace App\Http\Controllers\Api\V1\Auction\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use App\Modules\Auction\DTO\CreateAuctionDTO;

class CreateAuctionRequest extends BaseRequest
{
    protected static array $types = [
        'Animal',
        'Bird',
        'Reptile',
        'Amphibian',
        'Fish',
        'Insect',
        'Mammal',
        'Plant',
        'Fungi',
        'Microorganism',
        'Arthropod',
        'Mollusk',
        'Crustacean'
    ];

    public function DTO(): string
    {
        return CreateAuctionDTO::class;
    }

    public function rules(): array
    {
        return [
            'name' => ['bail', 'required', 'string'],
            'color' => ['bail', 'required', 'string'],
            'age' => ['bail', 'required', 'numeric'],
            'type' => $this->validateType(),
            'tagLine' => ['bail', 'required', 'string'],
            'description' => ['bail', 'required', 'string'],
            'initialPrice' => ['bail', 'required', 'numeric'],
            'startTime' => ['bail', 'required', 'date_format:Y-m-d H:i:s'],
            'expiryTime' => ['bail', 'required', 'date_format:Y-m-d H:i:s'],
            'medias' => ['bail', 'required', 'array'],
            'medias.*' => ['bail', 'required', 'file', 'mimes:jpeg,png,jpg'],
        ];
    }

    protected function validateType(): array
    {
        return [
            'bail',
            'required',
            'string',
            Rule::in(self::$types),
        ];
    }
}
