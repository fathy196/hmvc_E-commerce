@extends('admin::layouts.app')
@section('title', 'Categories')
@section('content')

    <div class="container my-5">
        <!-- Header Section -->
        <div class="text-center mb-5">
            <h1 class="display-4 text-primary fw-bold">Category Management</h1>
            <p class="text-primary">Manage your categories easily from here.</p>
        </div>

        <!-- Products Section -->
      
    {{-- </div> --}}


    <!-- Categories Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Categories</h2>
            <button class="btn btn-light btn-sm" onclick="window.location.href='{{ route('dashboard.categories.create') }}'">
                <i class="bi bi-plus-circle"></i> Add Category
            </button>
        </div>
        <div class="card-body">
            @if (count($categories))
                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Numper of Products</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->products_count }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-sm btn-outline-primary me-2 mr-2"
                                                href="{{ route('dashboard.categories.edit', $category->id) }}">
                                                Edit
                                            </a>
                                            {{-- Uncomment for Delete Button --}}

                                            <form method="POST" action="{{ route('dashboard.categories.destroy', $category->id) }}">
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
            @else
                <p class="text-center text-muted">No Categories Found.</p>
            @endif
        </div>
    </div>
    </div>
    
    {{$categories->links() }}

@endsection
