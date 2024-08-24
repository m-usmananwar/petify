<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Billable,
        HasApiTokens, 
        HasRoles, 
        Notifiable;

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
        'level',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
