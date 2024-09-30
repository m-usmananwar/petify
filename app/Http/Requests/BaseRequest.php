<?php

namespace App\Http\Requests;

use App\DTO\BaseDTO;
use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;
use App\Http\Response\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class BaseRequest extends FormRequest
{

    public abstract function DTO():string;
    
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator):void
    {
        $errors = [];
        foreach ($validator->errors()->toArray() as $path => $error) {
            Arr::set($errors, $path, $error);
        }
        $response = ApiResponse::validation($errors);

        throw new HttpResponseException($response);
    }

    protected function prepareForValidation()
    {
        $this->merge(request()->route()->parameters());
    }

    public function toDto():BaseDTO
    {
        $dto = $this->DTO();

        Assert::subclassOf($dto, BaseDTO::class);

        return new $dto(...$this->validated());
    }
}
