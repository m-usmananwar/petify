<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\User\UserHelper;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Traits\Global\HasWallet;
use App\Models\Traits\User\UserRelation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Billable,
        HasApiTokens,
        HasRoles,
        Notifiable,
        UserRelation,
        UserHelper,
        HasWallet;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'image',
        'contact_no',
        'email',
        'password',
        'email_verified_at',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
