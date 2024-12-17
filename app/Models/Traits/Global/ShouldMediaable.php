<?php

namespace App\Models\Traits\Global;

use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ShouldMediaable
{
    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }
}
