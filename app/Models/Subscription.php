<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    use HasFactory;

    const INTERVAL_MONTH = 'month';
    const INTERVAL_YEAR = 'year';

    const MONTHLY_PLAN = 'Monthly';
    const YEARLY_PLAN = 'Yearly';
}
