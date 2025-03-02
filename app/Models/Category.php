<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'product_name',
        'status',
        'description',
    ];

    public function manufactur()
    {
        return $this->hasMany(Manufactur::class);
    }

    public function version()
    {
        return $this->hasOne(Version::class);
    }
}
