import { initHero3D } from './hero3d.js';
import { initHeroVideo } from './hero-video.js';
import { initJordanHero } from './jordan-hero.js';
import { initCart } from './cart.js';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Cart
    initCart();

    // 2. Initialize Interactive Hero Video, 3D Hero, and Jordan Shoes Showcase
    initHeroVideo();
    initJordanHero();
    if (document.getElementById('hero-3d-canvas')) {
        initHero3D();
    }

    // 3. 3D Product Studio is initialised lazily when its tab is opened (see section 6)

    // 4. Mobile Navigation Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // 5. Quick Add To Cart from Product Cards
    document.querySelectorAll('[data-quick-add]').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();

            const raw = btn.getAttribute('data-quick-add');
            try {
                const data = JSON.parse(raw);
                window.novaCart.addItem({
                    id: data.id,
                    name: data.name,
                    slug: data.slug,
                    price: parseFloat(data.price),
                    image: data.image,
                    color: (data.colors && data.colors[0]) || { hex: '#16161a', label: 'Default' },
                    size: (data.sizes && data.sizes[0]) || 'M',
                    quantity: 1,
                });
            } catch (err) {
                console.error('Error adding item', err);
            }
        });
    });

    // 6. Product Detail Page Interactions
    const wrapperPhoto = document.getElementById('product-photo-wrapper');

    // Photo: 360 spin viewer (drag to rotate) when multi-angle frames exist
    if (wrapperPhoto && wrapperPhoto.dataset.spinFrames) {
        const frameUrls = JSON.parse(wrapperPhoto.dataset.spinFrames);
        const spinHint = wrapperPhoto.querySelector('span');
        const baseImg = document.getElementById('product-photo-img');
        if (baseImg) baseImg.classList.add('hidden');
        if (spinHint) spinHint.textContent = document.documentElement.lang === 'ar' ? 'اسحب لتدوير المنتج 360°' : 'Drag to rotate 360°';

        // front, side, back, then the side frame mirrored to complete the loop
        const frameEls = [...frameUrls, frameUrls[1]].map((url, index) => {
            const img = document.createElement('img');
            img.src = url;
            img.alt = '';
            img.draggable = false;
            img.className = 'absolute inset-0 w-full h-full object-cover pointer-events-none';
            img.style.transform = index === 3 ? 'scaleX(-1)' : 'none';
            img.style.opacity = index === 0 ? '1' : '0';
            wrapperPhoto.insertBefore(img, wrapperPhoto.firstChild);
            return img;
        });

        const frameCount = frameEls.length;
        let position = 0;
        let isSpinDragging = false;
        let lastX = 0;
        let autoSpin = true;
        let resumeTimer = null;

        const renderSpin = () => {
            frameEls.forEach((img, i) => {
                let distance = Math.abs(position - i);
                distance = Math.min(distance, frameCount - distance);
                img.style.opacity = String(Math.max(0, 1 - distance));
            });
        };

        const pauseAutoSpin = () => {
            autoSpin = false;
            clearTimeout(resumeTimer);
            resumeTimer = setTimeout(() => { autoSpin = true; }, 3500);
        };

        wrapperPhoto.classList.replace('cursor-zoom-in', 'cursor-grab');

        wrapperPhoto.addEventListener('pointerdown', (e) => {
            isSpinDragging = true;
            lastX = e.clientX;
            pauseAutoSpin();
            wrapperPhoto.setPointerCapture(e.pointerId);
        });

        wrapperPhoto.addEventListener('pointermove', (e) => {
            if (!isSpinDragging) return;
            position = (position - (e.clientX - lastX) * 0.012 + frameCount) % frameCount;
            lastX = e.clientX;
            pauseAutoSpin();
            renderSpin();
        });

        const endSpinDrag = () => { isSpinDragging = false; };
        wrapperPhoto.addEventListener('pointerup', endSpinDrag);
        wrapperPhoto.addEventListener('pointercancel', endSpinDrag);

        const tickSpin = () => {
            if (autoSpin && !isSpinDragging && !wrapperPhoto.classList.contains('hidden')) {
                position = (position + 0.006) % frameCount;
                renderSpin();
            }
            requestAnimationFrame(tickSpin);
        };
        requestAnimationFrame(tickSpin);
    }

    // Photo: subtle 3D tilt following the cursor + click to zoom (single-image products)
    const photoImg = document.getElementById('product-photo-img');
    if (photoImg && wrapperPhoto && !wrapperPhoto.dataset.spinFrames) {
        let zoomed = false;

        const resetPhoto = () => {
            photoImg.style.transform = zoomed ? 'scale(1.8)' : 'rotateX(0) rotateY(0) scale(1)';
        };

        wrapperPhoto.addEventListener('mousemove', (e) => {
            const rect = wrapperPhoto.getBoundingClientRect();
            const px = (e.clientX - rect.left) / rect.width - 0.5;
            const py = (e.clientY - rect.top) / rect.height - 0.5;

            if (zoomed) {
                photoImg.style.transformOrigin = `${(px + 0.5) * 100}% ${(py + 0.5) * 100}%`;
                photoImg.style.transform = 'scale(1.8)';
            } else {
                photoImg.style.transformOrigin = '50% 50%';
                photoImg.style.transform = `rotateY(${px * 8}deg) rotateX(${-py * 8}deg) scale(1.03)`;
            }
        });

        wrapperPhoto.addEventListener('mouseleave', () => {
            zoomed = false;
            wrapperPhoto.classList.add('cursor-zoom-in');
            wrapperPhoto.classList.remove('cursor-zoom-out');
            photoImg.style.transformOrigin = '50% 50%';
            resetPhoto();
        });

        wrapperPhoto.addEventListener('click', () => {
            zoomed = !zoomed;
            wrapperPhoto.classList.toggle('cursor-zoom-in', !zoomed);
            wrapperPhoto.classList.toggle('cursor-zoom-out', zoomed);
            resetPhoto();
        });
    }

    // Color swatches selector on Product Detail Page
    const colorSwatches = document.querySelectorAll('[data-product-color-choice]');
    const colorNameDisplay = document.getElementById('selected-color-name');
    let selectedColor = null;

    if (colorSwatches.length > 0) {
        selectedColor = {
            hex: colorSwatches[0].getAttribute('data-product-color-choice'),
            label: colorSwatches[0].getAttribute('data-product-color-name'),
        };

        colorSwatches.forEach((swatch) => {
            swatch.addEventListener('click', () => {
                colorSwatches.forEach((s) => s.classList.remove('ring-4', 'ring-cyan-400', 'scale-110'));
                swatch.classList.add('ring-4', 'ring-cyan-400', 'scale-110');

                const hex = swatch.getAttribute('data-product-color-choice');
                const label = swatch.getAttribute('data-product-color-name');
                selectedColor = { hex, label };

                if (colorNameDisplay) colorNameDisplay.textContent = label;

                // Sync 3D viewer color!
                if (window.set3DColor) {
                    window.set3DColor(hex);
                }
            });
        });
    }

    // Size selector on Product Detail Page
    const sizePills = document.querySelectorAll('[data-product-size-choice]');
    let selectedSize = sizePills.length > 0 ? sizePills[0].getAttribute('data-product-size-choice') : 'M';

    sizePills.forEach((pill) => {
        pill.addEventListener('click', () => {
            sizePills.forEach((p) => {
                p.classList.remove('bg-cyan-400', 'text-black', 'font-bold', 'border-cyan-400');
                p.classList.add('bg-white/5', 'text-gray-300', 'border-white/10');
            });
            pill.classList.add('bg-cyan-400', 'text-black', 'font-bold', 'border-cyan-400');
            pill.classList.remove('bg-white/5', 'text-gray-300', 'border-white/10');

            selectedSize = pill.getAttribute('data-product-size-choice');
        });
    });

    // Quantity selector on Product Detail Page
    const qtyInput = document.getElementById('product-qty-input');
    const qtyMinus = document.getElementById('product-qty-minus');
    const qtyPlus = document.getElementById('product-qty-plus');

    if (qtyInput && qtyMinus && qtyPlus) {
        qtyMinus.addEventListener('click', () => {
            let val = parseInt(qtyInput.value) || 1;
            if (val > 1) qtyInput.value = val - 1;
        });
        qtyPlus.addEventListener('click', () => {
            let val = parseInt(qtyInput.value) || 1;
            qtyInput.value = val + 1;
        });
    }

    // "Add to Cart" Button on Product Detail Page
    const detailAddToCartBtn = document.getElementById('product-detail-add-cart');
    if (detailAddToCartBtn) {
        detailAddToCartBtn.addEventListener('click', () => {
            const raw = detailAddToCartBtn.getAttribute('data-product');
            try {
                const product = JSON.parse(raw);
                const qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;

                window.novaCart.addItem({
                    id: product.id,
                    name: product.name,
                    slug: product.slug,
                    price: parseFloat(product.price),
                    image: product.image,
                    color: selectedColor || (product.colors && product.colors[0]) || { hex: '#16161a', label: 'Default' },
                    size: selectedSize,
                    quantity: qty,
                });
            } catch (err) {
                console.error(err);
            }
        });
    }

    // "Buy Now" Button triggers checkout directly
    const buyNowBtn = document.getElementById('product-detail-buy-now');
    if (buyNowBtn && detailAddToCartBtn) {
        buyNowBtn.addEventListener('click', () => {
            detailAddToCartBtn.click();
            setTimeout(() => {
                window.novaCart.closeDrawer();
                window.novaCart.openCheckoutModal();
            }, 300);
        });
    }
});
