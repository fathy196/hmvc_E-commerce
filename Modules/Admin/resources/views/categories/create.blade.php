@extends('admin::layouts.app')
@section('title', 'Create Category')
@section('content')

<div class="container my-5">
    <!-- Header Section -->
    <div class="text-center mb-5">
        <h1 class="display-5 text-primary fw-bold">Create New Category</h1>
        <p class="text-muted">Add a new category to organize your products.</p>
    </div>

    <!-- Form Section -->
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('dashboard.categories.store') }}" method="POST">
                        @csrf

                        <!-- Category Name -->
                        <div class="form-group mb-4">
                            <label for="name" class="form-label fw-semibold">Category Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter category name">
                            @error('name')
                                <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Create Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
