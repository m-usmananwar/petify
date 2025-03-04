<?php

namespace App\Models;

use App\Models\Traits\Wallet\WalletHelper;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Wallet\WalletRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory, WalletRelation, WalletHelper;

    protected $fillable = ['user_id', 'balance'];
}
