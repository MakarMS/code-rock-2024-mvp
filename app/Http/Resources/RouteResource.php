<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'departure_point' => $this->departurePoint->city,
            'arrival_point' => $this->arrivalPoint->city,
            'cost' => $this->cost,
            'length_delivery' => $this->length_delivery,
            'distance' => $this->distance,
        ];
    }
}
