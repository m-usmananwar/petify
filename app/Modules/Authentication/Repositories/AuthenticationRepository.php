<?php

namespace App\Modules\Authentication\Repositories;

use App\Models\User\User;
use App\Modules\Authentication\Repositories\Interfaces\IAuthenticationRepository;
use App\Repositories\BaseRepository;

class AuthenticationRepository extends BaseRepository implements IAuthenticationRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}