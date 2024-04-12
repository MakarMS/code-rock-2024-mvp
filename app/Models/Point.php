<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufacturer_id',
        'city_id',
        'type'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
