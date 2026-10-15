@extends('layouts.app')

@section('title', 'تم تأكيد طلبك بنجاح | ' . $order->order_number)

@php
    $isAr = app()->getLocale() === 'ar';
@endphp

@section('content')
<div class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-[#050508]">
    <div class="max-w-3xl mx-auto space-y-8">

        <!-- Celebratory Top Card -->
        <div class="p-8 sm:p-12 rounded-[32px] bg-gradient-to-b from-[#161622] via-[#0d0d16] to-[#08080d] border border-white/10 shadow-2xl text-center relative overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-96 h-32 bg-red-600/20 blur-[100px] pointer-events-none"></div>

            <div class="w-20 h-20 mx-auto rounded-full bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400 mb-6 shadow-xl shadow-emerald-500/10">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-red-600/20 border border-red-500/30 text-xs font-mono font-bold text-red-400 mb-3">
                <span>JORDAN FLIGHT // ORDER CONFIRMED</span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-black text-white">
                {{ $isAr ? 'تم استلام وتأكيد طلبك بنجاح!' : 'Order Placed Successfully!' }}
            </h1>

            <p class="text-sm text-gray-400 mt-2 max-w-md mx-auto">
                {{ $isAr 
                    ? 'شكراً لاختيارك متجر جوردان. جاري تجهيز شحنتك داخل البوكس الأصلي مع الفحص الشامل.' 
                    : 'Thank you for shopping with Jordan. Your sneakers are being double-boxed and prepped for dispatch.' }}
            </p>

            <div class="mt-6 inline-flex flex-wrap items-center justify-center gap-3 p-4 rounded-2xl bg-white/5 border border-white/10 font-mono text-xs">
                <span class="text-gray-400">{{ $isAr ? 'رقم الشحنة / الطلب:' : 'Order Number:' }}</span>
                <span class="text-lg font-black text-red-500 tracking-wider select-all">{{ $order->order_number }}</span>
                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $order->status_badge_class }}">
                    {{ $order->status_label }}
                </span>
            </div>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <a href="https://wa.me/201012345678?text={{ urlencode(($isAr ? 'مرحباً، أود الاستفسار عن طلبي رقم: ' : 'Hello, inquiry about order: ') . $order->order_number) }}" 
                   target="_blank" 
                   class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs flex items-center gap-2 shadow-lg shadow-emerald-600/20 transition">
                    <span>💬</span>
                    <span>{{ $isAr ? 'تأكيد عبر واتساب' : 'WhatsApp Support' }}</span>
                </a>

                <a href="{{ route('orders.track', ['q' => $order->order_number]) }}" 
                   class="px-6 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs flex items-center gap-2 transition">
                    <span>📍</span>
                    <span>{{ $isAr ? 'تتبع حالة الشحنة' : 'Live Tracking' }}</span>
                </a>

                <button type="button" onclick="window.print()" class="px-5 py-3 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 font-bold text-xs transition">
                    🖨️ {{ $isAr ? 'طباعة الإيصال' : 'Print Receipt' }}
                </button>
            </div>
        </div>

        <!-- Order Breakdown Card -->
        <div class="p-6 sm:p-8 rounded-3xl bg-[#0c0c14] border border-white/10 space-y-6">
            <h2 class="text-lg font-bold text-white flex items-center gap-2 border-b border-white/10 pb-4">
                <span>👟</span>
                <span>{{ $isAr ? 'تفاصيل السنيكرز المطلوبة' : 'Ordered Sneakers' }}</span>
            </h2>

            <div class="divide-y divide-white/5">
                @foreach($order->items as $item)
                    <div class="py-4 flex items-center gap-4">
                        <div class="w-20 h-16 rounded-xl bg-[#161622] border border-white/10 flex items-center justify-center p-2 flex-shrink-0">
                            <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-contain filter drop-shadow" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-white truncate">{{ $item->product_name }}</h3>
                            <div class="flex items-center gap-3 text-xs text-gray-400 mt-1">
                                <span class="font-mono text-gray-300 font-semibold">{{ $isAr ? 'المقاس:' : 'Size:' }} EU {{ $item->size }}</span>
                                <span>•</span>
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full border border-white/20" style="background-color: {{ $item->color_hex }}"></span>
                                    <span>{{ $item->color_label }}</span>
                                </span>
                                <span>•</span>
                                <span>{{ $isAr ? 'الكمية:' : 'Qty:' }} {{ $item->quantity }}</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="font-mono font-black text-sm text-white">{{ number_format($item->total) }}</span>
                            <span class="text-[10px] text-gray-400 block">{{ $isAr ? 'ج.م' : 'EGP' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Price Summary -->
            <div class="pt-4 border-t border-white/10 space-y-2 text-xs text-gray-300">
                <div class="flex justify-between">
                    <span>{{ $isAr ? 'المجموع الفرعي:' : 'Subtotal:' }}</span>
                    <span class="font-mono font-bold text-white">{{ number_format($order->subtotal) }} {{ $isAr ? 'ج.م' : 'EGP' }}</span>
                </div>
                @if($order->discount > 0)
                    <div class="flex justify-between text-red-400">
                        <span>{{ $isAr ? 'الخصم الترويجي:' : 'Discount:' }}</span>
                        <span class="font-mono font-bold">-{{ number_format($order->discount) }} {{ $isAr ? 'ج.م' : 'EGP' }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span>{{ $isAr ? 'الشحن والتوصيل:' : 'Shipping Fee:' }}</span>
                    <span class="font-mono font-bold {{ $order->shipping_fee == 0 ? 'text-emerald-400' : 'text-white' }}">
                        {{ $order->shipping_fee == 0 ? ($isAr ? 'مجاني' : 'FREE') : number_format($order->shipping_fee) . ' ' . ($isAr ? 'ج.م' : 'EGP') }}
                    </span>
                </div>
                <div class="flex justify-between text-base font-black text-white pt-3 border-t border-white/10">
                    <span>{{ $isAr ? 'المبلغ الإجمالي المستحق:' : 'Total Amount:' }}</span>
                    <span class="font-mono text-red-500 text-lg">{{ number_format($order->total) }} {{ $isAr ? 'ج.م' : 'EGP' }}</span>
                </div>
            </div>
        </div>

        <!-- Customer & Destination Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="p-6 rounded-3xl bg-[#0c0c14] border border-white/10 space-y-3">
                <h3 class="text-xs font-mono font-bold text-red-400 uppercase tracking-wider">{{ $isAr ? 'بيانات العميل المستلم' : 'Recipient Info' }}</h3>
                <div class="text-sm font-bold text-white">{{ $order->customer_name }}</div>
                <div class="text-xs text-gray-300 font-mono" dir="ltr">{{ $order->customer_phone }}</div>
                @if($order->customer_email)
                    <div class="text-xs text-gray-400">{{ $order->customer_email }}</div>
                @endif
            </div>

            <div class="p-6 rounded-3xl bg-[#0c0c14] border border-white/10 space-y-3">
                <h3 class="text-xs font-mono font-bold text-red-400 uppercase tracking-wider">{{ $isAr ? 'عنوان الشحن والتسليم' : 'Shipping Address' }}</h3>
                <div class="text-sm font-bold text-white">{{ $order->governorate }} - {{ $order->city }}</div>
                <div class="text-xs text-gray-300 leading-relaxed">{{ $order->shipping_address }}</div>
                <div class="text-[11px] text-gray-400 font-mono">{{ $isAr ? 'طريقة الدفع:' : 'Payment:' }} {{ $order->payment_method_label }}</div>
            </div>
        </div>

        <div class="text-center pt-4">
            <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 text-xs font-mono font-bold text-gray-400 hover:text-white transition">
                <span>←</span>
                <span>{{ $isAr ? 'العودة إلى المتجر وتصفح التشكيلة' : 'Back to Sneaker Catalog' }}</span>
            </a>
        </div>

    </div>
</div>
@endsection
