<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans';
            margin: 0;
            padding: 0;
            background: #f8f9fa;
            color: #2c3e50;
            line-height: 1.6;
        }

        .invoice-container {
            max-width: 800px;
            /* margin: 20px auto; */
            background: #ffffff;
            /* padding: 10px; */
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 20px;
        }

        .company-info {
            text-align: left;
        }

        .invoice-details {
            text-align: right;
        }

        .invoice-header h1 {
            margin: 0;
            font-size: 32px;
            color: #3498db;
            font-weight: 700;
        }

        .invoice-header p {
            margin: 5px 0;
            color: #7f8c8d;
        }

        .invoice-section {
            margin-bottom: 30px;
        }

        .invoice-section h2 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
            display: inline-block;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #ffffff;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #e9ecef;
            padding: 12px 15px;
            text-align: left;
        }

        .invoice-table th {
            background: #3498db;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
        }

        .invoice-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .invoice-footer {
            text-align: right;
            font-size: 18px;
            margin-top: 10px;
            padding-top: 20px;
            border-top: 2px solid #3498db;
        }

        .text-center {
            text-align: center;
        }

        .customer-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }

        .total-amount {
            font-size: 24px;
            color: #3498db;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header Section -->
        <div class="invoice-header">
            <div class="company-info">
                <h1>INVOICE</h1>
                <p>CGM Hair</p>
                <p>Palastine</p>
                <p>contact@cgmhair.com</p>
            </div>
            <div class="invoice-details">
                <p><strong>Invoice #:</strong> {{ $order->id }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>Due Date:</strong> {{ $order->created_at->addDays(30)->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Customer Information Section -->
        <div class="invoice-section">
            <h2>Bill To</h2>
            <div class="customer-info">
                <p><strong>{{ $order->user->name }}</strong></p>
                <p>{{ $order->user->email }}</p>
                @if (isset($order->user->address))
                    <p>{{ $order->user->address }}</p>
                @endif
            </div>
        </div>
{{-- 'originalPrice','discount','deliveryPrice','finalPrice' --}}
        <!-- Order Details Section -->
        <div class="invoice-section">
            <h2>Order Summary</h2>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name_en }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td>₪ {{ number_format($item->unit_price, 2) }}</td>
                            <td>₪ {{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Footer Section -->
        <div class="invoice-footer">
            <p><strong>Subtotal:</strong> ₪ {{ number_format($originalPrice, 2) }}</p>
            <p><strong>Discount:</strong> ₪ {{$discount}}</p>
            <p><strong>Delivery Price:</strong> ₪ {{ number_format($deliveryPrice, 2) }}</p>
            <p class="total-amount"><strong>Grand Total:</strong> ₪ {{ number_format($finalPrice, 2) }}</p>
        </div>
    </div>
</body>

</html>
