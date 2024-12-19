@extends('admin.layouts.app')

@section('title', isset($isEdit) && $isEdit ? 'Edit Delivery Location' : 'Create Delivery Location')

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

        <!-- Delivery Form -->
        <form
            action="{{ isset($isEdit) && $isEdit ? route('admin.deliveries.update', $delivery->id) : route('admin.deliveries.store') }}"
            method="POST">
            @csrf
            @if (isset($isEdit) && $isEdit)
                @method('PUT')
            @endif

            <div class="row">
                <!-- Left Column: City and Country Fields -->
                <div class="col-lg-6 col-md-12 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>{{ isset($isEdit) && $isEdit ? 'Edit' : 'Create' }} Delivery Location</h6>
                        </div>
                        <div class="card-body">
                            <!-- City Fields -->
                            <div class="form-group mb-3">
                                <label for="city_en" class="form-label">City (English) <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="city_en" name="city_en"
                                    class="form-control @error('city_en') is-invalid @enderror"
                                    placeholder="Enter city in English"
                                    value="{{ old('city_en', $delivery->city_en ?? '') }}" required>
                                @error('city_en')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="city_ar" class="form-label">City (Arabic)</label>
                                <input type="text" id="city_ar" name="city_ar"
                                    class="form-control @error('city_ar') is-invalid @enderror"
                                    placeholder="Enter city in Arabic"
                                    value="{{ old('city_ar', $delivery->city_ar ?? '') }}">
                                @error('city_ar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="city_he" class="form-label">City (Hebrew)</label>
                                <input type="text" id="city_he" name="city_he"
                                    class="form-control @error('city_he') is-invalid @enderror"
                                    placeholder="Enter city in Hebrew"
                                    value="{{ old('city_he', $delivery->city_he ?? '') }}">
                                @error('city_he')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Country Fields -->
                            <div class="form-group mb-3">
                                <label for="country_en" class="form-label">Country (English) <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="country_en" name="country_en"
                                    class="form-control @error('country_en') is-invalid @enderror"
                                    placeholder="Enter country in English"
                                    value="{{ old('country_en', $delivery->country_en ?? '') }}" required>
                                @error('country_en')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="country_ar" class="form-label">Country (Arabic)</label>
                                <input type="text" id="country_ar" name="country_ar"
                                    class="form-control @error('country_ar') is-invalid @enderror"
                                    placeholder="Enter country in Arabic"
                                    value="{{ old('country_ar', $delivery->country_ar ?? '') }}">
                                @error('country_ar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="country_he" class="form-label">Country (Hebrew)</label>
                                <input type="text" id="country_he" name="country_he"
                                    class="form-control @error('country_he') is-invalid @enderror"
                                    placeholder="Enter country in Hebrew"
                                    value="{{ old('country_he', $delivery->country_he ?? '') }}">
                                @error('country_he')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Price and Status Fields -->
                <div class="col-lg-6 col-md-12 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Delivery Prices</h6>
                        </div>
                        <div class="card-body">
                            <!-- Price -->
                            <div class="form-group mb-3">
                                <label for="price" class="form-label">Price ($) <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01" id="price" name="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    placeholder="Enter delivery price" value="{{ old('price', $delivery->price ?? '') }}"
                                    required>
                                @error('price')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="form-group mb-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select id="is_active" name="is_active" class="form-control">
                                    <option value="1"
                                        {{ old('is_active', $delivery->is_active ?? '1') == '1' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0"
                                        {{ old('is_active', $delivery->is_active ?? '1') == '0' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="form-group text-end">
                <a href="{{ isset($isEdit) && $isEdit ? route('admin.deliveries.index') : route('admin.deliveries.index') }}"
                    class="btn btn-secondary">Cancel</a>
                <button type="submit"
                    class="btn btn-success">{{ isset($isEdit) && $isEdit ? 'Update Delivery Location' : 'Create Delivery Location' }}</button>
            </div>
        </form>
    </div>
@endsection
