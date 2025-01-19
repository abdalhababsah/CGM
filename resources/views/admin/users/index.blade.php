@extends('dashboard-layouts.app')

@section('content')
    <div class="container-fluid py-4">
        @include('components._messages')

        <style>
            .col-md-3 {
                margin-top: 0px !important;
            }
        </style>

        <!-- Filters Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Filter Users</h6>
                    </div>
                    <div class="card-body">
                        <form id="filterForm" method="GET" action="{{ route('admin.users.index') }}">
                            <div class="row g-3">
                                <!-- Search Filter -->
                                <div class="col-md-3">
                                    <input type="text" id="search" name="search" class="form-control mt-3"
                                        placeholder="Search by Name or Email" value="{{ request('search') }}">
                                </div>

                                <!-- Role Filter -->
                                <div class="col-md-3">
                                    <select id="role" name="role" class="form-control mt-3">
                                        <option value="">Select Role</option>
                                        <option value="0" {{ request('role') == '0' ? 'selected' : '' }}>User</option>
                                        <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>

                                <!-- Filter Buttons -->
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100 mt-3">Apply Filters</button>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('admin.users.index') }}"
                                        class="btn btn-secondary w-100 mt-3">Clear Filters</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Users Table</h6>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                            Add New User
                        </button>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Names</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td class="align-middle text-center">{{ $user->id }}</td>
                                            <td class="align-middle text-left">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </td>
                                            <td class="align-middle text-left">{{ $user->email }}</td>
                                            <td class="align-middle text-left">{{ $user->phone }}</td>
                                            <td class="align-middle text-center">
                                                @if ($user->role == 1)
                                                    <span class="badge bg-gradient-primary">Admin</span>
                                                @elseif ($user->role == 0)
                                                    <span class="badge bg-gradient-secondary">User</span>
                                                @else
                                                    <span class="badge bg-gradient-info">Guest</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                    method="POST" style="display: inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-danger font-weight-bold text-xs border-0 bg-transparent">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-secondary text-sm">No users found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                <div class="mt-3">
                    {{ $users->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-body">
                    <!-- First Name -->
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" id="first_name"
                            class="form-control @error('first_name') is-invalid @enderror"
                            value="{{ old('first_name') }}" required>
                        @error('first_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" id="last_name"
                            class="form-control @error('last_name') is-invalid @enderror"
                            value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}" required>
                        @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror" required>
                        @error('password_confirmation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role"
                            class="form-control @error('role') is-invalid @enderror" required>
                            <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>User</option>
                            <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection