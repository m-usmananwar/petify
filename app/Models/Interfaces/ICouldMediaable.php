<?php

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ICouldMediaable
{
    public function medias(): MorphMany;
}