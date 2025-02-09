<?php

namespace App\Http\Controllers\Api\V1\Bid\Requests;

use App\Enum\GlobalEnum;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\App;
use App\Modules\Auction\Services\AuctionService;
use App\Modules\Bid\DTO\FetchBidsDTO;

class FetchBidsRequest extends BaseRequest
{
    public function DTO(): string
    {
        return FetchBidsDTO::class;
    }

    public function rules(): array
    {
        return [
            'biddableType' => ['bail', 'required', Rule::in(GlobalEnum::$biddableTypes)],
            'biddableId' => $this->validateBiddleableId(),
        ];
    }

    private function validateBiddleableId(): array
    {
        return [
            'bail',
            'required',
            function ($attribute, $value, $fail) {

                $biddable = $this->input('biddableType');

                $biddeableServices = [
                    'Auction' => AuctionService::class,
                ];

                $service = App::make($biddeableServices[$biddable]);

                $biddableModel = $service->getRepository()->get($value);

                if (!$biddableModel) {
                    $fail("The particular {$biddable} does not exist.");
                    return;
                }
            }
        ];
    }
}
