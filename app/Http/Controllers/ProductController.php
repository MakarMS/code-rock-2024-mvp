<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $products = Product::select('id', 'product_name', 'description', 'image', 'cost', 'height', 'width', 'depth', 'mass')
            ->where('manufacturer_id', Auth::guard('manufacturer')->id())
            ->paginate(10);

        return ProductResource::collection($products);
    }

    public function show(Request $request): JsonResponse
    {
        $product = Product::select('id', 'product_name', 'description', 'image', 'cost', 'height', 'width', 'depth', 'mass')->find($this->getId($request));

        return new JsonResponse($product);
    }

    public function update(ProductRequest $request): JsonResponse
    {
        $product = Product::find($this->getId($request));

        $fillData = [
            'product_name' => $request->input('product_name'),
            'description' => $request->input('description'),
            'cost' => $request->input('cost'),
            'height' => $request->input('height'),
            'width' => $request->input('width'),
            'depth' => $request->input('depth'),
            'mass' => $request->input('mass'),
        ];

        if ($request->file('image')) {
            $imagePath = $request->file('image')->store('products/images');
            $fillData['image'] = $imagePath;
        }

        $product->update($fillData);

        return new JsonResponse(null, 204);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $fillData = [
            'product_name' => $request->input('product_name'),
            'manufacturer_id' => Auth::guard('manufacturer')->id(),
            'description' => $request->input('description'),
            'cost' => $request->input('cost'),
            'height' => $request->input('height'),
            'width' => $request->input('width'),
            'depth' => $request->input('depth'),
            'mass' => $request->input('mass'),
        ];

        if ($request->file('image')) {
            $imagePath = $request->file('image')->store('products/images');
            $fillData['image'] = $imagePath;
        }

        $product = new Product($fillData);

        $product->save();

        return new JsonResponse(null, 204);
    }

    public function destroy(Request $request): JsonResponse
    {
        $product = Product::find($this->getId($request));
        $product->delete();

        return new JsonResponse(null, 204);
    }
}
