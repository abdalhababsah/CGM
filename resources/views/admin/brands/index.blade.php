@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        @include('components._messages')
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Brands Table</h6>
                        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">Add Brand</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        
                        <div class="table-responsive p-0">
                            <table class="table align-items-center table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Brand ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Description</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Logo</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($brands as $brand)
                                        <tr>
                                            <!-- Brand ID -->
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">{{ $brand->id }}</p>
                                            </td>

                                            <!-- Name -->
                                            <td class="align-middle text-left">
                                                <p class="text-xs text-secondary mb-0">Ar: {{ $brand->name_ar }}</p>
                                                <p class="text-xs text-secondary mb-0">En: {{ $brand->name_en }}</p>
                                                <p class="text-xs text-secondary mb-0">He: {{ $brand->name_he }}</p>
                                            </td>

                                            <!-- Description -->
                                            <td class="align-middle text-left">
                                                <p class="text-xs text-secondary mb-0">Ar: {{ $brand->description_ar }}</p>
                                                <p class="text-xs text-secondary mb-0">En: {{ $brand->description_en }}</p>
                                                <p class="text-xs text-secondary mb-0">He: {{ $brand->description_he }}</p>
                                            </td>

                                            <!-- Logo -->
                                            <td class="align-middle text-center">
                                                @if ($brand->logo_url)
                                                    <img src="{{ asset('storage/'.$brand->logo_url) }}" class="rounded-circle"
                                                        height="50" alt="Logo">
                                                @else
                                                    <span class="text-muted text-xs">No Logo</span>
                                                @endif
                                            </td>

                                            <!-- Status -->
                                            <td class="align-middle text-center">
                                                @if ($brand->is_active)
                                                    <span class="badge badge-sm bg-gradient-success">Active</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td class="align-middle text-center">
                                                <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                                    class="text-secondary font-weight-bold text-xs me-2"
                                                    data-toggle="tooltip" data-original-title="Edit brand">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.brands.destroy', $brand->id) }}"
                                                    method="POST" style="display: inline-block;"
                                                    onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-danger font-weight-bold text-xs border-0 bg-transparent"
                                                        data-toggle="tooltip" data-original-title="Delete brand">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-secondary text-sm">No brands found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
