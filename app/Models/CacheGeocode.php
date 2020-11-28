<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CacheGeocode extends Model
{
    protected $casts = [
        'result' => 'array',
    ];
}
