<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Seed the storefront with authentic sneaker categories and shoes-only catalogue.
     */
    public function run(): void
    {
        $palette = [
            'black' => ['hex' => '#16161a', 'ar' => 'أسود', 'en' => 'Black'],
            'charcoal' => ['hex' => '#3a3a42', 'ar' => 'فحمي', 'en' => 'Charcoal'],
            'white' => ['hex' => '#f2f2f0', 'ar' => 'أبيض', 'en' => 'White'],
            'sand' => ['hex' => '#d9c7a7', 'ar' => 'رملي / شيل', 'en' => 'Sail / Sand'],
            'mocha' => ['hex' => '#5a3a28', 'ar' => 'موكا / بني', 'en' => 'Mocha Brown'],
            'red' => ['hex' => '#df0101', 'ar' => 'أحمر شيكاغو', 'en' => 'Chicago Red'],
            'royal' => ['hex' => '#1d4ed8', 'ar' => 'أزرق ملكي', 'en' => 'Royal Blue'],
            'emerald' => ['hex' => '#0f6b4f', 'ar' => 'أخضر باين', 'en' => 'Pine Green'],
            'violet' => ['hex' => '#a855f7', 'ar' => 'بنفسجي إلكتريك', 'en' => 'Electric Purple'],
            'grey' => ['hex' => '#9ca3af', 'ar' => 'رمادي كلاسيك', 'en' => 'Cool Grey'],
        ];

        $categories = collect([
            ['slug' => 'sneakers', 'name_ar' => 'كل السنيكرز', 'name_en' => 'All Sneakers', 'image' => 'images/store/products/air-jordan-1-retro.jpg', 'sort_order' => 1],
            ['slug' => 'retro', 'name_ar' => 'جوردان ريترو', 'name_en' => 'Jordan Retro', 'image' => 'images/store/products/air-jordan-4-retro.jpg', 'sort_order' => 2],
            ['slug' => 'basketball', 'name_ar' => 'كرة السلة والأداء', 'name_en' => 'Basketball Court', 'image' => 'images/store/products/jordan-jumpman-2021-pf.jpg', 'sort_order' => 3],
            ['slug' => 'lifestyle', 'name_ar' => 'ستريت وكاجوال', 'name_en' => 'Streetwear Lifestyle', 'image' => 'images/store/products/nike-dunk-low-panda.jpg', 'sort_order' => 4],
            ['slug' => 'exclusive', 'name_ar' => 'إصدارات حصرية', 'name_en' => 'Special Drops', 'image' => 'images/store/products/travis-scott-jordan-1-low.jpg', 'sort_order' => 5],
        ])->mapWithKeys(fn (array $data): array => [
            $data['slug'] => Category::updateOrCreate(['slug' => $data['slug']], $data),
        ]);

        $shoeSizes = ['40', '41', '42', '43', '44', '45'];

        $products = [
            [
                'category' => 'basketball', 'slug' => 'jordan-jumpman-2021-pf', 'garment' => 'shoe', 'image' => 'products/jordan-jumpman-2021-pf',
                'name_ar' => 'سنيكرز جوردان جمب مان 2021 PF', 'name_en' => 'Jordan Jumpman 2021 PF',
                'description_ar' => 'مستوحى من تصميم أحدث أحذية جوردان للمباريات. مزود بوحدة Zoom Air سريعة الاستجابة في مقدمة القدم وأسلاك Flightwire المقوسة لتثبيت محكم وأداء فائق.',
                'description_en' => 'Inspired by the design of the latest Air Jordan game shoe, the Jordan Jumpman 2021 PF helps up-and-coming players level up their game with responsive forefoot Zoom Air cushioning and arc-shaped Flightwire design.',
                'material_ar' => 'خامات شبكية خفيفة وجلد داعم مع وحدة Zoom Air', 'material_en' => 'Lightweight textile, genuine leather and responsive Zoom Air cushioning',
                'price' => 4150, 'old_price' => 4950, 'colors' => ['red', 'violet', 'emerald'], 'sizes' => $shoeSizes,
                'rating' => 4.9, 'reviews_count' => 1260, 'is_featured' => true, 'is_new' => true,
            ],
            [
                'category' => 'retro', 'slug' => 'air-jordan-1-retro', 'garment' => 'shoe', 'image' => 'products/air-jordan-1-retro',
                'name_ar' => 'سنيكرز إير جوردان 1 ريترو هاي OG "شيكاغو"', 'name_en' => 'Air Jordan 1 Retro High OG "Chicago"',
                'description_ar' => 'الأيقونة الأسطورية المستوحاة من ملاعب كرة السلة لعام 1985. جلد طبيعي فاخر بتدرجات شيكاغو الكلاسيكية، وحدة وسائد Nike Air المدمجة ونعل مطاطي عالي الثبات لأقصى راحة وأناقة في الشارع.',
                'description_en' => 'The legendary icon inspired by the 1985 basketball court classic. Crafted with premium genuine leather in Chicago red, white and black colorways, encapsulated Nike Air cushioning, and a high-traction rubber outsole.',
                'material_ar' => 'جلد طبيعي فاخر 100% مع نعل مطاطي مضغوط', 'material_en' => '100% Genuine leather upper, encapsulated Air-Sole unit',
                'price' => 4850, 'old_price' => 5600, 'colors' => ['red', 'black', 'white'], 'sizes' => $shoeSizes,
                'rating' => 4.9, 'reviews_count' => 1480, 'is_featured' => true, 'is_new' => true,
            ],
            [
                'category' => 'retro', 'slug' => 'air-jordan-4-retro', 'garment' => 'shoe', 'image' => 'products/air-jordan-4-retro',
                'name_ar' => 'سنيكرز إير جوردان 4 ريترو "ميليتري بلاك"', 'name_en' => 'Air Jordan 4 Retro "Military Black"',
                'description_ar' => 'تصميم ريترو أيقوني بأجنحة التثبيت الشهيرة وطبقات الشمواه الرمادي الفاخر مع شبكات التهوية الجانبية ووحدة Air-Sole الشفافة في الكعب.',
                'description_en' => 'Iconic retro silhouette featuring molded eyelet wings, premium grey suede mudguards, lateral mesh quarter panels, and visible Air-Sole heel unit.',
                'material_ar' => 'جلد طبيعي ناعم مع تفاصيل شمواه ونعل Air هوائي', 'material_en' => 'Smooth leather with premium suede overlays and visible Air-Sole unit',
                'price' => 5400, 'old_price' => 6200, 'colors' => ['white', 'black', 'grey'], 'sizes' => $shoeSizes,
                'rating' => 5.0, 'reviews_count' => 890, 'is_featured' => true, 'is_new' => true,
            ],
            [
                'category' => 'exclusive', 'slug' => 'travis-scott-jordan-1-low', 'garment' => 'shoe', 'image' => 'products/travis-scott-jordan-1-low',
                'name_ar' => 'سنيكرز ترافيس سكوت x جوردان 1 لو "ريفيرس موكا"', 'name_en' => 'Travis Scott x Air Jordan 1 Low "Reverse Mocha"',
                'description_ar' => 'التعاون الأيقوني الأكثر طلباً عالمياً بشعار السووش العكسي المميز، مزيج فريد بين جلد الشمواه البني والجلد الأبيض العاجي مع نعل فينتدج كلاسيكي.',
                'description_en' => 'The highly coveted collaboration featuring the iconic reversed Nike Swoosh, nubuck mocha panels paired with premium white leather overlays and a vintage sail midsole.',
                'material_ar' => 'جلد نوبوك طبيعي فاخر مع بطانة مسامية ناعمة', 'material_en' => 'Premium nubuck suede with tumbled leather and sail rubber cupsole',
                'price' => 8900, 'old_price' => 10500, 'colors' => ['mocha', 'sand', 'white'], 'sizes' => $shoeSizes,
                'rating' => 5.0, 'reviews_count' => 640, 'is_featured' => true, 'is_new' => true,
            ],
            [
                'category' => 'lifestyle', 'slug' => 'nike-dunk-low-panda', 'garment' => 'shoe', 'image' => 'products/nike-dunk-low-panda',
                'name_ar' => 'سنيكرز نايكي دانك لو ريترو "باندا"', 'name_en' => 'Nike Dunk Low Retro "Panda"',
                'description_ar' => 'السنيكرز الأكثر انتشاراً في ثقافة الستريت وير الكاجوال بلوني الأبيض والأسود الكلاسيكيين وتصميم منخفض الرقبة مريح للمشي طوال اليوم.',
                'description_en' => 'The ultimate streetwear staple rendered in crisp black and white two-tone blocking with a low-cut padded collar for all-day comfort.',
                'material_ar' => 'جلد طبيعي متين مع نعل مطاطي بنقوش تماسك دائرية', 'material_en' => 'Durable leather upper with pivot-circle rubber outsole',
                'price' => 3200, 'old_price' => 3800, 'colors' => ['black', 'white'], 'sizes' => $shoeSizes,
                'rating' => 4.8, 'reviews_count' => 2150, 'is_featured' => true, 'is_new' => false,
            ],
            [
                'category' => 'retro', 'slug' => 'air-jordan-1-royal', 'garment' => 'shoe', 'image' => 'products/air-jordan-1-royal',
                'name_ar' => 'سنيكرز إير جوردان 1 ريترو هاي "رويال بلو"', 'name_en' => 'Air Jordan 1 Retro High "Royal Blue"',
                'description_ar' => 'اللون الأزرق الملكي الكلاسيكي من إصدارات 1985 الأولى لجوردان، مصنوع من أجود أنواع الجلود الطبيعية بشعار Wings الأسطوري.',
                'description_en' => 'The legendary original 1985 Royal Blue colorway built with supple tumbled leather and the iconic embossed Jordan Wings emblem.',
                'material_ar' => 'جلد طبيعي فاخر 100% مع نعل هواء مضغوط', 'material_en' => '100% Premium leather with encapsulated Nike Air unit',
                'price' => 4600, 'old_price' => 5200, 'colors' => ['royal', 'black', 'white'], 'sizes' => $shoeSizes,
                'rating' => 4.9, 'reviews_count' => 740, 'is_featured' => true, 'is_new' => false,
            ],
            [
                'category' => 'retro', 'slug' => 'air-jordan-1-shadow', 'garment' => 'shoe', 'image' => 'products/air-jordan-1-shadow',
                'name_ar' => 'سنيكرز إير جوردان 1 ريترو "شادو بلاك"', 'name_en' => 'Air Jordan 1 Retro "Shadow 2.0"',
                'description_ar' => 'مزيج هادئ وفخم بين الجلد الأسود غير اللامع وطبقات الشمواه الرمادي الدخاني، اختيار مثالي للإطلالات الرسمية والشارع على حد سواء.',
                'description_en' => 'Stealthy sophistication combining matte black leather with smokey grey suede overlays for versatile daily streetwear.',
                'material_ar' => 'جلد طبيعي وشمواه رمادي فاخر', 'material_en' => 'Genuine matte leather and smokey grey suede',
                'price' => 4450, 'old_price' => 5100, 'colors' => ['charcoal', 'black', 'grey'], 'sizes' => $shoeSizes,
                'rating' => 4.8, 'reviews_count' => 520, 'is_featured' => false, 'is_new' => false,
            ],
            [
                'category' => 'retro', 'slug' => 'air-jordan-1-green', 'garment' => 'shoe', 'image' => 'products/air-jordan-1-green',
                'name_ar' => 'سنيكرز إير جوردان 1 هاي "باين جرين"', 'name_en' => 'Air Jordan 1 Retro High "Pine Green"',
                'description_ar' => 'تدرجات الأخضر الزمردي الأنيق المستوحاة من ألوان الملاعب الكلاسيكية، كعب مدعم ونعل مرن مريح طوال اليوم.',
                'description_en' => 'Vibrant emerald Pine Green colorblocking paying homage to classic hardwood rivalry with locked-in ankle support.',
                'material_ar' => 'جلد طبيعي محبب عالي الجودة', 'material_en' => 'Full-grain pebbled leather and responsive rubber outsole',
                'price' => 4350, 'old_price' => 4950, 'colors' => ['emerald', 'black', 'white'], 'sizes' => $shoeSizes,
                'rating' => 4.7, 'reviews_count' => 380, 'is_featured' => false, 'is_new' => false,
            ],
        ];

        // Clean out legacy non-shoe products to keep storefront exclusively for shoes
        Product::query()->whereNotIn('slug', collect($products)->pluck('slug'))->delete();

        foreach ($products as $data) {
            $category = $categories[$data['category']] ?? $categories['sneakers'];

            Product::updateOrCreate(['slug' => $data['slug']], [
                ...collect($data)->except(['category', 'image', 'colors'])->all(),
                'category_id' => $category->id,
                'image' => "images/store/products/{$data['slug']}.jpg",
                'colors' => collect($data['colors'])->map(fn (string $key): array => $palette[$key] ?? ['hex' => '#df0101', 'ar' => 'أحمر', 'en' => 'Red'])->all(),
                'stock' => 45,
            ]);
        }
    }
}
