<?php

namespace App\Models\Traits\Media;

use Illuminate\Database\Eloquent\Relations\MorphTo;

trait MediaRelation
{
    public function mediaable(): MorphTo
    {
        return $this->morphTo();
    }
}