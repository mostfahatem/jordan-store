<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'لوحة التحكم | JORDAN ADMIN')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#06060a] text-gray-100 min-h-screen flex antialiased selection:bg-red-600 selection:text-white font-sans">

    @php
        $isAr = app()->getLocale() === 'ar';
        $pendingCount = \App\Models\Order::where('status', 'pending')->count();
    @endphp

    <!-- Mobile Sidebar Backdrop -->
    <div id="admin-mobile-backdrop" class="fixed inset-0 z-40 bg-black/80 backdrop-blur-sm hidden lg:hidden"></div>

    <!-- ============================================== -->
    <!-- 1. SIDEBAR (RTL/LTR Friendly)                  -->
    <!-- ============================================== -->
    <aside id="admin-sidebar" class="fixed inset-y-0 start-0 z-50 w-72 bg-[#0b0b12] border-e border-white/10 flex flex-col justify-between transform -translate-x-full lg:translate-x-0 rtl:translate-x-full rtl:lg:translate-x-0 transition-transform duration-300">
        
        <!-- Sidebar Top -->
        <div class="p-6 space-y-6">
            <!-- Brand Logo -->
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center p-2 shadow-lg">
                        <img src="{{ asset('images/store/logo_jumpman.png') }}" alt="Jordan Jumpman" class="w-full h-full object-contain brightness-125" />
                    </div>
                    <div>
                        <span class="text-sm font-black text-white tracking-wider block">JORDAN <span class="text-red-500">ADMIN</span></span>
                        <span class="text-[10px] font-mono text-gray-400 block tracking-widest">COMMAND OS 2026</span>
                    </div>
                </a>

                <button type="button" id="admin-mobile-close" class="p-1.5 rounded-lg text-gray-400 hover:text-white hover:bg-white/10 lg:hidden">
                    ✕
                </button>
            </div>

            <!-- Quick Store Telemetry Badge -->
            <div class="p-3 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="font-mono text-gray-300 text-[11px]">{{ $isAr ? 'المتجر متصل بالإنترنت' : 'Storefront Live' }}</span>
                </div>
                <a href="{{ route('home') }}" target="_blank" class="text-[11px] font-mono text-red-400 hover:text-red-300 flex items-center gap-1 font-bold">
                    <span>{{ $isAr ? 'معاينة' : 'Visit' }}</span>
                    <span class="rtl:rotate-180">↗</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1.5 pt-2 font-medium text-xs">
                
                <!-- Overview -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white font-bold shadow-lg shadow-red-600/25' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span>{{ $isAr ? 'لوحة المبيعات الرئيسية' : 'Dashboard Overview' }}</span>
                </a>

                <!-- Orders -->
                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center justify-between px-3.5 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-red-600 text-white font-bold shadow-lg shadow-red-600/25' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span>{{ $isAr ? 'إدارة الطلبات والشحن' : 'Orders & Dispatch' }}</span>
                    </div>
                    @if($pendingCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-400 text-black shadow-md">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>

                <!-- Products -->
                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.products.*') ? 'bg-red-600 text-white font-bold shadow-lg shadow-red-600/25' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <span>{{ $isAr ? 'الأحذية والكتالوج' : 'Sneaker Catalog' }}</span>
                </a>

                <!-- Categories -->
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-red-600 text-white font-bold shadow-lg shadow-red-600/25' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span>{{ $isAr ? 'تصنيفات السنيكرز' : 'Categories' }}</span>
                </a>

                <!-- Customers -->
                <a href="{{ route('admin.customers.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.customers.*') ? 'bg-red-600 text-white font-bold shadow-lg shadow-red-600/25' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>{{ $isAr ? 'سجل العملاء والمشتريات' : 'Customer History' }}</span>
                </a>

            </nav>
        </div>

        <!-- Sidebar Bottom: Admin Profile & Logout -->
        <div class="p-6 border-t border-white/10 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-red-600/20 border border-red-500/30 flex items-center justify-center font-mono font-bold text-red-400 text-xs">
                    JA
                </div>
                <div class="min-w-0 flex-1">
                    <span class="text-xs font-bold text-white block truncate">{{ auth()->user()->name ?? 'Jordan Admin' }}</span>
                    <span class="text-[10px] text-gray-500 font-mono block truncate">{{ auth()->user()->email ?? 'admin@jordan.com' }}</span>
                </div>
            </div>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2.5 px-3.5 rounded-xl bg-white/5 hover:bg-rose-600/20 text-gray-400 hover:text-rose-400 border border-white/5 hover:border-rose-500/30 text-xs font-mono font-bold transition flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>{{ $isAr ? 'تسجيل الخروج' : 'Log Out' }}</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- ============================================== -->
    <!-- 2. MAIN CONTENT WRAPPER                        -->
    <!-- ============================================== -->
    <div class="flex-1 flex flex-col min-w-0 lg:ps-72 transition-all">
        
        <!-- Top HUD Navigation Bar -->
        <header class="sticky top-0 z-30 h-16 bg-[#09090f]/90 backdrop-blur-md border-b border-white/10 px-4 sm:px-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button type="button" id="admin-mobile-open" class="p-2 rounded-xl text-gray-300 hover:text-white hover:bg-white/10 lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="font-mono text-xs text-gray-400 hidden sm:block">
                    <span>● SYSTEM CLOCK: </span>
                    <span class="text-white font-bold">{{ now()->format('Y-m-d H:i') }} (UTC+3)</span>
                </div>
            </div>

            <!-- Top Right Utilities -->
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-xs font-mono font-bold text-gray-300 hover:text-white transition flex items-center gap-1.5 shadow-sm">
                    <span>🏪</span>
                    <span class="hidden sm:inline">{{ $isAr ? 'المتجر الرئيسي' : 'Storefront' }}</span>
                    <span class="rtl:rotate-180 text-[10px]">↗</span>
                </a>

                <a href="{{ route('admin.products.create') }}" class="px-3.5 py-1.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono font-bold text-xs flex items-center gap-1.5 shadow-md shadow-red-600/25 transition">
                    <span>+</span>
                    <span>{{ $isAr ? 'إضافة سنيكرز' : 'New Sneaker' }}</span>
                </a>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 p-4 sm:p-8 space-y-6">
            
            <!-- Global Flash Messages -->
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 text-xs font-bold flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-2">
                        <span>✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-rose-500/15 border border-rose-500/30 text-rose-400 text-xs font-bold flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-2">
                        <span>⚠️</span>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-400 hover:text-white">✕</button>
                </div>
            @endif

            @yield('admin_content')

        </main>

        <!-- Admin Footer -->
        <footer class="p-6 border-t border-white/5 text-center text-xs font-mono text-gray-500">
            <span>JORDAN FLIGHT OS // ADVANCED E-COMMERCE ENGINE © {{ date('Y') }}</span>
        </footer>

    </div>

    <!-- Mobile Sidebar Script -->
    <script>
        const sidebar = document.getElementById('admin-sidebar');
        const openBtn = document.getElementById('admin-mobile-open');
        const closeBtn = document.getElementById('admin-mobile-close');
        const backdrop = document.getElementById('admin-mobile-backdrop');
        const isRtl = document.documentElement.dir === 'rtl';

        const openSidebar = () => {
            sidebar.classList.remove('-translate-x-full', 'rtl:translate-x-full');
            backdrop.classList.remove('hidden');
        };

        const closeSidebar = () => {
            sidebar.classList.add(isRtl ? 'rtl:translate-x-full' : '-translate-x-full');
            backdrop.classList.add('hidden');
        };

        if (openBtn) openBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (backdrop) backdrop.addEventListener('click', closeSidebar);
    </script>

</body>
</html>
