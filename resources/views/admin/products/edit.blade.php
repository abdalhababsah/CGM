@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
    <div class="container-fluid py-4">
        <!-- Display Validation Errors (if any) -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <!-- Part 1: General Information -->
            <div class="col-lg-8 col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6>General Information</h6>
                    </div>
                    <div class="card-body">
                        <form id="generalInfoForm">
                            @csrf
                            @method('PUT') <!-- Necessary for PUT request -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="name_en" class="form-label">Name (English)</label>
                                    <input type="text" name="name_en" id="name_en"
                                        class="form-control styled-input" value="{{ $product->name_en }}" required>
                                    <span id="name_en_error" class="text-danger small" style="display:none;">This field is required</span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="name_ar" class="form-label">Name (Arabic)</label>
                                    <input type="text" name="name_ar" id="name_ar"
                                        class="form-control styled-input" value="{{ $product->name_ar }}" required>
                                    <span id="name_ar_error" class="text-danger small" style="display:none;">This field is required</span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="name_he" class="form-label">Name (Hebrew)</label>
                                    <input type="text" name="name_he" id="name_he"
                                        class="form-control styled-input" value="{{ $product->name_he }}" required>
                                    <span id="name_he_error" class="text-danger small" style="display:none;">This field is required</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="description_en" class="form-label">Description (English)</label>
                                    <textarea name="description_en" id="description_en" class="form-control styled-input" rows="3">{{ $product->description_en }}</textarea>
                                    <span id="description_en_error" class="text-danger small" style="display:none;">This field is required</span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="description_ar" class="form-label">Description (Arabic)</label>
                                    <textarea name="description_ar" id="description_ar" class="form-control styled-input" rows="3">{{ $product->description_ar }}</textarea>
                                    <span id="description_ar_error" class="text-danger small" style="display:none;">This field is required</span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="description_he" class="form-label">Description (Hebrew)</label>
                                    <textarea name="description_he" id="description_he" class="form-control styled-input" rows="3">{{ $product->description_he }}</textarea>
                                    <span id="description_he_error" class="text-danger small" style="display:none;">This field is required</span>
                                </div>
                            </div>
                            <button type="button" id="updateGeneralInfo" class="btn btn-primary">Update General Info</button>
                        </form>
                    </div>
                </div>
                            <!-- Part 3: Manage Images -->
            <div class="col-lg-12 col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6>Manage Images</h6>
                    </div>
                    <div class="card-body">
                        <form id="imagesForm">
                            @csrf
                            <div id="imageDropzone" class="dropzone"></div>
                            <span id="imageError" class="text-danger small d-none">Please upload at least one image.</span>
                            <button type="button" id="updateImages" class="btn btn-primary mt-3">Update Images</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>

            <!-- Part 2: Options -->
            <div class="col-lg-4 col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6>Main Image</h6>
                    </div>
                    <div class="card-body text-center">
                        @php
                            $primaryImage = $product->images()->where('is_primary', true)->first();
                        @endphp
                        @if ($primaryImage)
                            <img src="{{ asset('storage/' . $primaryImage->image_url) }}" class="img-thumbnail mb-2" style="max-height: 150px;">
                            <form action="{{ route('admin.products.deleteImage', $primaryImage->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete Primary Image</button>
                            </form>
                        @else
                            <p class="text-muted">No Image uploaded</p>
                        @endif
                        <div class="form-group mt-3">
                            <label for="is_primary" class="form-label">Upload Main Image</label>
                            <input type="file" id="is_primary" name="is_primary" class="form-control">
                            <span id="is_primary_error" class="text-danger small" style="display:none;">Please upload a primary image</span>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h6>Options</h6>
                    </div>
                    <div class="card-body">
                        <form id="optionsForm">
                            @csrf
                            @method('PUT') <!-- Necessary for PUT request -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" id="category_id" class="form-select styled-input" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                <span id="category_id_error" class="text-danger small" style="display:none;">Please select a category</span>
                            </div>
                            <div class="mb-3">
                                <label for="brand_id" class="form-label">Brand</label>
                                <select name="brand_id" id="brand_id" class="form-select styled-input">
                                    <option value="">No Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                <span id="brand_id_error" class="text-danger small" style="display:none;">Please select a brand</span>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" step="0.01" name="price" id="price"
                                    class="form-control styled-input" value="{{ $product->price }}" required>
                                <span id="price_error" class="text-danger small" style="display:none;">This field is required</span>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control styled-input"
                                    value="{{ $product->quantity }}" required>
                                <span id="quantity_error" class="text-danger small" style="display:none;">This field is required</span>
                            </div>
                            <div class="mb-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select name="is_active" id="is_active" class="form-select styled-input">
                                    <option value="1" {{ $product->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <span id="is_active_error" class="text-danger small" style="display:none;">This field is required</span>
                            </div>
                            <button type="button" id="updateOptions" class="btn btn-primary">Update Options</button>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Part 4: Primary Image -->
  
        </div>
    </div>
@endsection