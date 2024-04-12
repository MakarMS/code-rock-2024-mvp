<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\RouteRequest;
use App\Http\Resources\RouteResource;
use App\Models\Route;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $routes = Route::with(['departurePoint', 'arrivalPoint'])
            ->where('manufacturer_id', Auth::guard('manufacturer')->id())
            ->paginate(10);

        return RouteResource::collection($routes);
    }

    public function show(Request $request): JsonResponse
    {
        $route = Route::select('id', 'departure_point', 'arrival_point', 'cost', 'length_delivery', 'distance')->find($this->getId($request));

        return new JsonResponse($route);
    }

    public function update(RouteRequest $request): JsonResponse
    {
        $route = Route::find($this->getId($request));
        $route->update($request->all());

        return new JsonResponse(null, 204);
    }

    public function destroy(Request $request): JsonResponse
    {
        $route = Route::find($this->getId($request));
        $route->delete();

        return new JsonResponse(null, 204);
    }

    public function store(RouteRequest $request): JsonResponse
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
        return new JsonResponse(null, 204);
    }
}
