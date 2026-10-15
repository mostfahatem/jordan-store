<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'JORDAN SNEAKER LAB | المتجر الرسمي لسنيكرز جوردان الأصلية')</title>
    <meta name="description" content="@yield('meta_description', 'المتجر الرسمي الأول المتخصص في سنيكرز جوردان الأصلية وأحذية كرة السلة والإصدارات الحصرية مع شحن سريع وتغليف مزدوج فاخر.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#07070b] text-gray-100 min-h-screen flex flex-col antialiased selection:bg-violet-600 selection:text-white">

    <!-- Ambient background glow elements -->
    <div class="fixed top-0 left-1/4 w-[500px] h-[500px] bg-violet-600/10 rounded-full blur-[140px] pointer-events-none -z-10"></div>
    <div class="fixed top-1/3 right-10 w-[450px] h-[450px] bg-cyan-500/10 rounded-full blur-[150px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-10 left-1/3 w-[600px] h-[600px] bg-pink-500/5 rounded-full blur-[160px] pointer-events-none -z-10"></div>

    <!-- Announcement Bar -->
    <div class="bg-gradient-to-r from-red-950/80 via-black to-zinc-950 border-b border-white/10 py-2.5 px-4 text-center text-xs tracking-wide">
        <span class="inline-flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
            @if(app()->getLocale() === 'ar')
                <span>🔥 عروض سنيكرز الموسم الجديد: خصم <b>20%</b> بكوبون <code class="px-1.5 py-0.5 rounded bg-red-600/30 border border-red-500/40 text-red-300 font-mono">JORDAN20</code> + شحن مجاني للطلبات فوق 2000 ج.م</span>
            @else
                <span>🔥 New Season Sneaker Drop: Get <b>20% OFF</b> with code <code class="px-1.5 py-0.5 rounded bg-red-600/30 border border-red-500/40 text-red-300 font-mono">JORDAN20</code> + Free Shipping over 2,000 EGP</span>
            @endif
        </span>
    </div>

    <!-- Glassmorphism Navbar -->
    <header class="sticky top-0 z-40 bg-[#060608]/90 backdrop-blur-xl border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Jordan & Nike Brand Logos -->
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/store/logo_jumpman.png') }}" alt="Jordan Jumpman" class="h-8 w-auto object-contain brightness-125 group-hover:scale-105 transition-transform" />
                    <span class="h-5 w-px bg-white/20"></span>
                    <img src="{{ asset('images/store/logo_swoosh.png') }}" alt="Nike Swoosh" class="h-4 w-auto object-contain brightness-125 group-hover:scale-105 transition-transform" />
                </div>
                <div class="hidden sm:block">
                    <span class="text-xs font-mono font-black tracking-widest text-white uppercase block leading-none">JORDAN SNEAKER LAB</span>
                    <span class="text-[9px] font-mono tracking-wider text-red-500 uppercase font-bold">2026 OFFICIAL STORE</span>
                </div>
            </a>

            <!-- Desktop Nav Links (Sneaker Categories) -->
            <nav class="hidden md:flex items-center gap-5 lg:gap-7 font-sans font-black text-xs uppercase tracking-widest">
                <a href="{{ route('home') }}" class="relative py-2 transition {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400 hover:text-white' }}">
                    <span>{{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'HOME' }}</span>
                    @if(request()->routeIs('home'))
                        <span class="absolute bottom-0 inset-x-0 h-0.5 bg-red-600 rounded-full shadow-lg shadow-red-600"></span>
                    @endif
                </a>
                <a href="{{ route('shop') }}" class="relative py-2 transition {{ request()->routeIs('shop') && !request('category') ? 'text-white' : 'text-gray-400 hover:text-white' }}">
                    <span>{{ app()->getLocale() === 'ar' ? 'كل السنيكرز' : 'ALL SNEAKERS' }}</span>
                </a>
                <a href="{{ route('shop', ['category' => 'retro']) }}" class="relative py-2 transition {{ request('category') === 'retro' ? 'text-red-500 font-black' : 'text-gray-400 hover:text-white' }}">
                    <span>{{ app()->getLocale() === 'ar' ? 'جوردان ريترو' : 'JORDAN RETRO' }}</span>
                </a>
                <a href="{{ route('shop', ['category' => 'basketball']) }}" class="relative py-2 transition {{ request('category') === 'basketball' ? 'text-red-500 font-black' : 'text-gray-400 hover:text-white' }}">
                    <span>{{ app()->getLocale() === 'ar' ? 'أحذية السلة' : 'BASKETBALL' }}</span>
                </a>
                <a href="{{ route('shop', ['category' => 'lifestyle']) }}" class="relative py-2 transition {{ request('category') === 'lifestyle' ? 'text-red-500 font-black' : 'text-gray-400 hover:text-white' }}">
                    <span>{{ app()->getLocale() === 'ar' ? 'ستريت وكاجوال' : 'LIFESTYLE' }}</span>
                </a>
                <a href="{{ route('shop', ['category' => 'exclusive']) }}" class="relative py-2 transition {{ request('category') === 'exclusive' ? 'text-red-500 font-black' : 'text-gray-400 hover:text-white' }}">
                    <span>{{ app()->getLocale() === 'ar' ? 'إصدارات حصرية' : 'EXCLUSIVE' }}</span>
                </a>
                <a href="{{ route('shop') }}" class="relative py-2 text-red-500 hover:text-red-400 transition font-black">
                    <span>{{ app()->getLocale() === 'ar' ? 'تخفيضات السنيكرز' : 'SALE' }}</span>
                </a>
            </nav>

            <!-- Actions (Language switch, Search, Cart, User) -->
            <div class="flex items-center gap-3">
                <!-- Language Toggle Button -->
                <a href="{{ route('locale', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-mono font-bold bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 hover:text-white transition" title="{{ app()->getLocale() === 'ar' ? 'Switch to English' : 'التبديل إلى العربية' }}">
                    <span>{{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}</span>
                </a>

                <!-- Search Button -->
                <a href="{{ route('shop') }}" class="p-2 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition" title="Search Sneakers">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </a>

                <!-- Cart Bag Button -->
                <button type="button" data-cart-open class="relative p-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-white transition group" title="Cart">
                    <svg class="w-5 h-5 text-gray-300 group-hover:text-red-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span data-cart-count class="hidden absolute -top-1.5 -end-1.5 w-5 h-5 rounded-full bg-red-600 text-[11px] font-black text-white flex items-center justify-center shadow-lg shadow-red-600/50">
                        0
                    </span>
                </button>

                <!-- Live Order Tracking -->
                <a href="{{ route('orders.track') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-mono font-bold bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 hover:text-white transition" title="{{ app()->getLocale() === 'ar' ? 'تتبع الشحنة' : 'Track Order' }}">
                    <span>📍</span>
                    <span>{{ app()->getLocale() === 'ar' ? 'تتبع الطلب' : 'Track' }}</span>
                </a>

                <!-- Commercial Sales Pitch Deck -->
                <a href="{{ route('presentation') }}" class="hidden lg:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-mono font-bold bg-amber-500/15 hover:bg-amber-500 border border-amber-500/40 hover:border-amber-400 text-amber-300 hover:text-gray-900 transition shadow-sm" title="{{ app()->getLocale() === 'ar' ? 'العرض التقديمي التجاري للمنصة' : 'Commercial Pitch Deck' }}">
                    <span>📽️</span>
                    <span>{{ app()->getLocale() === 'ar' ? 'العرض التقديمي' : 'Pitch Deck' }}</span>
                </a>

                <!-- Admin Dashboard Shortcut -->
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-mono font-bold bg-red-600/20 hover:bg-red-600 border border-red-500/40 hover:border-red-500 text-red-400 hover:text-white transition shadow-sm" title="{{ app()->getLocale() === 'ar' ? 'لوحة تحكم المتجر' : 'Admin Dashboard' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    <span>{{ app()->getLocale() === 'ar' ? 'لوحة التحكم' : 'Dashboard' }}</span>
                </a>

                <!-- Mobile Menu Button -->
                <button type="button" id="mobile-menu-btn" class="md:hidden p-2 rounded-xl bg-white/5 text-gray-300 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-white/10 bg-[#09090f]/98 backdrop-blur-xl px-4 py-4 space-y-2 font-mono text-xs">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-gray-300 hover:bg-white/5">{{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}</a>
            <a href="{{ route('shop') }}" class="block px-3 py-2 rounded-lg font-bold text-red-400 hover:bg-white/5">{{ app()->getLocale() === 'ar' ? 'كل السنيكرز' : 'All Sneakers' }}</a>
            <a href="{{ route('shop', ['category' => 'retro']) }}" class="block px-3 py-2 rounded-lg text-gray-300 hover:bg-white/5">{{ app()->getLocale() === 'ar' ? 'جوردان ريترو' : 'Jordan Retro' }}</a>
            <a href="{{ route('shop', ['category' => 'basketball']) }}" class="block px-3 py-2 rounded-lg text-gray-300 hover:bg-white/5">{{ app()->getLocale() === 'ar' ? 'أحذية السلة' : 'Basketball' }}</a>
            <a href="{{ route('shop', ['category' => 'lifestyle']) }}" class="block px-3 py-2 rounded-lg text-gray-300 hover:bg-white/5">{{ app()->getLocale() === 'ar' ? 'ستريت وكاجوال' : 'Lifestyle' }}</a>
            <a href="{{ route('shop', ['category' => 'exclusive']) }}" class="block px-3 py-2 rounded-lg text-gray-300 hover:bg-white/5">{{ app()->getLocale() === 'ar' ? 'إصدارات حصرية' : 'Exclusive Drops' }}</a>
            <a href="{{ route('orders.track') }}" class="block px-3 py-2 rounded-lg text-gray-300 hover:bg-white/5">📍 {{ app()->getLocale() === 'ar' ? 'تتبع شحنتك' : 'Track Order' }}</a>
            <a href="{{ route('presentation') }}" class="block px-3 py-2 rounded-lg text-amber-300 font-bold hover:bg-white/5">📽️ {{ app()->getLocale() === 'ar' ? 'العرض التقديمي للبيع (Pitch Deck)' : 'Sales Pitch Deck' }}</a>
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-red-400 font-bold border-t border-white/5 pt-2">🛡️ {{ app()->getLocale() === 'ar' ? 'لوحة تحكم الإدارة (Dashboard)' : 'Admin Dashboard' }}</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Modern Dark Sneaker Footer -->
    <footer class="border-t border-white/10 bg-[#09090f] text-gray-400 mt-20 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-white/5">
                
                <!-- Col 1: Brand & Bio -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <img src="{{ asset('images/store/logo_jumpman.png') }}" alt="Jordan Jumpman" class="h-7 w-auto object-contain brightness-125" />
                        <span class="text-lg font-black text-white tracking-wider">JORDAN <span class="text-red-500">SNEAKER LAB</span></span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-sm">
                        {{ app()->getLocale() === 'ar' 
                            ? 'المنصة الرسمية الأولى المتخصصة في سنيكرز جوردان الأصلية وإصدارات كرة السلة الحصرية مع فحص الجودة وتوصيل سريع وتغليف مزدوج.'
                            : 'The premier destination for authentic Jordan sneakers, court performance footwear and exclusive drops with nationwide express delivery.' }}
                    </p>
                    <div class="flex items-center gap-3 pt-2 text-gray-400">
                        <span class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center hover:text-red-400 hover:bg-white/10 transition cursor-pointer">IG</span>
                        <span class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center hover:text-red-400 hover:bg-white/10 transition cursor-pointer">TK</span>
                        <span class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center hover:text-red-400 hover:bg-white/10 transition cursor-pointer">FB</span>
                        <span class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center hover:text-red-400 hover:bg-white/10 transition cursor-pointer">WA</span>
                    </div>
                </div>

                <!-- Col 2: Sneaker Categories -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">{{ app()->getLocale() === 'ar' ? 'تصنيفات السنيكرز' : 'Sneaker Drops' }}</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('shop') }}" class="hover:text-white transition">{{ app()->getLocale() === 'ar' ? 'كل الأحذية الرياضية' : 'All Footwear' }}</a></li>
                        <li><a href="{{ route('shop', ['category' => 'retro']) }}" class="hover:text-white transition">{{ app()->getLocale() === 'ar' ? 'جوردان ريترو 1 و 4' : 'Air Jordan Retro' }}</a></li>
                        <li><a href="{{ route('shop', ['category' => 'basketball']) }}" class="hover:text-white transition">{{ app()->getLocale() === 'ar' ? 'أحذية ملاعب السلة' : 'Basketball Shoes' }}</a></li>
                        <li><a href="{{ route('shop', ['category' => 'lifestyle']) }}" class="hover:text-white transition">{{ app()->getLocale() === 'ar' ? 'نايكي دانك وكاجوال' : 'Nike Dunk & Casual' }}</a></li>
                        <li><a href="{{ route('shop', ['category' => 'exclusive']) }}" class="hover:text-white transition">{{ app()->getLocale() === 'ar' ? 'إصدارات ترافيس سكوت' : 'Collabs & Drops' }}</a></li>
                    </ul>
                </div>

                <!-- Col 3: Sneakerhead Care & Sizing -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">{{ app()->getLocale() === 'ar' ? 'المقاسات والأصالة' : 'Authentication & Sizing' }}</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" class="hover:text-white transition">{{ app()->getLocale() === 'ar' ? 'جدول مقاسات الأحذية (EU/US)' : 'Shoe Size Chart (EU/US)' }}</a></li>
                        <li><a href="#" class="hover:text-white transition">{{ app()->getLocale() === 'ar' ? 'ضمان الأصالة 100%' : '100% Authentic Guarantee' }}</a></li>
                        <li><a href="#" class="hover:text-white transition">{{ app()->getLocale() === 'ar' ? 'سياسة الاستبدال السريع' : 'Fast 14-Day Exchange' }}</a></li>
                        <li><a href="#" class="hover:text-white transition">{{ app()->getLocale() === 'ar' ? 'شحن فوري 24 ساعة' : 'Express Shipping' }}</a></li>
                    </ul>
                </div>

                <!-- Col 4: Drops Newsletter -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4">{{ app()->getLocale() === 'ar' ? 'إشعارات الإطلاقات' : 'Drop Alerts' }}</h4>
                    <p class="text-xs text-gray-400 mb-3">
                        {{ app()->getLocale() === 'ar' ? 'اشترك لتصلك إشعارات إصدارات السنيكرز الحصرية فور إطلاقها.' : 'Subscribe for instant alerts on limited sneaker drops and restocks.' }}
                    </p>
                    <form class="space-y-2" onsubmit="event.preventDefault(); alert('{{ app()->getLocale() === 'ar' ? 'تم تسجيلك بنجاح في قائمة إشعارات السنيكرز الحصرية!' : 'Successfully subscribed to VIP Sneaker Alerts!' }}');">
                        <input type="email" placeholder="{{ app()->getLocale() === 'ar' ? 'بريدك الإلكتروني...' : 'Your email...' }}" required class="w-full px-3 py-2 rounded-lg bg-white/5 border border-white/10 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-red-500" />
                        <button type="submit" class="w-full py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white text-xs font-semibold transition">
                            {{ app()->getLocale() === 'ar' ? 'تفعيل الإشعارات' : 'Notify Me' }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                <p>© {{ date('Y') }} JORDAN SNEAKER LAB Inc. {{ app()->getLocale() === 'ar' ? 'جميع الحقوق محفوظة.' : 'All rights reserved.' }}</p>
                <div class="flex items-center gap-4">
                    <span>{{ app()->getLocale() === 'ar' ? 'طرق الدفع المدعومة:' : 'Accepted Payments:' }}</span>
                    <span class="px-2 py-1 rounded bg-white/5 border border-white/5 font-mono text-[10px] text-gray-300">VISA / MASTERCARD</span>
                    <span class="px-2 py-1 rounded bg-white/5 border border-white/5 font-mono text-[10px] text-gray-300">InstaPay / فودافون كاش</span>
                    <span class="px-2 py-1 rounded bg-white/5 border border-white/5 font-mono text-[10px] text-gray-300">Cash on Delivery</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- ============================================== -->
    <!-- SLIDING CART DRAWER -->
    <!-- ============================================== -->
    <div id="cart-drawer-backdrop" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 transition-opacity duration-300 opacity-0 pointer-events-none"></div>

    <aside id="cart-drawer" class="fixed top-0 bottom-0 {{ app()->getLocale() === 'ar' ? 'left-0 -translate-x-full' : 'right-0 translate-x-full' }} w-full max-w-md bg-[#0d0d17] border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }} border-white/10 z-50 shadow-2xl flex flex-col transition-transform duration-300 ease-in-out pointer-events-none">
        
        <!-- Drawer Header -->
        <div class="p-5 border-b border-white/10 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h3 class="font-bold text-white text-base">{{ app()->getLocale() === 'ar' ? 'سلة المشتريات' : 'Shopping Cart' }}</h3>
                <span data-cart-count class="px-2 py-0.5 rounded-full bg-violet-500/20 text-violet-300 text-xs font-mono">0</span>
            </div>
            <button type="button" id="cart-drawer-close" class="p-1.5 rounded-lg text-gray-400 hover:text-white hover:bg-white/10 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Free Shipping Progress -->
        <div class="px-5 py-3 bg-white/5 border-b border-white/5">
            <div id="cart-free-shipping-text" class="text-xs text-gray-300 mb-2">
                {{ app()->getLocale() === 'ar' ? 'أضف منتجات بقيمة 2000 ج.م لشحن مجاني' : 'Add products worth 2,000 EGP for free shipping' }}
            </div>
            <div class="w-full h-1.5 rounded-full bg-white/10 overflow-hidden">
                <div id="cart-free-shipping-bar" class="h-full bg-gradient-to-r from-violet-500 to-cyan-400 rounded-full transition-all duration-500" style="width: 0%"></div>
            </div>
        </div>

        <!-- Drawer Body: Items list -->
        <div class="flex-1 overflow-y-auto p-5 space-y-3">
            <div id="cart-drawer-items" class="space-y-3"></div>

            <!-- Empty State -->
            <div id="cart-drawer-empty" class="text-center py-16">
                <div class="w-16 h-16 mx-auto rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-500 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h4 class="text-white font-semibold mb-1">{{ app()->getLocale() === 'ar' ? 'سلتك فارغة حالياً' : 'Your cart is empty' }}</h4>
                <p class="text-xs text-gray-400 mb-6">{{ app()->getLocale() === 'ar' ? 'استكشف أحدث إصدارات السنيكرز الرسمية' : 'Explore our latest authentic sneaker drops' }}</p>
                <a href="{{ route('shop') }}" onclick="document.getElementById('cart-drawer-close').click()" class="inline-block px-5 py-2.5 rounded-xl bg-violet-600 hover:bg-violet-500 text-white text-xs font-semibold transition">
                    {{ app()->getLocale() === 'ar' ? 'تصفح المتجر الآن' : 'Shop Now' }}
                </a>
            </div>
        </div>

        <!-- Drawer Footer: Checkout Actions -->
        <div id="cart-drawer-footer" class="p-5 border-t border-white/10 bg-[#090910] space-y-3">
            <!-- Promo Code Input -->
            <div class="flex gap-2">
                <input type="text" id="promo-code-input" placeholder="{{ app()->getLocale() === 'ar' ? 'كود الخصم (جرب: NOVA20)' : 'Promo Code (Try: NOVA20)' }}" class="flex-1 px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-xs text-white placeholder-gray-500 uppercase focus:outline-none focus:border-cyan-400 font-mono" />
                <button type="button" id="apply-promo-btn" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold transition">
                    {{ app()->getLocale() === 'ar' ? 'تطبيق' : 'Apply' }}
                </button>
            </div>

            <!-- Price Breakdown -->
            <div class="space-y-1.5 text-xs text-gray-300 pt-2 border-t border-white/5">
                <div class="flex justify-between">
                    <span>{{ app()->getLocale() === 'ar' ? 'المجموع الفرعي:' : 'Subtotal:' }}</span>
                    <span id="cart-subtotal" class="font-semibold text-white">0 ج.م</span>
                </div>
                <div class="flex justify-between text-sm font-bold text-white pt-2 border-t border-white/10">
                    <span>{{ app()->getLocale() === 'ar' ? 'الإجمالي:' : 'Total:' }}</span>
                    <span id="cart-total" class="text-cyan-400">0 ج.م</span>
                </div>
            </div>

            <!-- Checkout Button -->
            <button type="button" id="open-checkout-modal-btn" class="w-full py-3.5 rounded-xl glow-btn-primary text-white font-bold text-sm flex items-center justify-center gap-2">
                <span>{{ app()->getLocale() === 'ar' ? 'إتمام الطلب الآن' : 'Proceed to Checkout' }}</span>
                <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </aside>

    <!-- ============================================== -->
    <!-- INTERACTIVE CHECKOUT MODAL -->
    <!-- ============================================== -->
    <div id="checkout-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div id="checkout-modal-backdrop" class="fixed inset-0 bg-black/80 backdrop-blur-md"></div>
        
        <div id="checkout-modal-content" class="relative z-10 w-full max-w-2xl bg-[#0e0e18] border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-violet-600 to-cyan-400 flex items-center justify-center text-white font-bold">
                        ✓
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">{{ app()->getLocale() === 'ar' ? 'إتمام الطلب السريع' : 'Fast Checkout' }}</h3>
                        <p class="text-xs text-gray-400">{{ app()->getLocale() === 'ar' ? 'بياناتك مشفرة ومحمية 100%' : 'Your data is encrypted & secured 100%' }}</p>
                    </div>
                </div>
                <button type="button" id="close-checkout-modal-btn" class="p-2 text-gray-400 hover:text-white rounded-lg hover:bg-white/5 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Order Items Summary in Modal -->
            <div id="checkout-items-summary" class="mb-6"></div>

            <!-- Customer Shipping Form -->
            <form id="checkout-form" class="space-y-4">
                <div id="checkout-error-msg" class="hidden p-3 rounded-xl bg-red-500/10 border border-red-500/30 text-xs text-red-400"></div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-300 mb-1.5">{{ app()->getLocale() === 'ar' ? 'الاسم بالكامل *' : 'Full Name *' }}</label>
                        <input type="text" name="customer_name" required placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: مصطفى حاتم' : 'e.g. John Doe' }}" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-300 mb-1.5">{{ app()->getLocale() === 'ar' ? 'رقم الهاتف (واتساب) *' : 'Phone (WhatsApp) *' }}</label>
                        <input type="tel" name="customer_phone" required placeholder="{{ app()->getLocale() === 'ar' ? '010XXXXXXXX' : '+20 10X XXX XXXX' }}" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-300 mb-1.5">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني (اختياري)' : 'Email (Optional)' }}</label>
                        <input type="email" name="customer_email" placeholder="name@example.com" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-300 mb-1.5">{{ app()->getLocale() === 'ar' ? 'المحافظة *' : 'Governorate *' }}</label>
                        <select name="governorate" required class="w-full px-3.5 py-2.5 rounded-xl bg-[#141422] border border-white/10 text-sm text-white focus:outline-none focus:border-cyan-400">
                            <option value="Cairo">{{ app()->getLocale() === 'ar' ? 'القاهرة' : 'Cairo' }}</option>
                            <option value="Giza">{{ app()->getLocale() === 'ar' ? 'الجيزة' : 'Giza' }}</option>
                            <option value="Alexandria">{{ app()->getLocale() === 'ar' ? 'الإسكندرية' : 'Alexandria' }}</option>
                            <option value="Mansoura">{{ app()->getLocale() === 'ar' ? 'المنصورة / الدقهلية' : 'Mansoura / Daqahlia' }}</option>
                            <option value="Tanta">{{ app()->getLocale() === 'ar' ? 'طنطا / الغربية' : 'Tanta / Gharbia' }}</option>
                            <option value="Sharqia">{{ app()->getLocale() === 'ar' ? 'الشرقية' : 'Sharqia' }}</option>
                            <option value="Other">{{ app()->getLocale() === 'ar' ? 'محافظة أخرى' : 'Other' }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-300 mb-1.5">{{ app()->getLocale() === 'ar' ? 'المدينة / المنطقة *' : 'City / Area *' }}</label>
                        <input type="text" name="city" required placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: المعادي / الشيخ زايد' : 'e.g. Maadi / Zayed' }}" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-300 mb-1.5">{{ app()->getLocale() === 'ar' ? 'العنوان التفصيلي *' : 'Detailed Address *' }}</label>
                    <input type="text" name="shipping_address" required placeholder="{{ app()->getLocale() === 'ar' ? 'الشارع، رقم العمارة، الشقة / علامة مميزة' : 'Street, building, apartment / landmark' }}" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-300 mb-1.5">{{ app()->getLocale() === 'ar' ? 'ملاحظات الشحن (اختياري)' : 'Delivery Notes (Optional)' }}</label>
                    <input type="text" name="notes" placeholder="{{ app()->getLocale() === 'ar' ? 'موعد الاستلام المفضل، رن الجرس...' : 'Preferred delivery time, etc.' }}" class="w-full px-3.5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400" />
                </div>

                <!-- Payment Methods Choice -->
                <div>
                    <label class="block text-xs font-semibold text-gray-300 mb-2">{{ app()->getLocale() === 'ar' ? 'طريقة الدفع' : 'Payment Method' }}</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="flex items-center gap-2.5 p-3 rounded-xl bg-white/5 border border-cyan-400/40 cursor-pointer hover:bg-white/10 transition">
                            <input type="radio" name="payment_method" value="cod" checked class="text-cyan-400 focus:ring-0" />
                            <span class="text-xs font-medium text-white">{{ app()->getLocale() === 'ar' ? 'الدفع عند الاستلام' : 'Cash on Delivery' }}</span>
                        </label>
                        <label class="flex items-center gap-2.5 p-3 rounded-xl bg-white/5 border border-white/10 cursor-pointer hover:bg-white/10 transition">
                            <input type="radio" name="payment_method" value="instapay" class="text-cyan-400 focus:ring-0" />
                            <span class="text-xs font-medium text-white">{{ app()->getLocale() === 'ar' ? 'إنستاباي / محفظة' : 'InstaPay / Wallet' }}</span>
                        </label>
                        <label class="flex items-center gap-2.5 p-3 rounded-xl bg-white/5 border border-white/10 cursor-pointer hover:bg-white/10 transition">
                            <input type="radio" name="payment_method" value="card" class="text-cyan-400 focus:ring-0" />
                            <span class="text-xs font-medium text-white">{{ app()->getLocale() === 'ar' ? 'بطاقة بنكية' : 'Credit / Debit Card' }}</span>
                        </label>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 rounded-2xl glow-btn-cyan text-gray-900 font-extrabold text-sm tracking-wide transition">
                        {{ app()->getLocale() === 'ar' ? 'تأكيد الطلب وشحن الشحنة 🚀' : 'Confirm & Place Order 🚀' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- FLOATING LIVE TEST-DRIVE TRIGGER FOR BUYERS    -->
    <!-- ============================================== -->
    <div class="fixed bottom-6 end-6 z-40">
        <button type="button" id="open-demo-modal-btn" class="px-5 py-3 rounded-full bg-gradient-to-r from-red-600 via-rose-600 to-amber-600 text-white font-mono font-black text-xs uppercase tracking-wider shadow-2xl shadow-red-600/50 hover:scale-105 transition-all flex items-center gap-2.5 border border-white/20 animate-bounce cursor-pointer group">
            <span class="w-2.5 h-2.5 rounded-full bg-white animate-ping"></span>
            <span>🎮 {{ app()->getLocale() === 'ar' ? 'وضع تجربة النظام (Test Drive)' : 'Live Test-Drive' }}</span>
        </button>
    </div>

    <!-- Live Test-Drive Interactive HUD Modal -->
    <div id="demo-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-xl hidden transition-opacity">
        <div class="relative w-full max-w-lg bg-[#0e0e18] border border-white/15 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
            
            <div class="flex items-center justify-between pb-4 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-red-600 to-amber-500 flex items-center justify-center text-white text-lg font-bold shadow-lg shadow-red-600/30">
                        🎮
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white">{{ app()->getLocale() === 'ar' ? 'مركز التجربة الحية (Live Demo Hub)' : 'Live Interactive Demo Hub' }}</h3>
                        <p class="text-xs text-gray-400">{{ app()->getLocale() === 'ar' ? 'اختر التجربة التي تريد استكشافها فوراً بنقرة واحدة:' : 'Pick any scenario to test with one click:' }}</p>
                    </div>
                </div>
                <button type="button" id="close-demo-modal-btn" class="p-2 text-gray-400 hover:text-white rounded-lg hover:bg-white/5 transition cursor-pointer">
                    ✕
                </button>
            </div>

            <!-- 4 Instant Click Actions -->
            <div class="space-y-3">
                
                <!-- Action 1: Instant Admin Login -->
                <a href="{{ route('demo.admin-login') }}" class="p-4 rounded-2xl bg-gradient-to-r from-red-950/40 to-transparent border border-red-500/30 hover:border-red-500 hover:bg-red-950/60 transition flex items-center justify-between group">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">🛡️</span>
                        <div class="text-start">
                            <span class="text-xs font-mono font-bold text-red-400 block uppercase">Scenario 01</span>
                            <span class="text-sm font-bold text-white group-hover:text-red-400 transition">{{ app()->getLocale() === 'ar' ? 'دخول فوري كمسؤول (Admin Dashboard)' : 'Instant One-Click Admin Login' }}</span>
                            <span class="text-[11px] text-gray-400 block">{{ app()->getLocale() === 'ar' ? 'استكشف المبيعات، الطلبات، طباعة الفواتير، والكتالوج' : 'Access revenue telemetry, orders, and thermal invoices' }}</span>
                        </div>
                    </div>
                    <span class="text-white group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition text-sm">→</span>
                </a>

                <!-- Action 2: 1-Click Buy Simulation -->
                <button type="button" id="btn-demo-quick-buy" class="w-full p-4 rounded-2xl bg-gradient-to-r from-cyan-950/40 to-transparent border border-cyan-500/30 hover:border-cyan-400 hover:bg-cyan-950/60 transition flex items-center justify-between group cursor-pointer text-start">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">⚡</span>
                        <div>
                            <span class="text-xs font-mono font-bold text-cyan-400 block uppercase">Scenario 02</span>
                            <span class="text-sm font-bold text-white group-hover:text-cyan-400 transition">{{ app()->getLocale() === 'ar' ? 'محاكاة شراء سريعة (1-Click Buy)' : 'Instant 1-Click Order Simulation' }}</span>
                            <span class="text-[11px] text-gray-400 block">{{ app()->getLocale() === 'ar' ? 'إنشاء أوردر حقيقي تلقائياً والانتقال لشاشة التأكيد' : 'Auto-places a test Jordan sneaker order to see receipt' }}</span>
                        </div>
                    </div>
                    <span class="text-white group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition text-sm">→</span>
                </button>

                <!-- Action 3: Live Radar Tracking -->
                <a href="{{ route('orders.track', ['q' => 'JRD-849102']) }}" class="p-4 rounded-2xl bg-gradient-to-r from-purple-950/40 to-transparent border border-purple-500/30 hover:border-purple-400 hover:bg-purple-950/60 transition flex items-center justify-between group">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">📍</span>
                        <div class="text-start">
                            <span class="text-xs font-mono font-bold text-purple-400 block uppercase">Scenario 03</span>
                            <span class="text-sm font-bold text-white group-hover:text-purple-400 transition">{{ app()->getLocale() === 'ar' ? 'رادار تتبع الشحنة الحي (Live Radar)' : 'Live Flight Tracking Radar' }}</span>
                            <span class="text-[11px] text-gray-400 block">{{ app()->getLocale() === 'ar' ? 'شاهد مراحل التوصيل الأربعة للشحنة JRD-849102' : 'View the real-time 4-step dispatch radar' }}</span>
                        </div>
                    </div>
                    <span class="text-white group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition text-sm">→</span>
                </a>

                <!-- Action 4: Commercial Pitch Deck -->
                <a href="{{ route('presentation') }}" class="p-4 rounded-2xl bg-gradient-to-r from-amber-950/40 to-transparent border border-amber-500/30 hover:border-amber-400 hover:bg-amber-950/60 transition flex items-center justify-between group">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">📽️</span>
                        <div class="text-start">
                            <span class="text-xs font-mono font-bold text-amber-400 block uppercase">Commercial Asset</span>
                            <span class="text-sm font-bold text-white group-hover:text-amber-400 transition">{{ app()->getLocale() === 'ar' ? 'عرض الشرائح التقديمي للبيع (Pitch Deck)' : 'Commercial Sales Pitch Deck' }}</span>
                            <span class="text-[11px] text-gray-400 block">{{ app()->getLocale() === 'ar' ? 'عرض شرائح متكامل بالمواصفات والأسعار والمقارنة' : '8-slide presentation ready for client meetings & PDF' }}</span>
                        </div>
                    </div>
                    <span class="text-white group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition text-sm">→</span>
                </a>

            </div>

        </div>
    </div>

    <!-- Demo Simulation Controller Script -->
    <script>
        const demoBtn = document.getElementById('open-demo-modal-btn');
        const demoModal = document.getElementById('demo-modal');
        const closeDemoBtn = document.getElementById('close-demo-modal-btn');
        const quickBuyBtn = document.getElementById('btn-demo-quick-buy');

        if (demoBtn && demoModal) {
            demoBtn.addEventListener('click', () => demoModal.classList.remove('hidden'));
        }
        if (closeDemoBtn && demoModal) {
            closeDemoBtn.addEventListener('click', () => demoModal.classList.add('hidden'));
        }
        if (demoModal) {
            demoModal.addEventListener('click', (e) => {
                if (e.target === demoModal) demoModal.classList.add('hidden');
            });
        }

        if (quickBuyBtn) {
            quickBuyBtn.addEventListener('click', async () => {
                const originalHtml = quickBuyBtn.innerHTML;
                quickBuyBtn.disabled = true;
                quickBuyBtn.innerHTML = '<span class="text-xs font-mono text-cyan-300 py-3 block text-center w-full animate-pulse">⏳ جاري محاكاة الشراء وتوليد الطلب في قاعدة البيانات...</span>';
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                const samplePayload = {
                    customer_name: 'أحمد المنصوري (تجربة حية)',
                    customer_phone: '010' + Math.floor(10000000 + Math.random() * 90000000),
                    customer_email: 'demo@jordan-lab.com',
                    governorate: 'Cairo',
                    city: 'المعادي الجديدة',
                    shipping_address: 'شارع 250، برج النخيل، الدور 7',
                    payment_method: 'cod',
                    promo_code: 'JORDAN20',
                    notes: 'طلب تجريبي تم تنفيذه تلقائياً من مركز التجربة الحية',
                    items: [
                        {
                            id: 1,
                            name: 'Air Jordan 1 Retro High Chicago',
                            size: '43',
                            price: 4950,
                            quantity: 1,
                            color: { name: 'Chicago', hex: '#dc2626', label: 'شيكاغو ريترو' },
                            image: '/images/store/products/air-jordan-1-retro.jpg'
                        }
                    ]
                };

                try {
                    const res = await fetch('/checkout', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(samplePayload)
                    });
                    const data = await res.json();
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else if (data.order && data.order.order_number) {
                        window.location.href = '/orders/' + data.order.order_number;
                    } else {
                        window.location.href = '/shop';
                    }
                } catch (e) {
                    quickBuyBtn.disabled = false;
                    quickBuyBtn.innerHTML = originalHtml;
                    alert('حدث خطأ أثناء المحاكاة، يرجى المحاولة مرة أخرى.');
                }
            });
        }
    </script>

</body>
</html>
