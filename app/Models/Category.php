<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'status',
        'description',
    ];

    public function manufacturs(): HasMany
    {
        return $this->hasMany(Manufactur::class);
    }
}
