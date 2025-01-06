@extends('dashboard-layouts.app')

@section('content')
    <div class="container-fluid py-4">
        @include('components._messages')

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Coming Soon Section</h6>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createComingSoonModal">
                            Add Section
                        </button>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($commingSoons as $commingSoon)
                                        <tr>
                                            <!-- Image -->
                                            <td class="align-middle text-center">
                                                @if ($commingSoon->image)
                                                    <img src="{{ asset('storage/'.$commingSoon->image) }}" class="rounded-circle" height="50" alt="Image">
                                                @else
                                                    <span class="text-muted text-xs">No Image</span>
                                                @endif
                                            </td>

                                            <!-- Name -->
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">Ar: {{ $commingSoon->name_ar }}</p>
                                                <p class="text-xs text-secondary mb-0">En: {{ $commingSoon->name_en }}</p>
                                                <p class="text-xs text-secondary mb-0">He: {{ $commingSoon->name_he }}</p>
                                            </td>

                                            <!-- Actions -->
                                            <td class="align-middle text-center">
                                                <a href="#" class="text-secondary font-weight-bold text-xs me-2 edit-coming-soon-btn"
                                                    data-bs-toggle="modal" data-bs-target="#editComingSoonModal"
                                                    data-id="{{ $commingSoon->id }}"
                                                    data-name_ar="{{ $commingSoon->name_ar }}"
                                                    data-name_en="{{ $commingSoon->name_en }}"
                                                    data-name_he="{{ $commingSoon->name_he }}"
                                                    data-image="{{ $commingSoon->image }}">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.comming-soon.destroy', $commingSoon->id) }}"
                                                    method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure?');">
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
                                            <td colspan="3" class="text-center text-secondary text-sm">No sections found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $commingSoons->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createComingSoonModal" tabindex="-1" aria-labelledby="createComingSoonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.comming-soon.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createComingSoonModalLabel">Add Section</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Arabic Name -->
                        <div class="mb-3">
                            <label for="name_ar" class="form-label">Name (Arabic)</label>
                            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" value="{{ old('name_ar') }}" required>
                            @error('name_ar')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- English Name -->
                        <div class="mb-3">
                            <label for="name_en" class="form-label">Name (English)</label>
                            <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" id="name_en" value="{{ old('name_en') }}" required>
                            @error('name_en')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Hebrew Name -->
                        <div class="mb-3">
                            <label for="name_he" class="form-label">Name (Hebrew)</label>
                            <input type="text" name="name_he" class="form-control @error('name_he') is-invalid @enderror" id="name_he" value="{{ old('name_he') }}" required>
                            @error('name_he')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" accept="image/*" required>
                            @error('image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Section</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editComingSoonModal" tabindex="-1" aria-labelledby="editComingSoonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editComingSoonForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editComingSoonModalLabel">Edit Section</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden Section ID -->
                        <input type="hidden" name="id" id="edit_section_id">

                        <!-- Arabic Name -->
                        <div class="mb-3">
                            <label for="edit_name_ar" class="form-label">Name (Arabic)</label>
                            <input type="text" name="name_ar" class="form-control" id="edit_name_ar" required>
                        </div>

                        <!-- English Name -->
                        <div class="mb-3">
                            <label for="edit_name_en" class="form-label">Name (English)</label>
                            <input type="text" name="name_en" class="form-control" id="edit_name_en" required>
                        </div>

                        <!-- Hebrew Name -->
                        <div class="mb-3">
                            <label for="edit_name_he" class="form-label">Name (Hebrew)</label>
                            <input type="text" name="name_he" class="form-control" id="edit_name_he" required>
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="edit_image" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" id="edit_image" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Section</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.edit-coming-soon-btn').on('click', function() {
                const data = $(this).data();
                $('#edit_section_id').val(data.id);
                $('#edit_name_ar').val(data.name_ar);
                $('#edit_name_en').val(data.name_en);
                $('#edit_name_he').val(data.name_he);
                $('#editComingSoonForm').attr('action', "{{ url('admin/comming-soon') }}/" + data.id);
            });

            $('#editComingSoonModal').on('hidden.bs.modal', function() {
                $('#editComingSoonForm')[0].reset();
            });
        });
    </script>
@endpush