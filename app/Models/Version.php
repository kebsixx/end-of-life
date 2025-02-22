<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $table = 'versions';
    protected $fillable = [
        'version-name-auto',
        'verison-name',
        'realese-date',
        'version-description',
    ];
}
