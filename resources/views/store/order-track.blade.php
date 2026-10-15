@extends('layouts.app')

@section('title', 'تتبع شحنة السنيكرز | JORDAN TRACK')

@php
    $isAr = app()->getLocale() === 'ar';
@endphp

@section('content')
<div class="min-h-screen py-16 px-4 sm:px-6 lg:px-8 bg-[#050508]">
    <div class="max-w-2xl mx-auto space-y-8">

        <!-- Tracking Search Box -->
        <div class="p-8 sm:p-10 rounded-3xl bg-gradient-to-b from-[#161622] via-[#0d0d16] to-[#08080d] border border-white/10 shadow-2xl text-center space-y-4">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-red-600/20 border border-red-500/30 text-xs font-mono font-bold text-red-400">
                <span>● LIVE FLIGHT DISPATCH RADAR</span>
            </span>
            <h1 class="text-3xl font-black text-white">
                {{ $isAr ? 'تتبع حالة طلبك وشحنتك' : 'Track Your Sneaker Order' }}
            </h1>
            <p class="text-xs text-gray-400 max-w-md mx-auto">
                {{ $isAr ? 'أدخل رقم الشحنة (مثال: JRD-849000) أو رقم هاتفك لمعرفة حالة التوصيل اللحظية.' : 'Enter your order number or phone number to check dispatch status.' }}
            </p>

            <form action="{{ route('orders.track') }}" method="GET" class="flex gap-2 max-w-md mx-auto pt-2">
                <input type="text" 
                       name="q" 
                       value="{{ $query }}" 
                       required 
                       placeholder="{{ $isAr ? 'رقم الطلب أو الهاتف...' : 'Order # or phone...' }}" 
                       class="flex-1 px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white font-mono text-sm placeholder-gray-500 focus:outline-none focus:border-red-500" />
                <button type="submit" class="px-6 py-3 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold text-xs font-mono transition">
                    {{ $isAr ? 'تتبع' : 'Track' }}
                </button>
            </form>
        </div>

        @if($order)
            <!-- Order Found Details & Progress Stepper -->
            <div class="p-6 sm:p-8 rounded-3xl bg-[#0c0c14] border border-white/10 space-y-6">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-white/10 pb-4">
                    <div>
                        <span class="text-xs text-gray-400 block">{{ $isAr ? 'رقم الشحنة' : 'Order No.' }}</span>
                        <span class="text-lg font-mono font-black text-white">{{ $order->order_number }}</span>
                    </div>
                    <div class="text-end space-y-1">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold {{ $order->status_badge_class }}">
                            {{ $order->status_label }}
                        </span>
                        <span class="text-[11px] font-mono text-gray-400 block">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                </div>

                <!-- 4 Steps Status Stepper -->
                @php
                    $steps = [
                        'pending' => ['label_ar' => 'تم استلام الطلب', 'label_en' => 'Order Received', 'icon' => '📝'],
                        'processing' => ['label_ar' => 'جاري التجهيز والفحص', 'label_en' => 'Quality Inspection', 'icon' => '📦'],
                        'shipped' => ['label_ar' => 'خرج مع المندوب', 'label_en' => 'Out for Delivery', 'icon' => '🚚'],
                        'delivered' => ['label_ar' => 'تم التسليم بنجاح', 'label_en' => 'Delivered', 'icon' => '✓'],
                    ];
                    $statusOrder = ['pending', 'processing', 'shipped', 'delivered'];
                    $currentIndex = array_search($order->status, $statusOrder, true);
                    if ($currentIndex === false && $order->status === 'cancelled') {
                        $currentIndex = -1;
                    }
                @endphp

                @if($order->status === 'cancelled')
                    <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs font-bold text-center">
                        ⚠️ {{ $isAr ? 'تم إلغاء هذا الطلب. يرجى التواصل مع الدعم الفني لمزيد من المعلومات.' : 'This order has been cancelled. Contact support for assistance.' }}
                    </div>
                @else
                    <div class="grid grid-cols-4 gap-2 pt-4 text-center">
                        @foreach($steps as $key => $step)
                            @php
                                $stepIndex = array_search($key, $statusOrder, true);
                                $isCompleted = $stepIndex <= $currentIndex;
                                $isCurrent = $stepIndex === $currentIndex;
                            @endphp
                            <div class="flex flex-col items-center space-y-2">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-black transition-all {{ $isCompleted ? 'bg-red-600 text-white shadow-lg shadow-red-600/30 ring-4 ring-red-600/20' : 'bg-white/5 border border-white/10 text-gray-500' }}">
                                    {{ $step['icon'] }}
                                </div>
                                <span class="text-[11px] font-bold {{ $isCurrent ? 'text-red-400' : ($isCompleted ? 'text-white' : 'text-gray-500') }} leading-tight">
                                    {{ $isAr ? $step['label_ar'] : $step['label_en'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Items Preview -->
                <div class="pt-4 border-t border-white/10 space-y-3">
                    <h4 class="text-xs font-mono font-bold text-gray-300 uppercase">{{ $isAr ? 'القطع بالشحنة:' : 'Package Contents:' }}</h4>
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between text-xs py-2 bg-white/5 px-3.5 rounded-xl border border-white/5">
                            <span class="text-white font-bold">{{ $item->product_name }} (EU {{ $item->size }})</span>
                            <span class="font-mono text-red-400">×{{ $item->quantity }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center text-xs text-gray-400 pt-2 border-t border-white/5">
                    <span>{{ $isAr ? 'الإجمالي المطلوب سداده:' : 'Total Due:' }}</span>
                    <span class="font-mono font-black text-sm text-white">{{ number_format($order->total) }} {{ $isAr ? 'ج.م' : 'EGP' }}</span>
                </div>
            </div>
        @elseif($query !== '')
            <div class="p-8 rounded-3xl bg-[#0c0c14] border border-white/10 text-center text-xs text-gray-400 space-y-2">
                <span class="text-2xl block">🔍</span>
                <p>{{ $isAr ? 'لم نعثر على أي شحنة مطابقة للبيانات المدخلة: ' : 'No shipment found matching: ' }} <strong class="text-white font-mono">{{ $query }}</strong></p>
                <p class="text-[11px] text-gray-500">{{ $isAr ? 'تأكد من كتابة رقم الطلب بصيغة JRD-XXXXXX أو رقم الهاتف المسجل بالطلب.' : 'Please verify your order number or phone.' }}</p>
            </div>
        @endif

    </div>
</div>
@endsection
