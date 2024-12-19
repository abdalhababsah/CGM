@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    @include('components._messages')

    <style>
        .col-md-3{
                 margin-top:0px !important;
        }
    </style>
    <!-- Filters Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Filter Products</h6>
                </div>
                <div class="card-body">
                    <form id="filterForm" method="GET" action="{{ route('admin.products.index') }}">
                        <div class="row g-3">
                            <!-- Search Filter -->
                            <div class="col-md-3">
                                <label for="search" class="form-label">Search by Name</label>
                                <input 
                                    type="text" 
                                    id="search" 
                                    name="search" 
                                    class="form-control" 
                                    placeholder="Search by Name (EN, AR, HE)" 
                                    value="{{ request('search') }}">
                            </div>

                            <!-- Category Filter -->
                            <div class="col-md-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select id="category_id" name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Brand Filter -->
                            <div class="col-md-3">
                                <label for="brand_id" class="form-label">Brand</label>
                                <select id="brand_id" name="brand_id" class="form-control">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100 mt-3">Apply Filters</button>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary w-100 mt-3">Clear Filters</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Products Table</h6>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">Add New Product</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Names</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-center">Primary Image</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td class="align-middle text-center">{{ $product->id }}</td>
                                        <td class="align-middle text-left">
                                            En: {{ $product->name_en }}<br>
                                            Ar: {{ $product->name_ar }}<br>
                                            He: {{ $product->name_he }}
                                        </td>
                                        <td class="align-middle text-left">{{ $product->category->name_en ?? 'No Category' }}</td>
                                        <td class="align-middle text-left">{{ $product->brand->name_en ?? 'No Brand' }}</td>
                                        <td class="align-middle text-right">${{ number_format($product->price, 2) }}</td>
                                        <td class="align-middle text-center">{{ $product->quantity }}</td>
                                        <td class="align-middle text-center">
                                            @if ($product->primaryImage)
                                                <img src="{{ asset('storage/'.$product->primaryImage->image_url) }}" class="img-fluid rounded" height="50" alt="Primary Image">
                                            @else
                                                <span class="text-muted text-xs">No Image</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-left">
                                            En: {{ $product->description_en }}<br>
                                            Ar: {{ $product->description_ar }}<br>
                                            He: {{ $product->description_he }}
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge {{ $product->is_active ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-secondary font-weight-bold text-xs me-2">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger font-weight-bold text-xs border-0 bg-transparent">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-secondary text-sm">No products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection