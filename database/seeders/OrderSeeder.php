<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Seed sample realistic sneaker orders.
     */
    public function run(): void
    {
        if (Order::count() > 0) {
            return;
        }

        $products = Product::all();
        if ($products->isEmpty()) {
            return;
        }

        $sampleOrders = [
            [
                'customer_name' => 'أحمد محمود سليمان',
                'customer_phone' => '01012345678',
                'customer_email' => 'ahmed.soliman@gmail.com',
                'governorate' => 'القاهرة',
                'city' => 'مدينة نصر',
                'shipping_address' => 'شارع عباس العقاد، عمارة 14، الدور الخامس',
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'status' => 'pending',
                'notes' => 'يرجى الاتصال قبل الوصول بنصف ساعة للمعاينة.',
                'items' => [
                    ['slug' => 'jordan-jumpman-2021-pf', 'size' => '42', 'color' => 'أحمر شيكاغو', 'hex' => '#df0101', 'qty' => 1],
                ],
            ],
            [
                'customer_name' => 'محمد طارق إبراهيم',
                'customer_phone' => '01198765432',
                'customer_email' => 'm.tarek@outlook.com',
                'governorate' => 'الجيزة',
                'city' => 'الشيخ زايد',
                'shipping_address' => 'كمبوند الياسمين، فيلا 22',
                'payment_method' => 'instapay',
                'payment_status' => 'paid',
                'status' => 'processing',
                'notes' => 'تم التحويل عبر إنستاباي بنجاح.',
                'items' => [
                    ['slug' => 'air-jordan-1-retro', 'size' => '43', 'color' => 'أحمر شيكاغو', 'hex' => '#df0101', 'qty' => 1],
                    ['slug' => 'nike-dunk-low-panda', 'size' => '41', 'color' => 'أسود', 'hex' => '#16161a', 'qty' => 1],
                ],
            ],
            [
                'customer_name' => 'سارة كريم خليل',
                'customer_phone' => '01234567890',
                'customer_email' => 'sara.kareem@yahoo.com',
                'governorate' => 'الإسكندرية',
                'city' => 'سموحة',
                'shipping_address' => 'شارع فوزي معاذ، برج النخيل، شقة 10',
                'payment_method' => 'card',
                'payment_status' => 'paid',
                'status' => 'shipped',
                'notes' => 'توصيل خلال أوقات العمل الرسمية.',
                'items' => [
                    ['slug' => 'air-jordan-4-retro', 'size' => '40', 'color' => 'أبيض', 'hex' => '#f2f2f0', 'qty' => 1],
                ],
            ],
            [
                'customer_name' => 'عمر خالد المنشاوي',
                'customer_phone' => '01511223344',
                'customer_email' => 'omar.khaled@gmail.com',
                'governorate' => 'الدقهلية',
                'city' => 'المنصورة',
                'shipping_address' => 'شارع المشاية السفلية أمام النادي',
                'payment_method' => 'cod',
                'payment_status' => 'paid',
                'status' => 'delivered',
                'notes' => 'تم الاستلام والدفع كاش.',
                'items' => [
                    ['slug' => 'travis-scott-jordan-1-low', 'size' => '44', 'color' => 'موكا / بني', 'hex' => '#5a3a28', 'qty' => 1],
                ],
            ],
            [
                'customer_name' => 'يوسف عبد الرحمن',
                'customer_phone' => '01099887766',
                'customer_email' => 'youssef.ar@gmail.com',
                'governorate' => 'القاهرة',
                'city' => 'التجمع الخامس',
                'shipping_address' => 'الحي الأول، ش 90 الشمالي',
                'payment_method' => 'cod',
                'payment_status' => 'paid',
                'status' => 'delivered',
                'notes' => '',
                'items' => [
                    ['slug' => 'air-jordan-1-retro', 'size' => '42', 'color' => 'أزرق ملكي', 'hex' => '#1d4ed8', 'qty' => 1],
                ],
            ],
        ];

        foreach ($sampleOrders as $index => $data) {
            $itemsData = $data['items'];
            unset($data['items']);

            $subtotal = 0;
            $orderItems = [];

            foreach ($itemsData as $itemInfo) {
                $product = $products->firstWhere('slug', $itemInfo['slug']) ?? $products->first();
                $itemPrice = $product->price;
                $itemTotal = $itemPrice * $itemInfo['qty'];
                $subtotal += $itemTotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name_ar,
                    'product_image' => $product->image,
                    'size' => $itemInfo['size'],
                    'color_label' => $itemInfo['color'],
                    'color_hex' => $itemInfo['hex'],
                    'price' => $itemPrice,
                    'quantity' => $itemInfo['qty'],
                    'total' => $itemTotal,
                ];
            }

            $discount = $subtotal > 4000 ? 500 : 0;
            $shipping = $subtotal >= 2000 ? 0 : 75;
            $total = $subtotal - $discount + $shipping;

            $order = Order::create([
                ...$data,
                'order_number' => 'JRD-'.(849000 + $index),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_fee' => $shipping,
                'total' => $total,
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }
        }
    }
}
