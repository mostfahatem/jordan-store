@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'متجر السنيكرز الأصلي | JORDAN SNEAKER LAB' : 'All Authentic Sneakers | JORDAN SNEAKER LAB')

@php
    $isAr = app()->getLocale() === 'ar';
    $hasFilters = !empty(array_filter($filters ?? []));
@endphp

@section('content')

    <!-- Header Section -->
    <div class="border-b border-white/5 bg-[#09090f]/70 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <nav class="flex items-center gap-2 text-xs text-gray-400 mb-2">
                        <a href="{{ route('home') }}" class="hover:text-white transition">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
                        <span>/</span>
                        <span class="text-red-500 font-medium">{{ $isAr ? 'المتجر' : 'Shop' }}</span>
                    </nav>
                    <h1 class="text-3xl sm:text-4xl font-black text-white">
                        {{ $isAr ? 'كتالوج أحذية وسنيكرز جوردان' : 'All Authentic Jordan Sneakers' }}
                    </h1>
                </div>

                <div class="text-xs text-gray-400">
                    {{ $isAr ? 'عرض' : 'Showing' }} <span class="font-mono text-cyan-400 font-bold">{{ $products->total() }}</span> {{ $isAr ? 'قطعة مميزة' : 'unique pieces' }}
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Filters Sidebar -->
            <aside class="space-y-6">
                <form id="filter-form" action="{{ route('shop') }}" method="GET" class="p-6 rounded-3xl bg-[#0e0e17] border border-white/10 space-y-6">
                    
                    <!-- Search input -->
                    <div>
                        <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2">
                            {{ $isAr ? 'بحث بالاسم' : 'Search' }}
                        </label>
                        <div class="relative">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $isAr ? 'ابحث عن هودي، تيشيرت...' : 'Search garments...' }}" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400" />
                            <button type="submit" class="absolute end-2.5 top-2.5 text-gray-400 hover:text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Categories Filter -->
                    <div class="pt-4 border-t border-white/5">
                        <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2.5">
                            {{ $isAr ? 'الفئات' : 'Categories' }}
                        </label>
                        <div class="space-y-1 text-xs">
                            <a href="{{ route('shop', array_merge(request()->except('category', 'page'))) }}" class="block px-3 py-2 rounded-xl transition {{ !request('category') ? 'bg-violet-600 text-white font-semibold' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                                {{ $isAr ? 'جميع الفئات' : 'All Categories' }}
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('shop', array_merge(request()->except('page'), ['category' => $cat->slug])) }}" class="flex items-center justify-between px-3 py-2 rounded-xl transition {{ request('category') === $cat->slug ? 'bg-violet-600 text-white font-semibold' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                                    <span>{{ $cat->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sneaker Type Filter -->
                    <div class="pt-4 border-t border-white/5">
                        <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2.5">
                            {{ $isAr ? 'نوع السنيكرز' : 'Sneaker Silhouette' }}
                        </label>
                        <div class="grid grid-cols-2 gap-1.5 text-xs">
                            @php
                                $garments = [
                                    'shoe' => ['ar' => 'أحذية رياضية', 'en' => 'All Sneakers'],
                                ];
                            @endphp
                            @foreach($garments as $key => $labels)
                                <a href="{{ route('shop', array_merge(request()->except('page'), ['garment' => request('garment') === $key ? null : $key])) }}" class="px-2.5 py-2 text-center rounded-lg border transition {{ request('garment') === $key ? 'bg-red-600 text-white border-red-500 font-bold shadow-lg shadow-red-600/30' : 'bg-white/5 text-gray-400 border-white/5 hover:text-white hover:bg-white/10' }}">
                                    {{ $labels[$isAr ? 'ar' : 'en'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- EU Shoe Sizes Filter -->
                    <div class="pt-4 border-t border-white/5">
                        <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2.5">
                            {{ $isAr ? 'المقاس الأوروبي (EU)' : 'Shoe Size (EU)' }}
                        </label>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach(['40', '41', '42', '43', '44', '45', '46'] as $sz)
                                <a href="{{ route('shop', array_merge(request()->except('page'), ['size' => request('size') === $sz ? null : $sz])) }}" class="w-9 h-9 rounded-lg flex items-center justify-center font-mono text-xs border transition {{ request('size') === $sz ? 'bg-red-600 text-white border-red-500 font-bold shadow-lg shadow-red-600/30' : 'bg-white/5 text-gray-300 border-white/10 hover:border-white/30' }}">
                                    {{ $sz }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Colors Swatches Filter -->
                    <div class="pt-4 border-t border-white/5">
                        <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2.5">
                            {{ $isAr ? 'اللون' : 'Color' }}
                        </label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($colors as $clr)
                                <a href="{{ route('shop', array_merge(request()->except('page'), ['color' => request('color') === $clr['hex'] ? null : $clr['hex']])) }}" class="w-7 h-7 rounded-full border-2 transition-transform hover:scale-110 flex items-center justify-center {{ request('color') === $clr['hex'] ? 'ring-2 ring-cyan-400 scale-110 border-white' : 'border-white/20' }}" style="background-color: {{ $clr['hex'] }}" title="{{ $clr['label'] }}">
                                    @if(request('color') === $clr['hex'])
                                        <span class="w-1.5 h-1.5 rounded-full bg-white shadow"></span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="pt-4 border-t border-white/5">
                        <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2.5">
                            {{ $isAr ? 'نطاق السعر (ج.م)' : 'Price Range (EGP)' }}
                        </label>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <input type="number" name="min" value="{{ request('min') }}" placeholder="{{ $isAr ? 'من' : 'Min' }}" class="px-2.5 py-2 rounded-lg bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400" />
                            <input type="number" name="max" value="{{ request('max') }}" placeholder="{{ $isAr ? 'إلى' : 'Max' }}" class="px-2.5 py-2 rounded-lg bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400" />
                        </div>
                        <button type="submit" class="w-full mt-2 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-white text-xs font-semibold transition">
                            {{ $isAr ? 'تطبيق السعر' : 'Apply Price' }}
                        </button>
                    </div>

                    @if($hasFilters)
                        <div class="pt-4 border-t border-white/5">
                            <a href="{{ route('shop') }}" class="w-full block py-2.5 text-center rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-300 text-xs font-bold transition">
                                {{ $isAr ? 'إعادة ضبط الفلاتر ✕' : 'Clear All Filters ✕' }}
                            </a>
                        </div>
                    @endif

                </form>
            </aside>

            <!-- Products Content (3 cols) -->
            <div class="lg:col-span-3 space-y-6">
                
                <!-- Sort & View Controls -->
                <div class="p-4 rounded-2xl bg-[#0e0e17] border border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs text-gray-400">
                        {{ $isAr ? 'ترتيب النتائج:' : 'Sort by:' }}
                    </div>

                    <div class="flex items-center gap-2">
                        @php
                            $sortOptions = [
                                'newest' => ['ar' => 'الأحدث', 'en' => 'Newest'],
                                'price_asc' => ['ar' => 'السعر: من الأقل للأعلى', 'en' => 'Price: Low to High'],
                                'price_desc' => ['ar' => 'السعر: من الأعلى للأقل', 'en' => 'Price: High to Low'],
                                'popular' => ['ar' => 'الأكثر تقييماً', 'en' => 'Top Rated'],
                            ];
                        @endphp
                        <form action="{{ route('shop') }}" method="GET" class="inline">
                            @foreach(request()->except('sort', 'page') as $k => $v)
                                @if($v)
                                    <input type="hidden" name="{{ $k }}" value="{{ $v }}" />
                                @endif
                            @endforeach
                            <select name="sort" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl bg-[#141422] border border-white/10 text-xs text-white focus:outline-none focus:border-cyan-400">
                                @foreach($sortOptions as $optKey => $optVal)
                                    <option value="{{ $optKey }}" {{ request('sort', 'newest') === $optKey ? 'selected' : '' }}>
                                        {{ $optVal[$isAr ? 'ar' : 'en'] }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="p-16 rounded-3xl bg-[#0e0e17] border border-white/10 text-center space-y-4">
                        <div class="w-16 h-16 mx-auto rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white">{{ $isAr ? 'لم يتم العثور على منتجات' : 'No products matched your criteria' }}</h3>
                        <p class="text-xs text-gray-400 max-w-sm mx-auto">
                            {{ $isAr ? 'جرب تغيير معايير البحث أو تصفير الفلاتر لاستعراض كل التشكيلة.' : 'Try adjusting your filters or resetting them to view the full drop.' }}
                        </p>
                        <a href="{{ route('shop') }}" class="inline-block px-6 py-3 rounded-full glow-btn-primary text-white text-xs font-semibold">
                            {{ $isAr ? 'إعادة ضبط كل الفلاتر' : 'Reset All Filters' }}
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection
