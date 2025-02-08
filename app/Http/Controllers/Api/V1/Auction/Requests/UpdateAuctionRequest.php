<?php

namespace App\Http\Controllers\Api\V1\Auction\Requests;

use App\Enum\AuctionStatusEnum;
use App\Enum\GlobalEnum;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\App;
use App\Modules\Auction\DTO\UpdateAuctionDTO;
use App\Modules\Auction\Services\AuctionService;

class UpdateAuctionRequest extends BaseRequest
{
    public function DTO(): string
    {
        return UpdateAuctionDTO::class;
    }

    public function rules(): array
    {
        return [
            'id' => $this->validateId(),
            'name' => ['bail', 'required', 'string'],
            'color' => ['bail', 'required', 'string'],
            'age' => ['bail', 'required', 'numeric'],
            'type' => $this->validateType(),
            'tagLine' => ['bail', 'required', 'string'],
            'description' => ['bail', 'required', 'string'],
            'initialPrice' => ['bail', 'required', 'numeric'],
            'startTime' => ['bail', 'required', 'date_format:Y-m-d H:i:s'],
            'expiryTime' => ['bail', 'required', 'date_format:Y-m-d H:i:s'],
            'status' => $this->validateStatus(),
            'medias' => ['bail', 'sometimes', 'array'],
            'medias.*' => ['bail', 'sometimes', 'file', 'mimes:jpeg,png,jpg,webp'],
        ];
    }

    protected function validateType(): array
    {
        return [
            'bail',
            'required',
            'string',
            Rule::in(GlobalEnum::$auctionableTypes),
        ];
    }

    protected function validateId(): array 
    {
        return [
            'bail',
            'required',
            'integer',
            'gt:0',
            function($attribute, $value, $fail) {
                $auction = App::make(AuctionService::class)->getRepository()->get($value);

                if(!$auction) {
                    $fail('The selected auction does not exist.');
                    return;
                }

                if($auction->owner_id !== currentUserId()) {
                    $fail('You are not authorized to update this auction.');
                    return;
                }

                if($auction->bids) {
                    $fail('You cannot update this auction because it has bids.');
                    return;
                }

                if($auction->status === AuctionStatusEnum::BLOCKED_BY_ADMIN->value) {
                    $fail('You cannot update this auction because it is blocked by the admin');
                    return;
                }
 
                if($auction->status === AuctionStatusEnum::COMPLETED->value) {
                    $fail('You cannot update this auction because it is completed');
                    return;
                }
            }
        ];
    }

    public function validateStatus(): array
    {
        return [
            'bail',
            'required',
            'string',
            Rule::in(array_column(AuctionStatusEnum::cases(), 'value')),
        ];
    }
}
