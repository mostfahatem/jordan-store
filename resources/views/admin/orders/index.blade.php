@extends('admin.layout')

@section('title', 'إدارة الطلبات والشحن | JORDAN ORDERS')

@php
    $isAr = app()->getLocale() === 'ar';
@endphp

@section('admin_content')
<div class="space-y-6">

    <!-- Top Headline -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-600/10 border border-red-600/20 text-xs font-mono font-bold text-red-400 mb-1">
                <span>DISPATCH LOGISTICS // INBOUND & OUTBOUND</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">
                {{ $isAr ? 'إدارة وفحص طلبات العملاء' : 'Orders & Dispatch Management' }}
            </h1>
        </div>
        <div class="text-xs font-mono text-gray-400">
            {{ $isAr ? 'إجمالي الطلبات:' : 'Total orders:' }} <strong class="text-white">{{ $statusTotals['all'] }}</strong>
        </div>
    </div>

    <!-- Status Tabs Strip -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-white/10 text-xs font-mono">
        @php
            $tabs = [
                '' => ['label_ar' => 'كل الطلبات', 'label_en' => 'All Orders', 'key' => 'all'],
                'pending' => ['label_ar' => 'بانتظار التأكيد', 'label_en' => 'Pending', 'key' => 'pending'],
                'processing' => ['label_ar' => 'قيد التجهيز', 'label_en' => 'Processing', 'key' => 'processing'],
                'shipped' => ['label_ar' => 'تم الشحن', 'label_en' => 'Shipped', 'key' => 'shipped'],
                'delivered' => ['label_ar' => 'تم التسليم', 'label_en' => 'Delivered', 'key' => 'delivered'],
                'cancelled' => ['label_ar' => 'ملغي', 'label_en' => 'Cancelled', 'key' => 'cancelled'],
            ];
        @endphp

        @foreach($tabs as $val => $tab)
            @php
                $isActive = (string)$currentStatus === (string)$val;
            @endphp
            <a href="{{ route('admin.orders.index', array_merge(request()->query(), ['status' => $val ?: null])) }}" 
               class="px-4 py-2 rounded-xl whitespace-nowrap font-bold transition flex items-center gap-2 {{ $isActive ? 'bg-red-600 text-white shadow-lg shadow-red-600/20' : 'bg-white/5 text-gray-400 hover:text-white hover:bg-white/10' }}">
                <span>{{ $isAr ? $tab['label_ar'] : $tab['label_en'] }}</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ $isActive ? 'bg-black/40 text-white' : 'bg-white/10 text-gray-400' }}">
                    {{ $statusTotals[$tab['key']] }}
                </span>
            </a>
        @endforeach
    </div>

    <!-- Search & Filter Bar -->
    <div class="p-4 rounded-2xl bg-[#0d0d16] border border-white/10 flex flex-wrap items-center justify-between gap-4">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex items-center gap-2 flex-1 max-w-md">
            @if($currentStatus)
                <input type="hidden" name="status" value="{{ $currentStatus }}">
            @endif
            <input type="text" 
                   name="search" 
                   value="{{ $search }}" 
                   placeholder="{{ $isAr ? 'بحث برقم الطلب، اسم العميل، الهاتف، أو المدينة...' : 'Search order #, customer, phone, city...' }}" 
                   class="w-full px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-red-500 font-mono transition" />
            <button type="submit" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-mono font-bold transition">
                {{ $isAr ? 'بحث' : 'Search' }}
            </button>
            @if($search)
                <a href="{{ route('admin.orders.index', ['status' => $currentStatus]) }}" class="px-3 py-2 rounded-xl bg-rose-500/10 text-rose-400 text-xs font-mono hover:bg-rose-500/20 transition">
                    ✕
                </a>
            @endif
        </form>
    </div>

    <!-- Orders Table Card -->
    <div class="rounded-3xl bg-[#0d0d16] border border-white/10 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead>
                    <tr class="bg-black/40 text-gray-400 font-mono border-b border-white/10 text-[11px] uppercase tracking-wider">
                        <th class="p-4 text-start">{{ $isAr ? 'رقم الشحنة' : 'Order #' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'العميل المستلم' : 'Customer' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'المحافظة / المدينة' : 'Location' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'القطع' : 'Items' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'الإجمالي' : 'Total' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'الدفع' : 'Payment' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'الحالة' : 'Status' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'التاريخ' : 'Date' }}</th>
                        <th class="p-4 text-end">{{ $isAr ? 'الإجراءات' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 font-sans">
                    @forelse($orders as $order)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="p-4 font-mono font-bold text-white whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-red-400 hover:text-red-300 font-mono tracking-wider font-black transition">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td class="p-4 text-gray-200">
                                <div class="font-bold truncate max-w-[140px]">{{ $order->customer_name }}</div>
                                <div class="text-[10px] text-gray-500 font-mono" dir="ltr">{{ $order->customer_phone }}</div>
                            </td>
                            <td class="p-4 text-gray-300 whitespace-nowrap">
                                <span class="font-bold text-white block">{{ $order->governorate }}</span>
                                <span class="text-[10px] text-gray-500">{{ $order->city }}</span>
                            </td>
                            <td class="p-4 font-mono text-gray-400 whitespace-nowrap">
                                <span class="text-white font-bold">{{ $order->items->sum('quantity') }}</span> {{ $isAr ? 'قطعة' : 'prs' }}
                            </td>
                            <td class="p-4 font-mono font-black text-white whitespace-nowrap">
                                {{ number_format($order->total) }} <span class="text-[10px] text-gray-400 font-sans font-normal">{{ $isAr ? 'ج.م' : 'EGP' }}</span>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono block mb-1 font-bold {{ $order->payment_status === 'paid' ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30' : 'bg-amber-500/15 text-amber-400 border border-amber-500/30' }}">
                                    {{ $order->payment_status_label }}
                                </span>
                                <span class="text-[10px] text-gray-500 block">{{ $order->payment_method_label }}</span>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $order->status_badge_class }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-400 font-mono text-[11px] whitespace-nowrap">
                                {{ $order->created_at->format('Y-m-d') }}
                                <span class="text-[10px] text-gray-600 block">{{ $order->created_at->format('H:i') }}</span>
                            </td>
                            <td class="p-4 text-end whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="px-2.5 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-white font-mono text-xs transition" title="{{ $isAr ? 'عرض التفاصيل' : 'View' }}">
                                        {{ $isAr ? 'تفاصيل' : 'View' }}
                                    </a>
                                    <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition" title="{{ $isAr ? 'طباعة الإيصال' : 'Invoice' }}">
                                        🖨️
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-12 text-center text-gray-500">
                                <span class="text-3xl block mb-2">📦</span>
                                <div>{{ $isAr ? 'لا توجد أي طلبات مطابقة للفلتر المحدد' : 'No orders match this filter' }}</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-4 border-t border-white/10 bg-black/20">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
