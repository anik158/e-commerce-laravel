<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Admin\Color;
use App\Models\Admin\Product;
use App\Models\Admin\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the latest products.
     */
    public function index()
    {


        return ProductResource::Collection(Product::with(['colors', 'sizes', 'reviews'])->get())->additional([
            'colors' => Color::has('products')->with('products')->get(),
            'sizes' => Size::has('products')->with('products')->get(),
        ]);

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
