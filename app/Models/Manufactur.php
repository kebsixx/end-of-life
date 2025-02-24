<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manufactur extends Model
{
    protected $table = 'manufacturs';
    protected $fillable = [
        'category_id',
        'product_name',
        'license_duration',
        'license_number',
        'first_installation_date',
        'last_installation_date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
