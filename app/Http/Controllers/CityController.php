<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    public function index(): JsonResponse
    {
        $cities = City::select('id', 'city')->get();
        return new JsonResponse(['cities' => $cities]);
    }
}
