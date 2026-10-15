// Interactive Jordan Jumpman 2021 PF Hero Controller
// Full-Screen Edge-to-Edge Architecture matching Nickelfox Jordan Shoes Concept UI

export function initJordanHero() {
    const mainShoeImg = document.getElementById('hero-cutout-shoe');
    const heroJumpText = document.getElementById('hero-title-jump');
    const heroPriceText = document.getElementById('hero-price-display');
    const heroTagYear = document.getElementById('hero-tag-year');
    const ambientGlow = document.getElementById('hero-ambient-glow');
    const addToCartBtn = document.getElementById('hero-add-to-cart-btn');
    const buyNowBtn = document.getElementById('hero-buy-now-btn');
    const shardsContainer = document.getElementById('hero-shards-container');

    // Colorways data definition
    const colorways = {
        'red': {
            key: 'red',
            nameAr: 'سنيكرز جوردان جمب مان 2021 PF "يونيفيرستي ريد"',
            nameEn: 'Jordan Jumpman 2021 PF "University Red"',
            priceUSD: '134$',
            priceEGP: 4150,
            shoeImage: '/images/store/jumpman_angled_red.png',
            glowClass: 'bg-red-600/35',
            jumpColor: 'text-red-600',
            jumpShadow: 'drop-shadow-[0_20px_40px_rgba(239,68,68,0.45)]',
            tagColor: 'text-red-500',
            priceColor: 'text-red-600',
            shardColor: 'bg-red-600',
            colorHex: '#df0101',
            colorLabelAr: 'أحمر ناري / شيكاغو',
            colorLabelEn: 'University Red / Black',
        },
        'purple': {
            key: 'purple',
            nameAr: 'سنيكرز جوردان جمب مان 2021 PF "إلكتريك بيربل"',
            nameEn: 'Jordan Jumpman 2021 PF "Electric Purple"',
            priceUSD: '134$',
            priceEGP: 4150,
            shoeImage: '/images/store/jumpman_angled_purple.png',
            glowClass: 'bg-purple-600/35',
            jumpColor: 'text-purple-600',
            jumpShadow: 'drop-shadow-[0_20px_40px_rgba(168,85,247,0.45)]',
            tagColor: 'text-purple-500',
            priceColor: 'text-purple-600',
            shardColor: 'bg-purple-600',
            colorHex: '#a855f7',
            colorLabelAr: 'بنفسجي إلكتريك',
            colorLabelEn: 'Electric Purple / Black',
        },
        'green': {
            key: 'green',
            nameAr: 'سنيكرز جوردان جمب مان 2021 PF "نيون إيميرالد"',
            nameEn: 'Jordan Jumpman 2021 PF "Neon Emerald"',
            priceUSD: '134$',
            priceEGP: 4150,
            shoeImage: '/images/store/jumpman_angled_green.png',
            glowClass: 'bg-emerald-600/35',
            jumpColor: 'text-emerald-500',
            jumpShadow: 'drop-shadow-[0_20px_40px_rgba(16,185,129,0.45)]',
            tagColor: 'text-emerald-400',
            priceColor: 'text-emerald-500',
            shardColor: 'bg-emerald-500',
            colorHex: '#10b981',
            colorLabelAr: 'أخضر نيون إيميرالد',
            colorLabelEn: 'Neon Emerald / Black',
        },
    };

    let activeColorway = colorways['red'];
    let selectedSize = '42';

    // 1. Colorway Switching Logic
    function setColorway(key) {
        if (!colorways[key]) return;
        activeColorway = colorways[key];

        // Animate Shoe Image Transition
        if (mainShoeImg) {
            mainShoeImg.style.transition = 'opacity 0.2s ease, transform 0.2s cubic-bezier(0.16, 1, 0.3, 1)';
            mainShoeImg.style.opacity = '0.2';
            mainShoeImg.style.transform = 'scale(0.96)';

            setTimeout(() => {
                mainShoeImg.src = activeColorway.shoeImage;
                mainShoeImg.style.opacity = '1';
                mainShoeImg.style.transform = '';
            }, 120);
        }

        // Update Jump Headline color and glow
        if (heroJumpText) {
            heroJumpText.className = `jordan-title-jump ${activeColorway.jumpColor} ${activeColorway.jumpShadow} transition-colors duration-500 text-7xl sm:text-8xl md:text-9xl lg:text-[11vw] xl:text-[12vw] select-none`;
        }

        // Update Tag Year color
        if (heroTagYear) {
            heroTagYear.className = `${activeColorway.tagColor} font-mono font-black text-xl lg:text-3xl tracking-widest transition-colors duration-500`;
        }

        // Update Price color
        if (heroPriceText) {
            heroPriceText.className = `text-4xl lg:text-6xl font-black font-mono ${activeColorway.priceColor} tracking-tight transition-colors duration-500`;
        }

        // Update Ambient Glow
        if (ambientGlow) {
            ambientGlow.className = `absolute w-[750px] h-[750px] rounded-full blur-[190px] pointer-events-none transition-all duration-700 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 ${activeColorway.glowClass} z-0`;
        }

        // Update Shards Color
        if (shardsContainer) {
            shardsContainer.querySelectorAll('.shard-item').forEach((shard) => {
                shard.className = `shard-item ${activeColorway.shardColor} shadow-lg transition-colors duration-500`;
            });
        }

        // Update Thumbnail Buttons Active Ring
        document.querySelectorAll('[data-colorway-key]').forEach((btn) => {
            const btnKey = btn.getAttribute('data-colorway-key');
            if (btnKey === key) {
                btn.classList.add('ring-2', 'ring-white', 'scale-110', 'opacity-100');
                btn.classList.remove('opacity-50');
            } else {
                btn.classList.remove('ring-2', 'ring-white', 'scale-110', 'opacity-100');
                btn.classList.add('opacity-50');
            }
        });
    }

    // Attach click listeners to colorway thumbnails
    document.querySelectorAll('[data-colorway-key]').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const key = btn.getAttribute('data-colorway-key');
            setColorway(key);
        });
    });

    // Clicking the main sneaker cycles through the 3 colorways smoothly
    if (mainShoeImg) {
        mainShoeImg.addEventListener('click', () => {
            const keys = ['red', 'purple', 'green'];
            const nextIdx = (keys.indexOf(activeColorway.key) + 1) % keys.length;
            setColorway(keys[nextIdx]);
        });
    }

    // 2. Pagination dots (Right side 5 dots)
    const dotKeys = ['red', 'purple', 'green', 'red', 'purple'];
    document.querySelectorAll('[data-pagination-dot]').forEach((dot, index) => {
        dot.addEventListener('click', () => {
            const nextKey = dotKeys[index % dotKeys.length];
            setColorway(nextKey);
            document.querySelectorAll('[data-pagination-dot]').forEach((d) => d.classList.remove('bg-white', 'scale-125'));
            dot.classList.add('bg-white', 'scale-125');
        });
    });

    // 3. Size selection
    document.querySelectorAll('[data-jordan-size]').forEach((sizePill) => {
        sizePill.addEventListener('click', () => {
            document.querySelectorAll('[data-jordan-size]').forEach((p) => {
                p.classList.remove('bg-red-600', 'text-white', 'border-red-500', 'font-black', 'shadow-lg');
                p.classList.add('bg-white/5', 'text-gray-300', 'border-white/10');
            });

            sizePill.classList.add('bg-red-600', 'text-white', 'border-red-500', 'font-black', 'shadow-lg');
            sizePill.classList.remove('bg-white/5', 'text-gray-300', 'border-white/10');

            selectedSize = sizePill.getAttribute('data-jordan-size');
        });
    });

    // 4. Cart addition helper
    function addHeroProductToCart() {
        if (!window.novaCart) return;

        const isAr = document.documentElement.lang === 'ar';
        window.novaCart.addItem({
            id: 201,
            name: isAr ? activeColorway.nameAr : activeColorway.nameEn,
            slug: 'jordan-jumpman-2021-pf',
            price: activeColorway.priceEGP,
            image: activeColorway.shoeImage,
            color: {
                hex: activeColorway.colorHex,
                label: isAr ? activeColorway.colorLabelAr : activeColorway.colorLabelEn,
            },
            size: selectedSize,
            quantity: 1,
        });
    }

    // 5. Add To Cart Button Handler
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', (e) => {
            e.preventDefault();
            addHeroProductToCart();

            const isAr = document.documentElement.lang === 'ar';
            const originalText = addToCartBtn.innerHTML;
            addToCartBtn.innerHTML = `<span>✓ ${isAr ? 'تمت الإضافة للسلة!' : 'ADDED TO BAG!'}</span>`;
            setTimeout(() => {
                addToCartBtn.innerHTML = originalText;
            }, 1800);
        });
    }

    // 6. Buy Now Button Handler
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', (e) => {
            e.preventDefault();
            addHeroProductToCart();

            const openCartTrigger = document.querySelector('[data-cart-open]');
            if (openCartTrigger) {
                openCartTrigger.click();
            }
        });
    }

    // 7. Hero Ambient Video Sound Toggle
    const heroBgVideo = document.getElementById('hero-bg-video');
    const soundToggleBtn = document.getElementById('btn-hero-sound-toggle');
    const soundIcon = document.getElementById('hero-sound-icon');
    const soundLabel = document.getElementById('hero-sound-label');

    if (soundToggleBtn && heroBgVideo) {
        soundToggleBtn.addEventListener('click', () => {
            const isMuted = heroBgVideo.muted;
            heroBgVideo.muted = !isMuted;
            if (heroBgVideo.muted) {
                if (soundIcon) soundIcon.textContent = '🔇';
                if (soundLabel) soundLabel.textContent = document.documentElement.lang === 'ar' ? 'الصوت: مغلق' : 'AUDIO: OFF';
                soundToggleBtn.classList.remove('bg-red-600', 'border-red-500');
                soundToggleBtn.classList.add('bg-white/10', 'border-white/15');
            } else {
                heroBgVideo.volume = 0.5;
                heroBgVideo.play().catch(() => {});
                if (soundIcon) soundIcon.textContent = '🔊';
                if (soundLabel) soundLabel.textContent = document.documentElement.lang === 'ar' ? 'الصوت: يعمل' : 'AUDIO: ON';
                soundToggleBtn.classList.add('bg-red-600', 'border-red-500');
                soundToggleBtn.classList.remove('bg-white/10', 'border-white/15');
            }
        });
    }

    // 8. Launch Film Theater Modal
    const openFilmBtn = document.getElementById('btn-open-film-modal');
    const closeFilmBtn = document.getElementById('btn-close-film-modal');
    const filmModal = document.getElementById('cinema-film-modal');
    const modalVideo = document.getElementById('cinema-modal-video');

    if (openFilmBtn && filmModal && modalVideo) {
        openFilmBtn.addEventListener('click', () => {
            filmModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            modalVideo.currentTime = 0;
            modalVideo.volume = 0.8;
            modalVideo.play().catch(() => {});
        });

        const closeFilm = () => {
            filmModal.classList.add('hidden');
            document.body.style.overflow = '';
            modalVideo.pause();
        };

        if (closeFilmBtn) {
            closeFilmBtn.addEventListener('click', closeFilm);
        }

        filmModal.addEventListener('click', (e) => {
            if (e.target === filmModal) closeFilm();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !filmModal.classList.contains('hidden')) {
                closeFilm();
            }
        });
    }
}
