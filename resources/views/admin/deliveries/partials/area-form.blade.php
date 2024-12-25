<div class="area-item card mb-3">
    <div class="card-body">
        <div class="row">
            <!-- Area English Name -->
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="areas[{{ $index }}][area_en]" class="form-label">Area (English) <span class="text-danger">*</span></label>
                    <input type="text" name="areas[{{ $index }}][area_en]" class="form-control @error('areas.' . $index . '.area_en') is-invalid @enderror" placeholder="Enter area in English" value="{{ old('areas.' . $index . '.area_en', $area->area_en ?? '') }}" required>
                    @error('areas.' . $index . '.area_en')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Area Arabic Name -->
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="areas[{{ $index }}][area_ar]" class="form-label">Area (Arabic)</label>
                    <input type="text" name="areas[{{ $index }}][area_ar]" class="form-control @error('areas.' . $index . '.area_ar') is-invalid @enderror" placeholder="Enter area in Arabic" value="{{ old('areas.' . $index . '.area_ar', $area->area_ar ?? '') }}">
                    @error('areas.' . $index . '.area_ar')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Area Hebrew Name -->
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="areas[{{ $index }}][area_he]" class="form-label">Area (Hebrew)</label>
                    <input type="text" name="areas[{{ $index }}][area_he]" class="form-control @error('areas.' . $index . '.area_he') is-invalid @enderror" placeholder="Enter area in Hebrew" value="{{ old('areas.' . $index . '.area_he', $area->area_he ?? '') }}">
                    @error('areas.' . $index . '.area_he')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Company Area ID -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="areas[{{ $index }}][company_area_id]" class="form-label">Company Area ID</label>
                    <input type="text" name="areas[{{ $index }}][company_area_id]" class="form-control @error('areas.' . $index . '.company_area_id') is-invalid @enderror" placeholder="Enter company area ID" value="{{ old('areas.' . $index . '.company_area_id', $area->company_area_id ?? '') }}">
                    @error('areas.' . $index . '.company_area_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Delete Button -->
            <div class="col-md-6 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-area-button">Delete Area</button>
            </div>
        </div>

        <!-- Hidden ID Field (for editing) -->
        @if (isset($area->id))
            <input type="hidden" name="areas[{{ $index }}][id]" value="{{ $area->id }}">
        @endif
    </div>
</div>