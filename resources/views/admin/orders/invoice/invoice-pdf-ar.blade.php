<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            color: #333;
            direction: rtl;
            text-align: right;
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
            text-align: right;
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
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header Section -->
        <div class="invoice-header">
            <h1>فاتورة</h1>
            <p><strong>رقم الطلب:</strong> {{ $order->id }}</p>
            <p><strong>التاريخ:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
        </div>

        <!-- Customer Information Section -->
        <div class="invoice-section">
            <h2>معلومات العميل</h2>
            <p><strong>الاسم:</strong> {{ $order->user->name }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $order->user->email }}</p>
        </div>

        <!-- Order Location Section -->
        <div class="invoice-section">
            <h2>موقع الطلب</h2>
            <p><strong>المدينة:</strong> {{ $order->orderLocation->city ?? 'غير متوفر' }}</p>
            <p><strong>الولاية:</strong> {{ $order->orderLocation->state ?? 'غير متوفر' }}</p>
            <p><strong>الدولة:</strong> {{ $order->orderLocation->country ?? 'غير متوفر' }}</p>
        </div>

        <!-- Order Details Section -->
        <div class="invoice-section">
            <h2>تفاصيل الطلب</h2>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>سعر الوحدة</th>
                        <th>الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name_ar }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->unit_price, 2) }} $</td>
                            <td>{{ number_format($item->total_price, 2) }} $</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer Section -->
        <div class="invoice-footer">
            <p><strong>الإجمالي الكلي:</strong> {{ number_format($order->total_amount, 2) }} $</p>
        </div>
    </div>
</body>
</html>