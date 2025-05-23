<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\CategoryRequest;
use Modules\Admin\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('admin::categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('dashboard.categories.index')->with('status', "Category Created Successfully");
    }
    

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(Category $category)
    {
        return view('admin::categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(CategoryRequest $request, Category $category)
    {
        $category->update(['name' => $request->name]);
        return redirect()->route('dashboard.categories.index')->with('status', 'Category updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('dashboard.categories.index')->with("status", "Category Deleted Successfully");
    }
}
