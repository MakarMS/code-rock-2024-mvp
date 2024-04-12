<?php

namespace App\Http\Controllers;

use App\Http\Requests\PointRequest;
use App\Http\Resources\PointResource;
use App\Models\Point;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $points = Point::with('city')
            ->where('manufacturer_id', Auth::guard('manufacturer')->id())
            ->paginate(10);

        return PointResource::collection($points);
    }

    public function destroy(Request $request): JsonResponse
    {
        $point = Point::find($this->getId($request));
        $point->delete();

        return new JsonResponse(null, 204);
    }

    public function store(PointRequest $request): JsonResponse
    {
        $route = (new Point())->fill([
                'manufacturer_id' => Auth::guard('manufacturer')->id(),
                'city_id' => $request->input('city'),
                'type' => $request->input('type')
            ]
        );

        $route->save();
        return new JsonResponse(null, 204);
    }
}
