@extends('admin.layouts.app')

@section('title', isset($brand) ? 'Edit Brand' : 'Create Brand')

@section('content')
<div class="container-fluid py-4">
    <form action="{{ isset($brand) ? route('admin.brands.update', $brand->id) : route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($brand))
            @method('PUT')
        @endif

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                <!-- Thumbnail Card -->
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Brand Logo</h6>
                    </div>
                    <div class="card-body text-center">
                        @if(isset($brand) && $brand->logo_url)
                            <img src="{{ asset($brand->logo_url) }}" alt="Brand Logo" class="img-thumbnail" style="max-width: 100%;">
                        @else
                            <p class="text-muted">No logo uploaded</p>
                        @endif
                        <div class="form-group mt-3">
                            <label for="logo_path" class="form-label">Upload Logo</label>
                            <input type="file" id="logo_path" name="logo_path" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Names Card -->
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Brand Names</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name_en" class="form-label">Name (English) <span class="text-danger">*</span></label>
                            <input type="text" id="name_en" name="name_en" class="form-control" placeholder="Enter name in English" value="{{ old('name_en', $brand->name_en ?? '') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name_ar" class="form-label">Name (Arabic)</label>
                            <input type="text" id="name_ar" name="name_ar" class="form-control" placeholder="Enter name in Arabic" value="{{ old('name_ar', $brand->name_ar ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="name_he" class="form-label">Name (Hebrew)</label>
                            <input type="text" id="name_he" name="name_he" class="form-control" placeholder="Enter name in Hebrew" value="{{ old('name_he', $brand->name_he ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-9 col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ isset($brand) ? 'Edit Brand' : 'Create Brand' }}</h6>
                    </div>
                    <div class="card-body">
                        <!-- Description Fields -->
                        <div class="form-group mb-3">
                            <label for="description_en" class="form-label">Description (English)</label>
                            <div id="description_en_editor" class="quill-editor">{!! old('description_en', $brand->description_en ?? '') !!}</div>
                            <input type="hidden" name="description_en" id="description_en">
                        </div>
                        <div class="form-group mb-3">
                            <label for="description_ar" class="form-label">Description (Arabic)</label>
                            <div id="description_ar_editor" class="quill-editor">{!! old('description_ar', $brand->description_ar ?? '') !!}</div>
                            <input type="hidden" name="description_ar" id="description_ar">
                        </div>
                        <div class="form-group mb-3">
                            <label for="description_he" class="form-label">Description (Hebrew)</label>
                            <div id="description_he_editor" class="quill-editor">{!! old('description_he', $brand->description_he ?? '') !!}</div>
                            <input type="hidden" name="description_he" id="description_he">
                        </div>

                        <!-- Status -->
                        <div class="form-group mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select id="is_active" name="is_active" class="form-control">
                                <option value="1" {{ isset($brand) && $brand->is_active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ isset($brand) && !$brand->is_active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group text-end">
                            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">{{ isset($brand) ? 'Update Brand' : 'Create Brand' }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <!-- Include Quill -->

    <script>
        // Initialize Quill editors
        const descriptionEnEditor = new Quill('#description_en_editor', { theme: 'snow' });
        const descriptionArEditor = new Quill('#description_ar_editor', { theme: 'snow' });
        const descriptionHeEditor = new Quill('#description_he_editor', { theme: 'snow' });

        // On form submit, set hidden inputs with the Quill editor contents
        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('description_en').value = descriptionEnEditor.root.innerHTML;
            document.getElementById('description_ar').value = descriptionArEditor.root.innerHTML;
            document.getElementById('description_he').value = descriptionHeEditor.root.innerHTML;
        });
    </script>
@endpush