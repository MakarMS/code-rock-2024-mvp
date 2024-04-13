<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Product;
use App\Models\Route;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    public function show(PlanRequest $request): JsonResponse
    {
        $planId = $this->getId($request);

        $manufacturerId = Product::with('manufacturer')->where('id', $request->input('product_id'))->first()->manufacturer_id;

        $sql = '
                   WITH RECURSIVE optimal_paths AS (
                       SELECT
                           id AS city_id,
                           ARRAY[]::BIGINT[] AS path,
                           0 AS cost
                       FROM
                           cities

                       UNION ALL

                       SELECT
                           c.id AS city_id,
                           op.path || r.id AS path,
                           op.cost + ' . ($planId === 1 ? 'r.cost AS cost' : ($planId === 2 ? 'r.length_delivery AS cost' : 'r.distance AS cost')) . '
                       FROM
                           optimal_paths op
                               JOIN
                           routes r ON op.city_id = r.departure_point
                               JOIN
                           cities c ON r.arrival_point = c.id
                       WHERE
                          r.manufacturer_id = ?
                   )
                   SELECT
                       optimal_paths.*
                   FROM
                       optimal_paths JOIN points ON optimal_paths.city_id = points.city_id
                       WHERE points.manufacturer_id = ? AND type = 2 AND array_length(optimal_paths.path, 1) > 0 ORDER BY cost';

        $routesByCost = DB::select($sql, [$manufacturerId, $manufacturerId]);

        $response = [];

        foreach ($routesByCost as $route) {
            $path = explode(',', trim($route->path, '{}'));

            $routeResponse = [
                'routes_ids' => $path,
            ];

            $totalCost = 0;
            $totalLengthDelivery = 0;
            $totalDistance = 0;

            foreach ($path as $routeId) {
                $route = Route::with(['departurePoint', 'arrivalPoint'])->find($routeId);
                $totalCost += $route->cost;
                $totalLengthDelivery += $route->length_delivery;
                $totalDistance += $route->distance;
            }

            $routeResponse['total_cost'] = $totalCost;
            $routeResponse['total_length_delivery'] = $totalLengthDelivery;
            $routeResponse['total_distance'] = $totalDistance;

            $response[] = $routeResponse;
        }

        return new JsonResponse(['data' => $response]);
    }
}
