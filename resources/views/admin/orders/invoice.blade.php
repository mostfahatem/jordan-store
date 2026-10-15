<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <title>فاتورة الشحن | {{ $order->order_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background: #fff; color: #111; margin: 0; padding: 24px; font-size: 13px; line-height: 1.5; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #000; padding-bottom: 16px; margin-bottom: 24px; }
        .logo { font-size: 20px; font-weight: 900; letter-spacing: 1px; }
        .badge { display: inline-block; padding: 4px 10px; background: #f4f4f4; border: 1px solid #ddd; font-family: monospace; font-size: 12px; border-radius: 4px; font-weight: bold; }
        .grid { display: flex; justify-content: space-between; gap: 24px; margin-bottom: 24px; }
        .box { flex: 1; border: 1px solid #e5e5e5; border-radius: 8px; padding: 16px; background: #fafafa; }
        .box h3 { margin: 0 0 8px; font-size: 13px; text-transform: uppercase; color: #666; border-bottom: 1px solid #eee; padding-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th { background: #f0f0f0; border: 1px solid #ddd; padding: 10px; text-align: inherit; font-size: 12px; }
        td { border: 1px solid #ddd; padding: 10px; text-align: inherit; }
        .total-row { font-size: 14px; font-weight: bold; background: #f9f9f9; }
        .grand-total { font-size: 16px; font-weight: 900; background: #f0f0f0; color: #d00; }
        .footer { text-align: center; border-top: 1px dashed #ccc; padding-top: 16px; margin-top: 32px; font-size: 11px; color: #777; }
        @media print { .no-print { display: none; } body { padding: 0; } }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; display: flex; gap: 10px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #d00; color: #fff; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
            🖨️ طباعة البوليصة / الفاتورة
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #eee; border: 1px solid #ccc; border-radius: 6px; cursor: pointer;">
            إغلاق النافذة
        </button>
    </div>

    <div class="header">
        <div>
            <div class="logo">JORDAN SNEAKER LAB</div>
            <div style="font-size: 11px; color: #666;">المتجر الرسمي المعتمد لأحذية وسنيكرز جوردان الأصلية</div>
        </div>
        <div style="text-align: end;">
            <div class="badge">{{ $order->order_number }}</div>
            <div style="font-size: 11px; color: #666; margin-top: 4px;">تاريخ الطلب: {{ $order->created_at->format('Y-m-d H:i') }}</div>
        </div>
    </div>

    <div class="grid">
        <div class="box">
            <h3>بيانات العميل والشحن</h3>
            <div><strong>الاسم:</strong> {{ $order->customer_name }}</div>
            <div><strong>الهاتف:</strong> {{ $order->customer_phone }}</div>
            @if($order->customer_email)
                <div><strong>البريد:</strong> {{ $order->customer_email }}</div>
            @endif
            <div><strong>المحافظة / المدينة:</strong> {{ $order->governorate }} - {{ $order->city }}</div>
            <div><strong>العنوان:</strong> {{ $order->shipping_address }}</div>
        </div>

        <div class="box">
            <h3>تفاصيل الدفع والتسليم</h3>
            <div><strong>طريقة الدفع:</strong> {{ $order->payment_method_label }}</div>
            <div><strong>حالة الدفع:</strong> {{ $order->payment_status_label }}</div>
            <div><strong>حالة الشحنة:</strong> {{ $order->status_label }}</div>
            @if($order->notes)
                <div style="margin-top: 8px; font-size: 11px; color: #555;"><strong>ملاحظات العميل:</strong> {{ $order->notes }}</div>
            @endif
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الحذاء والموديل</th>
                <th>المقاس (EU)</th>
                <th>اللون</th>
                <th>سعر القطعة</th>
                <th>الكمية</th>
                <th>الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $item->product_name }}</strong></td>
                    <td style="font-family: monospace;">{{ $item->size }}</td>
                    <td>{{ $item->color_label }}</td>
                    <td style="font-family: monospace;">{{ number_format($item->price) }} ج.م</td>
                    <td style="font-family: monospace;">×{{ $item->quantity }}</td>
                    <td style="font-family: monospace; font-weight: bold;">{{ number_format($item->total) }} ج.م</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="6" style="text-align: end;">المجموع الفرعي:</td>
                <td style="font-family: monospace;">{{ number_format($order->subtotal) }} ج.م</td>
            </tr>
            @if($order->discount > 0)
                <tr class="total-row" style="color: #d00;">
                    <td colspan="6" style="text-align: end;">الخصم الترويجي:</td>
                    <td style="font-family: monospace;">-{{ number_format($order->discount) }} ج.م</td>
                </tr>
            @endif
            <tr class="total-row">
                <td colspan="6" style="text-align: end;">الشحن والتوصيل:</td>
                <td style="font-family: monospace;">{{ $order->shipping_fee == 0 ? 'مجاني' : number_format($order->shipping_fee) . ' ج.م' }}</td>
            </tr>
            <tr class="grand-total">
                <td colspan="6" style="text-align: end;">المبلغ الإجمالي المستحق:</td>
                <td style="font-family: monospace;">{{ number_format($order->total) }} ج.م</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div>بوليصة وفاتورة رسمية صادرة من JORDAN SNEAKER LAB • جميع الأحذية أصلية 100% ومفحوصة مع البوكس الأصلي</div>
        <div>حق المعاينة والتأكد من المقاس مكفول للعميل عند الاستلام قبل السداد • للاستفسارات: support@jordan.com</div>
    </div>

</body>
</html>
