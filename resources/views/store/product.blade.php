@extends('layouts.app')

@section('title', ($product->name) . ' | JORDAN SNEAKERS')
@section('meta_description', Str::limit($product->description, 150))

@php
    $isAr = app()->getLocale() === 'ar';
    $discount = $product->discount_percent;
    $spinDirectory = 'images/store/360/'.$product->slug;
    $spinFrames = collect(['front', 'side', 'back'])
        ->filter(fn (string $frame): bool => file_exists(public_path($spinDirectory.'/'.$frame.'.jpg')))
        ->map(fn (string $frame): string => asset($spinDirectory.'/'.$frame.'.jpg'))
        ->values();
    $hasSpin = $spinFrames->count() === 3;
@endphp

@section('content')

    <!-- Inject Product Data into JS for 3D Studio -->
    <script>
        window.__PRODUCT_DATA__ = @json($product->toStorefront());
    </script>

    <!-- Breadcrumbs -->
    <div class="border-b border-white/5 bg-[#09090f]/70 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-white transition">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
                <span>/</span>
                <a href="{{ route('shop') }}" class="hover:text-white transition">{{ $isAr ? 'المتجر' : 'Shop' }}</a>
                <span>/</span>
                <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="hover:text-white transition">{{ $product->category->name }}</a>
                <span>/</span>
                <span class="text-cyan-400 truncate max-w-xs">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Detail Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- ============================================== -->
            <!-- LEFT: COMMERCIAL SNEAKER STUDIO SHOWCASE (7 cols) -->
            <!-- ============================================== -->
            <div class="lg:col-span-7 space-y-5">
                
                <!-- Main Sneaker Showcase (Aspect 4:3, Dark Luxury Pedestal, Ambient Red Glow) -->
                <div id="product-photo-wrapper" class="relative rounded-[32px] overflow-hidden bg-gradient-to-b from-[#161622] via-[#0d0d16] to-[#07070b] border border-white/10 aspect-[4/3] shadow-2xl flex items-center justify-center p-6 sm:p-12 select-none group">
                    
                    <!-- Ambient Soft Red Pedestal Glow -->
                    <div class="absolute bottom-6 w-3/4 h-12 bg-red-600/20 rounded-full blur-3xl pointer-events-none group-hover:bg-red-600/35 transition-all duration-700"></div>

                    <!-- Top HUD Status -->
                    <div class="absolute top-4 inset-x-4 z-20 flex items-center justify-between pointer-events-none">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/75 backdrop-blur-md border border-white/10 text-xs font-mono text-red-400 shadow-lg">
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                            <span class="font-bold tracking-wider">OFFICIAL JORDAN STUDIO // 4K HD</span>
                        </div>

                        <span class="text-[11px] font-mono text-gray-400 bg-black/70 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/10 hidden sm:inline">
                            {{ $isAr ? 'حذاء أصلي 100% مع البوكس والباركود' : '100% Authentic with Original Box' }}
                        </span>
                    </div>

                    <!-- Sneaker Image (Zero Edge Clipping, High Precision Float) -->
                    <img id="product-photo-img" 
                         src="{{ asset($product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-contain filter drop-shadow-[0_25px_40px_rgba(0,0,0,0.95)] transform group-hover:scale-105 group-hover:-rotate-2 transition-all duration-700 ease-out" />
                    
                    <!-- Bottom Tip -->
                    <span class="absolute bottom-4 start-4 text-[11px] font-mono text-gray-300 bg-black/70 backdrop-blur-md px-3 py-1 rounded-full border border-white/10">
                        {{ $isAr ? '🔍 صور حقيقية استوديو 100% مطابقة للمنتج' : '🔍 High-Resolution Authentic Commercial Studio' }}
                    </span>
                </div>

                <!-- Sneaker Quality & Authenticity Guarantee Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center">
                    <div class="p-3.5 rounded-2xl bg-white/5 border border-white/5 space-y-1">
                        <span class="text-base">✓</span>
                        <h4 class="text-xs font-bold text-white">{{ $isAr ? 'أصلي 100%' : '100% Authentic' }}</h4>
                        <p class="text-[10px] text-gray-400">{{ $isAr ? 'فحص جودة معتمد' : 'Verified by experts' }}</p>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-white/5 border border-white/5 space-y-1">
                        <span class="text-base">📦</span>
                        <h4 class="text-xs font-bold text-white">{{ $isAr ? 'تغليف مزدوج' : 'Double Boxed' }}</h4>
                        <p class="text-[10px] text-gray-400">{{ $isAr ? 'حماية البوكس الأصلي' : 'Protects original box' }}</p>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-white/5 border border-white/5 space-y-1">
                        <span class="text-base">⚡</span>
                        <h4 class="text-xs font-bold text-white">{{ $isAr ? 'وسائد هوائية' : 'Air Cushioning' }}</h4>
                        <p class="text-[10px] text-gray-400">{{ $isAr ? 'راحة ومرونة استثنائية' : 'Maximum flight bounce' }}</p>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-white/5 border border-white/5 space-y-1">
                        <span class="text-base">🛡️</span>
                        <h4 class="text-xs font-bold text-white">{{ $isAr ? 'معاينة عند الاستلام' : 'Try Before Paying' }}</h4>
                        <p class="text-[10px] text-gray-400">{{ $isAr ? 'تأكد من المقاس والجودة' : 'Check fit on delivery' }}</p>
                    </div>
                </div>

            </div>

            <!-- ============================================== -->
            <!-- RIGHT: PRODUCT OPTIONS & PURCHASE (5 cols) -->
            <!-- ============================================== -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Category & Badges -->
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-violet-600/20 border border-violet-500/30 text-violet-300">
                        {{ $product->category->name }}
                    </span>
                    @if($product->is_new)
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-cyan-400 text-black">
                            {{ $isAr ? 'إصدار جديد' : 'NEW DROP' }}
                        </span>
                    @endif
                    @if($discount)
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-pink-500 text-white">
                            -{{ $discount }}% {{ $isAr ? 'خصم' : 'OFF' }}
                        </span>
                    @endif
                </div>

                <!-- Product Title -->
                <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                    {{ $product->name }}
                </h1>

                <!-- Ratings & Stock Status -->
                <div class="flex items-center gap-4 text-xs">
                    <div class="flex items-center gap-1.5 text-amber-400">
                        <div class="flex">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= floor($product->rating) ? 'fill-current' : 'text-gray-600 fill-current' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <span class="font-bold text-white">{{ $product->rating }}</span>
                        <span class="text-gray-500">({{ $product->reviews_count }} {{ $isAr ? 'تقييم' : 'reviews' }})</span>
                    </div>

                    <span class="text-gray-600">•</span>

                    <span class="inline-flex items-center gap-1 text-emerald-400 font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>{{ $isAr ? 'متوفر بالمخزون' : 'In Stock' }}</span>
                    </span>
                </div>

                <!-- Price Box -->
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-between">
                    <div>
                        <div class="text-xs text-gray-400">{{ $isAr ? 'السعر الشامل للضريبة:' : 'Price (Incl. VAT):' }}</div>
                        <div class="flex items-baseline gap-2 mt-0.5">
                            <span class="text-3xl font-black text-white font-mono">{{ number_format($product->price) }}</span>
                            <span class="text-sm font-semibold text-cyan-400">{{ $isAr ? 'جنيه مصري' : 'EGP' }}</span>
                            @if($product->old_price)
                                <span class="text-sm text-gray-500 line-through ms-2">{{ number_format($product->old_price) }} EGP</span>
                            @endif
                        </div>
                    </div>

                    <div class="text-end text-xs text-gray-400">
                        <span>{{ $isAr ? 'كود الخصم:' : 'Promo code:' }}</span>
                        <div class="font-mono text-cyan-300 font-bold">NOVA20 (-20%)</div>
                    </div>
                </div>

                <!-- Description -->
                <p class="text-sm text-gray-300 leading-relaxed">
                    {{ $product->description }}
                </p>

                <!-- Color Options -->
                <div class="space-y-2.5 pt-2 border-t border-white/5">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-gray-300 uppercase tracking-wider">{{ $isAr ? 'اللون المحدد:' : 'Selected Color:' }}</span>
                        <span id="selected-color-name" class="font-semibold text-red-500">
                            {{ $product->localized_colors[0]['label'] ?? 'Black' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-3">
                        @foreach($product->localized_colors as $index => $color)
                            <button type="button" data-product-color-choice="{{ $color['hex'] }}" data-product-color-name="{{ $color['label'] }}" class="w-9 h-9 rounded-full border-2 transition-transform {{ $index === 0 ? 'ring-4 ring-red-500 scale-110 border-white' : 'border-white/20 hover:scale-105' }}" style="background-color: {{ $color['hex'] }}" title="{{ $color['label'] }}"></button>
                        @endforeach
                    </div>
                    <p class="text-[11px] text-gray-500 italic">
                        {{ $isAr ? '⚡ اختر اللون المفضل لإضافته إلى طلبك' : '⚡ Select your preferred colorway' }}
                    </p>
                </div>

                <!-- Size Options -->
                <div class="space-y-2.5 pt-2 border-t border-white/5">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-gray-300 uppercase tracking-wider">{{ $isAr ? 'المقاس (EU):' : 'Select Size (EU):' }}</span>
                        <button type="button" onclick="alert('{{ $isAr ? 'دليل مقاسات السنيكرز: مقاسات قياسية أوروبية (EU). اختر مقاسك المعتاد في الأحذية الرياضية.' : 'True to EU sneaker sizing. Order your standard sneaker size.' }}')" class="text-red-400 hover:text-red-300 underline font-medium">
                            {{ $isAr ? 'دليل مقاسات الأحذية' : 'Sneaker Size Guide' }}
                        </button>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @foreach($product->sizes as $index => $size)
                            <button type="button" data-product-size-choice="{{ $size }}" class="w-12 h-11 rounded-xl font-mono text-xs font-semibold border transition {{ $index === 0 ? 'bg-red-600 text-white font-bold border-red-500 shadow-lg shadow-red-600/30' : 'bg-white/5 text-gray-300 border-white/10 hover:border-white/30' }}">
                                {{ $size }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Quantity & Purchase Actions -->
                <div class="space-y-3 pt-4 border-t border-white/5">
                    <div class="flex items-center gap-3">
                        
                        <!-- Qty Selector -->
                        <div class="flex items-center border border-white/10 rounded-2xl bg-white/5 overflow-hidden">
                            <button type="button" id="product-qty-minus" class="w-11 h-12 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 transition text-lg font-bold">
                                -
                            </button>
                            <input type="number" id="product-qty-input" value="1" min="1" max="10" readonly class="w-12 text-center text-sm font-bold text-white bg-transparent focus:outline-none font-mono" />
                            <button type="button" id="product-qty-plus" class="w-11 h-12 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 transition text-lg font-bold">
                                +
                            </button>
                        </div>

                        <!-- Add To Cart Button -->
                        <button type="button" id="product-detail-add-cart" data-product='@json($product->toStorefront())' class="flex-1 py-3.5 px-6 rounded-2xl bg-red-600 hover:bg-red-500 text-white font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-red-600/30 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span>{{ $isAr ? 'إضافة إلى السلة' : 'Add to Cart' }}</span>
                        </button>

                    </div>

                    <!-- Instant Buy Now Button -->
                    <button type="button" id="product-detail-buy-now" class="w-full py-3.5 rounded-2xl bg-white hover:bg-gray-200 text-black font-black text-sm tracking-wide transition flex items-center justify-center gap-2 shadow-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>{{ $isAr ? 'شراء فوري سريع (الدفع عند الاستلام)' : 'Buy Now (Cash on Delivery)' }}</span>
                    </button>
                </div>

                <!-- Product Accordions (Details & Care) -->
                <div class="space-y-3 pt-6 border-t border-white/5 text-xs">
                    
                    <!-- Material specs -->
                    <details class="group rounded-2xl bg-white/5 border border-white/5 p-4" open>
                        <summary class="font-bold text-white flex items-center justify-between cursor-pointer list-none">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span>{{ $isAr ? 'مواصفات الحذاء والتقنيات' : 'Shoe Specs & Craftsmanship' }}</span>
                            </span>
                            <span class="group-open:rotate-180 transition-transform text-gray-400">▼</span>
                        </summary>
                        <div class="mt-3 text-gray-400 leading-relaxed space-y-1">
                            <p><b>{{ $isAr ? 'الخامة العلوية:' : 'Upper Material:' }}</b> {{ $product->material }}</p>
                            <p><b>{{ $isAr ? 'النعل والوسائد:' : 'Sole & Cushioning:' }}</b> {{ $isAr ? 'وسائد Zoom Air مدمجة مع نعل مطاطي عالي المتانة' : 'Integrated Zoom Air cushioning with high-abrasion rubber outsole' }}</p>
                            <p><b>{{ $isAr ? 'ضمان الأصالة:' : 'Authenticity:' }}</b> {{ $isAr ? 'أصلي 100% مع الباركود والبوكس المزدوج والتغليف المعتمد' : '100% Verified authentic with original box and barcode' }}</p>
                        </div>
                    </details>

                    <!-- Shipping -->
                    <details class="group rounded-2xl bg-white/5 border border-white/5 p-4">
                        <summary class="font-bold text-white flex items-center justify-between cursor-pointer list-none">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                <span>{{ $isAr ? 'التوصيل وسياسة الاسترجاع' : 'Shipping & 14-Day Returns' }}</span>
                            </span>
                            <span class="group-open:rotate-180 transition-transform text-gray-400">▼</span>
                        </summary>
                        <div class="mt-3 text-gray-400 leading-relaxed">
                            <p>{{ $isAr ? 'شحن فوري لباب البيت خلال 2-3 أيام عمل. يمكنك فحص وقياس المنتج أمام مندوب الشحن والاستبدال أو الاسترجاع بكل سهولة خلال 14 يوم.' : 'Fast home delivery within 48-72 hours. You can inspect the garment upon arrival, with hassle-free 14-day exchange and returns.' }}</p>
                        </div>
                    </details>

                </div>

            </div>

        </div>

        <!-- ============================================== -->
        <!-- RELATED PRODUCTS -->
        <!-- ============================================== -->
        @if($related->count() > 0)
            <div class="mt-24 pt-12 border-t border-white/10">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <span class="text-xs font-mono text-cyan-400 uppercase tracking-widest">{{ $isAr ? 'قد يعجبك أيضاً' : 'YOU MAY ALSO LIKE' }}</span>
                        <h2 class="text-2xl font-black text-white mt-1">{{ $isAr ? 'قطع مكملة لإطلالتك' : 'Complete The Look' }}</h2>
                    </div>
                    <a href="{{ route('shop') }}" class="text-xs font-semibold text-violet-400 hover:text-white transition">
                        {{ $isAr ? 'استعراض الكل' : 'View All' }}
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($related as $rel)
                        <x-product-card :product="$rel" />
                    @endforeach
                </div>
            </div>
        @endif

    </div>

@endsection
