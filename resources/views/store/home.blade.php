@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'JORDAN | جمب مان 2021 PF - المتجر الرسمي' : 'JORDAN | Jumpman 2021 PF Official Store')

@php
    $isAr = app()->getLocale() === 'ar';
@endphp

@section('content')

    <!-- ============================================== -->
    <!-- 1. FULL-WIDTH CINEMATIC VIDEO HERO SHOWCASE    -->
    <!-- IMMERSIVE 4K REEL + FLOATING JUMPMAN 2021 PF   -->
    <!-- ============================================== -->
    <section dir="ltr" class="relative w-full min-h-[92vh] lg:min-h-screen bg-[#020204] overflow-hidden flex flex-col justify-between pt-2 pb-8 select-none">

        <!-- A. CINEMATIC VIDEO AMBIENT BACKGROUND LAYER -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <video id="hero-bg-video" autoplay loop muted playsinline class="w-full h-full object-cover opacity-25 filter contrast-125 brightness-90 mix-blend-screen scale-105 transition-opacity duration-1000">
                <source src="{{ asset('videos/hero_runway.mp4') }}" type="video/mp4">
            </video>
            <!-- Cinematic Dark Vignettes & Radial Depth -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#020204] via-[#020204]/60 to-[#020204]/90"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,transparent_20%,#020204_85%)]"></div>
        </div>

        <!-- B. GIGANTIC WATERMARK BACKGROUND TYPOGRAPHY -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none overflow-hidden select-none z-0">
            <span class="text-[20vw] font-black tracking-tighter text-white/[0.03] uppercase leading-none font-sans">
                JORDAN
            </span>
        </div>

        <!-- C. AMBIENT RADIAL COLOR GLOW BEHIND SNEAKER -->
        <div id="hero-ambient-glow" class="absolute w-[750px] h-[750px] rounded-full blur-[190px] pointer-events-none transition-all duration-700 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-red-600/35 z-0"></div>

        <!-- D. SUBTLE FLOWING VECTOR RED CONTOUR CURVES -->
        <svg class="absolute inset-0 w-full h-full pointer-events-none z-0 opacity-40" viewBox="0 0 1440 900" fill="none" preserveAspectRatio="none">
            <path d="M-100 240 C350 80, 750 820, 1600 320" stroke="#ef4444" stroke-width="1.2" stroke-opacity="0.35"/>
            <path d="M-100 520 C420 380, 920 120, 1600 700" stroke="#ef4444" stroke-width="1" stroke-opacity="0.25"/>
            <path d="M200 -50 C500 500, 1100 200, 1500 850" stroke="#ef4444" stroke-width="0.8" stroke-opacity="0.2"/>
        </svg>

        <!-- ============================================== -->
        <!-- E. FOREGROUND INTERACTIVE ATHLETIC STAGE       -->
        <!-- ============================================== -->
        <div class="relative z-10 w-full flex-1 flex flex-col justify-between px-4 sm:px-8 lg:px-14 xl:px-20 max-w-[1920px] mx-auto my-auto">

            <!-- TOP HERO BROADCAST & CINEMA HUD BAR -->
            <div class="w-full flex items-center justify-between py-3 border-b border-white/10 text-xs font-mono mb-2">
                <!-- Left: Live Broadcast Tag -->
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-600/20 border border-red-500/40 text-red-400 font-bold tracking-wider">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                        <span>● REC // 4K FLIGHT LAB</span>
                    </span>
                    <span class="text-gray-400 hidden sm:inline">JORDAN BRAND 2026 OFFICIAL SHOWCASE</span>
                </div>

                <!-- Right: Cinema Controls (Sound & Launch Film) -->
                <div class="flex items-center gap-2 pointer-events-auto">
                    <button type="button" id="btn-hero-sound-toggle" class="px-3.5 py-1.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/15 text-white flex items-center gap-1.5 transition cursor-pointer">
                        <span id="hero-sound-icon">🔇</span>
                        <span id="hero-sound-label">{{ $isAr ? 'الصوت: مغلق' : 'AUDIO: OFF' }}</span>
                    </button>

                    <button type="button" id="btn-open-film-modal" class="px-4 py-1.5 rounded-full bg-red-600 hover:bg-red-500 text-white font-bold flex items-center gap-2 shadow-lg shadow-red-600/30 transition cursor-pointer hover:scale-105">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        <span>{{ $isAr ? 'مشاهدة فيلم الإطلاق' : 'PLAY FILM' }}</span>
                    </button>
                </div>
            </div>

            <!-- MAIN RESPONSIVE HERO GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center flex-1 my-auto py-4">

                <!-- 1. LEFT TYPOGRAPHY & STORY (Col 1 to 4) -->
                <div class="lg:col-span-4 z-20 space-y-4 text-left">
                    
                    <!-- Stylized Jump Headline -->
                    <div>
                        <h1 id="hero-title-jump" class="jordan-title-jump text-red-600 drop-shadow-[0_20px_40px_rgba(239,68,68,0.45)] text-7xl sm:text-8xl md:text-9xl lg:text-[11vw] xl:text-[12vw] select-none leading-none">
                            Jump
                        </h1>
                        <span class="block tracking-[0.45em] text-xs sm:text-sm font-bold uppercase text-white/90 mt-2 font-mono">
                            B a s k e t b a l l &nbsp; S h o e
                        </span>
                    </div>

                    <!-- Mini Tagline Description -->
                    <p class="text-xs sm:text-sm text-gray-400 max-w-sm leading-relaxed hidden sm:block">
                        {{ $isAr 
                            ? 'أيقونة كرة السلة العصرية بوحدة وسائد Zoom Air المرتدة وأسلاك Flightwire المقوسة لتثبيت استثنائي وتحليق بلا حدود.'
                            : 'Engineered for relentless court propulsion. Combining encapsulated Zoom Air with arc-shaped Flightwire stability.' }}
                    </p>

                    <!-- CHOOSE COLOR PALETTE HOTSPOT -->
                    <div class="pt-4 space-y-2.5">
                        <span class="text-xs font-mono font-bold text-gray-400 uppercase tracking-widest block">
                            CHOOSE COLOR :
                        </span>
                        
                        <div class="flex items-center gap-3">
                            <!-- Purple Colorway -->
                            <button type="button" 
                                    data-colorway-key="purple" 
                                    class="w-14 h-12 lg:w-16 lg:h-14 rounded-2xl overflow-hidden border border-white/20 hover:border-purple-400 bg-black/60 backdrop-blur-md p-1 transition-all duration-300 opacity-50 hover:opacity-100 group cursor-pointer shadow-xl"
                                    title="Electric Purple Colorway">
                                <img src="{{ asset('images/store/thumb_purple.png') }}" alt="Purple" class="w-full h-full object-contain group-hover:scale-110 transition-transform" />
                            </button>

                            <!-- Green Colorway -->
                            <button type="button" 
                                    data-colorway-key="green" 
                                    class="w-14 h-12 lg:w-16 lg:h-14 rounded-2xl overflow-hidden border border-white/20 hover:border-emerald-400 bg-black/60 backdrop-blur-md p-1 transition-all duration-300 opacity-50 hover:opacity-100 group cursor-pointer shadow-xl"
                                    title="Neon Emerald Colorway">
                                <img src="{{ asset('images/store/thumb_green.png') }}" alt="Green" class="w-full h-full object-contain group-hover:scale-110 transition-transform" />
                            </button>

                            <!-- Red Colorway (Default Active) -->
                            <button type="button" 
                                    data-colorway-key="red" 
                                    class="w-14 h-12 lg:w-16 lg:h-14 rounded-2xl overflow-hidden border border-white/20 hover:border-red-500 bg-black/60 backdrop-blur-md p-1 transition-all duration-300 ring-2 ring-white scale-110 group cursor-pointer shadow-xl opacity-100"
                                    title="University Red Colorway">
                                <img src="{{ asset('images/store/thumb_red.png') }}" alt="Red" class="w-full h-full object-contain group-hover:scale-110 transition-transform" />
                            </button>
                        </div>
                    </div>

                </div>

                <!-- 2. CENTER: FLOATING DIAGONAL JUMPMAN SNEAKER (Col 5 to 8) -->
                <div class="lg:col-span-4 relative flex items-center justify-center min-h-[360px] sm:min-h-[440px] lg:min-h-[520px]">
                    
                    <!-- Ground Shadow Reflection -->
                    <div class="absolute bottom-8 w-3/4 h-12 bg-black/90 rounded-full blur-2xl transform scale-y-50 pointer-events-none"></div>

                    <!-- Flying 3D Crystal Shards on Heel -->
                    <div id="hero-shards-container" class="absolute top-10 end-6 sm:end-10 z-20 pointer-events-none hidden sm:flex items-center gap-2">
                        <div class="shard-item bg-red-600 w-4 h-6 rotate-45 transform skew-x-12 shadow-lg animate-pulse" style="clip-path: polygon(50% 0%, 0% 100%, 100% 100%);"></div>
                        <div class="shard-item bg-red-500 w-6 h-8 -rotate-12 transform shadow-2xl" style="clip-path: polygon(50% 0%, 0% 100%, 100% 70%);"></div>
                        <div class="shard-item bg-red-700 w-3 h-5 rotate-180 transform shadow-md" style="clip-path: polygon(0% 0%, 100% 0%, 50% 100%);"></div>
                    </div>

                    <!-- THE ICONIC SNEAKER GRAPHIC (HIGH RESOLUTION TRANSPARENT HQ) -->
                    <div class="relative z-10 w-full flex flex-col items-center justify-center">
                        <div class="animate-shoe-float cursor-pointer group flex items-center justify-center w-full">
                            <img id="hero-cutout-shoe" 
                                 src="{{ asset('images/store/jumpman_angled_red.png') }}" 
                                 alt="Air Jordan Jumpman 2021 PF" 
                                 class="w-full max-w-[460px] sm:max-w-[540px] lg:max-w-[620px] xl:max-w-[680px] object-contain transition-all duration-500 group-hover:scale-105 filter drop-shadow-[0_20px_35px_rgba(0,0,0,0.8)]" />
                        </div>

                        <!-- Sneaker Tech Details Quick Access Button -->
                        <div class="mt-4 z-20">
                            <a href="{{ route('products.show', 'jordan-jumpman-2021-pf') }}" class="inline-flex items-center gap-2.5 px-6 py-2.5 rounded-full bg-black/80 hover:bg-red-600 text-white backdrop-blur-md border border-white/20 hover:border-red-500 text-xs font-mono font-bold tracking-wider transition-all duration-300 hover:scale-105 shadow-2xl group cursor-pointer">
                                <span class="w-2 h-2 rounded-full bg-red-500 group-hover:bg-white animate-ping"></span>
                                <span>{{ $isAr ? 'تفاصيل ومواصفات الحذاء الرسمية' : 'Official Sneaker Details & Tech' }}</span>
                                <span class="text-xs group-hover:translate-x-1 transition-transform rtl:rotate-180">→</span>
                            </a>
                        </div>
                    </div>

                </div>

                <!-- 3. RIGHT TYPOGRAPHY, PRICE & INSPIRATION CARD (Col 9 to 12) -->
                <div class="lg:col-span-4 z-20 space-y-6 text-left lg:ps-8">
                    
                    <!-- Stylized man Headline + 2021 PF -->
                    <div>
                        <span id="hero-tag-year" class="text-red-500 font-mono font-black text-xl sm:text-2xl lg:text-3xl tracking-widest uppercase block transition-colors duration-500">
                            2021 PF
                        </span>
                        <h2 class="jordan-title-man text-white drop-shadow-[0_20px_40px_rgba(255,255,255,0.2)] text-7xl sm:text-8xl md:text-9xl lg:text-[11vw] xl:text-[12vw] select-none leading-none">
                            man
                        </h2>
                    </div>

                    <!-- Price & Exclusive Tag Group -->
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <span id="hero-price-display" class="text-5xl lg:text-6xl font-black font-mono text-red-600 tracking-tight transition-colors duration-500">
                                134$
                            </span>
                            <span class="px-3.5 py-1 rounded-full bg-red-600 text-white text-[10px] font-mono font-black uppercase tracking-wider shadow-lg shadow-red-600/40">
                                exclusive
                            </span>
                        </div>
                        <div class="text-xs font-mono font-bold tracking-wider text-white uppercase">
                            JORDAN JUMPMAN 2021 PF
                        </div>
                    </div>

                    <!-- INSPIRATION CARD -->
                    <div class="p-5 rounded-2xl bg-black/60 border border-white/10 backdrop-blur-md max-w-sm space-y-2 shadow-2xl">
                        <div class="text-xs font-mono font-black tracking-widest text-white uppercase flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                            <span>INSPIRATION</span>
                        </div>
                        <p class="text-xs text-gray-300 leading-relaxed font-sans">
                            Inspired by the design of the latest Air Jordan game shoe, the Jordan Jumpman 2021 helps up-and-coming players level up their game.
                        </p>
                    </div>

                </div>

            </div>

            <!-- F. BOTTOM ACTION BAR (ADD TO CART & BUY NOW BUTTONS) -->
            <div class="w-full flex flex-wrap items-center justify-between gap-6 pt-6 border-t border-white/10">
                
                <!-- Quick Specs Tag -->
                <div class="hidden sm:flex items-center gap-3 text-xs font-mono text-gray-400">
                    <span class="text-red-500 font-bold">100% AUTHENTIC</span>
                    <span>•</span>
                    <span>OUTDOOR PF RUBBER</span>
                    <span>•</span>
                    <span>ZOOM AIR CUSHIONING</span>
                </div>

                <!-- Center Main Action Buttons -->
                <div class="flex items-center gap-4 mx-auto lg:mx-0">
                    <!-- ADD TO CART BUTTON -->
                    <button type="button" 
                            id="hero-add-to-cart-btn" 
                            class="px-10 py-4 rounded-sm bg-white hover:bg-gray-200 text-black font-sans font-black text-xs uppercase tracking-widest shadow-2xl hover:scale-105 active:scale-95 transition-all duration-200 cursor-pointer flex items-center gap-2.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span>{{ $isAr ? 'أضف للسلة' : 'ADD TO CART' }}</span>
                    </button>

                    <!-- BUY NOW BUTTON -->
                    <button type="button" 
                            id="hero-buy-now-btn" 
                            class="px-10 py-4 rounded-sm border-2 border-white hover:bg-white/10 text-white font-sans font-black text-xs uppercase tracking-widest hover:scale-105 active:scale-95 transition-all duration-200 cursor-pointer">
                        <span>{{ $isAr ? 'شراء فوري' : 'BUY NOW' }}</span>
                    </button>
                </div>

                <!-- Right Side 5 Vertical Pagination Dots -->
                <div class="hidden lg:flex items-center gap-2">
                    <button type="button" data-pagination-dot="0" class="w-2 h-2 rounded-full bg-white/40 hover:bg-white transition-all cursor-pointer" title="01"></button>
                    <button type="button" data-pagination-dot="1" class="w-2 h-2 rounded-full bg-white/40 hover:bg-white transition-all cursor-pointer" title="02"></button>
                    <button type="button" data-pagination-dot="2" class="w-2 h-2 rounded-full bg-white/40 hover:bg-white transition-all cursor-pointer" title="03"></button>
                    <button type="button" data-pagination-dot="3" class="w-2 h-2 rounded-full bg-white/40 hover:bg-white transition-all cursor-pointer" title="04"></button>
                    <button type="button" data-pagination-dot="4" class="w-2.5 h-2.5 rounded-full bg-white shadow-lg cursor-pointer scale-125" title="05"></button>
                </div>

            </div>

        </div>

    </section>

    <!-- ============================================== -->
    <!-- 2. QUICK EU SIZE SELECTOR STRIP                -->
    <!-- ============================================== -->
    <div class="w-full bg-[#07070b] border-y border-white/10 py-4 px-4 sm:px-8 lg:px-14">
        <div class="max-w-[1920px] mx-auto flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="w-2.5 h-2.5 rounded-full bg-red-600 animate-pulse"></span>
                <span class="text-xs font-mono font-bold text-gray-300 uppercase tracking-wider">
                    {{ $isAr ? 'اختر المقاس القياسي (EU):' : 'SELECT SIZE (EU):' }}
                </span>
            </div>

            <div class="flex items-center gap-2">
                @foreach(['40', '41', '42', '43', '44', '45'] as $size)
                    <button type="button" 
                            data-jordan-size="{{ $size }}" 
                            class="w-11 h-11 rounded-xl text-xs font-bold border transition flex items-center justify-center {{ $size === '42' ? 'bg-red-600 text-white border-red-500 font-black shadow-lg shadow-red-600/30' : 'bg-white/5 text-gray-300 border-white/10 hover:border-white/30' }}">
                        {{ $size }}
                    </button>
                @endforeach
            </div>

            <div class="text-xs font-mono text-gray-400 hidden sm:block">
                <span>{{ $isAr ? 'شحن فوري خلال 24 ساعة لجميع المحافظات' : 'EXPRESS 24H DELIVERY NATIONWIDE' }}</span>
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 3. LIVE ATHLETIC MARQUEE TICKER                -->
    <!-- ============================================== -->
    <div class="relative py-3.5 bg-gradient-to-r from-red-950 via-black to-zinc-950 border-b border-white/10 overflow-hidden font-mono text-xs uppercase tracking-widest font-black text-red-400">
        <div class="flex whitespace-nowrap animate-marquee gap-8">
            <span>🔥 JORDAN JUMPMAN 2021 PF // SPECIAL RELEASE</span>
            <span>•</span>
            <span>FOREFOOT ZOOM AIR CUSHIONING</span>
            <span>•</span>
            <span>ARC-SHAPED FLIGHTWIRE SYSTEM</span>
            <span>•</span>
            <span>100% AUTHENTIC SNEAKERS GUARANTEE</span>
            <span>•</span>
            <span>FREE EXPRESS SHIPPING OVER 2,000 EGP</span>
            <span>•</span>
            <span>PROMO CODE: JORDAN20 FOR 20% OFF</span>
            <span>•</span>
            <span>🔥 JORDAN JUMPMAN 2021 PF // SPECIAL RELEASE</span>
            <span>•</span>
            <span>FOREFOOT ZOOM AIR CUSHIONING</span>
            <span>•</span>
            <span>ARC-SHAPED FLIGHTWIRE SYSTEM</span>
            <span>•</span>
            <span>100% AUTHENTIC SNEAKERS GUARANTEE</span>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 4. THE VAULT 2026: SNEAKER DROPS CATALOG       -->
    <!-- ============================================== -->
    <section class="py-20 bg-[#07070c]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-600/10 border border-red-600/20 text-xs font-mono font-bold text-red-400 mb-2">
                        <span>JORDAN BRAND 2026 // THE VAULT</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white">
                        {{ $isAr ? 'أحدث إصدارات السنيكرز الرسمية' : 'Official Sneaker Drops' }}
                    </h2>
                    <p class="text-sm text-gray-400 mt-1">
                        {{ $isAr ? 'تشكيلة أصلية 100% معتمدة مع شحن سريع وتغليف مزدوج ومعاينة عند الاستلام' : '100% authentic curated drops with nationwide express delivery and try-on guarantee.' }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('shop') }}" class="px-5 py-2.5 rounded-xl bg-white/5 hover:bg-red-600 border border-white/10 hover:border-red-500 text-white text-xs font-mono font-bold transition flex items-center gap-2 shadow-lg">
                        <span>{{ $isAr ? 'عرض تشكيلة الأحذية بالكامل' : 'View All Sneakers' }}</span>
                        <span class="rtl:rotate-180">→</span>
                    </a>
                </div>
            </div>

            <!-- Products Grid (4:3 Pedestal Display, Zero Edge Clipping) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featured as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- 5. AIR LAB 360° // SNEAKER ANATOMY BLUEPRINT   -->
    <!-- ============================================== -->
    <section class="py-20 bg-[#050509] border-y border-white/5 relative overflow-hidden">
        
        <!-- Ambient Red Glow in Background -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[500px] bg-red-600/10 rounded-full blur-[160px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-mono font-bold text-red-500 uppercase tracking-widest block">
                    {{ $isAr ? 'مختبر الهندسة التشريحية // FLIGHT LAB' : 'ENGINEERED FLIGHT BLUEPRINT' }}
                </span>
                <h2 class="text-3xl sm:text-5xl font-black text-white mt-2">
                    {{ $isAr ? 'تشريح تقنيات التحليق والأداء' : 'Anatomy of Flight Technology' }}
                </h2>
                <p class="text-sm text-gray-400 mt-2">
                    {{ $isAr 
                        ? 'نظام هندسي متكامل يجمع بين وسائد Zoom Air المتفجرة وأسلاك Flightwire المقوسة لتأمين تحكم وثبات مطلق على أرضية الملاعب.'
                        : 'Precision-engineered architecture combining explosive Zoom Air units with curved Flightwire lockdown.' }}
                </p>
            </div>

            <!-- Interactive Blueprint Stage -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left: 4 Hotspot Blueprint Callouts -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <div class="p-6 rounded-2xl bg-white/5 border border-white/10 hover:border-red-500/50 transition-all duration-300 group">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-8 h-8 rounded-xl bg-red-600/20 text-red-500 border border-red-500/30 flex items-center justify-center font-mono font-black text-xs">01</span>
                            <h3 class="font-black text-white text-base">{{ $isAr ? 'وسائد Zoom Air سريعة الارتداد' : 'Forefoot Zoom Air Unit' }}</h3>
                        </div>
                        <p class="text-xs text-gray-400 leading-relaxed">
                            {{ $isAr ? 'وحدة وسائد هوائية مدمجة أسفل مقدمة القدم تمتص الصدمات وتعيد الطاقة الفورية مع كل وثبة.' : 'Responsive air bag positioned under the ball of the foot for instant explosive propulsion.' }}
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white/5 border border-white/10 hover:border-red-500/50 transition-all duration-300 group">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-8 h-8 rounded-xl bg-red-600/20 text-red-500 border border-red-500/30 flex items-center justify-center font-mono font-black text-xs">02</span>
                            <h3 class="font-black text-white text-base">{{ $isAr ? 'كابلات Flightwire المقوسة' : 'Arc-Shaped Flightwire' }}</h3>
                        </div>
                        <p class="text-xs text-gray-400 leading-relaxed">
                            {{ $isAr ? 'خيوط دعم فائقة المتانة تلتف على جوانب الحذاء وتتصل بالأربطة لتثبيت القدم ومنع الانزلاق العرضي.' : 'High-tensile cables integrated with lacing system to lock down the foot during sharp directional cuts.' }}
                        </p>
                    </div>

                </div>

                <!-- Center: High-Tech Sneaker Visual Showcase -->
                <div class="lg:col-span-4 relative flex flex-col items-center justify-center text-center">
                    <div class="relative w-full max-w-[420px] aspect-square flex items-center justify-center p-4">
                        <!-- Hologram Glowing Base Ring -->
                        <div class="absolute w-64 h-64 rounded-full border border-red-500/20 animate-spin" style="animation-duration: 20s"></div>
                        <div class="absolute w-80 h-80 rounded-full border border-dashed border-red-500/15 animate-spin" style="animation-duration: 35s"></div>
                        <div class="absolute bottom-6 w-3/4 h-8 bg-red-600/25 rounded-full blur-2xl"></div>

                        <!-- Sneaker -->
                        <img src="{{ asset('images/store/jumpman_angled_red.png') }}" alt="Sneaker Blueprint" class="w-full object-contain filter drop-shadow-[0_20px_30px_rgba(0,0,0,0.9)] transform hover:scale-105 transition-transform duration-500" />
                    </div>

                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-xs font-mono text-gray-300 mt-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>JORDAN JUMPMAN 2021 PF // FLIGHT CHASSIS</span>
                    </div>
                </div>

                <!-- Right: Blueprint Callouts 03 & 04 + Performance Metrics -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <div class="p-6 rounded-2xl bg-white/5 border border-white/10 hover:border-red-500/50 transition-all duration-300 group">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-8 h-8 rounded-xl bg-red-600/20 text-red-500 border border-red-500/30 flex items-center justify-center font-mono font-black text-xs">03</span>
                            <h3 class="font-black text-white text-base">{{ $isAr ? 'لوح دعم TPU المنحوت' : 'Molded TPU Flight Shank' }}</h3>
                        </div>
                        <p class="text-xs text-gray-400 leading-relaxed">
                            {{ $isAr ? 'جسر تثبيت مفرغ أسفل وسط القدم يقلل من وزن الحذاء ويمنح صلابة ديناميكية ممتازة عند الانطلاق.' : 'Cored-out flight plate reduces overall shoe weight while maintaining structural torsional stability.' }}
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white/5 border border-white/10 hover:border-red-500/50 transition-all duration-300 group">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-8 h-8 rounded-xl bg-red-600/20 text-red-500 border border-red-500/30 flex items-center justify-center font-mono font-black text-xs">04</span>
                            <h3 class="font-black text-white text-base">{{ $isAr ? 'نعل PF المطاطي المخصص للملاعب الصلبة' : 'Extra-Durable PF Outsole' }}</h3>
                        </div>
                        <p class="text-xs text-gray-400 leading-relaxed">
                            {{ $isAr ? 'مطاط عالي الكثافة مع نقوش متعرجة متعددة الاتجاهات مصمم خصيصاً للاستخدام الشاق على الملاعب الخارجية والأسفلت.' : 'Heavy-duty rubber outsole engineered specifically for high abrasion resistance on outdoor courts.' }}
                        </p>
                    </div>

                </div>

            </div>

            <!-- Bottom 3 Telemetry Metrics Strip -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-14 pt-10 border-t border-white/10 text-center">
                <div class="p-6 rounded-2xl bg-black/40 border border-white/5">
                    <span class="text-4xl font-mono font-black text-red-500">+38%</span>
                    <h4 class="text-white font-bold text-sm mt-1">{{ $isAr ? 'طاقة دفع ارتدادية' : 'Energy Return' }}</h4>
                    <p class="text-xs text-gray-400 mt-1">{{ $isAr ? 'استجابة فورية لوحدة Zoom Air' : 'Responsive forefoot bounce' }}</p>
                </div>

                <div class="p-6 rounded-2xl bg-black/40 border border-white/5">
                    <span class="text-4xl font-mono font-black text-white">340g</span>
                    <h4 class="text-white font-bold text-sm mt-1">{{ $isAr ? 'وزن فائق الخفة' : 'Featherlight Chassis' }}</h4>
                    <p class="text-xs text-gray-400 mt-1">{{ $isAr ? 'هيكل مفرغ لتسريع الانطلاقات' : 'Cored midsole architecture' }}</p>
                </div>

                <div class="p-6 rounded-2xl bg-black/40 border border-white/5">
                    <span class="text-4xl font-mono font-black text-emerald-400">100%</span>
                    <h4 class="text-white font-bold text-sm mt-1">{{ $isAr ? 'ثبات ومطاط PF معتمد' : 'PF Court Durability' }}</h4>
                    <p class="text-xs text-gray-400 mt-1">{{ $isAr ? 'مقاومة تامة للتآكل بالملاعب الخارجية' : 'Engineered for outdoor courts' }}</p>
                </div>
            </div>

        </div>
    </section>

    <!-- ============================================== -->
    <!-- 6. HERITAGE SNEAKER STORY CINEMATIC SHOWCASE   -->
    <!-- ============================================== -->
    <section class="py-16 sm:py-24 bg-[#030305]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-[36px] overflow-hidden border border-white/10 shadow-2xl min-h-[520px] lg:min-h-[580px] flex items-center bg-[#050508] group">
                
                <!-- Background Authentic Jordan Sneaker Campaign Visual -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                    <img src="{{ asset('images/store/lookbook_banner.jpg') }}" 
                         alt="Air Jordan 1 High Chicago" 
                         class="w-full h-full object-cover {{ $isAr ? '-scale-x-100 object-left sm:object-center' : 'object-right sm:object-center' }} transform group-hover:scale-105 transition-transform duration-1000" />
                    
                    <!-- Directional High-Contrast Cinematic Gradient (fades over text area without blocking the sneaker) -->
                    <div class="absolute inset-0 {{ $isAr ? 'bg-gradient-to-l from-[#040406]/98 via-[#040406]/85 sm:via-[#040406]/55 to-transparent' : 'bg-gradient-to-r from-[#040406]/98 via-[#040406]/85 sm:via-[#040406]/55 to-transparent' }}"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#040406]/80 via-transparent to-transparent"></div>
                </div>

                <!-- Text Content - Clean, Unboxed & Seamlessly Blended -->
                <div class="relative z-10 w-full max-w-2xl p-6 sm:p-12 lg:p-16 text-start ms-0 me-auto">
                    <div class="space-y-6">
                        
                        <!-- Eyebrow Badge -->
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-600/20 border border-red-500/40 text-xs font-mono font-bold text-red-400 shadow-lg shadow-red-600/10 backdrop-blur-md">
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                            <span>SINCE 1985 // AIR JORDAN HERITAGE</span>
                        </div>

                        <!-- Main Title with Gradient Glow -->
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight drop-shadow-md">
                            @if($isAr)
                                صُممت للتحليق، <br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-rose-500 to-amber-500">صُنعت لتغيير قواعد اللعبة</span>
                            @else
                                Engineered For Flight, <br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-rose-500 to-amber-500">Built to Change The Game</span>
                            @endif
                        </h2>

                        <!-- Authentic Description -->
                        <p class="text-sm sm:text-base text-gray-300 leading-relaxed font-normal max-w-lg drop-shadow">
                            {{ $isAr 
                                ? 'منذ وثبة مايكل جوردان الأسطورية في 1985، شكّلت أحذية Air Jordan ثورة في ملاعب كرة السلة وثقافة السنيكرز العالمية. نواصل هذا الإرث بأندر الإصدارات الأصلية المفحوصة بدقة مع شحن فوري وضمان معاينة.'
                                : 'Since Michael Jordan took flight in 1985, Air Jordan sneakers have rewritten basketball and global street culture. Every pair verified 100% authentic with factory certification.' }}
                        </p>

                        <!-- Heritage Feature Pills -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2 max-w-lg">
                            <div class="p-3 rounded-2xl bg-black/40 backdrop-blur-md border border-white/10 flex items-center gap-2.5">
                                <span class="text-red-500 text-base">✓</span>
                                <span class="text-xs font-bold text-gray-200">{{ $isAr ? 'جلد طبيعي 100%' : '100% Genuine' }}</span>
                            </div>
                            <div class="p-3 rounded-2xl bg-black/40 backdrop-blur-md border border-white/10 flex items-center gap-2.5">
                                <span class="text-red-500 text-base">⚡</span>
                                <span class="text-xs font-bold text-gray-200">{{ $isAr ? 'وسادة Nike Air' : 'Nike Air Sole' }}</span>
                            </div>
                            <div class="p-3 rounded-2xl bg-black/40 backdrop-blur-md border border-white/10 flex items-center gap-2.5 col-span-2 sm:col-span-1">
                                <span class="text-red-500 text-base">🛡️</span>
                                <span class="text-xs font-bold text-gray-200">{{ $isAr ? 'بوكس أصلي كامل' : 'Original Box' }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons & Voucher -->
                        <div class="pt-2 flex flex-wrap items-center gap-4">
                            <a href="{{ route('shop') }}" class="px-8 py-3.5 rounded-2xl bg-red-600 hover:bg-red-500 text-white font-mono font-black text-xs uppercase tracking-wider shadow-xl shadow-red-600/40 transition-all duration-300 hover:scale-105 flex items-center gap-2">
                                <span>{{ $isAr ? 'استكشف التشكيلة الآن' : 'EXPLORE COLLECTION' }}</span>
                                <span class="rtl:rotate-180">→</span>
                            </a>
                            
                            <button type="button" 
                                    onclick="navigator.clipboard.writeText('JORDAN20'); const el = this.querySelector('.voucher-text'); el.textContent='{{ $isAr ? '✓ تم النسخ!' : '✓ COPIED!' }}'; setTimeout(() => el.textContent='JORDAN20', 2500)" 
                                    class="px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/15 border border-white/20 hover:border-red-500/50 text-xs font-mono font-bold text-gray-200 transition-all duration-300 flex items-center gap-2.5 cursor-pointer shadow-md backdrop-blur-md"
                                    title="{{ $isAr ? 'اضغط لنسخ كود الخصم' : 'Click to copy promo code' }}">
                                <span class="text-red-400">✂</span>
                                <span>{{ $isAr ? 'كود الخصم:' : 'Code:' }} <strong class="text-red-400 voucher-text">JORDAN20</strong></span>
                                <span class="text-[10px] text-gray-400 hidden sm:inline">(-20%)</span>
                            </button>
                        </div>

                    </div>
                </div>

                <!-- Floating Interactive Sneaker HUD Badge (Desktop) -->
                <div class="hidden lg:flex absolute {{ $isAr ? 'start-10' : 'end-10' }} bottom-8 z-20 pointer-events-none">
                    <div class="px-4 py-2 rounded-2xl bg-black/70 backdrop-blur-md border border-white/15 text-[11px] font-mono text-gray-300 flex items-center gap-3 shadow-2xl">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                        <span class="text-white font-bold">AIR JORDAN 1 RETRO HIGH OG</span>
                        <span class="text-gray-500">|</span>
                        <span class="text-red-400 font-bold">CHICAGO 1985</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- 7. VALUE PROPOSITIONS & GUARANTEES             -->
    <!-- ============================================== -->
    <section class="py-16 border-t border-white/5 bg-[#050508]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="p-6 rounded-2xl bg-white/5 border border-white/5 space-y-3 hover:border-red-500/30 transition">
                    <div class="w-12 h-12 rounded-xl bg-red-600/10 border border-red-500/20 flex items-center justify-center text-red-500 text-xl font-black">
                        ✓
                    </div>
                    <h4 class="font-bold text-white text-base">{{ $isAr ? 'أصلي 100% ومضمون' : '100% Authentic Verified' }}</h4>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ $isAr ? 'جميع القطع مفحوصة بدقة ومعتمدة من خبراء الأحذية مع البوكس الأصلي والباركود.' : 'Every pair verified authentic by expert sneaker authenticators with original packaging.' }}</p>
                </div>

                <div class="p-6 rounded-2xl bg-white/5 border border-white/5 space-y-3 hover:border-red-500/30 transition">
                    <div class="w-12 h-12 rounded-xl bg-red-600/10 border border-red-500/20 flex items-center justify-center text-red-500 text-xl font-black">
                        ⚡
                    </div>
                    <h4 class="font-bold text-white text-base">{{ $isAr ? 'شحن سريع لجميع المحافظات' : 'Express Double-Box Delivery' }}</h4>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ $isAr ? 'توصيل خلال 24 إلى 48 ساعة مع تغليف مزدوج لحماية البوكس الأصلي للحذاء.' : 'Delivered within 24-48 hours with protective double-box packaging.' }}</p>
                </div>

                <div class="p-6 rounded-2xl bg-white/5 border border-white/5 space-y-3 hover:border-red-500/30 transition">
                    <div class="w-12 h-12 rounded-xl bg-red-600/10 border border-red-500/20 flex items-center justify-center text-red-500 text-xl font-black">
                        🛡️
                    </div>
                    <h4 class="font-bold text-white text-base">{{ $isAr ? 'معاينة عند الاستلام واسترجاع' : 'Try-On & 14-Day Returns' }}</h4>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ $isAr ? 'حق المعاينة والتأكد من المقاس قبل الدفع واستبدال سهل خلال 14 يوماً.' : 'Inspect size and fit upon delivery with hassle-free 14-day exchange guarantee.' }}</p>
                </div>

                <div class="p-6 rounded-2xl bg-white/5 border border-white/5 space-y-3 hover:border-red-500/30 transition">
                    <div class="w-12 h-12 rounded-xl bg-red-600/10 border border-red-500/20 flex items-center justify-center text-red-500 text-xl font-black">
                        💳
                    </div>
                    <h4 class="font-bold text-white text-base">{{ $isAr ? 'طرق دفع متعددة وآمنة' : 'Flexible Secure Payment' }}</h4>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ $isAr ? 'دفع عند الاستلام، بطاقات بنكية، إنستاباي، والتقسيط عبر فاليو.' : 'Cash on delivery, cards, InstaPay, or installment plans available.' }}</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- 8. CINEMATIC LAUNCH FILM THEATER MODAL         -->
    <!-- ============================================== -->
    <div id="cinema-film-modal" class="fixed inset-0 z-50 bg-black/95 backdrop-blur-xl flex items-center justify-center p-4 sm:p-8 hidden transition-opacity duration-300">
        <div class="relative w-full max-w-5xl rounded-3xl overflow-hidden bg-black border border-white/20 shadow-2xl">
            <!-- Modal Header HUD -->
            <div class="p-4 sm:px-6 bg-zinc-950/90 border-b border-white/10 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-red-600 animate-ping"></span>
                    <span class="text-xs font-mono font-bold tracking-widest text-white uppercase">JORDAN BRAND // 4K CINEMATIC LAUNCH REEL</span>
                </div>
                <button type="button" id="btn-close-film-modal" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer text-sm">
                    ✕
                </button>
            </div>

            <!-- Video Player -->
            <div class="relative aspect-video w-full bg-black">
                <video id="cinema-modal-video" controls class="w-full h-full object-contain">
                    <source src="{{ asset('videos/hero_runway.mp4') }}" type="video/mp4">
                </video>
            </div>

            <!-- Modal Footer -->
            <div class="p-4 sm:px-6 bg-zinc-950/90 border-t border-white/10 flex flex-wrap items-center justify-between gap-4 text-xs font-mono">
                <span class="text-gray-400">{{ $isAr ? 'جلسة تصوير سينمائية رسمية لعالم سنيكرز جوردان 2026' : 'Official Jordan Flight 2026 cinematic showcase' }}</span>
                <a href="{{ route('shop') }}" class="px-5 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold transition">
                    {{ $isAr ? 'تسوق الأحذية الآن' : 'SHOP SNEAKERS' }} →
                </a>
            </div>
        </div>
    </div>

@endsection
