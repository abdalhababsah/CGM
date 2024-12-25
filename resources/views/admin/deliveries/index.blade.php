@extends('dashboard-layouts.app')

@section('title', 'Delivery Locations')

@section('content')
    <div class="container-fluid py-4">
        @include('components._messages') <!-- Ensure you have a partial for flash messages -->

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Delivery Locations</h6>
                        <a href="{{ route('admin.deliveries.create') }}" class="btn btn-primary btn-sm">Add New Location</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            City
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Price ($)
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($deliveries as $delivery)
                                        <tr>
                                            <!-- ID -->
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">{{ $delivery->id }}</p>
                                            </td>

                                            <!-- City -->
                                            <td class="align-middle text-left">
                                                <p class="text-xs text-secondary mb-0">En: {{ $delivery->city_en }}</p>
                                                @if ($delivery->city_ar)
                                                    <p class="text-xs text-secondary mb-0">Ar: {{ $delivery->city_ar }}</p>
                                                @endif
                                                @if ($delivery->city_he)
                                                    <p class="text-xs text-secondary mb-0">He: {{ $delivery->city_he }}</p>
                                                @endif
                                            </td>

                                    

                                            <!-- Price -->
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">
                                                    ${{ number_format($delivery->price, 2) }}</p>
                                            </td>

                                            <!-- Status -->
                                            <td class="align-middle text-center">
                                                @if ($delivery->is_active)
                                                    <span class="badge badge-sm bg-gradient-success">Active</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td class="align-middle text-center">
                                                <a href="{{ route('admin.deliveries.edit', $delivery->id) }}"
                                                    class="text-secondary font-weight-bold text-xs me-2"
                                                    data-toggle="tooltip" data-original-title="Edit Delivery">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.deliveries.destroy', $delivery->id) }}"
                                                    method="POST" style="display: inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this delivery location?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-danger font-weight-bold text-xs border-0 bg-transparent"
                                                        data-toggle="tooltip" data-original-title="Delete Delivery">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-secondary text-sm">No delivery
                                                locations found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    {{ $deliveries->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection