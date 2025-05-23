@extends('admin::layouts.app')
@section('title', 'Products')
@section('content')

    <div class="container my-5">
        <!-- Header Section -->
        <div class="text-center mb-5">
            <h1 class="display-4 text-primary fw-bold">Product Management</h1>
            <p class="text-primary">Manage your products easily from here.</p>
        </div>

        <!-- Products Section -->
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Products</h2>
                <button class="btn btn-light btn-sm" onclick="window.location.href='{{ route('dashboard.products.create') }}'">
                    <i class="bi bi-plus-circle"></i> Add Product
                </button>
            </div>
            <div class="card-body">
                <!-- Product List or Message -->
                @if (count($products) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div class="row">
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ substr($product->description,0,15 )}}...</td>
                                            <td>{{ number_format($product->price)}}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>{{ $product->is_active_status }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn btn-sm btn-outline-primary me-2 mr-2"
                                                        href="{{ route('dashboard.products.edit', $product->id) }}">
                                                        Edit
                                                    </a>
                                                    {{-- Uncomment for Delete Button --}}

                                                    <form method="POST"
                                                        action="{{ route('dashboard.products.destroy', $product->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        @else
            <p class="text-center">No products found.</p>
            @endif
        </div>
    {{-- </div> --}}


    <!-- Categories Section -->
   
    {{$products->links() }}

@endsection
