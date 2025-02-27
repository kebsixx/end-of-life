<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufactur extends Model
{
    protected $table = 'manufacturs';
    protected $fillable = [
        'name',
        'license_duration',
        'license_number',
        'first_installation_date',
        'last_installation_date',
        'notification_period',
        'is_notified'
    ];

    protected $casts = [
        'first_installation_date' => 'date',
        'last_installation_date' => 'date',
        'is_notified' => 'boolean',
    ];
}
