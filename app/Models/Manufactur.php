<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manufactur extends Model
{
    protected $table = 'manufacturs';
    protected $fillable = [
        'category_id',
        'license_duration',
        'license_number',
        'first_installation_date',
        'last_installation_date',
        'notify_90_days',
        'notify_30_days',
        'notify_7_days',
        'is_notified_90',
        'is_notified_30',
        'is_notified_7',
    ];

    protected $casts = [
        'first_installation_date' => 'date',
        'last_installation_date' => 'date',
        'notify_90_days' => 'boolean',
        'notify_30_days' => 'boolean',
        'notify_7_days' => 'boolean',
        'is_notified_90' => 'boolean',
        'is_notified_30' => 'boolean',
        'is_notified_7' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
