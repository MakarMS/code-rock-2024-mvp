<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

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
