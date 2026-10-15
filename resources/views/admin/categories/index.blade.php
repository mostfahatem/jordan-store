@extends('admin.layout')

@section('title', 'تصنيفات السنيكرز | JORDAN CATEGORIES')

@php
    $isAr = app()->getLocale() === 'ar';
@endphp

@section('admin_content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-600/10 border border-red-600/20 text-xs font-mono font-bold text-red-400 mb-1">
                <span>STRUCTURE & TAXONOMY</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">
                {{ $isAr ? 'إدارة تصنيفات الأحذية الرياضية' : 'Sneaker Categories' }}
            </h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Categories Table (8 cols) -->
        <div class="lg:col-span-8 rounded-3xl bg-[#0d0d16] border border-white/10 overflow-hidden shadow-2xl">
            <div class="p-5 border-b border-white/10 flex items-center justify-between">
                <h3 class="text-sm font-bold text-white">{{ $isAr ? 'التصنيفات الحالية بالمتجر' : 'Active Store Categories' }}</h3>
                <span class="text-xs font-mono text-gray-400">{{ $categories->count() }} {{ $isAr ? 'تصنيف' : 'total' }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-start text-xs">
                    <thead>
                        <tr class="bg-black/40 text-gray-400 font-mono border-b border-white/10 text-[11px] uppercase tracking-wider">
                            <th class="p-4 text-start">{{ $isAr ? 'الترتيب' : 'Order' }}</th>
                            <th class="p-4 text-start">{{ $isAr ? 'التصنيف بالعربية' : 'Name (AR)' }}</th>
                            <th class="p-4 text-start">{{ $isAr ? 'التصنيف بالإنجليزية' : 'Name (EN)' }}</th>
                            <th class="p-4 text-start">{{ $isAr ? 'المعرف (Slug)' : 'Slug' }}</th>
                            <th class="p-4 text-start">{{ $isAr ? 'عدد الأحذية' : 'Sneakers' }}</th>
                            <th class="p-4 text-end">{{ $isAr ? 'إجراءات' : 'Actions' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 font-sans">
                        @foreach($categories as $category)
                            <tr class="hover:bg-white/[0.02] transition">
                                <td class="p-4 font-mono font-bold text-gray-400">
                                    {{ $category->sort_order }}
                                </td>
                                <td class="p-4 font-bold text-white whitespace-nowrap">
                                    {{ $category->name_ar }}
                                </td>
                                <td class="p-4 text-gray-300 font-mono whitespace-nowrap">
                                    {{ $category->name_en }}
                                </td>
                                <td class="p-4 font-mono text-red-400 text-[11px] whitespace-nowrap">
                                    {{ $category->slug }}
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-lg bg-white/5 font-mono text-gray-300 font-bold">
                                        {{ $category->products_count }} {{ $isAr ? 'موديل' : 'items' }}
                                    </span>
                                </td>
                                <td class="p-4 text-end whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('shop', ['category' => $category->slug]) }}" target="_blank" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition" title="{{ $isAr ? 'عرض في المتجر' : 'View in Shop' }}">
                                            👁️
                                        </a>

                                        @if($category->products_count === 0)
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('{{ $isAr ? 'حذف هذا التصنيف؟' : 'Delete this category?' }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition" title="{{ $isAr ? 'حذف' : 'Delete' }}">
                                                    ✕
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Category Card (4 cols) -->
        <div class="lg:col-span-4 p-6 sm:p-8 rounded-3xl bg-[#0d0d16] border border-white/10 shadow-2xl space-y-4">
            <h3 class="text-sm font-mono font-bold uppercase text-white flex items-center gap-2 border-b border-white/10 pb-3">
                <span>+</span>
                <span>{{ $isAr ? 'إضافة تصنيف سنيكرز جديد' : 'New Category' }}</span>
            </h3>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                        {{ $isAr ? 'الاسم بالعربية *' : 'Name (AR) *' }}
                    </label>
                    <input type="text" name="name_ar" required placeholder="مثال: أحذية كرة السلة" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500" />
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                        {{ $isAr ? 'الاسم بالإنجليزية *' : 'Name (EN) *' }}
                    </label>
                    <input type="text" name="name_en" required placeholder="e.g. Basketball Court" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500 font-mono" />
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                        {{ $isAr ? 'ترتيب الظهور' : 'Sort Order' }}
                    </label>
                    <input type="number" name="sort_order" value="{{ $categories->count() + 1 }}" min="1" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500 font-mono" />
                </div>

                <div>
                    <label class="block text-xs font-mono font-bold text-gray-300 mb-1.5">
                        {{ $isAr ? 'صورة الغلاف' : 'Cover Image Path' }}
                    </label>
                    <input type="text" name="image" value="images/store/products/air-jordan-1-retro.jpg" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white focus:outline-none focus:border-red-500 font-mono" />
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-red-600/20 cursor-pointer">
                        {{ $isAr ? 'إضافة التصنيف ✓' : 'Create Category ✓' }}
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
