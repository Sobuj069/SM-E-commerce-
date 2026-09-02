<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourierSetting extends Model
{
    protected $fillable = [
        'provider',
        'api_key',
        'secret_key',
        'client_id',
        'sender_name',
        'sender_phone',
        'sender_address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}