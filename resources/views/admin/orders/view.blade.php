@extends('dashboard-layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border shadow-none">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="font-size-16 mb-0">Order Details <span class="float-end">#{{ $order->id }}</span></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <thead>
                                <tr>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Product</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>₪{{ number_format($item->unit_price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₪{{ number_format($item->total_price, 2) }}</td>
                                        <td class="d-flex align-items-center">
                                            <img
                                            @if ($item->product->primaryImage)
                                            src="{{ asset('storage/' . $item->product->primaryImage->image_url) }}"
                                            class="img-fluid rounded" style="max-height: 150px"
                                            alt="{{ $item->product->name_en }}"
                                            @else
                                            src="https://via.placeholder.com/50"
                                            alt="Primary Image"
                                            @endif
                                            class="rounded me-3" width="50">
                                            <span>{{ $item->product->name_en }}</span>
                                            <span style="background-color: {{ $item->hex }}; height :10px; width :10px;"></span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <h6>Customer Information</h6>
                    <p><strong>Name:</strong> {{ $order->user?->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user?->email }}</p>
                    <p><strong>Phone:</strong> 
                        {{ $order->user?->phone }}
                        <br>
                        @if ($order->user?->phone)
                            <button 
                                type="button" 
                                class="btn btn-success btn-sm ms-2"
                                onclick="openWhatsApp('{{ $order->user?->phone }}')"
                            >
                                WhatsApp
                            </button>
                        @endif
                    </p>

                    <!-- Modal for country code selection -->
                    <div class="modal fade" id="countryCodeModal" tabindex="-1" aria-labelledby="countryCodeModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="countryCodeModalLabel">Enter Country Code</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <input type="text" id="countryCodeInput" class="form-control" placeholder="e.g. 972 or 970">
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="goToWhatsAppBtn">Go to WhatsApp</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    @push('scripts')
                    <script>
                    function openWhatsApp(phone) {
                        // Remove spaces, dashes, parentheses
                        let cleanPhone = phone.replace(/[\s\-()]/g, '');
                        // Check if phone starts with '+'
                        if (cleanPhone.startsWith('+')) {
                            cleanPhone = cleanPhone.substring(1);
                        }
                        // Check if phone starts with country code (assume at least 10 digits for local)
                        if (/^\d{11,15}$/.test(cleanPhone)) {
                            window.open('https://wa.me/' + cleanPhone, '_blank');
                        } else {
                            // Show modal to ask for country code
                            window.selectedPhone = cleanPhone;
                            var modal = new bootstrap.Modal(document.getElementById('countryCodeModal'));
                            modal.show();
                        }
                    }

                    document.addEventListener('DOMContentLoaded', function () {
                        document.getElementById('goToWhatsAppBtn').onclick = function () {
                            var code = document.getElementById('countryCodeInput').value.replace(/\D/g, '');
                            if (!code) {
                                alert('Please enter a valid country code.');
                                return;
                            }
                            var fullPhone = code + window.selectedPhone.replace(/^0+/, '');
                            window.open('https://wa.me/' + fullPhone, '_blank');
                            var modal = bootstrap.Modal.getInstance(document.getElementById('countryCodeModal'));
                            modal.hide();
                        };
                    });
                    </script>
                    @endpush

                    <hr>

                    <h6>Delivery Information</h6>
                    <p><strong>City:</strong> {{ $order->deliveryLocation->city ?? 'N/A' }}</p>
                    <p><strong>Area:</strong> {{ $order->areaLocation->area ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ $order->orderLocation->address ?? 'N/A' }}</p>

                    <hr>

                    <p><strong>Note:</strong> {{ $order->note ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border shadow-none">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="font-size-16 mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Subtotal:</td>
                                    <td class="text-end">₪{{ number_format($originalPrice, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Discount:</td>
                                    <td class="text-end">- ₪{{ number_format($order->discount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Delivery Price:</td>
                                    <td class="text-end">₪{{ number_format($deliveryPrice, 2) }}</td>
                                </tr>
                                <tr class="bg-light">
                                    <th>Total:</th>
                                    <td class="text-end">
                                        <strong>₪{{ number_format($finalPrice, 2) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border shadow-none mt-4">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="font-size-16 mb-0">Actions</h5>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mb-3">
                        <i class="mdi mdi-arrow-left"></i> Back to Orders
                    </a>
                    <a href="{{ route('admin.orders.invoice.download', ['order' => $order->id, 'language' => 'en']) }}"
                       class="btn btn-primary">
                        <i class="mdi mdi-download"></i> Download Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
