<?php

namespace App\Models\Traits\Media;

trait MediaRelation
{
    public function mediaable()
    {
        return $this->morphTo();
    }
}