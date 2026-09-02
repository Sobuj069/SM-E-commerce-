<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FraudBlacklist extends Model
{
    protected $fillable = [
        'phone',
        'email',
        'ip_address',
        'reason',
        'blocked_by',
    ];
}