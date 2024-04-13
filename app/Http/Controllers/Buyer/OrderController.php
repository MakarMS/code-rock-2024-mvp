<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
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
            ->where('buyer_id', Auth::guard('buyer')->id())
            ->orderBy('id', 'DESC')
            ->paginate(10);

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
                'manufacturer' => $order->product->manufacturer->company_name
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

    public function reOrder(Request $response): JsonResponse
    {
        $id = $this->getId($response);

        $lastOrder = Order::select()->where('buyer_id', Auth::guard('buyer')->id())->where('id', $id)->first();
        $newOrder = $lastOrder->replicate();

        $newOrder->save();

        return new JsonResponse(null, 204);
    }

    public function store(OrderRequest $request): JsonResponse
    {
        $data = $request->all();

        $data['buyer_id'] = Auth::guard('buyer')->id();
        $data['cost'] = Product::find($data['product_id'])->cost * $data['count'];
        $data['routes'] = json_encode(explode('-', $data['routes']));

        $order = (new Order($data));
        $order->save();

        return new JsonResponse(null, 204);
    }
}
