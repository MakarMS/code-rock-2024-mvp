<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCardResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProductCardResource::collection(Product::with('manufacturer')->orderBy('id', 'DESC')->paginate(10));
    }

    public function show(Request $request): JsonResponse
    {
        $product = Product::select('id', 'product_name', 'description', 'image', 'cost', 'height', 'width', 'depth', 'mass')->find($this->getId($request));

        return new JsonResponse($product);
    }
}
