<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\ProductRequest;
use Modules\Admin\Models\Category;
use Modules\Admin\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(15);
        // dd($products);
        return view('admin::products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin::products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
        } else {
            return redirect()->back()->withErrors(['image' => 'Image file is required.']);
        }
        $request->file('image')->move(public_path('storage/products'), $imageName);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'is_active' => $request->is_active,
            'image' => $imageName,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard.products.index')->with('status', 'Product created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        // return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
         $categories = Category::all();
        return view('admin::products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $imageName = $product->image;

        if($request->hasfile('image')){
            if(file_exists(public_path($product->image_path))){
                unlink(public_path($product->image_path));
            }
            $imageName=time().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('storage/products'), $imageName);

        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'is_active' => $request->is_active,
            'image' => $imageName ?? $product->image,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard.products.index')->with('status', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('dashboard.products.index')->with("status", "Product Deleted Successfully");
    
    }
}
