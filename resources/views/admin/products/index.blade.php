@extends('admin.layout')

@section('title', 'إدارة الأحذية والمنتجات | JORDAN SNEAKERS')

@php
    $isAr = app()->getLocale() === 'ar';
@endphp

@section('admin_content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-600/10 border border-red-600/20 text-xs font-mono font-bold text-red-400 mb-1">
                <span>CATALOG MASTER // SNEAKERS ONLY</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">
                {{ $isAr ? 'إدارة كتالوج الأحذية والسنيكرز' : 'Sneaker Catalog Management' }}
            </h1>
        </div>

        <div>
            <a href="{{ route('admin.products.create') }}" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono font-bold text-xs flex items-center gap-2 shadow-lg shadow-red-600/20 transition">
                <span>+</span>
                <span>{{ $isAr ? 'إضافة سنيكرز جديد' : 'Add New Sneaker' }}</span>
            </a>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="p-4 rounded-2xl bg-[#0d0d16] border border-white/10 flex flex-wrap items-center justify-between gap-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap items-center gap-2 flex-1">
            <input type="text" 
                   name="search" 
                   value="{{ $search }}" 
                   placeholder="{{ $isAr ? 'بحث باسم الحذاء أو الموديل...' : 'Search sneaker name or model...' }}" 
                   class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-red-500 font-mono transition flex-1 min-w-[200px]" />
            
            <select name="category_id" class="px-3.5 py-2 rounded-xl bg-[#141420] border border-white/10 text-xs text-white focus:outline-none focus:border-red-500 font-mono">
                <option value="">{{ $isAr ? 'كل التصنيفات' : 'All Categories' }}</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (string)$categoryId === (string)$cat->id ? 'selected' : '' }}>
                        {{ $isAr ? $cat->name_ar : $cat->name_en }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-mono font-bold transition">
                {{ $isAr ? 'تصفية' : 'Filter' }}
            </button>

            @if($search || $categoryId)
                <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-xl bg-rose-500/10 text-rose-400 text-xs font-mono hover:bg-rose-500/20 transition">
                    ✕
                </a>
            @endif
        </form>
    </div>

    <!-- Products Table Card -->
    <div class="rounded-3xl bg-[#0d0d16] border border-white/10 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead>
                    <tr class="bg-black/40 text-gray-400 font-mono border-b border-white/10 text-[11px] uppercase tracking-wider">
                        <th class="p-4 text-start">{{ $isAr ? 'الحذاء' : 'Sneaker' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'التصنيف' : 'Category' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'السعر' : 'Price' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'المقاسات المتاحة' : 'Sizes' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'التقييم' : 'Rating' }}</th>
                        <th class="p-4 text-start">{{ $isAr ? 'الحالة' : 'Status' }}</th>
                        <th class="p-4 text-end">{{ $isAr ? 'الإجراءات' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 font-sans">
                    @forelse($products as $product)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-14 h-12 rounded-xl bg-black/60 border border-white/10 p-1 flex items-center justify-center flex-shrink-0">
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain filter drop-shadow" />
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('products.show', $product) }}" target="_blank" class="font-bold text-white hover:text-red-400 transition truncate max-w-xs block">
                                            {{ $product->name }}
                                        </a>
                                        <span class="text-[10px] text-gray-500 font-mono block">{{ $product->slug }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 text-gray-300 font-mono text-[11px]">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td class="p-4 whitespace-nowrap font-mono">
                                <span class="text-white font-bold">{{ number_format($product->price) }}</span>
                                @if($product->old_price)
                                    <span class="text-[10px] text-gray-500 line-through ms-1">{{ number_format($product->old_price) }}</span>
                                @endif
                                <span class="text-[10px] text-gray-400 font-sans block">{{ $isAr ? 'ج.م' : 'EGP' }}</span>
                            </td>
                            <td class="p-4 whitespace-nowrap font-mono text-[11px] text-gray-300">
                                @if(is_array($product->sizes))
                                    {{ implode(', ', array_slice($product->sizes, 0, 4)) }}{{ count($product->sizes) > 4 ? '...' : '' }}
                                @else
                                    40-45
                                @endif
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <span class="text-amber-400 font-mono font-bold">★ {{ $product->rating }}</span>
                                <span class="text-[10px] text-gray-500 font-mono block">({{ $product->reviews_count }})</span>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                @if($product->is_new)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-cyan-400 text-black">
                                        NEW
                                    </span>
                                @endif
                                @if($product->is_featured)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-red-600/30 text-red-400 border border-red-500/30 ms-1">
                                        FEATURED
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-end whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('products.show', $product) }}" target="_blank" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition" title="{{ $isAr ? 'معاينة بالمتجر' : 'View in Store' }}">
                                        👁️
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="px-2.5 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-white font-mono text-xs transition">
                                        {{ $isAr ? 'تعديل' : 'Edit' }}
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('{{ $isAr ? 'هل أنت متأكد من حذف هذا الحذاء؟' : 'Are you sure you want to delete this sneaker?' }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition" title="{{ $isAr ? 'حذف' : 'Delete' }}">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-gray-500">
                                {{ $isAr ? 'لا توجد أحذية مطابقة لخيارات البحث' : 'No sneakers match your search' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t border-white/10 bg-black/20">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
