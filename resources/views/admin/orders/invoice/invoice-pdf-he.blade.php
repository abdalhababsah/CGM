<!DOCTYPE html>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>חשבונית #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans';
            margin: 0;
            padding: 0;
            background: #f8f9fa;
            color: #2c3e50;
            line-height: 1.6;
            direction: rtl;
        }

        /* Keep the same CSS styles as before, just add/modify these properties */
        .invoice-header {
            flex-direction: row-reverse;
        }

        .company-info {
            text-align: right;
        }

        .invoice-details {
            text-align: left;
        }

        .invoice-table th,
        .invoice-table td {
            text-align: right;
        }

        .invoice-footer {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="company-info">
                <h1>חשבונית</h1>
                <p>סי ג'י אם הייר</p>
                <p>פלסטין</p>
                <p>contact@cgmhair.com</p>
            </div>
            <div class="invoice-details">
                <p><strong>מספר חשבונית:</strong> {{ $order->id }}</p>
                <p><strong>תאריך:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>תאריך תשלום:</strong> {{ $order->created_at->addDays(30)->format('d M Y') }}</p>
            </div>
        </div>

        <div class="invoice-section">
            <h2>לכבוד</h2>
            <div class="customer-info">
                <p><strong>{{ $order->user->name }}</strong></p>
                <p>{{ $order->user->email }}</p>
                @if (isset($order->user->address))
                    <p>{{ $order->user->address }}</p>
                @endif
            </div>
        </div>

        <div class="invoice-section">
            <h2>פירוט הזמנה</h2>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>מוצר</th>
                        <th class="text-center">כמות</th>
                        <th>מחיר ליחידה</th>
                        <th>סה"כ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name_he }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td>₪ {{ number_format($item->unit_price, 2) }}</td>
                            <td>₪ {{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="invoice-footer">
            <p><strong>סכום ביניים:</strong> ₪ {{ number_format($order->total_amount, 2) }}</p>
            <p class="total-amount"><strong>סה"כ לתשלום:</strong> ₪ {{ number_format($order->total_amount, 2) }}</p>
        </div>
    </div>
</body>

</html>