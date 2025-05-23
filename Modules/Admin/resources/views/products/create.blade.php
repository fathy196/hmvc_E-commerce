@extends('admin::layouts.app')
@section('title', 'Create Product')
@section('content')
    <div class="container my-5">
        <!-- Modern Header Section -->
        <div class="text-center mb-5">
            <h1 class="display-4 text-primary fw-bold">Create New Product</h1>
            <p class="text-muted">Add a new product to your inventory with ease.</p>
        </div>

        <!-- Form Section -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data"
                    class="shadow p-4 rounded bg-light">
                    @csrf

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Enter product name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Product Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"
                            placeholder="Enter product description">{{ old('description') }}</textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Product Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01"
                            value="{{ old('price') }}" placeholder="Enter product price">
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Product Quantity -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                            value="{{ old('quantity', 0) }}" placeholder="Enter product quantity">
                        @error('quantity')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Product Active Status -->
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Active</label>
                        <select class="form-select w-100" id="is_active" name="is_active">
                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>No</option>
                        </select>
                        @error('is_active')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Product Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control w-100" id="image" name="image">
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Product Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select w-100" id="category_id" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg w-100">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
