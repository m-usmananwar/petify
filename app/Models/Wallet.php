<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Wallet\WalletRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory, WalletRelation;

    protected $fillable = ['user_id', 'balance'];
}
