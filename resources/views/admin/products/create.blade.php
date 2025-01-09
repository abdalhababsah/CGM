<!-- resources/views/admin/products/create.blade.php -->

@extends('dashboard-layouts.app')

@section('title', 'Create Product')

@section('content')
    <div class="container-fluid py-4">
        <!-- Display Validation Errors -->
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
            <!-- Left Side: Main Form -->
            <div class="col-lg-8 col-md-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Create Product</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="productForm">
                            @csrf
                            <!-- Product Information Section -->
                            <section class="mb-4">
                                <h5 class="mb-3">Product Information</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name_en" class="form-label">Name (English)</label>
                                        <input type="text" name="name_en" id="name_en"
                                            class="form-control styled-input" required>
                                        <span id="name_en_error" class="text-danger small" style="display:none;">This field
                                            is required</span>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="name_ar" class="form-label">Name (Arabic)</label>
                                        <input type="text" name="name_ar" id="name_ar"
                                            class="form-control styled-input" required>
                                        <span id="name_ar_error" class="text-danger small" style="display:none;">This field
                                            is required</span>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="name_he" class="form-label">Name (Hebrew)</label>
                                        <input type="text" name="name_he" id="name_he"
                                            class="form-control styled-input" required>
                                        <span id="name_he_error" class="text-danger small" style="display:none;">This field
                                            is required</span>
                                    </div>
                                </div>
                            </section>

                            <!-- Product Description Section -->
                            <section class="mb-4">
                                <h5 class="mb-3">Product Description</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="description_en" class="form-label">Description (English)</label>
                                        <textarea name="description_en" id="description_en" class="form-control styled-input" rows="3"></textarea>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="description_ar" class="form-label">Description (Arabic)</label>
                                        <textarea name="description_ar" id="description_ar" class="form-control styled-input" rows="3"></textarea>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="description_he" class="form-label">Description (Hebrew)</label>
                                        <textarea name="description_he" id="description_he" class="form-control styled-input" rows="3"></textarea>
                                    </div>
                                </div>
                            </section>

                            <!-- Product Images Section -->
                            <section class="mb-4">
                                <h5 class="mb-3">Product Images</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="images" class="form-label">Upload Images</label>
                                        <div id="imageDropzone" class="dropzone"></div>
                                        <span id="imageError" class="text-danger small" style="display:none;">Please upload
                                            at least one image</span>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Side: Options -->
            <div class="col-lg-4 col-md-12">
                <!-- Primary Image -->
                <div class="card mb-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Main Image</h6>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <p class="text-muted">No Image uploaded</p>
                        <div class="form-group mt-3">
                            <label for="is_primary" class="form-label">Upload Main Image</label>
                            <input type="file" id="is_primary" name="is_primary" class="form-control">
                        </div>
                    </div>
                </div>


                <!-- Options -->
                <div class="card my-4">
                    <div class="card-header pb-0">
                        <h6>Options</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-1">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select styled-input" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name_en }}</option>
                                @endforeach
                            </select>
                            <span id="category_id_error" class="text-danger small" style="display:none;">Please select a
                                category</span>
                        </div>

                        <div class="mb-1">
                            <label for="brand_id" class="form-label">Brand</label>
                            <select name="brand_id" id="brand_id" class="form-select styled-input">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name_en }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Replace your existing multi-select elements with these -->

                        <div class="mb-3">
                            <label for="hair_pores" class="form-label">Hair Pores</label>
                            <select name="hair_pores[]" id="hair_pores" class="form-select select2-multiple"
                                multiple="multiple" data-placeholder="Select Hair Pores">
                                @foreach ($hairPores as $hairPore)
                                    <option value="{{ $hairPore->id }}">{{ $hairPore->name_en }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="hair_types" class="form-label">Hair Types</label>
                            <select name="hair_types[]" id="hair_types" class="form-select select2-multiple"
                                multiple="multiple" data-placeholder="Select Hair Types">
                                @foreach ($hairTypes as $hairType)
                                    <option value="{{ $hairType->id }}">{{ $hairType->name_en }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="hair_thicknesses" class="form-label">Hair Thicknesses</label>
                            <select name="hair_thicknesses[]" id="hair_thicknesses" class="form-select select2-multiple"
                                multiple="multiple" data-placeholder="Select Hair Thicknesses">
                                @foreach ($hairThicknesses as $hairThickness)
                                    <option value="{{ $hairThickness->id }}">{{ $hairThickness->name_en }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-1">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select styled-input">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" step="0.01" name="price" id="price"
                                    class="form-control styled-input" required>
                                <span id="price_error" class="text-danger small" style="display:none;">This field is
                                    required</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control styled-input"
                                    required>
                                <span id="quantity_error" class="text-danger small" style="display:none;">This field is
                                    required</span>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="button" id="submitBtn" class="btn btn-primary mb-2">Submit</button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .select2-container--classic .select2-selection--multiple .select2-selection__choice{
            background-color: #981e24 !important;
        }
        .select2-container--classic .select2-selection--multiple .select2-selection__choice__display{
            color: white !important;
        }
        .select2-container--classic .select2-selection--multiple .select2-selection__choice__remove{
            color: white !important; 
        }
    </style>
    <!-- Dropzone.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
    <!-- Add these in your layout file or before closing </head> -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;

        const myDropzone = new Dropzone("#imageDropzone", {
            url: "{{ route('admin.products.store') }}",
            autoProcessQueue: false,
            uploadMultiple: true,
            addRemoveLinks: true,
            acceptedFiles: "image/*",
            parallelUploads: 10,
            maxFiles: 10,
            paramName: "images[]",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        });

        document.getElementById('submitBtn').addEventListener('click', function() {
            this.disabled = true;

            // Create a new FormData object
            const formData = new FormData();

            // Append all input fields manually
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('name_en', document.getElementById('name_en').value);
            formData.append('name_ar', document.getElementById('name_ar').value);
            formData.append('name_he', document.getElementById('name_he').value);
            formData.append('description_en', document.getElementById('description_en').value);
            formData.append('description_ar', document.getElementById('description_ar').value);
            formData.append('description_he', document.getElementById('description_he').value);
            formData.append('category_id', document.getElementById('category_id').value);
            formData.append('brand_id', document.getElementById('brand_id').value);
            formData.append('is_active', document.getElementById('status').value === 'active' ? 1 : 0);
            formData.append('price', document.getElementById('price').value);
            formData.append('quantity', document.getElementById('quantity').value);

            // Append hair pores
            Array.from(document.getElementById('hair_pores').selectedOptions).forEach(option => {
                formData.append('hair_pores[]', option.value);
            });

            // Append hair types
            Array.from(document.getElementById('hair_types').selectedOptions).forEach(option => {
                formData.append('hair_types[]', option.value);
            });

            // Append hair thicknesses
            Array.from(document.getElementById('hair_thicknesses').selectedOptions).forEach(option => {
                formData.append('hair_thicknesses[]', option.value);
            });

            // Append main image (is_primary)
            if (document.getElementById('is_primary').files[0]) {
                formData.append('is_primary', document.getElementById('is_primary').files[0]);
            }

            // Append additional images
            myDropzone.getAcceptedFiles().forEach(file => {
                formData.append("images[]", file);
            });

            // Submit the form via Fetch API
            fetch("{{ route('admin.products.store') }}", {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(error => {
                            throw error;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Redirect to index on success
                    window.location.href = "{{ route('admin.products.index') }}";
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.disabled = false;

                    // Optionally display validation errors
                    if (error.errors) {
                        Object.keys(error.errors).forEach(field => {
                            const errorElement = document.getElementById(`${field}_error`);
                            if (errorElement) {
                                errorElement.style.display = 'inline';
                                errorElement.textContent = error.errors[field][0];
                            }
                        });
                    }
                });
        });

        $(document).ready(function() {
                    $('.select2-multiple').select2({
            theme: 'classic',
            width: '100%',
            closeOnSelect: false,
            allowClear: true,
            tags: false,
        });

        // Custom styling
        $('.select2-multiple').each(function() {
            $(this).siblings('.select2-container').css({
                'border-radius': '0.375rem',
                'border': '1px solid #d2d6da'
            });
        });
    });

    </script>
@endsection
