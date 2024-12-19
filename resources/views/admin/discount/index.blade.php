@extends('admin.layouts.app')

@section('title', 'Discount Codes')

@section('content')
    <div class="container-fluid py-4">
        <!-- Flash Messages -->
        @include('components._messages') <!-- Ensure you have this partial for displaying flash messages -->

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <!-- Card Header with Title and Add Button -->
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Discount Codes</h6>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDiscountModal">
                            Add Discount Code
                        </button>
                    </div>

                    <!-- Card Body with Table -->
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Code</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usage Limit</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Times Used</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Expiry Date</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($discountCodes as $discount)
                                        <tr>
                                            <!-- ID -->
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">{{ $discount->id }}</p>
                                            </td>

                                            <!-- Code -->
                                            <td class="align-middle text-left">
                                                <p class="text-xs text-secondary mb-0">{{ $discount->code }}</p>
                                            </td>

                                            <!-- Type -->
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">{{ ucfirst($discount->type) }}</p>
                                            </td>

                                            <!-- Amount -->
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">
                                                    @if($discount->type === 'fixed')
                                                        ${{ number_format($discount->amount, 2) }}
                                                    @elseif($discount->type === 'percentage')
                                                        {{ $discount->amount }}%
                                                    @endif
                                                </p>
                                            </td>

                                            <!-- Usage Limit -->
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">
                                                    @if($discount->usage_limit)
                                                        {{ $discount->usage_limit }}
                                                    @else
                                                        Unlimited
                                                    @endif
                                                </p>
                                            </td>

                                            <!-- Times Used -->
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">{{ $discount->times_used }}</p>
                                            </td>

                                            <!-- Expiry Date -->
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">
                                                    @if($discount->expiry_date)
                                                        {{ \Carbon\Carbon::parse($discount->expiry_date)->format('Y-m-d') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </p>
                                            </td>

                                            <!-- Status -->
                                            <td class="align-middle text-center">
                                                @if ($discount->is_active)
                                                    <span class="badge badge-sm bg-gradient-success">Active</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td class="align-middle text-center">
                                                <!-- Edit Link Styled as Text -->
                                                <a href="#"
                                                    class="text-secondary font-weight-bold text-xs me-2 edit-discount-btn"
                                                    data-bs-toggle="modal" data-bs-target="#editDiscountModal"
                                                    data-id="{{ $discount->id }}"
                                                    data-code="{{ $discount->code }}"
                                                    data-type="{{ $discount->type }}"
                                                    data-amount="{{ $discount->amount }}"
                                                    data-usage_limit="{{ $discount->usage_limit }}"
                                                    data-expiry_date="{{ $discount->expiry_date ? $discount->expiry_date->format('Y-m-d') : '' }}"
                                                    data-is_active="{{ $discount->is_active }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="right" title="Edit Discount">
                                                    Edit
                                                </a>
                                                <!-- Delete Button -->
                                                <form action="{{ route('admin.discount.destroy', $discount->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this discount code?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger font-weight-bold text-xs me-2 border-0 bg-transparent">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-secondary text-sm">No discount codes found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- Pagination Links -->
                            <div class="mt-3">
                                {{ $discountCodes->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Discount Modal -->
            <div class="modal fade" id="createDiscountModal" tabindex="-1" aria-labelledby="createDiscountModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.discount.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="createDiscountModalLabel">Add Discount Code</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Code -->
                                <div class="mb-3">
                                    <label for="code" class="form-label">Code</label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" id="code" value="{{ old('code') }}" required>
                                    @error('code')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Type -->
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Amount -->
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" id="amount" value="{{ old('amount') }}" required>
                                    @error('amount')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Usage Limit -->
                                <div class="mb-3">
                                    <label for="usage_limit" class="form-label">Usage Limit</label>
                                    <input type="number" name="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" id="usage_limit" value="{{ old('usage_limit') }}" min="1" placeholder="Leave blank for unlimited">
                                    @error('usage_limit')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Expiry Date -->
                                <div class="mb-3">
                                    <label for="expiry_date" class="form-label">Expiry Date</label>
                                    <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" id="expiry_date" value="{{ old('expiry_date') }}">
                                    @error('expiry_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Status -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active_create" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active_create">Active</label>
                                    @error('is_active')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Add Discount</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Create Discount Modal EOF -->

            <!-- Edit Discount Modal (Single Dynamic Modal) -->
            <div class="modal fade" id="editDiscountModal" tabindex="-1" aria-labelledby="editDiscountModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="editDiscountForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editDiscountModalLabel">Edit Discount Code</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Hidden Discount ID -->
                                <input type="hidden" name="discount_id" id="edit_discount_id">

                                <!-- Code -->
                                <div class="mb-3">
                                    <label for="edit_code" class="form-label">Code</label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" id="edit_code" value="{{ old('code') }}" required>
                                    @error('code')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Type -->
                                <div class="mb-3">
                                    <label for="edit_type" class="form-label">Type</label>
                                    <select name="type" id="edit_type" class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="fixed">Fixed</option>
                                        <option value="percentage">Percentage</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Amount -->
                                <div class="mb-3">
                                    <label for="edit_amount" class="form-label">Amount</label>
                                    <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" id="edit_amount" value="{{ old('amount') }}" required>
                                    @error('amount')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Usage Limit -->
                                <div class="mb-3">
                                    <label for="edit_usage_limit" class="form-label">Usage Limit</label>
                                    <input type="number" name="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" id="edit_usage_limit" value="{{ old('usage_limit') }}" min="1" placeholder="Leave blank for unlimited">
                                    @error('usage_limit')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Expiry Date -->
                                <div class="mb-3">
                                    <label for="edit_expiry_date" class="form-label">Expiry Date</label>
                                    <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" id="edit_expiry_date" value="{{ old('expiry_date') }}">
                                    @error('expiry_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Status -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="edit_is_active" value="1">
                                    <label class="form-check-label" for="edit_is_active">Active</label>
                                    @error('is_active')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update Discount</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Discount Modal EOF -->
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        $(document).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
              return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>

    <!-- JavaScript to Handle Edit Modal -->
    <script>
        $(document).ready(function() {
            // Function to populate the Edit Modal
            function populateEditModal(data) {
                $('#edit_discount_id').val(data.id);
                $('#edit_code').val(data.code);
                $('#edit_type').val(data.type);
                $('#edit_amount').val(data.amount);
                $('#edit_usage_limit').val(data.usage_limit);
                $('#edit_expiry_date').val(data.expiry_date);
                $('#edit_is_active').prop('checked', data.is_active);
                $('#editDiscountForm').attr('action', data.update_route);
            }

            // Event listener for Edit links
            $('.edit-discount-btn').on('click', function(event) {
                event.preventDefault(); // Prevent default anchor behavior

                // Get data attributes from the clicked link
                var discountId = $(this).data('id');
                var code = $(this).data('code');
                var type = $(this).data('type');
                var amount = $(this).data('amount');
                var usageLimit = $(this).data('usage_limit');
                var expiryDate = $(this).data('expiry_date');
                var isActive = $(this).data('is_active');

                // Construct the update route URL
                var updateRoute = "{{ route('admin.discount.update', ':id') }}".replace(':id', discountId);

                // Create a data object
                var discountData = {
                    id: discountId,
                    code: code,
                    type: type,
                    amount: amount,
                    usage_limit: usageLimit,
                    expiry_date: expiryDate,
                    is_active: isActive,
                    update_route: updateRoute
                };

                // Populate the modal fields
                populateEditModal(discountData);

                // Show the modal (if not already handled by data-bs attributes)
                // $('#editDiscountModal').modal('show'); // Not needed as data-bs attributes handle it
            });

            // Reset the modal fields when it's closed
            $('#editDiscountModal').on('hidden.bs.modal', function () {
                $('#editDiscountForm')[0].reset();
                // Remove any validation error messages
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            });

            // Optional: Change the Amount label based on Type selection in Edit Modal
            $('#edit_type').on('change', function() {
                var selectedType = $(this).val();
                var amountLabel = selectedType === 'percentage' ? 'Percentage (%)' : 'Amount ($)';
                $('label[for="edit_amount"]').text('Amount (' + (selectedType === 'percentage' ? '%' : '$') + ')');
            });

            // Trigger change on page load to set the correct label in Edit Modal
            $('#edit_type').trigger('change');
        });
    </script>
@endpush