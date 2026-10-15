@props(['product'])

@php
    $isAr = app()->getLocale() === 'ar';
    $discount = $product->discount_percent;
@endphp

<div class="group relative rounded-3xl bg-[#0c0c14] border border-white/10 hover:border-red-500/50 p-4 transition-all duration-500 hover:shadow-2xl hover:shadow-red-600/15 flex flex-col justify-between">
    
    <!-- Top Image Container (Sleek Sneaker Display Pedestal) -->
    <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden bg-gradient-to-b from-[#161622] via-[#0e0e17] to-[#08080d] border border-white/5 mb-4 flex items-center justify-center p-3 select-none">
        
        <!-- Ambient Under-Shoe Glow & Soft Pedestal Shadow -->
        <div class="absolute bottom-3 w-4/5 h-6 bg-red-600/15 rounded-full blur-xl pointer-events-none group-hover:bg-red-600/30 group-hover:scale-110 transition-all duration-500"></div>

        <!-- Badges (Top Start) -->
        <div class="absolute top-3 start-3 z-10 flex flex-col gap-1.5 items-start">
            @if($product->is_new)
                <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-black bg-cyan-400 text-black uppercase tracking-wider shadow-lg shadow-cyan-400/20">
                    {{ $isAr ? 'إصدار جديد' : 'NEW DROP' }}
                </span>
            @endif
            @if($discount)
                <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-black bg-gradient-to-r from-red-600 to-rose-600 text-white shadow-lg shadow-red-600/30">
                    -{{ $discount }}%
                </span>
            @endif
        </div>

        <!-- Authentic Product Sneaker Photo (Zero Edge Clipping, Clean Floating Hover) -->
        <a href="{{ route('products.show', $product) }}" class="w-full h-full flex items-center justify-center">
            <img src="{{ asset($product->image) }}" 
                 alt="{{ $product->name }}" 
                 loading="lazy" 
                 class="w-full h-full object-contain filter drop-shadow-[0_12px_24px_rgba(0,0,0,0.85)] transform group-hover:scale-110 group-hover:-rotate-3 group-hover:-translate-y-2 transition-all duration-500 ease-out" />
        </a>

        <!-- Quick Actions Hover Ribbon -->
        <div class="absolute inset-x-3 bottom-3 z-10 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 flex gap-2">
            <a href="{{ route('products.show', $product) }}" class="flex-1 py-2 px-3 rounded-xl bg-black/85 hover:bg-black text-white text-xs font-bold backdrop-blur-md border border-white/20 flex items-center justify-center gap-1.5 transition">
                <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <span>{{ $isAr ? 'عرض الحذاء' : 'View Sneaker' }}</span>
            </a>
            <button type="button" data-quick-add='@json($product->toStorefront())' class="p-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white transition flex items-center justify-center shadow-lg shadow-red-600/30" title="{{ $isAr ? 'إضافة سريعة للسلة' : 'Quick Add' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Product Details -->
    <div class="space-y-2.5">
        <div class="flex items-center justify-between text-xs text-gray-400">
            <span class="hover:text-red-400 transition font-mono uppercase text-[11px] font-bold text-gray-400">{{ $product->category->name }}</span>
            <div class="flex items-center gap-1 text-amber-400 text-xs">
                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <span class="text-white font-mono font-bold">{{ $product->rating }}</span>
            </div>
        </div>

        <h3 class="font-bold text-white text-sm line-clamp-2 min-h-[2.5rem] leading-snug group-hover:text-red-500 transition-colors">
            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
        </h3>

        <!-- Available Color Dots -->
        <div class="flex items-center gap-1.5 pt-0.5">
            @foreach($product->localized_colors as $color)
                <span class="w-3 h-3 rounded-full border border-white/20 transition-transform hover:scale-125" style="background-color: {{ $color['hex'] }}" title="{{ $color['label'] }}"></span>
            @endforeach
        </div>

        <!-- Pricing & Direct CTA -->
        <div class="flex items-center justify-between pt-2.5 border-t border-white/5">
            <div>
                <span class="font-mono font-black text-base text-white tracking-tight">{{ number_format($product->price) }} <span class="text-xs text-gray-400 font-sans font-normal">{{ $isAr ? 'ج.م' : 'EGP' }}</span></span>
                @if($product->old_price)
                    <span class="text-xs text-gray-500 font-mono line-through ms-1.5">{{ number_format($product->old_price) }}</span>
                @endif
            </div>

            <a href="{{ route('products.show', $product) }}" class="px-3.5 py-1.5 rounded-lg bg-white/5 hover:bg-red-600 text-gray-300 hover:text-white border border-white/10 hover:border-red-500 text-xs font-mono font-bold flex items-center gap-1 transition-all duration-300 shadow-sm">
                <span>{{ $isAr ? 'طلب الآن' : 'Shop' }}</span>
                <span class="rtl:rotate-180 text-[10px]">→</span>
            </a>
        </div>
    </div>
</div>
