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
        'version_description',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];
}
