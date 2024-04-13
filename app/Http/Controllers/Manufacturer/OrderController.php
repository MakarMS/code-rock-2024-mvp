<?php

namespace App\Http\Controllers\Manufacturer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Route;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = Order::with('product')
            ->orderBy('orders.id', 'DESC') // Указываем, что нужно сортировать по столбцу "id" из таблицы "orders"
            ->paginate(10);

        foreach ($orders as $key => $order) {
            if ($order->product->manufacturer_id !== Auth::guard('manufacturer')->id()) {
                unset($orders[$key]);
            }
        }

        $response = [
            'total' => $orders->total(),
            'current_page' => $orders->currentPage(),
            'orders' => []
        ];

        foreach ($orders as $order) {
            $orderResponse = [
                'id' => $order->id,
                'count' => $order->count,
                'cost' => $order->cost,
                'status' => $order->status,
                'product_name' => $order->product->product_name,
                'image' => Storage::url($order->product->image),
            ];

            foreach ($order->routes as $route) {
                $routeModel = Route::with(['departurePoint', 'arrivalPoint'])->where('id', $route)->first();

                $orderResponse['routes'][] = [
                    'departure_point' => $routeModel->departurePoint->city,
                    'arrival_point' => $routeModel->arrivalPoint->city,
                ];
            }

            $response['orders'][] = $orderResponse;
        }

        return new JsonResponse($response);
    }

    public function show(Request $request): JsonResponse
    {
        $routes = Order::find($this->getId($request))->first();

        $orderResponse = [];

        foreach ($routes->routes as $route) {
            $routeModel = Route::with(['departurePoint', 'arrivalPoint'])->where('id', $route)->first();

            $orderResponse['routes'][] = [
                'departure_point' => $routeModel->departurePoint->city,
                'arrival_point' => $routeModel->arrivalPoint->city,
            ];
        }

        return new JsonResponse($orderResponse);
    }
}
