@extends('admin.layout')

@section('title', 'سجل العملاء والمشترين | JORDAN CUSTOMERS')

@php
    $isAr = app()->getLocale() === 'ar';
@endphp

@section('admin_content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-600/10 border border-red-600/20 text-xs font-mono font-bold text-red-400 mb-1">
                <span>CLIENT RELATIONSHIPS & VIP MEMBERS</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">
                {{ $isAr ? 'سجل العملاء والمشترين' : 'Customer Roster & VIP Accounts' }}
            </h1>
        </div>
        <div class="text-xs font-mono text-gray-400">
            {{ $isAr ? 'إجمالي العملاء المميزين:' : 'Unique customers:' }} <strong class="text-white">{{ $customers->total() }}</strong>
        </div>
    </div>

    <!-- Customers Table Card -->
    <div class="rounded-3xl bg-[#0d0d16] border border-white/10 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead>
                    <tr class="bg-black/40 text-gray-400 font-mono border-b border-white/10 text-[11px] uppercase tracking-wider">
                        <th class="p-4 text-start">{{ $isAr ? 'العميل' : 'Customer' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'رقم الهاتف (واتساب)' : 'Phone (WhatsApp)' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'المحافظة / المدينة' : 'Location' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'عدد الطلبات' : 'Orders' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'إجمالي المشتريات' : 'Total Spent' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'آخر طلب' : 'Last Purchase' }}</th>
                        <th class="p-4 text-end">{{ $isAr ? 'التواصل' : 'Contact' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 font-sans">
                    @forelse($customers as $client)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center font-bold text-white text-xs">
                                        {{ mb_substr($client->customer_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-white block">{{ $client->customer_name }}</span>
                                        @if($client->customer_email)
                                            <span class="text-[10px] text-gray-500 font-mono block">{{ $client->customer_email }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 font-mono text-gray-300">
                                <a href="tel:{{ $client->customer_phone }}" class="hover:text-red-400 transition" dir="ltr">
                                    {{ $client->customer_phone }}
                                </a>
                            </td>
                            <td class="p-4 text-gray-300 whitespace-nowrap">
                                <span class="font-bold text-white">{{ $client->governorate }}</span>
                                <span class="text-[10px] text-gray-500 block">{{ $client->city }}</span>
                            </td>
                            <td class="p-4 font-mono whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-lg bg-white/5 text-white font-bold">
                                    {{ $client->total_orders }} {{ $isAr ? 'طلبات' : 'orders' }}
                                </span>
                            </td>
                            <td class="p-4 font-mono font-black text-white whitespace-nowrap">
                                {{ number_format($client->total_spent) }} <span class="text-[10px] text-gray-400 font-sans font-normal">{{ $isAr ? 'ج.م' : 'EGP' }}</span>
                            </td>
                            <td class="p-4 font-mono text-gray-400 text-[11px] whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($client->last_order_date)->format('Y-m-d') }}
                            </td>
                            <td class="p-4 text-end whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="https://wa.me/2{{ ltrim($client->customer_phone, '0') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-600/20 hover:bg-emerald-600/40 text-emerald-400 border border-emerald-500/30 text-xs font-mono font-bold transition flex items-center gap-1">
                                        <span>💬</span>
                                        <span>WhatsApp</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-gray-500">
                                {{ $isAr ? 'لا يوجد عملاء مسجلين بعد' : 'No customer records yet' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
            <div class="p-4 border-t border-white/10 bg-black/20">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
