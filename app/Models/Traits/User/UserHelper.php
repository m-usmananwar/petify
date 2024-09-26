<?php

namespace App\Models\Traits\User;

use App\Helpers\FileHandler;

trait UserHelper
{
    public function getProfileImageUrl(): ?string
    {
        if(empty($this->image)) {
            return null;
        }

        return FileHandler::getFileUrl($this->image);
    }
}