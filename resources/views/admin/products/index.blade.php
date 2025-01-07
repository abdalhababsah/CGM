@extends('dashboard-layouts.app')

@section('content')
<div class="container-fluid py-4">
    @include('components._messages')

    <style>
        .col-md-3 {
            margin-top: 0px !important;
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
                    <div>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#importProductsModal">Import Products</button>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">Add New Product</a>
                    </div>
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
                                        <td class="align-middle text-right">₪{{ number_format($product->price, 2) }}</td>
                                        <td class="align-middle text-center">{{ $product->quantity }}</td>
                                        <td class="align-middle text-center">
                                            @if ($product->primaryImage)
                                                <img src="{{ asset('storage/'.$product->primaryImage->image_url) }}" class="img-fluid rounded" style="max-height: 150px" alt="Primary Image">
                                            @else
                                                <span class="text-muted text-xs">No Image</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-left">
                                            En: {{ \Illuminate\Support\Str::words($product->description_en, 3, '...') }}<br>
                                            Ar: {{ \Illuminate\Support\Str::words($product->description_ar, 3, '...') }}<br>
                                            He: {{ \Illuminate\Support\Str::words($product->description_he, 3, '...') }}
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
            <div class="mt-3">
                {{ $products->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importProductsModal" tabindex="-1" aria-labelledby="importProductsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Made modal larger -->
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="importProductsModalLabel">
                    <i class="fas fa-file-import me-2"></i>Import Products
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Instructions Section -->
                <div class="alert alert-info mb-4" role="alert">
                    <h6 class="alert-heading mb-2 text-white">
                        <i class="fas fa-info-circle me-2 "></i>Important Instructions
                    </h6>
                    <p class="mb-0 text-white">Please ensure your Excel file adheres to the following format:</p>
                </div>

                <!-- Requirements Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-hover border">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 40%">Field</th>
                                <th scope="col">Requirement</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">sku</span>
                                    <small class="d-block text-muted">Product unique identifier</small>
                                </td>
                                <td><span class="badge bg-primary">Required</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">name_en, name_ar, name_he</span>
                                    <small class="d-block text-muted">Product names in different languages</small>
                                </td>
                                <td><span class="badge bg-primary">Required</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">category_id</span>
                                    <small class="d-block text-muted">Product category identifier</small>
                                </td>
                                <td><span class="badge bg-primary">Required</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">brand_id</span>
                                    <small class="d-block text-muted">Product brand identifier</small>
                                </td>
                                <td><span class="badge bg-primary">Required</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">price</span>
                                    <small class="d-block text-muted">Product price</small>
                                </td>
                                <td><span class="badge bg-primary">Required</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">quantity</span>
                                    <small class="d-block text-muted">Stock quantity</small>
                                </td>
                                <td><span class="badge bg-secondary">Optional</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">primary_image</span>
                                    <small class="d-block text-muted">Main product image URL</small>
                                </td>
                                <td><span class="badge bg-secondary">Optional</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">image_1, image_2, image_3</span>
                                    <small class="d-block text-muted">Additional image URLs</small>
                                </td>
                                <td><span class="badge bg-secondary">Optional</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Upload Form -->
                <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-container border rounded-3 p-4 bg-light">
                        <div class="mb-4">
                            <label for="file" class="form-label fw-bold">
                                <i class="fas fa-file-excel me-2"></i>Upload Excel File
                            </label>
                            <input type="file" id="file" name="file" class="form-control" required 
                                   accept=".xlsx,.xls,.csv">
                            <small class="text-muted">Accepted formats: .xlsx, .xls, .csv</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-upload me-2"></i>Import Products
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom styles for the modal */
.modal-content {
    border: none;
    border-radius: 0.5rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.modal-header {
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
    padding: 1rem 1.5rem;
}

.table {
    margin-bottom: 0;
}

.table th, .table td {
    padding: 1rem;
    vertical-align: middle;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.8em;
}

.upload-container {
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}

.upload-container:hover {
    background-color: #fff;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-primary {
    padding: 0.625rem 1.25rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modal-dialog {
        margin: 0.5rem;
    }
    
    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }
}
</style>
@endsection