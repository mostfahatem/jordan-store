<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'governorate',
        'city',
        'shipping_address',
        'payment_method',
        'payment_status',
        'status',
        'subtotal',
        'discount',
        'shipping_fee',
        'total',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'shipping_fee' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    /**
     * Relationship to ordered sneaker items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relationship to user if authenticated.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate unique Nike/Jordan order number (e.g. JRD-89412).
     */
    public static function generateOrderNumber(): string
    {
        do {
            $number = 'JRD-'.random_int(100000, 999999);
        } while (self::where('order_number', $number)->exists());

        return $number;
    }

    /**
     * Scope for filtering orders by status.
     */
    public function scopeFilterStatus(Builder $query, ?string $status): Builder
    {
        if ($status && in_array($status, ['pending', 'processing', 'shipped', 'delivered', 'cancelled'], true)) {
            return $query->where('status', $status);
        }

        return $query;
    }

    /**
     * Localized status label.
     */
    public function getStatusLabelAttribute(): string
    {
        $isAr = app()->getLocale() === 'ar';

        return match ($this->status) {
            'processing' => $isAr ? 'قيد التجهيز' : 'Processing',
            'shipped' => $isAr ? 'تم الشحن' : 'Shipped',
            'delivered' => $isAr ? 'تم التسليم' : 'Delivered',
            'cancelled' => $isAr ? 'ملغي' : 'Cancelled',
            default => $isAr ? 'بانتظار التأكيد' : 'Pending Confirmation',
        };
    }

    /**
     * Tailwind classes for status pill.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'processing' => 'bg-blue-500/20 text-blue-400 border border-blue-500/30',
            'shipped' => 'bg-purple-500/20 text-purple-400 border border-purple-500/30',
            'delivered' => 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30',
            'cancelled' => 'bg-rose-500/20 text-rose-400 border border-rose-500/30',
            default => 'bg-amber-500/20 text-amber-400 border border-amber-500/30',
        };
    }

    /**
     * Localized payment method label.
     */
    public function getPaymentMethodLabelAttribute(): string
    {
        $isAr = app()->getLocale() === 'ar';

        return match ($this->payment_method) {
            'instapay' => $isAr ? 'إنستاباي / محفظة إلكترونية' : 'InstaPay / Wallet',
            'card' => $isAr ? 'بطاقة بنكية (فيزا/ماستركارد)' : 'Debit / Credit Card',
            default => $isAr ? 'الدفع عند الاستلام (COD)' : 'Cash on Delivery (COD)',
        };
    }

    /**
     * Localized payment status label.
     */
    public function getPaymentStatusLabelAttribute(): string
    {
        $isAr = app()->getLocale() === 'ar';

        return match ($this->payment_status) {
            'paid' => $isAr ? 'تم الدفع بنجاح' : 'Paid',
            'failed' => $isAr ? 'فشل الدفع' : 'Payment Failed',
            default => $isAr ? 'بانتظار التحصيل' : 'Pending Payment',
        };
    }
}
