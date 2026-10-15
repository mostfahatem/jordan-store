<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل دخول المسؤول | JORDAN COMMAND CENTER</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#050508] text-gray-100 min-h-screen flex items-center justify-center p-4 antialiased selection:bg-red-600 selection:text-white relative overflow-hidden font-sans">

    <!-- Ambient Red Flight Glow -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-red-600/15 rounded-full blur-[160px] pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-md">
        
        <!-- Brand Header -->
        <div class="text-center mb-8 space-y-2">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/5 border border-white/10 shadow-2xl p-2.5 mb-2">
                <img src="{{ asset('images/store/logo_jumpman.png') }}" alt="Jordan Jumpman" class="w-full h-full object-contain brightness-125 filter drop-shadow" />
            </div>
            <div class="inline-block px-3 py-1 rounded-full bg-red-600/20 border border-red-500/30 text-[10px] font-mono font-black text-red-400 uppercase tracking-widest">
                JORDAN FLIGHT // ADMIN OS 2026
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                {{ app()->getLocale() === 'ar' ? 'لوحة تحكم المتجر' : 'Admin Command Center' }}
            </h1>
            <p class="text-xs text-gray-400">
                {{ app()->getLocale() === 'ar' ? 'سجّل الدخول لإدارة الطلبات والمنتجات والمبيعات' : 'Sign in to manage orders, catalog & inventory' }}
            </p>
        </div>

        <!-- Login Card -->
        <div class="p-8 rounded-[32px] bg-gradient-to-b from-[#141420] via-[#0d0d16] to-[#07070b] border border-white/10 shadow-2xl space-y-6">

            <!-- Flash Error -->
            @if(session('error'))
                <div class="p-3.5 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-400 text-xs font-bold">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="p-3.5 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 text-xs font-bold">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-3.5 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-400 text-xs space-y-1">
                    @foreach($errors->all() as $err)
                        <div>• {{ $err }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5 font-mono">
                        {{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Admin Email' }}
                    </label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', 'admin@jordan.com') }}" 
                           required 
                           autocomplete="email"
                           class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500 font-mono transition" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-300 mb-1.5 font-mono">
                        {{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}
                    </label>
                    <input type="password" 
                           name="password" 
                           value="password"
                           required 
                           class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-red-500 font-mono transition" />
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-gray-400 hover:text-white">
                        <input type="checkbox" name="remember" checked class="rounded bg-white/10 border-white/20 text-red-600 focus:ring-0" />
                        <span>{{ app()->getLocale() === 'ar' ? 'تذكرني على هذا الجهاز' : 'Remember me' }}</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono font-black text-xs uppercase tracking-wider shadow-lg shadow-red-600/30 transition-all duration-300 hover:scale-[1.02] cursor-pointer">
                        {{ app()->getLocale() === 'ar' ? 'دخول لوحة التحكم ➔' : 'ENTER COMMAND CENTER ➔' }}
                    </button>
                </div>
            </form>

            <!-- Quick Demo Credentials Box -->
            <div class="pt-4 border-t border-white/5 text-center">
                <div class="p-3 rounded-xl bg-white/5 border border-white/5 text-[11px] font-mono text-gray-400 space-y-1">
                    <div class="text-gray-300 font-bold">🔐 بيانات تجربة الأدمن الافتراضية:</div>
                    <div>Email: <strong class="text-red-400 select-all">admin@jordan.com</strong></div>
                    <div>Password: <strong class="text-white select-all">password</strong></div>
                </div>
            </div>

        </div>

        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-xs font-mono text-gray-500 hover:text-gray-300 transition">
                ← {{ app()->getLocale() === 'ar' ? 'الرجوع إلى المتجر' : 'Back to Storefront' }}
            </a>
        </div>

    </div>

</body>
</html>
