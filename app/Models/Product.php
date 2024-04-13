<?php

namespace App\Models;

use App\Models\Users\ManufacturerUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufacturer_id',
        'product_name',
        'description',
        'image',
        'cost',
        'height',
        'width',
        'depth',
        'mass'
    ];

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(ManufacturerUser::class, 'manufacturer_id');
    }
}
