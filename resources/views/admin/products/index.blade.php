@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        @include('components._messages')
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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Names</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Brand</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Primary Image</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr>
                                            <!-- Product ID -->
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">{{ $product->id }}</p>
                                            </td>

                                            <!-- Names -->
                                            <td class="align-middle text-left">
                                                <p class="text-xs text-secondary mb-0">En: {{ $product->name_en }}</p>
                                                <p class="text-xs text-secondary mb-0">Ar: {{ $product->name_ar }}</p>
                                                <p class="text-xs text-secondary mb-0">He: {{ $product->name_he }}</p>
                                            </td>

                                            <!-- Category -->
                                            <td class="align-middle text-left">
                                                @if($product->category)
                                                    <p class="text-xs text-secondary mb-0">{{ $product->category->name_en }}</p>
                                                @else
                                                    <span class="text-muted text-xs">No Category</span>
                                                @endif
                                            </td>

                                            <!-- Brand -->
                                            <td class="align-middle text-left">
                                                @if($product->brand)
                                                    <p class="text-xs text-secondary mb-0">{{ $product->brand->name_en }}</p>
                                                @else
                                                    <span class="text-muted text-xs">No Brand</span>
                                                @endif
                                            </td>

                                            <!-- Price -->
                                            <td class="align-middle text-right">
                                                <p class="text-xs text-secondary mb-0">${{ number_format($product->price, 2) }}</p>
                                            </td>

                                            <!-- Quantity -->
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">{{ $product->quantity }}</p>
                                            </td>

                                            <!-- Primary Image -->
                                            <td class="align-middle text-center">
                                                @if ($product->primaryImage)
                                                    <img src="{{ asset('storage/'.$product->primaryImage->image_url) }}" class="img-fluid rounded" height="50" alt="Primary Image">
                                                @else
                                                    <span class="text-muted text-xs">No Image</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-left">
                                                <p class="text-xs text-secondary mb-0">En: {{ $product->description_en }}</p>
                                                <p class="text-xs text-secondary mb-0">Ar: {{ $product->description_ar }}</p>
                                                <p class="text-xs text-secondary mb-0">He: {{ $product->description_he }}</p>
                                            </td>
                                            <!-- Status -->
                                            <td class="align-middle text-center">
                                                @if ($product->is_active)
                                                    <span class="badge badge-sm bg-gradient-success">Active</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td class="align-middle text-center">
                                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                                    class="text-secondary font-weight-bold text-xs me-2"
                                                    data-toggle="tooltip" title="Edit Product">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                    method="POST" style="display: inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-danger font-weight-bold text-xs border-0 bg-transparent"
                                                        data-toggle="tooltip" title="Delete Product">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-secondary text-sm">No products found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional: Pagination (if needed) -->
    
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
   
@endsection