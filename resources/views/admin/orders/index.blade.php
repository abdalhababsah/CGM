@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    @include('components._messages') <!-- Success and error messages -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Orders Table</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>User</th>
                                    <th>Total</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            {{ $order->user->name }}<br>
                                            <small>{{ $order->user->email }}</small>
                                        </td>
                                        <td>${{ $order->total_amount }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-gradient-{{ $order->status == 'completed' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button 
                                                class="btn btn-primary btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#invoiceModal" 
                                                data-order-id="{{ $order->id }}">
                                                Download Invoice
                                            </button>
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary btn-sm">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No orders found.</td>
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

<!-- Invoice Language Selection Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="invoiceForm" method="GET" action="{{ route('admin.orders.invoice.download', ['order' => 0]) }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoiceModalLabel">Choose Invoice Language</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="orderIdInput" name="order_id" value="">
                    <div class="form-group">
                        <label for="language">Language</label>
                        <select id="language" name="language" class="form-control">
                            <option value="en" selected>English</option>
                            <option value="ar">Arabic</option>
                            <option value="he">Hebrew</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Download</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const invoiceModal = document.getElementById('invoiceModal');
    invoiceModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const orderId = button.getAttribute('data-order-id');
        const form = document.getElementById('invoiceForm');
        const orderIdInput = document.getElementById('orderIdInput');
        
        orderIdInput.value = orderId;
        form.action = form.action.replace('/0', '/' + orderId); // Dynamically set form action
    });
</script>
@endpush
@endsection