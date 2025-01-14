<?php

namespace App\Http\Controllers\Api\V1\Auction\Requests;

use App\Enum\AuctionStatusEnum;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Auction\Services\AuctionService;

class DeleteAuctionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => $this->validateId()
        ];
    }

    private function validateId(): array
    {
        return [
            'required',
            'exists:auctions,id',
            function($attribute, $value, $fail) {
                $auction = App::make(AuctionService::class)->getRepository()->get($value);

                if(!$auction) {
                    $fail('The selected auction does not exist.');
                    return;
                }

                if($auction->owner !== currentUserId()) {
                    $fail('You are not authorized to delete this auction.');
                    return;
                }

                if($auction->bids) {
                    $fail('You cannot delete this auction because it has bids.');
                    return;
                }

                if($auction->status === AuctionStatusEnum::COMPLETED->value) {
                    $fail('You cannot delete this auction because it is completed');
                    return;
                }
            }
        ];
    }
}