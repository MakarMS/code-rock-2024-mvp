<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'description' => $this->description,
            'image' => Storage::url($this->image),
            'cost' => $this->cost,
            'sizes' => $this->height . 'x' . $this->width . 'x' . $this->depth,
            'mass' => $this->mass,
        ];
    }
}
