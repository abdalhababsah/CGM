@extends('dashboard-layouts.app')

@section('content')
<div class="container-fluid py-4">
    @include('components._messages')

    <!-- Filters Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Filter Areas</h6>
                </div>
                <div class="card-body">
                    <form id="filterForm" method="GET" action="{{ route('admin.areas.index') }}">
                        <div class="row g-3">
                            <!-- Search Filter -->
                            <div class="col-md-6">
                                <label for="search" class="form-label">Search by Name</label>
                                <input 
                                    type="text" 
                                    id="search" 
                                    name="search" 
                                    class="form-control" 
                                    placeholder="Search by Name (EN, AR, HE)" 
                                    value="{{ request('search') }}">
                            </div>

                            <!-- Delivery Location Filter -->
                            <div class="col-md-6">
                                <label for="delivery_location_id" class="form-label">City</label>
                                <select id="delivery_location_id" name="delivery_location_id" class="form-control">
                                    <option value="">Select City</option>
                                    @foreach ($deliveryLocations as $location)
                                        <option value="{{ $location->id }}" {{ request('delivery_location_id') == $location->id ? 'selected' : '' }}>
                                            {{ $location->city_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100 mt-3">Apply Filters</button>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.areas.index') }}" class="btn btn-secondary w-100 mt-3">Clear Filters</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Areas Table -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Areas Table</h6>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">Add New Area</button>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name (EN)</th>
                                    <th>Name (AR)</th>
                                    <th>Name (HE)</th>
                                    <th>City</th>
                                    <th>Roadfn Area Id</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($areas as $area)
                                <tr>
                                    <td>{{ $area->id }}</td>
                                    <td>{{ $area->area_en }}</td>
                                    <td>{{ $area->area_ar }}</td>
                                    <td>{{ $area->area_he }}</td>
                                    <td>{{ $area->deliveryLocation->city_en ?? 'No City Assigned' }}</td>
                                    <td>{{ $area->company_area_id }}</td>
                                    <td>
                                        <button 
                                            class="btn btn-sm btn-warning edit-area" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal"
                                            data-id="{{ $area->id }}"
                                            data-area-en="{{ $area->area_en }}"
                                            data-area-ar="{{ $area->area_ar }}"
                                            data-area-he="{{ $area->area_he }}"
                                            data-delivery-location-id="{{ $area->delivery_location_id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('admin.areas.destroy', $area->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this area?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                    

                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-secondary text-sm">No areas found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $areas->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.areas.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add New Area</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="area_en" class="form-label">Name (EN)</label>
                        <input type="text" name="area_en" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="area_ar" class="form-label">Name (AR)</label>
                        <input type="text" name="area_ar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="area_he" class="form-label">Name (HE)</label>
                        <input type="text" name="area_he" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="delivery_location_id" class="form-label">City</label>
                        <select name="delivery_location_id" class="form-control" required>
                            @foreach ($deliveryLocations as $location)
                                <option value="{{ $location->id }}">{{ $location->city_en }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="company_area_id" class="form-label">Company Area ID (Optional)</label>
                        <input type="text" name="company_area_id" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Area</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Area</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-area-id">
                    <div class="mb-3">
                        <label for="edit-area-en" class="form-label">Name (EN)</label>
                        <input type="text" id="edit-area-en" name="area_en" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-area-ar" class="form-label">Name (AR)</label>
                        <input type="text" id="edit-area-ar" name="area_ar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-area-he" class="form-label">Name (HE)</label>
                        <input type="text" id="edit-area-he" name="area_he" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-delivery-location-id" class="form-label">City</label>
                        <select id="edit-delivery-location-id" name="delivery_location_id" class="form-control" required>
                            @foreach ($deliveryLocations as $location)
                                <option value="{{ $location->id }}">{{ $location->city_en }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-company-area-id" class="form-label">Company Area ID (Optional)</label>
                        <input type="text" id="edit-company-area-id" name="company_area_id" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Area</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const areaEn = button.getAttribute('data-area-en');
            const areaAr = button.getAttribute('data-area-ar');
            const areaHe = button.getAttribute('data-area-he');
            const deliveryLocationId = button.getAttribute('data-delivery-location-id');
            const formAction = "{{ url('admin/areas') }}/" + id;

            document.getElementById('editForm').action = formAction;
            document.getElementById('edit-area-id').value = id;
            document.getElementById('edit-area-en').value = areaEn;
            document.getElementById('edit-area-ar').value = areaAr;
            document.getElementById('edit-area-he').value = areaHe;
            document.getElementById('edit-delivery-location-id').value = deliveryLocationId;
        });
    });
</script>
@endsection