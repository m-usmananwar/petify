<?php

namespace App\DTO;

class ByIdDTO extends BaseDTO
{
    public function __construct(public readonly int|string $id)
    {
        
    }
}