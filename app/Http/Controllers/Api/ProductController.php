<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the latest products.
     */
    public function index()
    {
        $products = Product::with(['colors', 'sizes', 'reviews.users'])
            ->where('status', 1) ->latest()
            ->paginate(12);
        return response()->json([ 'products' => ProductResource::collection($products),
            'links' => $products->links(),
            'meta' => [ 'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(), ] ]);
    }

    /**
     * Display the specified product.
     */
    public function show($slug)
    {
        $product = Product::with(['colors', 'sizes', 'reviews.users'])
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return new ProductResource($product);
    }
}
