<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $table = 'versions';

    protected $fillable = [
        'version_name',
        'version_number',
        'release_date',
        'expiry_date',
        'version_description',
        'notify_90_days',
        'notify_30_days',
        'notify_7_days',
        'is_notified_90',
        'is_notified_30',
        'is_notified_7',
    ];

    protected $casts = [
        'release_date' => 'date',
        'expiry_date' => 'date',
        'notify_90_days' => 'boolean',
        'notify_30_days' => 'boolean',
        'notify_7_days' => 'boolean',
        'is_notified_90' => 'boolean',
        'is_notified_30' => 'boolean',
        'is_notified_7' => 'boolean',
    ];
}
