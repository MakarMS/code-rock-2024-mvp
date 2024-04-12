<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufacturer_id',
        'departure_point',
        'arrival_point',
        'cost',
        'length_delivery',
        'distance'
    ];

    public function departurePoint(): BelongsTo
    {
        return $this->belongsTo(City::class, 'departure_point');
    }

    public function arrivalPoint(): BelongsTo
    {
        return $this->belongsTo(City::class, 'arrival_point');
    }
}
