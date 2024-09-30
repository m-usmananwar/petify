<?php

namespace App\Modules\Authentication\Repositories;

use App\Models\Verification;
use App\Modules\Authentication\Repositories\Interfaces\IVerificationRepository;
use App\Repositories\BaseRepository;

class VerificationRepository extends BaseRepository implements IVerificationRepository
{
    public function __construct(Verification $model)
    {
        parent::__construct($model);
    }
}