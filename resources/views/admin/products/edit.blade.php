@extends('dashboard-layouts.app')

@section('title', 'Edit Product')

@section('content')

    <div class="container-fluid py-4">
        <!-- Display Validation Errors (if any) -->
        @if ($errors->any())
            <div class="alert alert-danger" id="validationErrors">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Success Message -->
        <div class="alert alert-success d-none" id="successMessage"></div>

        <div class="row">
            <!-- Left Side: General Information and Images -->
            <div class="col-lg-8 col-md-12">
                <!-- General Information Card -->
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
                                    <input type="text" name="name_en" id="name_en" class="form-control styled-input"
                                        value="{{ old('name_en', $product->name_en) }}" required>
                                    <span id="name_en_error" class="text-danger small" style="display:none;">This field is
                                        required</span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="name_ar" class="form-label">Name (Arabic)</label>
                                    <input type="text" name="name_ar" id="name_ar" class="form-control styled-input"
                                        value="{{ old('name_ar', $product->name_ar) }}" required>
                                    <span id="name_ar_error" class="text-danger small" style="display:none;">This field is
                                        required</span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="name_he" class="form-label">Name (Hebrew)</label>
                                    <input type="text" name="name_he" id="name_he" class="form-control styled-input"
                                        value="{{ old('name_he', $product->name_he) }}" required>
                                    <span id="name_he_error" class="text-danger small" style="display:none;">This field is
                                        required</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="description_en" class="form-label">Description (English)</label>
                                    <textarea name="description_en" id="description_en" class="form-control styled-input" rows="3">{{ old('description_en', $product->description_en) }}</textarea>
                                    <span id="description_en_error" class="text-danger small" style="display:none;">This
                                        field is required</span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="description_ar" class="form-label">Description (Arabic)</label>
                                    <textarea name="description_ar" id="description_ar" class="form-control styled-input" rows="3">{{ old('description_ar', $product->description_ar) }}</textarea>
                                    <span id="description_ar_error" class="text-danger small" style="display:none;">This
                                        field is required</span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="description_he" class="form-label">Description (Hebrew)</label>
                                    <textarea name="description_he" id="description_he" class="form-control styled-input" rows="3">{{ old('description_he', $product->description_he) }}</textarea>
                                    <span id="description_he_error" class="text-danger small" style="display:none;">This
                                        field is required</span>
                                </div>
                            </div>
                            <button type="button" id="updateGeneralInfo" class="btn btn-primary">Update General
                                Info</button>
                        </form>
                    </div>
                </div>

                <!-- Manage Additional Images Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6>Manage Additional Images</h6>
                    </div>
                    <div class="card-body">
                        <form id="imagesForm">
                            @csrf
                            <div id="imageDropzone" class="dropzone"></div>
                            <span id="images_error" class="text-danger small d-none">Please upload valid image files.</span>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Side: Options & Primary Image -->
            <div class="col-lg-4 col-md-12">

                <div class="card mb-4">
                    <div class="card-header">
                        <h6>Main Image</h6>
                    </div>
                    <div class="card-body text-center">
                        @php
                            $primaryImage = $product->images()->where('is_primary', true)->first();
                        @endphp
                        <div id="primaryImageContainer">
                            @if ($primaryImage)
                                <img src="{{ asset('storage/' . $primaryImage->image_url) }}" class="img-thumbnail mb-2"
                                    style="max-height: 150px;" id="primaryImageDisplay">
                            @else
                                <p class="text-muted" id="noPrimaryImage">No Image uploaded</p>
                            @endif
                        </div>
                        <div class="form-group mt-3">
                            <label for="is_primary" class="form-label">Upload Main Image</label>
                            <input type="file" id="is_primary" name="is_primary" class="form-control">
                            <span id="is_primary_error" class="text-danger small" style="display:none;">Please upload a
                                primary image</span>
                        </div>
                        <button type="button" id="updatePrimaryImage" class="btn btn-primary mt-2">Update Primary
                            Image</button>
                    </div>
                </div>
                <!-- Options Card -->
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
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name_en }}</option>
                                    @endforeach
                                </select>
                                <span id="category_id_error" class="text-danger small" style="display:none;">Please
                                    select a category</span>
                            </div>
                            <div class="mb-3">
                                <label for="brand_id" class="form-label">Brand</label>
                                <select name="brand_id" id="brand_id" class="form-select styled-input">
                                    <option value="">No Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name_en }}</option>
                                    @endforeach
                                </select>
                                <span id="brand_id_error" class="text-danger small" style="display:none;">Please select a
                                    brand</span>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" step="0.01" name="price" id="price"
                                    class="form-control styled-input" value="{{ old('price', $product->price) }}"
                                    required>
                                <span id="price_error" class="text-danger small" style="display:none;">This field is
                                    required</span>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control styled-input"
                                    value="{{ old('quantity', $product->quantity) }}" required>
                                <span id="quantity_error" class="text-danger small" style="display:none;">This field is
                                    required</span>
                            </div>
                            <div class="mb-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select name="is_active" id="is_active" class="form-select styled-input">
                                    <option value="1"
                                        {{ old('is_active', $product->is_active) == '1' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0"
                                        {{ old('is_active', $product->is_active) == '0' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                <span id="is_active_error" class="text-danger small" style="display:none;">This field is
                                    required</span>
                            </div>
                            <button type="button" id="updateOptions" class="btn btn-primary">Update Options</button>
                        </form>
                    </div>
                </div>

                <!-- Main Image Section -->

            </div>
        </div>
    </div>

    <!-- Include Dropzone CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
        integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Include jQuery -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <!-- Include Dropzone JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

    <!-- Include SweetAlert2 (for better alerts) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .dropzone {
            border: 2px dashed #007bff;
            border-radius: 5px;
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
        }

        .styled-input {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            background-color: #f8f9fa;
        }

        .styled-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .dropzone .dz-preview .dz-image img {
            border-radius: 5px;
            width: 100%;
            height: auto;
        }
    </style>

    <script>
        Dropzone.autoDiscover = false;

        $(document).ready(function() {
            // Setup CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Function to display success messages
            function showSuccess(message) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            }

            // Function to display validation errors
            function showErrors(errors) {
                // Hide all previous errors
                $('span.text-danger').hide();

                // Iterate through errors and display them
                $.each(errors, function(field, messages) {
                    if (field.startsWith('images')) {
                        $('#images_error').text(messages[0]).removeClass('d-none');
                    } else {
                        $('#' + field + '_error').text(messages[0]).show();
                    }
                });
            }

            $(document).ready(function() {
                // Setup CSRF token for AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Function to refetch and reload images
                function fetchImages() {
                    $.ajax({
                        url: '{{ route('admin.products.fetchImages', $product->id) }}',
                        type: 'GET',
                        success: function(response) {

                            response.images.forEach(function(image) {
                                let mockFile = {
                                    name: image.image_url.split('/').pop(),
                                    size: 12345,
                                    imageId: image.id
                                };

                                var dropzone = Dropzone.forElement('#imageDropzone');
                                dropzone.emit("addedfile", mockFile);
                                dropzone.emit("thumbnail", mockFile,
                                    "{{ asset('storage') }}/" + image.image_url);
                                dropzone.emit("complete", mockFile);

                                // Store image ID for later use (e.g., deletion)
                                mockFile.previewElement.dataset.imageId = image.id;
                            });
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed to reload images.', 'error');
                        }
                    });
                }
                var myDropzone = new Dropzone("#imageDropzone", {
                    url: '{{ route('admin.products.uploadAdditionalImages', $product->id) }}',
                    paramName: "images[]",
                    maxFilesize: 2,
                    acceptedFiles: 'image/*',
                    addRemoveLinks: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    init: function() {
                        fetchImages();

                        // Handle image removal
                        this.on("removedfile", function(file) {
                            if (file.previewElement && file.previewElement.dataset
                                .imageId) {
                                var imageId = file.previewElement.dataset.imageId;

                                // Send delete request to the backend
                                $.ajax({
                                    url: '{{ route('admin.products.deleteImage', '') }}/' +
                                        imageId,
                                    type: 'DELETE',
                                    success: function(response) {
                                        Swal.fire('Success', response
                                            .message, 'success');
                                    },
                                    error: function() {
                                        Swal.fire('Error',
                                            'Failed to delete the image.',
                                            'error');
                                    }
                                });
                            }
                        });

                        // Handle successful uploads
                        this.on("success", function(file, response) {
                            // Dropzone.forElement('#imageDropzone').removeAllFiles(true);
                            // fetchImages();
                        });

                        // Handle errors
                        this.on("error", function(file, response) {
                            if (typeof response === "object" && response.errors) {
                                Swal.fire('Error', response.errors[0], 'error');
                            } else {
                                Swal.fire('Error',
                                    'An error occurred while uploading the image.',
                                    'error');
                            }
                        });
                    }
                });
            });
            /**
             * Manually clears all files from a Dropzone instance.
             * @param {Dropzone} dropzoneInstance - The Dropzone instance to clear.
             */
            function clearDropzone(dropzoneInstance) {
                if (dropzoneInstance && dropzoneInstance.files.length > 0) {
                    // Iterate over each file in the Dropzone instance and remove it
                    dropzoneInstance.files.forEach(function(file) {
                        dropzoneInstance.removeFile(file); // Removes file from Dropzone
                    });
                }
            }

            // Handle General Information Update
            $('#updateGeneralInfo').click(function() {
                let formData = {
                    name_en: $('#name_en').val(),
                    name_ar: $('#name_ar').val(),
                    name_he: $('#name_he').val(),
                    description_en: $('#description_en').val(),
                    description_ar: $('#description_ar').val(),
                    description_he: $('#description_he').val(),
                };

                $.ajax({
                    url: '{{ route('admin.products.updateGeneralInfo', $product->id) }}',
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        showSuccess(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            showErrors(xhr.responseJSON.errors);
                        } else {
                            Swal.fire('Error',
                                'An error occurred while updating general information.',
                                'error');
                        }
                    }
                });
            });

            // Handle Options Update
            $('#updateOptions').click(function() {
                let formData = {
                    category_id: $('#category_id').val(),
                    brand_id: $('#brand_id').val(),
                    price: $('#price').val(),
                    quantity: $('#quantity').val(),
                    is_active: $('#is_active').val(),
                };

                $.ajax({
                    url: '{{ route('admin.products.updateOptions', $product->id) }}',
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        showSuccess(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            showErrors(xhr.responseJSON.errors);
                        } else {
                            Swal.fire('Error', 'An error occurred while updating options.',
                                'error');
                        }
                    }
                });
            });

            // Handle Primary Image Update
            $('#updatePrimaryImage').click(function() {
                var fileInput = $('#is_primary')[0];
                if (fileInput.files.length === 0) {
                    $('#is_primary_error').text('Please upload a primary image').show();
                    return;
                }

                var formData = new FormData();
                formData.append('is_primary', fileInput.files[0]);
                formData.append('_method', 'PUT'); // Simulate a PUT request

                $.ajax({
                    url: '{{ route('admin.products.updatePrimaryImage', $product->id) }}',
                    type: 'POST', // Still use POST as the actual HTTP method
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        showSuccess(response.message);

                        // Update the primary image display
                        if ($('#primaryImageDisplay').length) {
                            $('#primaryImageDisplay').attr('src', response.primary_image_url);
                        } else {
                            $('#noPrimaryImage').remove();
                            $('#primaryImageContainer').append(
                                '<img src="' + response.primary_image_url +
                                '" class="img-thumbnail mb-2" style="max-height: 150px;" id="primaryImageDisplay">'
                            );
                        }

                        // Reset the file input
                        $('#is_primary').val('');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            $('#is_primary_error').text(xhr.responseJSON.errors.is_primary[0])
                                .show();
                        } else {
                            Swal.fire('Error',
                                'An error occurred while updating the primary image.',
                                'error');
                        }
                    }
                });
            });
        });
    </script>

@endsection
