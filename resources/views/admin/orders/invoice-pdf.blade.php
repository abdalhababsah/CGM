<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            color: #333;
        }
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-header h1 {
            margin: 0;
            font-size: 28px;
            color: #4CAF50;
        }
        .invoice-header p {
            margin: 5px 0;
        }
        .invoice-section {
            margin-bottom: 20px;
        }
        .invoice-section h2 {
            font-size: 18px;
            margin-bottom: 10px;
            border-bottom: 2px solid #4CAF50;
            display: inline-block;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .invoice-table th {
            background: #4CAF50;
            color: #fff;
        }
        .invoice-footer {
            text-align: right;
            font-size: 16px;
            margin-top: 20px;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header Section -->
        <div class="invoice-header">
            <h1>Invoice</h1>
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
        </div>

        <!-- Customer Information Section -->
        <div class="invoice-section">
            <h2>Customer Information</h2>
            <p><strong>Name:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <!-- Address could be a part of the `user` or `order` model -->
            @if(isset($order->user->address))
                <p><strong>Address:</strong> {{ $order->user->address }}</p>
            @endif
        </div>

        <!-- Order Details Section -->
        <div class="invoice-section">
            <h2>Order Details</h2>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name_en }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td>${{ number_format($item->unit_price, 2) }}</td>
                            <td>${{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer Section -->
        <div class="invoice-footer">
            <p><strong>Grand Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
        </div>
    </div>
</body>
</html>