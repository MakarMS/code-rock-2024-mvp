<?php

namespace App\Http\Controllers\Manufacturer;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    public function index(): JsonResponse
    {
        $cities = City::select('id', 'city')->get();
        return new JsonResponse(['cities' => $cities]);
    }

    public function routesCities(): JsonResponse
    {
        $warehouseCities = City::select('cities.id', 'cities.city')
            ->rightJoin('points', 'cities.id', '=', 'points.city_id')
            ->where('points.manufacturer_id', Auth::guard('manufacturer')->id())
            ->where('points.type', 1)
            ->distinct()
            ->get();

        $pickupCities = City::select('cities.id', 'cities.city')
            ->rightJoin('points', 'cities.id', '=', 'points.city_id')
            ->where('points.manufacturer_id', Auth::guard('manufacturer')->id())
            ->where('points.type', 2)
            ->distinct()
            ->get();

        return new JsonResponse(['warehouse_cities' => $warehouseCities, 'pickup_cities' => $pickupCities]);
    }
}
