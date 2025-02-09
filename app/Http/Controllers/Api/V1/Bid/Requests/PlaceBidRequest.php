<?php

namespace App\Http\Controllers\Api\V1\Bid\Requests;

use App\Enum\GlobalEnum;
use App\Enum\AuctionStatusEnum;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\App;
use App\Modules\Bid\DTO\PlaceBidDTO;
use App\Modules\Auction\Services\AuctionService;

class PlaceBidRequest extends BaseRequest
{
    public function DTO(): string
    {
        return PlaceBidDTO::class;
    }

    public function rules(): array
    {
        return [
            'biddleableType' => ['bail', 'required', Rule::in(GlobalEnum::$biddableTypes)],
            'biddleableId' => $this->validateBiddleableId(),
            'amount' => ['bail', 'required', 'numeric', 'min:01'],
        ];
    }

    private function validateBiddleableId(): array
    {
        return [
            'bail',
            'required',
            function($attribute, $value, $fail) {

                $biddable = $this->input('biddleableType');
                $amount = $this->input('amount');

                $biddeableServices = [
                    'Auction' => AuctionService::class,
                ];

                $service = App::make($biddeableServices[$biddable]);

                $biddableModel = $service->getRepository()->get($value);

                if(!$biddableModel) {
                    $fail("The particular {$biddable} does not exist.");
                    return;
                }

                if($biddableModel->status === AuctionStatusEnum::BLOCKED_BY_ADMIN->value) {
                    $fail("You cannot place bid on this {$biddable} because it is blocked by the admin");
                    return;
                }
 
                if($biddableModel->status === AuctionStatusEnum::COMPLETED->value) {
                    $fail("You cannot place bid on this {$biddable} because it is completed");
                    return;
                }

                if($biddableModel->status === AuctionStatusEnum::FAILED->value) {
                    $fail("You cannot place bid on this {$biddable} because it is failed");
                    return;
                }

                if($biddableModel->isExpired()) {
                    $fail("You cannot place bid on this {$biddable} because it is expired");
                    return;
                }

                if($biddableModel->highestBid() >= $amount) {
                    $fail("You cannot bid less than {$biddableModel->highestBid()}");
                    return;
                }
            }
        ];
    }
}