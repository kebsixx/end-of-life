<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufactur extends Model
{
    protected $table = 'manufacturs';
    protected $fillable = [
        'manufacture_name',
        'manufacture_description',
    ];
}
