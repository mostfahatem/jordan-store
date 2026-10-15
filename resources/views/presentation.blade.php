<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ app()->getLocale() === 'ar' ? 'العرض التقديمي التجاري | JORDAN FLIGHT OS PITCH DECK' : 'Commercial Sales Deck | JORDAN FLIGHT OS' }}</title>
    <meta name="description" content="Commercial pitch deck and live interactive demonstration for Jordan Flight OS high-ticket e-commerce platform.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: {{ app()->getLocale() === 'ar' ? "'Cairo', sans-serif" : "'Plus Jakarta Sans', sans-serif" }};
        }
        .slide-panel {
            display: none;
            opacity: 0;
            transform: scale(0.98);
            transition: opacity 0.35s ease, transform 0.35s ease;
        }
        .slide-panel.active {
            display: flex;
            opacity: 1;
            transform: scale(1);
        }
        @media print {
            .no-print { display: none !important; }
            .slide-panel { display: flex !important; opacity: 1 !important; transform: none !important; page-break-after: always; min-height: 95vh; }
        }
    </style>
</head>
<body class="bg-[#050508] text-gray-100 min-h-screen flex flex-col justify-between selection:bg-red-600 selection:text-white overflow-x-hidden">

    <!-- Ambient Glow FX -->
    <div class="fixed top-0 left-1/4 w-[600px] h-[600px] bg-red-600/10 rounded-full blur-[180px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-0 right-1/4 w-[500px] h-[500px] bg-cyan-600/10 rounded-full blur-[170px] pointer-events-none -z-10"></div>

    <!-- Presentation Top Control Header (Sticky HUD) -->
    <header class="no-print sticky top-0 z-50 bg-[#090912]/90 backdrop-blur-xl border-b border-white/10 px-4 sm:px-8 py-3.5">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            
            <!-- Brand Badge -->
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/store/logo_jumpman.png') }}" alt="Jumpman" class="h-6 w-auto brightness-150 group-hover:scale-110 transition" />
                    <span class="font-black text-sm tracking-wider text-white">JORDAN <span class="text-red-500 font-mono">PITCH DECK</span></span>
                </a>
                <span class="hidden md:inline-flex px-2.5 py-0.5 rounded-full bg-red-600/20 border border-red-500/30 text-[10px] font-mono text-red-400 font-bold">
                    COMMERCIAL ASSET
                </span>
            </div>

            <!-- Slide Switcher & Controls -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Slide Indicators -->
                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs font-mono font-bold text-gray-300">
                    <span id="slide-num-current" class="text-red-400 text-sm">1</span>
                    <span class="text-gray-500">/</span>
                    <span id="slide-num-total">8</span>
                </div>

                <!-- Navigation Buttons -->
                <button type="button" id="btn-prev-slide" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-white transition disabled:opacity-30 disabled:cursor-not-allowed" title="Previous Slide (Arrow Left)">
                    <span class="rtl:rotate-180 block">←</span>
                </button>
                <button type="button" id="btn-next-slide" class="p-2 rounded-xl bg-red-600 hover:bg-red-500 text-white transition disabled:opacity-30 disabled:cursor-not-allowed font-bold" title="Next Slide (Arrow Right)">
                    <span class="rtl:rotate-180 block">→</span>
                </button>

                <!-- Actions: Print & Fullscreen & Demo -->
                <button type="button" onclick="window.print()" class="hidden sm:inline-flex p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 hover:text-white transition" title="Print Deck / Save as PDF">
                    🖨️
                </button>
                <a href="{{ route('demo.admin-login') }}" class="px-3.5 py-1.5 rounded-xl bg-emerald-500/20 hover:bg-emerald-500 border border-emerald-500/40 hover:border-emerald-500 text-emerald-400 hover:text-white text-xs font-mono font-bold transition flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>{{ app()->getLocale() === 'ar' ? 'جرب الأدمن الآن' : 'Live Admin Demo' }}</span>
                </a>
                <a href="{{ route('locale', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" class="px-2.5 py-1.5 rounded-xl bg-white/5 hover:bg-white/10 text-xs font-mono font-bold text-gray-300">
                    {{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}
                </a>
            </div>

        </div>
    </header>

    <!-- Main Presentation Slides Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 flex flex-col justify-center">

        <!-- ================================================= -->
        <!-- SLIDE 1: COVER & VALUE PROPOSITION WITH MOCKUP    -->
        <!-- ================================================= -->
        <div class="slide-panel active flex-col justify-between min-h-[70vh] space-y-8" data-slide="1">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Left: Title, Bio & Metrics (Col 1 to 7) -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-600/20 border border-red-500/40 text-xs font-mono font-bold text-red-400">
                        <span>🚀 COMMERCIAL SOFTWARE ASSET FOR SALE</span>
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-black text-white leading-tight tracking-tight">
                        JORDAN <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-rose-500 to-amber-500">FLIGHT OS</span>
                    </h1>
                    <p class="text-base sm:text-xl text-gray-300 leading-relaxed font-light">
                        {{ app()->getLocale() === 'ar' 
                            ? 'الجيل الجديد من منصات التجارة الإلكترونية عالية التحويل، المصممة خصيصاً لبيع السنيكرز والمنتجات الرياضية الفاخرة مع نظام إدارة وتحكم ولوجستيات متكامل.' 
                            : 'The next-generation high-converting e-commerce engine engineered specifically for luxury sneakers and streetwear with an integrated admin telemetry center.' }}
                    </p>

                    <!-- Key Metric Highlights -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                        <div class="p-4 rounded-2xl bg-[#0e0e18] border border-white/10 space-y-1">
                            <span class="text-2xl font-mono font-black text-red-500">4.8%</span>
                            <h4 class="text-[11px] font-bold text-white">{{ app()->getLocale() === 'ar' ? 'معدل التحويل' : 'Conversion' }}</h4>
                            <p class="text-[10px] text-gray-400">{{ app()->getLocale() === 'ar' ? 'ضعف المتاجر النمطية' : '3x standard' }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-[#0e0e18] border border-white/10 space-y-1">
                            <span class="text-2xl font-mono font-black text-emerald-400">&lt; 1.2s</span>
                            <h4 class="text-[11px] font-bold text-white">{{ app()->getLocale() === 'ar' ? 'سرعة التحميل' : 'Speed' }}</h4>
                            <p class="text-[10px] text-gray-400">{{ app()->getLocale() === 'ar' ? 'أداء موبايل فائق' : 'Vite optimized' }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-[#0e0e18] border border-white/10 space-y-1">
                            <span class="text-2xl font-mono font-black text-cyan-400">100%</span>
                            <h4 class="text-[11px] font-bold text-white">{{ app()->getLocale() === 'ar' ? 'تشغيل فوري' : 'Turnkey' }}</h4>
                            <p class="text-[10px] text-gray-400">{{ app()->getLocale() === 'ar' ? 'سورس كود كامل' : 'Full source' }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-[#0e0e18] border border-white/10 space-y-1">
                            <span class="text-2xl font-mono font-black text-amber-400">23/23</span>
                            <h4 class="text-[11px] font-bold text-white">{{ app()->getLocale() === 'ar' ? 'اختبارات ناجحة' : 'Tests' }}</h4>
                            <p class="text-[10px] text-gray-400">{{ app()->getLocale() === 'ar' ? 'PHPUnit معتمد' : '100% passing' }}</p>
                        </div>
                    </div>

                    <!-- Quick Action Bar -->
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <button type="button" onclick="goToSlide(2)" class="px-8 py-3.5 rounded-2xl bg-red-600 hover:bg-red-500 text-white font-mono font-bold text-xs uppercase tracking-wider shadow-xl shadow-red-600/30 transition flex items-center gap-2 hover:scale-105">
                            <span>{{ app()->getLocale() === 'ar' ? 'استعراض شرائح العرض' : 'Start Presentation' }}</span>
                            <span class="rtl:rotate-180">→</span>
                        </button>
                        <a href="{{ route('home') }}" target="_blank" class="px-6 py-3.5 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/15 text-xs font-mono font-bold text-gray-300 hover:text-white transition flex items-center gap-2">
                            <span>🌐</span>
                            <span>{{ app()->getLocale() === 'ar' ? 'معاينة المتجر لايف' : 'Preview Live Store' }}</span>
                        </a>
                    </div>
                </div>

                <!-- Right: Visual Device Showcase (Col 8 to 12) -->
                <div class="lg:col-span-5 relative group">
                    <div class="relative rounded-3xl overflow-hidden border border-white/20 shadow-2xl bg-black p-2 ring-1 ring-white/10 shadow-red-600/10">
                        <div class="flex items-center gap-1.5 px-3 py-2 bg-[#12121c] border-b border-white/10 text-xs font-mono text-gray-400">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <span class="ms-2 text-[10px] text-gray-400 font-mono">https://jordan-flight-os.live</span>
                        </div>
                        <img src="{{ asset('images/store/store_mockup.jpg') }}" 
                             alt="Jordan Flight OS Live Storefront Mockup" 
                             class="w-full h-auto object-cover rounded-2xl transform group-hover:scale-102 transition-transform duration-700" />
                        <div class="absolute bottom-5 inset-x-5 p-3 rounded-2xl bg-black/80 backdrop-blur-md border border-white/15 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                                <span class="font-bold text-white">{{ app()->getLocale() === 'ar' ? 'واجهة المتجر السينمائية الحية' : 'Live Cinematic Storefront' }}</span>
                            </div>
                            <span class="font-mono text-[10px] text-red-400 font-bold">4K READY</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- ================================================= -->
        <!-- SLIDE 2: THE MARKET PROBLEM & THE SOLUTION        -->
        <!-- ================================================= -->
        <div class="slide-panel flex-col justify-between min-h-[70vh] space-y-8" data-slide="2">
            <div class="space-y-3">
                <span class="text-xs font-mono font-bold text-red-500 uppercase tracking-widest">01 // THE MARKET PROBLEM & OPPORTUNITY</span>
                <h2 class="text-3xl sm:text-5xl font-black text-white">
                    {{ app()->getLocale() === 'ar' ? 'لماذا تفشل المتاجر التقليدية وتنتصر هذه المنصة؟' : 'Why Generic Stores Fail and How This Platform Wins' }}
                </h2>
                <p class="text-gray-400 max-w-2xl text-sm sm:text-base">
                    {{ app()->getLocale() === 'ar' ? 'مشتري السنيكرز الفاخر (High-Ticket Buyer) لا يشتري من متجر نمطي بارد يشبه الصيدلية. إنه يشتري التجربة، الإثارة، والهوية.' : 'Sneakerheads do not buy high-ticket kicks from generic pharmacy-like websites. They buy the culture, adrenaline, and verified authenticity.' }}
                </p>
            </div>

            <!-- Comparison Table with Visual Enhancements -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Generic Stores -->
                <div class="p-6 sm:p-8 rounded-3xl bg-red-950/20 border border-red-500/20 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-red-400 font-bold text-sm font-mono">❌ المتاجر التقليدية (Shopify / WooCommerce Generic)</span>
                        <span class="px-2 py-0.5 rounded bg-red-600/20 text-red-400 text-[10px] font-mono">1.2% CONVERSION</span>
                    </div>
                    <ul class="space-y-3 text-xs sm:text-sm text-gray-300">
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 font-bold">✕</span>
                            <span>قوالب مكررة ومملة تفقد البراند هيبته وقيمته أمام العميل وتظهره كمتجر صيني تجاري.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 font-bold">✕</span>
                            <span>بطء في التحميل بسبب كثرة الـ Plugins غير المتناسقة واستهلاك بيانات الإنترنت.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 font-bold">✕</span>
                            <span>إتمام شراء معقد يطلب إنشاء حساب وكلمة مرور مما يهرب 60% من المشترين في اللحظة الأخيرة.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 font-bold">✕</span>
                            <span>انعدام نظام تتبع شحنات مباشر يسبب ضغطاً رهيباً على خدمة العملاء وتكرار سؤال "الأوردر فين؟".</span>
                        </li>
                    </ul>
                </div>

                <!-- Jordan Flight OS -->
                <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-emerald-950/30 to-[#0e0e18] border-2 border-emerald-500/40 space-y-4 shadow-2xl shadow-emerald-950/40">
                    <div class="flex items-center justify-between">
                        <span class="text-emerald-400 font-bold text-sm font-mono">✓ منصة JORDAN FLIGHT OS المبتكرة</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-mono font-bold">4.8% CONVERSION</span>
                    </div>
                    <ul class="space-y-3 text-xs sm:text-sm text-gray-200">
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-400 font-bold">✓</span>
                            <span><strong>واجهة سينمائية تفاعلية 4K</strong> مع فيديو إطلاق احترافي يرفع قيمة السنيكرز لـ 3 أضعاف.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-400 font-bold">✓</span>
                            <span><strong>شراء فوري في خطوة واحدة</strong> مهيأ لطرق الدفع في مصر والشرق الأوسط (كاش، إنستاباي، فيزا).</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-400 font-bold">✓</span>
                            <span><strong>رادار تتبع حي للشحنات</strong> بـ 4 مراحل يمنح العميل ثقة مطلقة ويخفض المرتجعات.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-400 font-bold">✓</span>
                            <span><strong>لوحة تحكم كاملة</strong> تطبع فواتير حرارية مع باركود الشحنة بنقرة واحدة.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Navigation -->
            <div class="flex justify-between items-center pt-4 border-t border-white/10">
                <button type="button" onclick="goToSlide(1)" class="text-xs font-mono text-gray-400 hover:text-white">← {{ app()->getLocale() === 'ar' ? 'السابق' : 'Previous' }}</button>
                <button type="button" onclick="goToSlide(3)" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono text-xs font-bold">{{ app()->getLocale() === 'ar' ? 'التالي: ابتكارات الواجهة →' : 'Next: Storefront →' }}</button>
            </div>
        </div>

        <!-- ================================================= -->
        <!-- SLIDE 3: STOREFRONT VISUAL SHOWCASE               -->
        <!-- ================================================= -->
        <div class="slide-panel flex-col justify-between min-h-[70vh] space-y-8" data-slide="3">
            <div class="space-y-3">
                <span class="text-xs font-mono font-bold text-red-500 uppercase tracking-widest">02 // STOREFRONT INNOVATIONS</span>
                <h2 class="text-3xl sm:text-5xl font-black text-white">
                    {{ app()->getLocale() === 'ar' ? 'ابتكارات الواجهة وتجربة المستخدم الساحرة' : 'Storefront Cinematic Innovations' }}
                </h2>
                <p class="text-gray-400 max-w-2xl text-sm sm:text-base">
                    {{ app()->getLocale() === 'ar' ? 'شاهد كيف يبدو المتجر للعميل بأدق تفاصيل السنيكرز والإضاءة التفاعلية:' : 'Experience how the storefront mesmerizes buyers with interactive sneaker technology:' }}
                </p>
            </div>

            <!-- 4 Visual Product Showcase Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Card 1: 4K Runway Hero -->
                <div class="p-5 rounded-3xl bg-[#0d0d16] border border-white/10 space-y-3 group hover:border-red-500/40 transition">
                    <div class="h-32 rounded-2xl overflow-hidden relative bg-black">
                        <img src="{{ asset('images/store/lookbook_banner.jpg') }}" alt="4K Video Hero" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
                        <span class="absolute top-2 start-2 px-2 py-0.5 rounded bg-black/70 text-[9px] font-mono text-red-400 font-bold">4K RUNWAY</span>
                    </div>
                    <h4 class="text-sm font-bold text-white">{{ app()->getLocale() === 'ar' ? 'فيديو سينمائي 4K تفاعلي' : '4K Video Runway Hero' }}</h4>
                    <p class="text-[11px] text-gray-400 leading-relaxed">{{ app()->getLocale() === 'ar' ? 'فيديو إطلاق خلفي مع زر تحكم بالصوت ونافذة سينما مدمجة.' : 'Atmospheric video reel with sound toggle and cinema film player.' }}</p>
                </div>

                <!-- Card 2: Interactive Colorway Switcher -->
                <div class="p-5 rounded-3xl bg-[#0d0d16] border border-white/10 space-y-3 group hover:border-red-500/40 transition">
                    <div class="h-32 rounded-2xl overflow-hidden relative bg-black flex items-center justify-center p-2">
                        <img src="{{ asset('images/store/products/jordan-jumpman-2021-pf.jpg') }}" alt="Colorway Switcher" class="max-h-full object-contain group-hover:scale-105 transition duration-500" />
                        <div class="absolute bottom-2 inset-x-2 flex justify-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-red-600 ring-2 ring-white"></span>
                            <span class="w-3 h-3 rounded-full bg-purple-600"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        </div>
                    </div>
                    <h4 class="text-sm font-bold text-white">{{ app()->getLocale() === 'ar' ? 'مبدل ألوان السنيكرز اللحظي' : 'Live Colorway Switcher' }}</h4>
                    <p class="text-[11px] text-gray-400 leading-relaxed">{{ app()->getLocale() === 'ar' ? 'تبديل ألوان الحذاء (أحمر، بنفسجي، أخضر) مع تغير الإضاءة الخلفية لحظياً.' : 'Dynamic color switching with synchronized reactive background glow.' }}</p>
                </div>

                <!-- Card 3: 1-Click Checkout -->
                <div class="p-5 rounded-3xl bg-[#0d0d16] border border-white/10 space-y-3 group hover:border-red-500/40 transition">
                    <div class="h-32 rounded-2xl overflow-hidden relative bg-black p-3 flex flex-col justify-between border border-white/5">
                        <div class="space-y-1 text-start">
                            <span class="text-[9px] font-mono text-cyan-400 block">⚡ EXPRESS CHECKOUT</span>
                            <span class="text-[10px] text-white block">القاهرة / الجيزة / الإسكندرية</span>
                        </div>
                        <div class="flex gap-1 text-[8px] font-mono text-gray-400">
                            <span class="px-1.5 py-0.5 rounded bg-white/10">كاش</span>
                            <span class="px-1.5 py-0.5 rounded bg-white/10">إنستاباي</span>
                            <span class="px-1.5 py-0.5 rounded bg-white/10">فيزا</span>
                        </div>
                    </div>
                    <h4 class="text-sm font-bold text-white">{{ app()->getLocale() === 'ar' ? 'شراء فوري + واتساب' : '1-Step Fast Checkout' }}</h4>
                    <p class="text-[11px] text-gray-400 leading-relaxed">{{ app()->getLocale() === 'ar' ? 'استمارة سريعة تجمع العنوان وطريقة الدفع دون طلب تسجيل حساب.' : 'Zero registration barrier capturing address and notes instantly.' }}</p>
                </div>

                <!-- Card 4: Heritage Story Banner -->
                <div class="p-5 rounded-3xl bg-[#0d0d16] border border-white/10 space-y-3 group hover:border-red-500/40 transition">
                    <div class="h-32 rounded-2xl overflow-hidden relative bg-black">
                        <img src="{{ asset('images/store/products/air-jordan-1-retro.jpg') }}" alt="Air Jordan Heritage" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
                        <span class="absolute top-2 start-2 px-2 py-0.5 rounded bg-red-600 text-[9px] font-mono text-white font-bold">SINCE 1985</span>
                    </div>
                    <h4 class="text-sm font-bold text-white">{{ app()->getLocale() === 'ar' ? 'قصة الحذاء وسرد البراند' : 'Heritage Sneaker Narrative' }}</h4>
                    <p class="text-[11px] text-gray-400 leading-relaxed">{{ app()->getLocale() === 'ar' ? 'قسم عرض سينمائي يبرز خامات الجلد الطبيعي والبوكس الأصلي وشهادة الفحص.' : 'Elevates brand prestige with original 1985 silhouette highlights.' }}</p>
                </div>

            </div>

            <!-- Footer Navigation -->
            <div class="flex justify-between items-center pt-4 border-t border-white/10">
                <button type="button" onclick="goToSlide(2)" class="text-xs font-mono text-gray-400 hover:text-white">← {{ app()->getLocale() === 'ar' ? 'السابق' : 'Previous' }}</button>
                <button type="button" onclick="goToSlide(4)" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono text-xs font-bold">{{ app()->getLocale() === 'ar' ? 'التالي: رادار تتبع الشحنات →' : 'Next: Live Tracking Radar →' }}</button>
            </div>
        </div>

        <!-- ================================================= -->
        <!-- SLIDE 4: LIVE ORDER TRACKING RADAR                -->
        <!-- ================================================= -->
        <div class="slide-panel flex-col justify-between min-h-[70vh] space-y-8" data-slide="4">
            <div class="space-y-3">
                <span class="text-xs font-mono font-bold text-red-500 uppercase tracking-widest">03 // LIVE ORDER TRACKING RADAR</span>
                <h2 class="text-3xl sm:text-5xl font-black text-white">
                    {{ app()->getLocale() === 'ar' ? 'رادار تتبع الشحنات اللحظي (Flight Dispatch Radar)' : 'Live Flight Dispatch Radar' }}
                </h2>
                <p class="text-gray-400 max-w-2xl text-sm sm:text-base">
                    {{ app()->getLocale() === 'ar' ? 'الحل الجذري لأكبر مشكلة في التجارة الإلكترونية: القلق من موعد الاستلام وتكرار أسئلة خدمة العملاء.' : 'Eliminates 80% of customer inquiry friction by providing live, visual milestone telemetry.' }}
                </p>
            </div>

            <!-- Live Tracking Stepper Preview -->
            <div class="p-6 sm:p-10 rounded-3xl bg-gradient-to-b from-[#12121e] to-[#07070d] border border-white/10 space-y-6 shadow-2xl">
                
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-white/10 pb-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/store/products/air-jordan-1-retro.jpg') }}" alt="Sneaker Package" class="w-12 h-12 object-cover rounded-xl border border-white/10" />
                        <div>
                            <span class="text-xs text-gray-400 font-mono block">SAMPLE DISPATCH CODE</span>
                            <span class="text-xl sm:text-2xl font-mono font-black text-white">JRD-849102</span>
                        </div>
                    </div>
                    <span class="px-4 py-1.5 rounded-full bg-cyan-500/20 border border-cyan-400/40 text-cyan-300 font-mono text-xs font-bold">
                        ● SHIPPED // خرج مع المندوب
                    </span>
                </div>

                <!-- 4 Steps Interactive Visual -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center">
                    <div class="p-3.5 rounded-2xl bg-white/5 border border-white/5 space-y-1.5">
                        <span class="w-9 h-9 rounded-full bg-red-600 text-white font-bold flex items-center justify-center mx-auto text-xs">✓</span>
                        <span class="text-xs font-bold text-white block">تم استلام الطلب</span>
                        <span class="text-[10px] text-gray-400 font-mono">10:30 AM</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-white/5 border border-white/5 space-y-1.5">
                        <span class="w-9 h-9 rounded-full bg-red-600 text-white font-bold flex items-center justify-center mx-auto text-xs">✓</span>
                        <span class="text-xs font-bold text-white block">جاري التجهيز والفحص</span>
                        <span class="text-[10px] text-gray-400 font-mono">01:15 PM</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-red-600/20 border border-red-500/40 space-y-1.5 ring-2 ring-red-500/40">
                        <span class="w-9 h-9 rounded-full bg-red-600 text-white font-bold flex items-center justify-center mx-auto animate-pulse text-xs">🚚</span>
                        <span class="text-xs font-bold text-red-400 block">خرج مع المندوب</span>
                        <span class="text-[10px] text-red-300 font-mono">LIVE RADAR</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-white/5 border border-white/5 space-y-1.5 opacity-50">
                        <span class="w-9 h-9 rounded-full bg-white/10 text-gray-400 font-bold flex items-center justify-center mx-auto text-xs">4</span>
                        <span class="text-xs font-bold text-gray-400 block">تم التسليم بنجاح</span>
                        <span class="text-[10px] text-gray-500 font-mono">PENDING</span>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs text-gray-400 pt-2 border-t border-white/5">
                    <span>{{ app()->getLocale() === 'ar' ? 'محتويات الشحنة: سنيكرز إير جوردان 1 ريترو (مقاس 43)' : 'Contents: Air Jordan 1 Retro Chicago (Size 43)' }}</span>
                    <a href="{{ route('orders.track', ['q' => 'JRD-849102']) }}" target="_blank" class="text-xs font-mono text-cyan-400 hover:text-cyan-300 font-bold underline flex items-center gap-1.5">
                        <span>{{ app()->getLocale() === 'ar' ? 'فتح شاشة الرادار الحية' : 'Open Live Radar' }}</span>
                        <span>↗</span>
                    </a>
                </div>
            </div>

            <!-- Footer Navigation -->
            <div class="flex justify-between items-center pt-4 border-t border-white/10">
                <button type="button" onclick="goToSlide(3)" class="text-xs font-mono text-gray-400 hover:text-white">← {{ app()->getLocale() === 'ar' ? 'السابق' : 'Previous' }}</button>
                <button type="button" onclick="goToSlide(5)" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono text-xs font-bold">{{ app()->getLocale() === 'ar' ? 'التالي: مركز قيادة الإدارة →' : 'Next: Admin Command Center →' }}</button>
            </div>
        </div>

        <!-- ================================================= -->
        <!-- SLIDE 5: ADMIN COMMAND CENTER WITH VISUAL MOCKUP  -->
        <!-- ================================================= -->
        <div class="slide-panel flex-col justify-between min-h-[70vh] space-y-8" data-slide="5">
            <div class="space-y-3">
                <span class="text-xs font-mono font-bold text-red-500 uppercase tracking-widest">04 // ADMIN COMMAND CENTER</span>
                <h2 class="text-3xl sm:text-5xl font-black text-white">
                    {{ app()->getLocale() === 'ar' ? 'مركز قيادة الإدارة الشامل (Admin Command Center)' : 'Admin Telemetry Command Center' }}
                </h2>
                <p class="text-gray-400 max-w-2xl text-sm sm:text-base">
                    {{ app()->getLocale() === 'ar' ? 'لوحة تحكم ذكية تمكن التاجر من إدارة مبيعاته وأوردراته وفواتيره بسهولة فائقة:' : 'Full operational control over sales, shipments, products, and customer relationships:' }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Left: Capabilities (Col 1 to 6) -->
                <div class="lg:col-span-6 space-y-4">
                    <div class="p-5 rounded-2xl bg-[#0d0d16] border border-white/10 flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-red-600/20 text-red-400 flex items-center justify-center font-bold text-base flex-shrink-0">📊</div>
                        <div>
                            <h4 class="text-sm font-bold text-white">{{ app()->getLocale() === 'ar' ? 'مؤشرات المبيعات اللحظية (KPIs)' : 'Live Sales Telemetry' }}</h4>
                            <p class="text-xs text-gray-400 mt-1 leading-relaxed">{{ app()->getLocale() === 'ar' ? 'عداد فوري للأرباح، الأوردرات الجديدة، نسبة التوصيل، وقائمة السنيكرز الـ 5 الأكثر مبيعاً.' : 'Real-time revenue meters, order counts, status breakdowns, and top-selling sneakers.' }}</p>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-[#0d0d16] border border-white/10 flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-cyan-600/20 text-cyan-400 flex items-center justify-center font-bold text-base flex-shrink-0">📄</div>
                        <div>
                            <h4 class="text-sm font-bold text-white">{{ app()->getLocale() === 'ar' ? 'طباعة الفواتير وبوليصة الشحن الحرارية' : 'Thermal Invoice Printing' }}</h4>
                            <p class="text-xs text-gray-400 mt-1 leading-relaxed">{{ app()->getLocale() === 'ar' ? 'توليد بوليصة شحن وفاتورة رسمية مزودة بباركود الشحنة وختم الفحص جاهزة للطباعة فوراً.' : 'Print-ready thermal receipts with dynamic barcode and authentication stamp.' }}</p>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-[#0d0d16] border border-white/10 flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-amber-600/20 text-amber-400 flex items-center justify-center font-bold text-base flex-shrink-0">👟</div>
                        <div>
                            <h4 class="text-sm font-bold text-white">{{ app()->getLocale() === 'ar' ? 'إدارة السنيكرز والعملاء (CRM)' : 'Catalog & Customer CRM' }}</h4>
                            <p class="text-xs text-gray-400 mt-1 leading-relaxed">{{ app()->getLocale() === 'ar' ? 'إضافة وتعديل الأحذية والمقاسات (EU 40-46) والأسعار مع أرشيف كامل للعملاء وروابط واتساب مباشرة.' : 'Complete product CRUD, size allocations, image uploads, and customer WhatsApp links.' }}</p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a href="{{ route('demo.admin-login') }}" target="_blank" class="px-6 py-3 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono text-xs font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-red-600/30">
                            <span>🚀 {{ app()->getLocale() === 'ar' ? 'دخول فوري لتجربة لوحة الأدمن لايف' : 'One-Click Admin Demo Login' }}</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- Right: Visual Monitor Mockup (Col 7 to 12) -->
                <div class="lg:col-span-6 relative group">
                    <div class="rounded-3xl overflow-hidden border border-white/20 shadow-2xl bg-black p-2 ring-1 ring-white/10 shadow-cyan-600/10">
                        <div class="flex items-center gap-1.5 px-3 py-2 bg-[#12121c] border-b border-white/10 text-xs font-mono text-gray-400">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <span class="ms-2 text-[10px] text-gray-400 font-mono">https://jordan-flight-os.live/admin</span>
                        </div>
                        <img src="{{ asset('images/store/admin_mockup.jpg') }}" 
                             alt="Admin Command Center Monitor Mockup" 
                             class="w-full h-auto object-cover rounded-2xl transform group-hover:scale-102 transition duration-700" />
                    </div>
                </div>

            </div>

            <!-- Footer Navigation -->
            <div class="flex justify-between items-center pt-4 border-t border-white/10">
                <button type="button" onclick="goToSlide(4)" class="text-xs font-mono text-gray-400 hover:text-white">← {{ app()->getLocale() === 'ar' ? 'السابق' : 'Previous' }}</button>
                <button type="button" onclick="goToSlide(6)" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono text-xs font-bold">{{ app()->getLocale() === 'ar' ? 'التالي: المواصفات التقنية →' : 'Next: Technical Stack →' }}</button>
            </div>
        </div>

        <!-- ================================================= -->
        <!-- SLIDE 6: TECHNICAL STACK & ARCHITECTURE           -->
        <!-- ================================================= -->
        <div class="slide-panel flex-col justify-between min-h-[70vh] space-y-8" data-slide="6">
            <div class="space-y-3">
                <span class="text-xs font-mono font-bold text-red-500 uppercase tracking-widest">05 // TECHNICAL STACK & ARCHITECTURE</span>
                <h2 class="text-3xl sm:text-5xl font-black text-white">
                    {{ app()->getLocale() === 'ar' ? 'البنية البرمجية وجودة الكود (Under The Hood)' : 'Robust Enterprise Architecture' }}
                </h2>
                <p class="text-gray-400 max-w-2xl text-sm sm:text-base">
                    {{ app()->getLocale() === 'ar' ? 'مبني وفق أعلى المعايير الهندسية لضمان استقرار وسرعة وأمان يتحمل آلاف الطلبات المتزامنة.' : 'Built on battle-tested frameworks guaranteeing speed, security, and scalability.' }}
                </p>
            </div>

            <!-- Tech Badges Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 text-center">
                <div class="p-5 rounded-2xl bg-[#0d0d16] border border-white/10 space-y-2">
                    <span class="text-red-500 font-mono font-black text-xl block">Laravel 12</span>
                    <span class="text-xs text-gray-300 font-bold block">Backend Framework</span>
                    <span class="text-[10px] text-gray-500 font-mono">PHP 8.4 Strict</span>
                </div>
                <div class="p-5 rounded-2xl bg-[#0d0d16] border border-white/10 space-y-2">
                    <span class="text-cyan-400 font-mono font-black text-xl block">MySQL 8</span>
                    <span class="text-xs text-gray-300 font-bold block">Relational Database</span>
                    <span class="text-[10px] text-gray-500 font-mono">Indexed & ACID</span>
                </div>
                <div class="p-5 rounded-2xl bg-[#0d0d16] border border-white/10 space-y-2">
                    <span class="text-sky-400 font-mono font-black text-xl block">Tailwind CSS</span>
                    <span class="text-xs text-gray-300 font-bold block">Modern Styling</span>
                    <span class="text-[10px] text-gray-500 font-mono">Dark HUD + RTL</span>
                </div>
                <div class="p-5 rounded-2xl bg-[#0d0d16] border border-white/10 space-y-2">
                    <span class="text-amber-400 font-mono font-black text-xl block">Vite Bundler</span>
                    <span class="text-xs text-gray-300 font-bold block">Ultra Fast Build</span>
                    <span class="text-[10px] text-gray-500 font-mono">HMR & Minified</span>
                </div>
                <div class="p-5 rounded-2xl bg-[#0d0d16] border border-white/10 space-y-2">
                    <span class="text-emerald-400 font-mono font-black text-xl block">PHPUnit</span>
                    <span class="text-xs text-gray-300 font-bold block">Automated Tests</span>
                    <span class="text-[10px] text-emerald-400 font-mono font-bold">23/23 100% Passed</span>
                </div>
                <div class="p-5 rounded-2xl bg-[#0d0d16] border border-white/10 space-y-2">
                    <span class="text-purple-400 font-mono font-black text-xl block">Pint Formatter</span>
                    <span class="text-xs text-gray-300 font-bold block">Clean Code</span>
                    <span class="text-[10px] text-gray-500 font-mono">PSR-12 Compliant</span>
                </div>
            </div>

            <!-- Code Highlights -->
            <div class="p-6 rounded-3xl bg-black/60 border border-white/10 font-mono text-xs text-gray-300 space-y-2 overflow-x-auto">
                <div class="flex items-center justify-between text-gray-500 pb-2 border-b border-white/5">
                    <span>TERMINAL OUTPUT // VERIFICATION PASS</span>
                    <span class="text-emerald-400">● 100% GREEN</span>
                </div>
                <div class="text-emerald-400">✓ Tests\Feature\OrderSystemTest (5 passed, 24 assertions)</div>
                <div class="text-emerald-400">✓ Tests\Feature\AdminDashboardTest (8 passed, 38 assertions)</div>
                <div class="text-emerald-400">✓ Tests\Feature\StoreTest (10 passed, 30 assertions)</div>
                <div class="text-gray-400 pt-1">Total: 23 tests, 92 assertions, 0 failures. All clean.</div>
            </div>

            <!-- Footer Navigation -->
            <div class="flex justify-between items-center pt-4 border-t border-white/10">
                <button type="button" onclick="goToSlide(5)" class="text-xs font-mono text-gray-400 hover:text-white">← {{ app()->getLocale() === 'ar' ? 'السابق' : 'Previous' }}</button>
                <button type="button" onclick="goToSlide(7)" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono text-xs font-bold">{{ app()->getLocale() === 'ar' ? 'التالي: باقات البيع المقترحة →' : 'Next: Commercial Packages →' }}</button>
            </div>
        </div>

        <!-- ================================================= -->
        <!-- SLIDE 7: COMMERCIAL PACKAGES & PRICING            -->
        <!-- ================================================= -->
        <div class="slide-panel flex-col justify-between min-h-[70vh] space-y-8" data-slide="7">
            <div class="space-y-3">
                <span class="text-xs font-mono font-bold text-red-500 uppercase tracking-widest">06 // COMMERCIAL PACKAGES & PRICING</span>
                <h2 class="text-3xl sm:text-5xl font-black text-white">
                    {{ app()->getLocale() === 'ar' ? 'باقات البيع المقترحة للعملاء (Commercial Offerings)' : 'Commercial Packages for Buyers' }}
                </h2>
                <p class="text-gray-400 max-w-2xl text-sm sm:text-base">
                    {{ app()->getLocale() === 'ar' ? 'خيارات تسليم مرنة تناسب التجار وأصحاب الماركات والشركات الناشئة.' : 'Tailored packages for brand owners, sneaker boutiques, and e-commerce entrepreneurs.' }}
                </p>
            </div>

            <!-- 3 Commercial Tiers -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Tier 1 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-[#0d0d16] border border-white/10 space-y-5 flex flex-col justify-between">
                    <div class="space-y-3">
                        <span class="text-xs font-mono text-gray-400 block font-bold">PACKAGE 01</span>
                        <h3 class="text-xl font-black text-white">{{ app()->getLocale() === 'ar' ? 'السورس كود الجاهز' : 'Turnkey Source Code' }}</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">{{ app()->getLocale() === 'ar' ? 'تسليم الشيفرة المصدرية كاملة مع قاعدة البيانات ودليل التشغيل لمطور العميل.' : 'Full source code delivery with documentation and database schema.' }}</p>
                        <div class="text-2xl font-mono font-black text-white pt-2">
                            <span>$499</span>
                            <span class="text-xs text-gray-500 font-sans font-normal"> / تدفع مرة واحدة</span>
                        </div>
                    </div>
                    <ul class="space-y-2 text-xs text-gray-300 border-t border-white/10 pt-4">
                        <li>✓ سورس كود Laravel 12 كامل وغير مشفر</li>
                        <li>✓ قاعدة بيانات MySQL مهيئة ومحشوة</li>
                        <li>✓ رخصة استخدام تجاري كاملة</li>
                    </ul>
                </div>

                <!-- Tier 2 (Recommended) -->
                <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-b from-red-950/40 via-[#0d0d16] to-[#0d0d16] border-2 border-red-500/60 space-y-5 flex flex-col justify-between relative shadow-2xl shadow-red-950/50">
                    <div class="absolute -top-3.5 right-6 px-3 py-1 rounded-full bg-red-600 text-[10px] font-mono font-black text-white uppercase tracking-wider shadow-lg shadow-red-600/50">
                        {{ app()->getLocale() === 'ar' ? 'الأكثر طلباً ومبيعاً 🔥' : 'MOST POPULAR' }}
                    </div>
                    <div class="space-y-3">
                        <span class="text-xs font-mono text-red-400 block font-bold">PACKAGE 02</span>
                        <h3 class="text-xl font-black text-white">{{ app()->getLocale() === 'ar' ? 'التشغيل والتخصيص الكامل' : 'Custom White-Label Setup' }}</h3>
                        <p class="text-xs text-gray-300 leading-relaxed">{{ app()->getLocale() === 'ar' ? 'نركب السيستم على سيرفر العميل، ونغير اللوجو والألوان ونربط رقم الواتساب وبوابات الدفع.' : 'Complete installation, custom branding, domain & payment gateway integration.' }}</p>
                        <div class="text-2xl font-mono font-black text-red-400 pt-2">
                            <span>$999</span>
                            <span class="text-xs text-gray-400 font-sans font-normal"> / شامل التركيب</span>
                        </div>
                    </div>
                    <ul class="space-y-2 text-xs text-gray-200 border-t border-white/10 pt-4">
                        <li>✓ كل مميزات باقة السورس كود</li>
                        <li>✓ استبدال البراندينج واللوجو والألوان بهوية العميل</li>
                        <li>✓ ربط رقم واتساب المتجر وبوابات الدفع</li>
                        <li>✓ تثبيت وإعداد السيرفر وشهادة الأمان SSL</li>
                    </ul>
                </div>

                <!-- Tier 3 -->
                <div class="p-6 sm:p-8 rounded-3xl bg-[#0d0d16] border border-white/10 space-y-5 flex flex-col justify-between">
                    <div class="space-y-3">
                        <span class="text-xs font-mono text-gray-400 block font-bold">PACKAGE 03</span>
                        <h3 class="text-xl font-black text-white">{{ app()->getLocale() === 'ar' ? 'المؤسسات والدعم السنوي' : 'Enterprise & Support' }}</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">{{ app()->getLocale() === 'ar' ? 'استضافة سحابية خاصة + تطوير ميزات إضافية + صيانة ودعم فني على مدار 12 شهراً.' : 'Dedicated cloud hosting, custom feature engineering, and 12-month SLA.' }}</p>
                        <div class="text-2xl font-mono font-black text-white pt-2">
                            <span>$1,799</span>
                            <span class="text-xs text-gray-500 font-sans font-normal"> / تشغيل كامل + سنة دعم</span>
                        </div>
                    </div>
                    <ul class="space-y-2 text-xs text-gray-300 border-t border-white/10 pt-4">
                        <li>✓ كل مميزات الباقة السابقة</li>
                        <li>✓ استضافة سحابية فائقة السرعة لمدة عام</li>
                        <li>✓ إضافة ميزات وتقارير خاصة عند الطلب</li>
                        <li>✓ دعم فني وصيانة أسبوعية مستمرة</li>
                    </ul>
                </div>
            </div>

            <!-- Footer Navigation -->
            <div class="flex justify-between items-center pt-4 border-t border-white/10">
                <button type="button" onclick="goToSlide(6)" class="text-xs font-mono text-gray-400 hover:text-white">← {{ app()->getLocale() === 'ar' ? 'السابق' : 'Previous' }}</button>
                <button type="button" onclick="goToSlide(8)" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-mono text-xs font-bold">{{ app()->getLocale() === 'ar' ? 'التالي: التجربة الحية وإغلاق الصفقة →' : 'Next: Live Demo & Close →' }}</button>
            </div>
        </div>

        <!-- ================================================= -->
        <!-- SLIDE 8: LIVE TEST DRIVE & CLOSE THE DEAL         -->
        <!-- ================================================= -->
        <div class="slide-panel flex-col justify-between min-h-[70vh] space-y-8" data-slide="8">
            <div class="space-y-3 text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-500/40 text-xs font-mono font-bold text-emerald-400">
                    <span>🎮 INTERACTIVE TEST-DRIVE // LIVE RUNTIME</span>
                </div>
                <h2 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white">
                    {{ app()->getLocale() === 'ar' ? 'جرّب بنفسك الآن... وانبهر بالنتيجة!' : 'Test Drive The Platform Yourself Right Now' }}
                </h2>
                <p class="text-gray-300 text-sm sm:text-base leading-relaxed">
                    {{ app()->getLocale() === 'ar' ? 'كل الروابط أدناه شغالة ولايف بنسبة 100%. اختر ما تريد تجربته بنقرة واحدة:' : 'All links below are live on the system. Choose what you want to experience with one tap:' }}
                </p>
            </div>

            <!-- Interactive Trial Launcher Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 max-w-4xl mx-auto w-full">
                
                <!-- Action 1: Admin Direct Login -->
                <a href="{{ route('demo.admin-login') }}" class="p-6 rounded-3xl bg-gradient-to-br from-red-950/40 to-[#0e0e18] border border-red-500/30 hover:border-red-500 transition-all text-center space-y-3 group hover:scale-105 shadow-xl">
                    <span class="w-14 h-14 rounded-2xl bg-red-600 text-white text-2xl flex items-center justify-center mx-auto shadow-lg shadow-red-600/30 group-hover:rotate-6 transition">
                        🛡️
                    </span>
                    <h3 class="text-lg font-bold text-white">{{ app()->getLocale() === 'ar' ? 'دخول لوحة تحكم الأدمن' : 'Open Admin Command Center' }}</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ app()->getLocale() === 'ar' ? 'دخول مباشر بنقرة واحدة كمسؤول لمشاهدة المبيعات وتحديث الأوردرات.' : 'One-click login to inspect KPIs, orders, and update statuses.' }}</p>
                    <span class="inline-block font-mono text-xs text-red-400 font-bold group-hover:underline">
                        {{ app()->getLocale() === 'ar' ? 'ابدأ التجربة الآن →' : 'Launch Admin →' }}
                    </span>
                </a>

                <!-- Action 2: Storefront Buying Experience -->
                <a href="{{ route('home') }}" class="p-6 rounded-3xl bg-gradient-to-br from-cyan-950/40 to-[#0e0e18] border border-cyan-500/30 hover:border-cyan-400 transition-all text-center space-y-3 group hover:scale-105 shadow-xl">
                    <span class="w-14 h-14 rounded-2xl bg-cyan-600 text-white text-2xl flex items-center justify-center mx-auto shadow-lg shadow-cyan-600/30 group-hover:rotate-6 transition">
                        🛒
                    </span>
                    <h3 class="text-lg font-bold text-white">{{ app()->getLocale() === 'ar' ? 'تجربة المتجر كعميل' : 'Experience Store as Buyer' }}</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ app()->getLocale() === 'ar' ? 'تصفح الأحذية، جرب تبديل الألوان بالفيديو، وأضف للسلة وأكمل طلبك.' : 'Browse sneakers, switch colorways, add to bag, and place an order.' }}</p>
                    <span class="inline-block font-mono text-xs text-cyan-400 font-bold group-hover:underline">
                        {{ app()->getLocale() === 'ar' ? 'فتح واجهة المتجر →' : 'Launch Store →' }}
                    </span>
                </a>

                <!-- Action 3: Live Radar Tracking -->
                <a href="{{ route('orders.track', ['q' => 'JRD-849102']) }}" class="p-6 rounded-3xl bg-gradient-to-br from-purple-950/40 to-[#0e0e18] border border-purple-500/30 hover:border-purple-400 transition-all text-center space-y-3 group hover:scale-105 shadow-xl">
                    <span class="w-14 h-14 rounded-2xl bg-purple-600 text-white text-2xl flex items-center justify-center mx-auto shadow-lg shadow-purple-600/30 group-hover:rotate-6 transition">
                        📍
                    </span>
                    <h3 class="text-lg font-bold text-white">{{ app()->getLocale() === 'ar' ? 'تتبع شحنة حية' : 'Track Live Shipment' }}</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ app()->getLocale() === 'ar' ? 'شاهد رادار الشحن الفوري لشحنة سنيكرز حقيقية بكود JRD-849102.' : 'Watch live dispatch radar for order JRD-849102 in action.' }}</p>
                    <span class="inline-block font-mono text-xs text-purple-400 font-bold group-hover:underline">
                        {{ app()->getLocale() === 'ar' ? 'فتح شاشة الرادار →' : 'Open Radar →' }}
                    </span>
                </a>

            </div>

            <!-- Contact & Closer Box -->
            <div class="p-6 rounded-3xl bg-white/5 border border-white/10 text-center max-w-xl mx-auto space-y-3">
                <h4 class="text-base font-bold text-white">{{ app()->getLocale() === 'ar' ? 'جاهز لحجز وشراء هذه المنصة لمشروعك؟' : 'Ready to acquire this platform for your brand?' }}</h4>
                <p class="text-xs text-gray-400">{{ app()->getLocale() === 'ar' ? 'تواصل معي مباشرة لمناقشة التفاصيل والبدء فوراً في إطلاق مشروعك.' : 'Contact now to close the agreement and deploy within 24 hours.' }}</p>
                <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                    <a href="https://wa.me/201000000000?text=مرحباً،%20أريد%20الاستفسار%20عن%20شراء%20منصة%20Jordan%20Flight%20OS" target="_blank" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-mono text-xs font-bold transition flex items-center gap-2 shadow-lg shadow-emerald-600/20">
                        <span>💬 تواصل عبر واتساب</span>
                    </a>
                    <button type="button" onclick="goToSlide(1)" class="px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/15 text-white font-mono text-xs font-bold transition">
                        {{ app()->getLocale() === 'ar' ? 'إعادة العرض من البداية ↺' : 'Restart Deck ↺' }}
                    </button>
                </div>
            </div>

            <!-- Footer Navigation -->
            <div class="flex justify-between items-center pt-4 border-t border-white/10">
                <button type="button" onclick="goToSlide(7)" class="text-xs font-mono text-gray-400 hover:text-white">← {{ app()->getLocale() === 'ar' ? 'السابق' : 'Previous' }}</button>
                <span class="text-xs font-mono text-gray-500">END OF COMMERCIAL DECK</span>
            </div>
        </div>

    </main>

    <!-- Presentation Slide Script -->
    <script>
        const totalSlides = 8;
        let currentSlide = 1;

        const currentNumEl = document.getElementById('slide-num-current');
        const prevBtn = document.getElementById('btn-prev-slide');
        const nextBtn = document.getElementById('btn-next-slide');
        const panels = document.querySelectorAll('.slide-panel');

        function updateUI() {
            panels.forEach(p => {
                const s = parseInt(p.getAttribute('data-slide'));
                if (s === currentSlide) {
                    p.classList.add('active');
                } else {
                    p.classList.remove('active');
                }
            });

            if (currentNumEl) currentNumEl.textContent = currentSlide;
            if (prevBtn) prevBtn.disabled = currentSlide <= 1;
            if (nextBtn) nextBtn.disabled = currentSlide >= totalSlides;

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function goToSlide(n) {
            if (n >= 1 && n <= totalSlides) {
                currentSlide = n;
                updateUI();
            }
        }

        if (prevBtn) prevBtn.addEventListener('click', () => goToSlide(currentSlide - 1));
        if (nextBtn) nextBtn.addEventListener('click', () => goToSlide(currentSlide + 1));

        // Keyboard arrows navigation
        window.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight' || e.key === 'PageDown') {
                if (document.documentElement.dir === 'rtl') {
                    goToSlide(currentSlide - 1);
                } else {
                    goToSlide(currentSlide + 1);
                }
            } else if (e.key === 'ArrowLeft' || e.key === 'PageUp') {
                if (document.documentElement.dir === 'rtl') {
                    goToSlide(currentSlide + 1);
                } else {
                    goToSlide(currentSlide - 1);
                }
            }
        });

        updateUI();
    </script>

</body>
</html>
