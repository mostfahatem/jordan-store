/**
 * Shopping Cart & Checkout System for NOVA 3D Store
 */

const STORAGE_KEY = 'nova_cart_v1';
const FREE_SHIPPING_THRESHOLD = 2000;

class CartManager {
    constructor() {
        this.items = this.load();
        this.discount = 0; // percentage, e.g. 0.2
        this.promoCode = null;
        this.initUI();
    }

    load() {
        try {
            const raw = localStorage.getItem(STORAGE_KEY);
            return raw ? JSON.parse(raw) : [];
        } catch {
            return [];
        }
    }

    save() {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(this.items));
        } catch (e) {
            console.error(e);
        }
        this.render();
    }

    addItem(item) {
        // match by id, size, and color hex
        const existing = this.items.find(
            (i) => i.id === item.id && i.size === item.size && i.color.hex === item.color.hex
        );

        if (existing) {
            existing.quantity += item.quantity || 1;
        } else {
            this.items.push({
                ...item,
                quantity: item.quantity || 1,
            });
        }

        this.save();
        this.openDrawer();
        this.showToast(document.documentElement.lang === 'ar' ? 'تمت إضافة المنتج إلى السلة بنجاح ✨' : 'Item added to your cart ✨');
    }

    removeItem(id, size, hex) {
        this.items = this.items.filter(
            (i) => !(i.id === id && i.size === size && i.color.hex === hex)
        );
        this.save();
    }

    updateQuantity(id, size, hex, delta) {
        const item = this.items.find(
            (i) => i.id === id && i.size === size && i.color.hex === hex
        );
        if (!item) return;

        item.quantity += delta;
        if (item.quantity <= 0) {
            this.removeItem(id, size, hex);
        } else {
            this.save();
        }
    }

    clear() {
        this.items = [];
        this.discount = 0;
        this.promoCode = null;
        this.save();
    }

    getSubtotal() {
        return this.items.reduce((sum, item) => sum + item.price * item.quantity, 0);
    }

    getTotal() {
        const subtotal = this.getSubtotal();
        const discountAmount = subtotal * this.discount;
        const shipping = subtotal >= FREE_SHIPPING_THRESHOLD || subtotal === 0 ? 0 : 75;
        return Math.max(0, subtotal - discountAmount + shipping);
    }

    getCount() {
        return this.items.reduce((sum, item) => sum + item.quantity, 0);
    }

    initUI() {
        // Open / close drawer
        const openBtns = document.querySelectorAll('[data-cart-open]');
        const closeBtn = document.getElementById('cart-drawer-close');
        const backdrop = document.getElementById('cart-drawer-backdrop');
        const drawer = document.getElementById('cart-drawer');

        openBtns.forEach((b) => b.addEventListener('click', () => this.openDrawer()));
        if (closeBtn) closeBtn.addEventListener('click', () => this.closeDrawer());
        if (backdrop) backdrop.addEventListener('click', () => this.closeDrawer());

        // Promo code form
        const promoBtn = document.getElementById('apply-promo-btn');
        const promoInput = document.getElementById('promo-code-input');
        if (promoBtn && promoInput) {
            promoBtn.addEventListener('click', () => {
                const code = promoInput.value.trim().toUpperCase();
                const isAr = document.documentElement.lang === 'ar';
                if (code === 'JORDAN20' || code === 'NOVA20') {
                    this.discount = 0.2;
                    this.promoCode = code;
                    this.showToast(isAr ? 'تم تطبيق خصم 20% بنجاح! 🎉' : '20% Discount applied! 🎉');
                    this.render();
                } else if (code.length > 0) {
                    this.showToast(isAr ? 'كوبون غير صالح' : 'Invalid promo code');
                }
            });
        }

        // Checkout modal triggers
        const checkoutBtn = document.getElementById('open-checkout-modal-btn');
        const checkoutModal = document.getElementById('checkout-modal');
        const closeCheckoutBtn = document.getElementById('close-checkout-modal-btn');
        const checkoutBackdrop = document.getElementById('checkout-modal-backdrop');

        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', () => {
                if (this.items.length === 0) return;
                this.closeDrawer();
                this.openCheckoutModal();
            });
        }
        if (closeCheckoutBtn) closeCheckoutBtn.addEventListener('click', () => this.closeCheckoutModal());
        if (checkoutBackdrop) checkoutBackdrop.addEventListener('click', () => this.closeCheckoutModal());

        // Checkout submit
        const checkoutForm = document.getElementById('checkout-form');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleCheckoutSubmit(checkoutForm);
            });
        }

        this.render();
    }

    openDrawer() {
        const drawer = document.getElementById('cart-drawer');
        const backdrop = document.getElementById('cart-drawer-backdrop');
        if (drawer) {
            drawer.classList.remove('translate-x-full', '-translate-x-full', 'pointer-events-none');
            drawer.classList.add('translate-x-0');
        }
        if (backdrop) {
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            backdrop.classList.add('opacity-100');
        }
    }

    closeDrawer() {
        const drawer = document.getElementById('cart-drawer');
        const backdrop = document.getElementById('cart-drawer-backdrop');
        const isRtl = document.documentElement.dir === 'rtl';
        if (drawer) {
            drawer.classList.remove('translate-x-0');
            drawer.classList.add(isRtl ? '-translate-x-full' : 'translate-x-full', 'pointer-events-none');
        }
        if (backdrop) {
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
        }
    }

    openCheckoutModal() {
        const modal = document.getElementById('checkout-modal');
        if (modal) {
            modal.classList.remove('hidden');
            this.renderCheckoutSummary();
        }
    }

    closeCheckoutModal() {
        const modal = document.getElementById('checkout-modal');
        if (modal) modal.classList.add('hidden');
    }

    async handleCheckoutSubmit(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const errorBox = document.getElementById('checkout-error-msg');
        if (errorBox) {
            errorBox.classList.add('hidden');
            errorBox.textContent = '';
        }

        const isAr = document.documentElement.lang === 'ar';
        const originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';

        if (!this.items || this.items.length === 0) {
            this.showToast(isAr ? 'سلة المشتريات فارغة!' : 'Your cart is empty!');
            return;
        }

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-900 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                ${isAr ? 'جاري تأكيد الطلب وحجز السنيكرز...' : 'Confirming order & reserving sneaker...'}
            `;
        }

        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = tokenMeta ? tokenMeta.getAttribute('content') : '';

        const formData = new FormData(form);
        const payload = {
            customer_name: formData.get('customer_name') || '',
            customer_phone: formData.get('customer_phone') || '',
            customer_email: formData.get('customer_email') || null,
            governorate: formData.get('governorate') || '',
            city: formData.get('city') || '',
            shipping_address: formData.get('shipping_address') || '',
            payment_method: formData.get('payment_method') || 'cod',
            notes: formData.get('notes') || null,
            promo_code: this.promoCode || (this.discount > 0 ? 'JORDAN20' : null),
            items: this.items.map((i) => ({
                id: i.id,
                name: i.name,
                size: String(i.size),
                price: Number(i.price),
                quantity: Number(i.quantity || 1),
                color: i.color || { name: 'Default', hex: '#111', label: 'Default' },
                image: i.image || null,
            })),
        };

        try {
            const response = await fetch('/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json();

            if (!response.ok) {
                let msg = data.message || (isAr ? 'حدث خطأ أثناء إتمام الطلب، يرجى المحاولة مرة أخرى.' : 'Error placing order, please try again.');
                if (data.errors) {
                    const firstKey = Object.keys(data.errors)[0];
                    msg = data.errors[firstKey][0];
                }
                if (errorBox) {
                    errorBox.textContent = msg;
                    errorBox.classList.remove('hidden');
                } else {
                    this.showToast(msg);
                }
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHtml;
                }
                return;
            }

            // Success! Clear cart
            this.clear();

            if (data.redirect_url) {
                window.location.href = data.redirect_url;
            } else if (data.order && data.order.order_number) {
                window.location.href = '/orders/' + data.order.order_number;
            } else {
                window.location.href = '/shop';
            }
        } catch (err) {
            console.error('Checkout error:', err);
            const msg = isAr ? 'تعذر الاتصال بالخادم، يرجى التحقق من اتصال الإنترنت.' : 'Could not reach server, please check network.';
            if (errorBox) {
                errorBox.textContent = msg;
                errorBox.classList.remove('hidden');
            } else {
                this.showToast(msg);
            }
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
            }
        }
    }

    renderCheckoutSummary() {
        const container = document.getElementById('checkout-items-summary');
        if (!container) return;

        const isAr = document.documentElement.lang === 'ar';
        const subtotal = this.getSubtotal();
        const discountAmount = subtotal * this.discount;
        const shipping = subtotal >= FREE_SHIPPING_THRESHOLD || subtotal === 0 ? 0 : 75;
        const total = this.getTotal();

        let html = `
            <div class="space-y-3 max-h-60 overflow-y-auto pr-2 mb-4">
        `;

        this.items.forEach((item) => {
            html += `
                <div class="flex items-center gap-3 p-2 rounded-lg bg-white/5 border border-white/5">
                    <img src="${item.image}" alt="${item.name}" class="w-12 h-12 object-cover rounded-md" />
                    <div class="flex-1 min-w-0">
                        <div class="text-xs font-semibold text-white truncate">${item.name}</div>
                        <div class="text-[11px] text-gray-400 flex items-center gap-2 mt-0.5">
                            <span>${item.size}</span>
                            <span class="w-2.5 h-2.5 rounded-full inline-block" style="background-color: ${item.color.hex}"></span>
                            <span>× ${item.quantity}</span>
                        </div>
                    </div>
                    <div class="text-xs font-bold text-cyan-400">${(item.price * item.quantity).toLocaleString()} ${isAr ? 'ج.م' : 'EGP'}</div>
                </div>
            `;
        });

        html += `
            </div>
            <div class="border-t border-white/10 pt-3 space-y-1.5 text-xs text-gray-300">
                <div class="flex justify-between">
                    <span>${isAr ? 'المجموع الفرعي:' : 'Subtotal:'}</span>
                    <span class="font-medium text-white">${subtotal.toLocaleString()} ${isAr ? 'ج.م' : 'EGP'}</span>
                </div>
                ${this.discount > 0 ? `
                <div class="flex justify-between text-emerald-400">
                    <span>${isAr ? 'الخصم (20%):' : 'Discount (20%):'}</span>
                    <span>-${discountAmount.toLocaleString()} ${isAr ? 'ج.م' : 'EGP'}</span>
                </div>` : ''}
                <div class="flex justify-between">
                    <span>${isAr ? 'الشحن:' : 'Shipping:'}</span>
                    <span class="${shipping === 0 ? 'text-emerald-400 font-bold' : 'text-white'}">
                        ${shipping === 0 ? (isAr ? 'مجاني' : 'FREE') : `${shipping} ${isAr ? 'ج.م' : 'EGP'}`}
                    </span>
                </div>
                <div class="flex justify-between text-sm font-bold text-white pt-2 border-t border-white/10">
                    <span>${isAr ? 'الإجمالي النهائي:' : 'Total:'}</span>
                    <span class="text-cyan-400">${total.toLocaleString()} ${isAr ? 'ج.م' : 'EGP'}</span>
                </div>
            </div>
        `;

        container.innerHTML = html;
    }

    render() {
        const countBadges = document.querySelectorAll('[data-cart-count]');
        const count = this.getCount();
        countBadges.forEach((b) => {
            b.textContent = count;
            b.classList.toggle('hidden', count === 0);
        });

        const itemsContainer = document.getElementById('cart-drawer-items');
        const emptyState = document.getElementById('cart-drawer-empty');
        const footer = document.getElementById('cart-drawer-footer');
        const isAr = document.documentElement.lang === 'ar';

        if (!itemsContainer) return;

        if (this.items.length === 0) {
            itemsContainer.innerHTML = '';
            if (emptyState) emptyState.classList.remove('hidden');
            if (footer) footer.classList.add('hidden');
            return;
        }

        if (emptyState) emptyState.classList.add('hidden');
        if (footer) footer.classList.remove('hidden');

        // Free Shipping Bar
        const subtotal = this.getSubtotal();
        const freeShippingBar = document.getElementById('cart-free-shipping-bar');
        const freeShippingText = document.getElementById('cart-free-shipping-text');
        if (freeShippingBar && freeShippingText) {
            const percent = Math.min(100, (subtotal / FREE_SHIPPING_THRESHOLD) * 100);
            freeShippingBar.style.width = `${percent}%`;
            if (subtotal >= FREE_SHIPPING_THRESHOLD) {
                freeShippingText.innerHTML = isAr ? '🎉 مبروك! حصلت على <b>شحن مجاني</b>' : '🎉 You unlocked <b>FREE Shipping</b>!';
            } else {
                const diff = (FREE_SHIPPING_THRESHOLD - subtotal).toLocaleString();
                freeShippingText.innerHTML = isAr
                    ? `أضف بقيمة <b>${diff} ج.م</b> إضافية للحصول على شحن مجاني`
                    : `Add <b>${diff} EGP</b> more to get FREE shipping`;
            }
        }

        // Subtotal & Total
        const subtotalEl = document.getElementById('cart-subtotal');
        const totalEl = document.getElementById('cart-total');
        if (subtotalEl) subtotalEl.textContent = `${subtotal.toLocaleString()} ${isAr ? 'ج.م' : 'EGP'}`;
        if (totalEl) totalEl.textContent = `${this.getTotal().toLocaleString()} ${isAr ? 'ج.م' : 'EGP'}`;

        // Build list
        let html = '';
        this.items.forEach((item) => {
            html += `
                <div class="flex gap-4 p-3.5 rounded-2xl bg-white/5 border border-white/5 hover:border-violet-500/30 transition-all">
                    <img src="${item.image}" alt="${item.name}" class="w-20 h-24 object-cover rounded-xl bg-black/40 flex-shrink-0" />
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start gap-2">
                                <h4 class="font-semibold text-sm text-white line-clamp-1">${item.name}</h4>
                                <button type="button" onclick="window.novaCart.removeItem(${item.id}, '${item.size}', '${item.color.hex}')" class="text-gray-400 hover:text-red-400 transition p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex items-center gap-2 mt-1 text-xs text-gray-400">
                                <span class="px-2 py-0.5 rounded-md bg-white/10 text-gray-300 font-mono">${item.size}</span>
                                <span class="flex items-center gap-1.5">
                                    <span class="w-3 h-3 rounded-full border border-white/30" style="background-color: ${item.color.hex}"></span>
                                    <span>${item.color.label}</span>
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            <span class="font-bold text-sm text-cyan-400">${(item.price * item.quantity).toLocaleString()} ${isAr ? 'ج.م' : 'EGP'}</span>
                            <div class="flex items-center border border-white/10 rounded-lg bg-black/40 overflow-hidden">
                                <button type="button" onclick="window.novaCart.updateQuantity(${item.id}, '${item.size}', '${item.color.hex}', -1)" class="w-7 h-7 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 transition">
                                    -
                                </button>
                                <span class="w-8 text-center text-xs font-semibold text-white">${item.quantity}</span>
                                <button type="button" onclick="window.novaCart.updateQuantity(${item.id}, '${item.size}', '${item.color.hex}', 1)" class="w-7 h-7 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 transition">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        itemsContainer.innerHTML = html;
    }

    showToast(message) {
        let toast = document.getElementById('nova-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'nova-toast';
            toast.className = 'fixed bottom-6 end-6 z-50 glass-panel-glow text-white px-5 py-3 rounded-2xl flex items-center gap-3 shadow-2xl transition-all duration-300 transform translate-y-16 opacity-0';
            document.body.appendChild(toast);
        }

        toast.innerHTML = `
            <div class="w-2.5 h-2.5 rounded-full bg-cyan-400 animate-ping"></div>
            <span class="text-sm font-medium">${message}</span>
        `;

        toast.classList.remove('translate-y-16', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-16', 'opacity-0');
        }, 3200);
    }
}

export function initCart() {
    window.novaCart = new CartManager();
}
