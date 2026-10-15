@extends('admin.layout')

@section('title', 'تفاصيل الطلب ' . $order->order_number . ' | JORDAN ORDERS')

@php
    $isAr = app()->getLocale() === 'ar';
@endphp

@section('admin_content')
<div class="space-y-8">

    <!-- Top Navigation & Order Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-white/10 pb-5">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-mono text-gray-400 hover:text-white transition">
                    ← {{ $isAr ? 'العودة لقائمة الطلبات' : 'Back to orders' }}
                </a>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-black text-white font-mono">
                    {{ $order->order_number }}
                </h1>
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $order->status_badge_class }}">
                    {{ $order->status_label }}
                </span>
            </div>
            <p class="text-xs text-gray-400 font-mono">
                {{ $isAr ? 'تم الإنشاء:' : 'Placed on:' }} {{ $order->created_at->format('Y-m-d H:i:s') }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="https://wa.me/2{{ ltrim($order->customer_phone, '0') }}?text={{ urlencode(($isAr ? 'مرحباً أستاذ ' : 'Hello ') . $order->customer_name . ($isAr ? '، نتواصل معك بخصوص طلبك من متجر جوردان رقم: ' : ', regarding your Jordan store order: ') . $order->order_number) }}" 
               target="_blank" 
               class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-2 shadow-lg shadow-emerald-600/20 transition">
                <span>💬</span>
                <span>{{ $isAr ? 'مراسلة واتساب' : 'WhatsApp' }}</span>
            </a>

            <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs flex items-center gap-2 transition">
                <span>🖨️</span>
                <span>{{ $isAr ? 'طباعة البوليصة' : 'Print Invoice' }}</span>
            </a>

            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('{{ $isAr ? 'هل أنت متأكد من حذف هذا الطلب نهائياً؟' : 'Are you sure you want to delete this order?' }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20 transition" title="{{ $isAr ? 'حذف الطلب' : 'Delete Order' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- 2 Column Layout: Order Items (8 cols) + Status & Customer Form (4 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: Ordered Items & Costs (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Items Table -->
            <div class="p-6 rounded-3xl bg-[#0d0d16] border border-white/10 space-y-4">
                <h3 class="text-sm font-mono font-bold uppercase text-white flex items-center gap-2">
                    <span>👟</span>
                    <span>{{ $isAr ? 'محتويات الشحنة والسنيكرز' : 'Ordered Sneaker Line Items' }}</span>
                </h3>

                <div class="divide-y divide-white/5">
                    @foreach($order->items as $item)
                        <div class="py-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-14 rounded-xl bg-black/60 border border-white/10 p-1.5 flex items-center justify-center flex-shrink-0">
                                    <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-contain filter drop-shadow" />
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-white">{{ $item->product_name }}</h4>
                                    <div class="flex items-center gap-3 text-xs text-gray-400 mt-1">
                                        <span class="font-mono text-gray-300 font-bold bg-white/5 px-2 py-0.5 rounded">EU {{ $item->size }}</span>
                                        <span>•</span>
                                        <span class="flex items-center gap-1.5">
                                            <span class="w-2.5 h-2.5 rounded-full border border-white/20" style="background-color: {{ $item->color_hex }}"></span>
                                            <span>{{ $item->color_label }}</span>
                                        </span>
                                        <span>•</span>
                                        <span class="font-mono text-white">{{ number_format($item->price) }} {{ $isAr ? 'ج.م' : 'EGP' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end whitespace-nowrap">
                                <span class="text-xs text-gray-400 font-mono block">× {{ $item->quantity }}</span>
                                <span class="text-sm font-mono font-black text-white block">{{ number_format($item->total) }} {{ $isAr ? 'ج.م' : 'EGP' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Totals Breakdown -->
                <div class="pt-4 border-t border-white/10 space-y-2 text-xs text-gray-300">
                    <div class="flex justify-between">
                        <span>{{ $isAr ? 'المجموع الفرعي:' : 'Subtotal:' }}</span>
                        <span class="font-mono font-bold text-white">{{ number_format($order->subtotal) }} {{ $isAr ? 'ج.م' : 'EGP' }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between text-red-400">
                            <span>{{ $isAr ? 'الخصم المطبق:' : 'Discount:' }}</span>
                            <span class="font-mono font-bold">-{{ number_format($order->discount) }} {{ $isAr ? 'ج.م' : 'EGP' }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span>{{ $isAr ? 'رسوم الشحن والتوصيل:' : 'Shipping Fee:' }}</span>
                        <span class="font-mono font-bold {{ $order->shipping_fee == 0 ? 'text-emerald-400' : 'text-white' }}">
                            {{ $order->shipping_fee == 0 ? ($isAr ? 'مجاني' : 'FREE') : number_format($order->shipping_fee) . ' ' . ($isAr ? 'ج.م' : 'EGP') }}
                        </span>
                    </div>
                    <div class="flex justify-between text-base font-black text-white pt-3 border-t border-white/10">
                        <span>{{ $isAr ? 'الإجمالي النهائي المطلوب:' : 'Grand Total:' }}</span>
                        <span class="font-mono text-red-500 text-lg">{{ number_format($order->total) }} {{ $isAr ? 'ج.م' : 'EGP' }}</span>
                    </div>
                </div>
            </div>

            <!-- Notes if any -->
            @if($order->notes)
                <div class="p-6 rounded-3xl bg-[#0d0d16] border border-white/10 space-y-2">
                    <h3 class="text-xs font-mono font-bold uppercase text-amber-400">{{ $isAr ? 'ملاحظات العميل الخاصة:' : 'Customer Notes:' }}</h3>
                    <p class="text-xs text-gray-300 leading-relaxed bg-white/5 p-3.5 rounded-2xl border border-white/5">
                        {{ $order->notes }}
                    </p>
                </div>
            @endif

        </div>

        <!-- Right Column: Status Update & Customer Info (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Update Status Form Card -->
            <div class="p-6 rounded-3xl bg-[#0d0d16] border border-white/10 space-y-5">
                <h3 class="text-sm font-mono font-bold uppercase text-white flex items-center gap-2">
                    <span>⚙️</span>
                    <span>{{ $isAr ? 'تحديث حالة الشحنة والدفع' : 'Update Dispatch Status' }}</span>
                </h3>

                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                            {{ $isAr ? 'حالة الطلب:' : 'Order Status:' }}
                        </label>
                        <select name="status" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500 font-mono">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>{{ $isAr ? 'بانتظار التأكيد (Pending)' : 'Pending' }}</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>{{ $isAr ? 'قيد التجهيز (Processing)' : 'Processing' }}</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>{{ $isAr ? 'تم الشحن مع المندوب (Shipped)' : 'Shipped' }}</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>{{ $isAr ? 'تم التسليم بنجاح (Delivered)' : 'Delivered' }}</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>{{ $isAr ? 'ملغي (Cancelled)' : 'Cancelled' }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                            {{ $isAr ? 'حالة الدفع:' : 'Payment Status:' }}
                        </label>
                        <select name="payment_status" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500 font-mono">
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>{{ $isAr ? 'بانتظار التحصيل (Pending)' : 'Pending' }}</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>{{ $isAr ? 'تم التحصيل / مدفوع (Paid)' : 'Paid' }}</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>{{ $isAr ? 'فشل الدفع (Failed)' : 'Failed' }}</option>
                        </select>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-red-600/20 cursor-pointer">
                            {{ $isAr ? 'حفظ التحديثات ✓' : 'Save Status ✓' }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Customer Shipping Information Card -->
            <div class="p-6 rounded-3xl bg-[#0d0d16] border border-white/10 space-y-4">
                <h3 class="text-sm font-mono font-bold uppercase text-white flex items-center gap-2">
                    <span>📍</span>
                    <span>{{ $isAr ? 'بيانات المستلم والعنوان' : 'Delivery Destination' }}</span>
                </h3>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-gray-400 block mb-0.5">{{ $isAr ? 'الاسم:' : 'Recipient Name:' }}</span>
                        <span class="text-white font-bold text-sm">{{ $order->customer_name }}</span>
                    </div>

                    <div>
                        <span class="text-gray-400 block mb-0.5">{{ $isAr ? 'رقم الهاتف:' : 'Phone Number:' }}</span>
                        <div class="flex items-center gap-2">
                            <a href="tel:{{ $order->customer_phone }}" class="text-red-400 font-mono font-bold hover:underline" dir="ltr">
                                {{ $order->customer_phone }}
                            </a>
                            <a href="https://wa.me/2{{ ltrim($order->customer_phone, '0') }}" target="_blank" class="text-[10px] bg-emerald-500/20 text-emerald-400 px-2 py-0.5 rounded font-mono font-bold">
                                WhatsApp
                            </a>
                        </div>
                    </div>

                    @if($order->customer_email)
                        <div>
                            <span class="text-gray-400 block mb-0.5">{{ $isAr ? 'البريد الإلكتروني:' : 'Email:' }}</span>
                            <span class="text-gray-300 font-mono">{{ $order->customer_email }}</span>
                        </div>
                    @endif

                    <div class="pt-2 border-t border-white/5">
                        <span class="text-gray-400 block mb-0.5">{{ $isAr ? 'المحافظة والمدينة:' : 'Governorate & City:' }}</span>
                        <span class="text-white font-bold">{{ $order->governorate }} - {{ $order->city }}</span>
                    </div>

                    <div>
                        <span class="text-gray-400 block mb-0.5">{{ $isAr ? 'العنوان بالتفصيل:' : 'Detailed Street Address:' }}</span>
                        <span class="text-gray-300 leading-relaxed block bg-white/5 p-3 rounded-xl border border-white/5">
                            {{ $order->shipping_address }}
                        </span>
                    </div>

                    <div class="pt-2 border-t border-white/5">
                        <span class="text-gray-400 block mb-0.5">{{ $isAr ? 'طريقة الدفع المختارة:' : 'Payment Method:' }}</span>
                        <span class="text-white font-bold">{{ $order->payment_method_label }}</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
