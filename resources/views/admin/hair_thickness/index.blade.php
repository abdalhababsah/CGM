@extends('dashboard-layouts.app')

@section('title', 'Hair Thicknesses')

@section('content')
    <div class="container-fluid py-4">
        @include('components._messages')

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <!-- Card Header -->
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Hair Thicknesses</h6>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createHairThicknessModal">
                            Add Hair Thickness
                        </button>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name (EN)</th>
                                        <th>Name (AR)</th>
                                        <th>Name (HE)</th>

                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($hairThicknesses as $thickness)
                                        <tr>
                                            <td>{{ $thickness->id }}</td>
                                            <td>{{ $thickness->name_en }}</td>
                                            <td>{{ $thickness->name_ar }}</td>
                                            <td>{{ $thickness->name_he }}</td>

                                            <td class="text-center">
                                                <a href="#"
                                                   class="btn btn-sm btn-info edit-hair-thickness-btn"
                                                   data-bs-toggle="modal" data-bs-target="#editHairThicknessModal"
                                                   data-id="{{ $thickness->id }}"
                                                   data-name_en="{{ $thickness->name_en }}"
                                                   data-name_ar="{{ $thickness->name_ar }}"
                                                   data-name_he="{{ $thickness->name_he }}"
                                                   data-is_active="{{ $thickness->is_active }}">
                                                   Edit
                                                </a>
                                                <form action="{{ route('admin.hair-thickness.destroy', $thickness->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this hair thickness?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No hair thicknesses found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $hairThicknesses->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Hair Thickness Modal -->
            <div class="modal fade" id="createHairThicknessModal" tabindex="-1" aria-labelledby="createHairThicknessModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.hair-thickness.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="createHairThicknessModalLabel">Add Hair Thickness</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Name EN -->
                                <div class="mb-3">
                                    <label for="name_en" class="form-label">Name (EN)</label>
                                    <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" id="name_en" value="{{ old('name_en') }}" required>
                                    @error('name_en')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Name AR -->
                                <div class="mb-3">
                                    <label for="name_ar" class="form-label">Name (AR)</label>
                                    <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" value="{{ old('name_ar') }}" required>
                                    @error('name_ar')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Name HE -->
                                <div class="mb-3">
                                    <label for="name_he" class="form-label">Name (HE)</label>
                                    <input type="text" name="name_he" class="form-control @error('name_he') is-invalid @enderror" id="name_he" value="{{ old('name_he') }}" required>
                                    @error('name_he')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Add Hair Thickness</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Create Hair Thickness Modal EOF -->

            <!-- Edit Hair Thickness Modal -->
            <div class="modal fade" id="editHairThicknessModal" tabindex="-1" aria-labelledby="editHairThicknessModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="editHairThicknessForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editHairThicknessModalLabel">Edit Hair Thickness</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Hidden ID -->
                                <input type="hidden" name="hair_thickness_id" id="edit_hair_thickness_id">

                                <!-- Name EN -->
                                <div class="mb-3">
                                    <label for="edit_name_en" class="form-label">Name (EN)</label>
                                    <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" id="edit_name_en" value="{{ old('name_en') }}" required>
                                    @error('name_en')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Name AR -->
                                <div class="mb-3">
                                    <label for="edit_name_ar" class="form-label">Name (AR)</label>
                                    <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" id="edit_name_ar" value="{{ old('name_ar') }}" required>
                                    @error('name_ar')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Name HE -->
                                <div class="mb-3">
                                    <label for="edit_name_he" class="form-label">Name (HE)</label>
                                    <input type="text" name="name_he" class="form-control @error('name_he') is-invalid @enderror" id="edit_name_he" value="{{ old('name_he') }}" required>
                                    @error('name_he')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update Hair Thickness</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Hair Thickness Modal EOF -->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
              return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            // Handle Edit button click
            $('.edit-hair-thickness-btn').on('click', function(event) {
                event.preventDefault();

                var id = $(this).data('id');
                var name_en = $(this).data('name_en');
                var name_ar = $(this).data('name_ar');
                var name_he = $(this).data('name_he');

                $('#edit_hair_thickness_id').val(id);
                $('#edit_name_en').val(name_en);
                $('#edit_name_ar').val(name_ar);
                $('#edit_name_he').val(name_he);

                var updateRoute = "{{ route('admin.hair-thickness.update', ':id') }}".replace(':id', id);
                $('#editHairThicknessForm').attr('action', updateRoute);
            });

            // Reset Edit Modal on close
            $('#editHairThicknessModal').on('hidden.bs.modal', function () {
                $('#editHairThicknessForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            });
        });
    </script>
@endpush