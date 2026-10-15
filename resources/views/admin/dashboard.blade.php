@extends('admin.layout')

@section('title', 'لوحة التحكم والتحليلات | JORDAN COMMAND')

@php
    $isAr = app()->getLocale() === 'ar';
@endphp

@section('admin_content')
<div class="space-y-8">

    <!-- Top Headline -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-600/10 border border-red-600/20 text-xs font-mono font-bold text-red-400 mb-1">
                <span>MISSION CONTROL // TELEMETRY</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">
                {{ $isAr ? 'مؤشرات الأداء والمبيعات الحية' : 'Store Analytics & Live Performance' }}
            </h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs font-mono font-bold transition flex items-center gap-2">
                <span>📦</span>
                <span>{{ $isAr ? 'عرض كل الطلبات' : 'All Orders' }}</span>
            </a>
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white text-xs font-mono font-bold transition flex items-center gap-1.5 shadow-lg shadow-red-600/20">
                <span>+</span>
                <span>{{ $isAr ? 'إضافة حذاء' : 'Add Sneaker' }}</span>
            </a>
        </div>
    </div>

    <!-- 4 Primary Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Revenue -->
        <div class="p-6 rounded-3xl bg-[#0d0d16] border border-white/10 shadow-xl space-y-3 relative overflow-hidden group hover:border-red-500/40 transition-all">
            <div class="flex items-center justify-between text-xs text-gray-400">
                <span class="font-mono uppercase font-bold">{{ $isAr ? 'إجمالي المبيعات' : 'Total Revenue' }}</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-500/15 text-emerald-400 flex items-center justify-center font-bold text-sm">💰</span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-mono font-black text-white tracking-tight">{{ number_format($totalRevenue) }}</span>
                <span class="text-xs text-gray-400 font-sans">{{ $isAr ? 'ج.م' : 'EGP' }}</span>
            </div>
            <div class="flex items-center gap-1.5 text-[11px] text-emerald-400 font-mono">
                <span>↑ +24.8%</span>
                <span class="text-gray-500">{{ $isAr ? 'مقارنة بالفترة السابقة' : 'vs last period' }}</span>
            </div>
        </div>

        <!-- Card 2: Total Orders -->
        <div class="p-6 rounded-3xl bg-[#0d0d16] border border-white/10 shadow-xl space-y-3 relative overflow-hidden group hover:border-red-500/40 transition-all">
            <div class="flex items-center justify-between text-xs text-gray-400">
                <span class="font-mono uppercase font-bold">{{ $isAr ? 'إجمالي الطلبات' : 'Total Orders' }}</span>
                <span class="w-8 h-8 rounded-xl bg-blue-500/15 text-blue-400 flex items-center justify-center font-bold text-sm">📦</span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-mono font-black text-white tracking-tight">{{ number_format($totalOrders) }}</span>
                <span class="text-xs text-gray-400 font-sans">{{ $isAr ? 'طلب' : 'orders' }}</span>
            </div>
            <div class="flex items-center gap-1.5 text-[11px] text-blue-400 font-mono">
                <span>{{ $deliveredOrders }} {{ $isAr ? 'تم تسليمها بنجاح' : 'delivered' }}</span>
            </div>
        </div>

        <!-- Card 3: Pending Shipments -->
        <div class="p-6 rounded-3xl bg-[#0d0d16] border border-white/10 shadow-xl space-y-3 relative overflow-hidden group hover:border-red-500/40 transition-all">
            <div class="flex items-center justify-between text-xs text-gray-400">
                <span class="font-mono uppercase font-bold">{{ $isAr ? 'بانتظار التأكيد والشحن' : 'Pending Action' }}</span>
                <span class="w-8 h-8 rounded-xl bg-amber-500/15 text-amber-400 flex items-center justify-center font-bold text-sm">⏳</span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-mono font-black text-amber-400 tracking-tight">{{ number_format($pendingOrders + $processingOrders) }}</span>
                <span class="text-xs text-gray-400 font-sans">{{ $isAr ? 'شحنة جارية' : 'pending' }}</span>
            </div>
            <div class="flex items-center gap-1.5 text-[11px] text-amber-400 font-mono">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                <span>{{ $pendingOrders }} {{ $isAr ? 'طلب جديد بالانتظار' : 'new orders' }}</span>
            </div>
        </div>

        <!-- Card 4: Catalog Sneakers -->
        <div class="p-6 rounded-3xl bg-[#0d0d16] border border-white/10 shadow-xl space-y-3 relative overflow-hidden group hover:border-red-500/40 transition-all">
            <div class="flex items-center justify-between text-xs text-gray-400">
                <span class="font-mono uppercase font-bold">{{ $isAr ? 'الأحذية بالكتالوج' : 'Active Sneakers' }}</span>
                <span class="w-8 h-8 rounded-xl bg-red-500/15 text-red-400 flex items-center justify-center font-bold text-sm">👟</span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-mono font-black text-white tracking-tight">{{ number_format($totalProducts) }}</span>
                <span class="text-xs text-gray-400 font-sans">{{ $isAr ? 'موديل' : 'models' }}</span>
            </div>
            <div class="flex items-center gap-1.5 text-[11px] text-gray-400 font-mono">
                <span>{{ $totalCategories }} {{ $isAr ? 'تصنيفات رسمية' : 'categories' }}</span>
            </div>
        </div>

    </div>

    <!-- Orders Pipeline Stepper & Progress Breakdown -->
    <div class="p-6 sm:p-8 rounded-3xl bg-[#0d0d16] border border-white/10 space-y-5">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-mono font-bold uppercase tracking-wider text-white">
                {{ $isAr ? 'مراحل ومسار معالجة الطلبات' : 'Order Processing Pipeline' }}
            </h3>
            <span class="text-xs font-mono text-gray-400">{{ $totalOrders }} {{ $isAr ? 'طلب إجمالي' : 'total' }}</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 text-center">
            
            <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/20">
                <span class="text-xs font-bold text-amber-400 block mb-1">{{ $isAr ? 'بانتظار التأكيد' : 'Pending' }}</span>
                <span class="text-2xl font-mono font-black text-white">{{ $pendingOrders }}</span>
            </div>

            <div class="p-4 rounded-2xl bg-blue-500/10 border border-blue-500/20">
                <span class="text-xs font-bold text-blue-400 block mb-1">{{ $isAr ? 'قيد التجهيز' : 'Processing' }}</span>
                <span class="text-2xl font-mono font-black text-white">{{ $processingOrders }}</span>
            </div>

            <div class="p-4 rounded-2xl bg-purple-500/10 border border-purple-500/20">
                <span class="text-xs font-bold text-purple-400 block mb-1">{{ $isAr ? 'تم الشحن' : 'Shipped' }}</span>
                <span class="text-2xl font-mono font-black text-white">{{ $shippedOrders }}</span>
            </div>

            <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20">
                <span class="text-xs font-bold text-emerald-400 block mb-1">{{ $isAr ? 'تم التسليم' : 'Delivered' }}</span>
                <span class="text-2xl font-mono font-black text-white">{{ $deliveredOrders }}</span>
            </div>

            <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 col-span-2 sm:col-span-1">
                <span class="text-xs font-bold text-rose-400 block mb-1">{{ $isAr ? 'ملغي' : 'Cancelled' }}</span>
                <span class="text-2xl font-mono font-black text-white">{{ $cancelledOrders }}</span>
            </div>

        </div>
    </div>

    <!-- 2 Columns: Recent Orders (7 cols) + Top Selling Sneakers (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Recent Orders Table (7 cols) -->
        <div class="lg:col-span-8 p-6 sm:p-8 rounded-3xl bg-[#0d0d16] border border-white/10 space-y-5">
            <div class="flex items-center justify-between border-b border-white/10 pb-4">
                <div>
                    <h3 class="text-base font-bold text-white">{{ $isAr ? 'أحدث الطلبات الواردة' : 'Recent Inbound Orders' }}</h3>
                    <p class="text-xs text-gray-400">{{ $isAr ? 'متابعة وتحديث حالة الشحنات مباشرة' : 'Live order feed with direct status management' }}</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-mono font-bold text-red-400 hover:text-red-300 transition">
                    {{ $isAr ? 'عرض الكل' : 'View All' }} →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-start text-xs">
                    <thead>
                        <tr class="text-gray-400 font-mono border-b border-white/5 text-[11px]">
                            <th class="py-3 text-start">{{ $isAr ? 'رقم الطلب' : 'Order #' }}</th>
                            <th class="py-3 text-start">{{ $isAr ? 'العميل' : 'Customer' }}</th>
                            <th class="py-3 text-start">{{ $isAr ? 'المدينة' : 'City' }}</th>
                            <th class="py-3 text-start">{{ $isAr ? 'الإجمالي' : 'Total' }}</th>
                            <th class="py-3 text-start">{{ $isAr ? 'الحالة' : 'Status' }}</th>
                            <th class="py-3 text-end">{{ $isAr ? 'إجراء' : 'Action' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 font-sans">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-white/[0.02] transition">
                                <td class="py-3.5 font-mono font-bold text-white">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-red-400 transition">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="py-3.5 text-gray-300 font-medium">
                                    <div class="truncate max-w-[130px]">{{ $order->customer_name }}</div>
                                    <div class="text-[10px] text-gray-500 font-mono" dir="ltr">{{ $order->customer_phone }}</div>
                                </td>
                                <td class="py-3.5 text-gray-400">
                                    {{ $order->city }}
                                </td>
                                <td class="py-3.5 font-mono font-bold text-white">
                                    {{ number_format($order->total) }} <span class="text-[10px] text-gray-400 font-sans font-normal">{{ $isAr ? 'ج.م' : 'EGP' }}</span>
                                </td>
                                <td class="py-3.5">
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $order->status_badge_class }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td class="py-3.5 text-end">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="px-2.5 py-1 rounded-lg bg-white/5 hover:bg-white/10 text-gray-300 hover:text-white font-mono text-xs transition">
                                        {{ $isAr ? 'عرض' : 'View' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500 text-xs">
                                    {{ $isAr ? 'لا توجد طلبات مسجلة بعد' : 'No orders recorded yet' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Top Selling Sneakers (4 cols) -->
        <div class="lg:col-span-4 p-6 sm:p-8 rounded-3xl bg-[#0d0d16] border border-white/10 space-y-5">
            <div class="flex items-center justify-between border-b border-white/10 pb-4">
                <h3 class="text-base font-bold text-white">{{ $isAr ? 'الأكثر طلباً ومبيعاً' : 'Top Performing Sneakers' }}</h3>
                <span class="text-xs font-mono text-gray-400">🔥 {{ $isAr ? 'شعبية' : 'Rank' }}</span>
            </div>

            <div class="space-y-3.5">
                @foreach($topProducts as $index => $prod)
                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-white/5 border border-white/5 hover:border-white/15 transition group">
                        <span class="w-6 h-6 rounded-lg bg-black/60 text-red-500 font-mono font-black text-xs flex items-center justify-center">
                            0{{ $index + 1 }}
                        </span>
                        <div class="w-12 h-10 rounded-xl bg-black/50 border border-white/5 p-1 flex items-center justify-center flex-shrink-0">
                            <img src="{{ asset($prod->image) }}" alt="{{ $prod->name }}" class="w-full h-full object-contain" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-white truncate group-hover:text-red-400 transition">{{ $prod->name }}</h4>
                            <span class="text-[10px] text-gray-400 font-mono">{{ number_format($prod->price) }} {{ $isAr ? 'ج.م' : 'EGP' }}</span>
                        </div>
                        <div class="text-end">
                            <span class="font-mono font-bold text-xs text-white">{{ $prod->order_items_count }}</span>
                            <span class="text-[10px] text-gray-500 block">{{ $isAr ? 'مبيعات' : 'sold' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-2">
                <a href="{{ route('admin.products.index') }}" class="w-full py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-gray-300 hover:text-white font-mono text-xs font-bold flex items-center justify-center gap-1.5 transition">
                    <span>{{ $isAr ? 'إدارة كل الأحذية' : 'Manage All Footwear' }}</span>
                    <span class="rtl:rotate-180">→</span>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
