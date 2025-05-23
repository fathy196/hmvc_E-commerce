<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\Models\Category;
use Modules\Admin\Models\Product;
use Modules\User\Transformers\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::with('category')->paginate(10));

    }

    public function show(Product $product)
    {
        return new ProductResource($product->load('category'));
    }

}