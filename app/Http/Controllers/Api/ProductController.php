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
    public function index(Request $request)
    {
        $productQuery = Product::with([ 'reviews']);


//        Filter by color
        if($request->has('color') && $request->color !='')
        {
            $productQuery->whereHas('colors', function($q) use($request){
                $q->where('colors.id', $request->color);
            });
        }

//        Filter by size
        if($request->has('size') && $request->size !='')
        {
            $productQuery->whereHas('sizes', function($q) use($request){
                $q->where('sizes.id', $request->size);
            });
        }

        if($request->has('search') && trim($request->search) != '')
        {
            $productQuery->where(function($q) use($request){
                $q->where('products.name', 'like', '%'.$request->search.'%');
            } );
        }


        $products = $productQuery->orderBy('id', 'desc')->get();;

        return ProductResource::collection($products)->additional([
            'colors' => Color::has('products')->get(['id', 'name']),
            'sizes'  => Size::has('products')->get(['id', 'name']),
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
