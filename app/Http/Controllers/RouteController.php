<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\RouteRequest;
use App\Models\Route;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    public function store(RouteRequest $request): void
    {
        $route = (new Route())->fill([
                'manufacturer_id' => Auth::guard('manufacturer')->id(),
                'departure_point' => $request->input('departure_point'),
                'arrival_point' => $request->input('arrival_point'),
                'cost' => $request->input('cost'),
                'length_delivery' => $request->input('length_delivery'),
                'distance' => $request->input('distance'),
            ]
        );

        $route->save();
    }
}
