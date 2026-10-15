// Cinematic Interactive Fashion Hero Video Controller

export function initHeroVideo() {
    const videoEl = document.getElementById('hero-fashion-video');
    if (!videoEl) return;

    const channelBtns = document.querySelectorAll('[data-hero-video-src]');
    const playPauseBtn = document.getElementById('btn-hero-playpause');
    const playPauseIcon = document.getElementById('hero-playpause-icon');
    const soundBtn = document.getElementById('btn-hero-sound');
    const soundText = document.getElementById('hero-sound-text');
    const progressBar = document.getElementById('hero-video-progress');
    const currentTag = document.getElementById('hero-active-tag');

    // Video channels data
    const channels = {
        'runway': {
            titleAr: 'عرض أزياء الشارع 2026 // RUNWAY',
            titleEn: 'RUNWAY 2026 // STREETWEAR DROP',
            tagSlug: 'orbit-bomber-jacket',
            tagTitle: 'جاكيت بومبر أوربت',
            tagPrice: '2,200 ج.م'
        },
        'hoodie': {
            titleAr: 'جلسة تصوير هودي إكليبس // STUDIO',
            titleEn: 'ECLIPSE HOODIE // STUDIO DROP',
            tagSlug: 'eclipse-oversized-hoodie',
            tagTitle: 'هودي إكليبس أوفرسايز',
            tagPrice: '1,250 ج.م'
        },
        'jacket': {
            titleAr: 'جاكيت ريبل بايكر جلد // LOOKBOOK',
            titleEn: 'REBEL BIKER JACKET // LOOKBOOK',
            tagSlug: 'rebel-leather-biker-jacket',
            tagTitle: 'جاكيت جلد ريبل بايكر',
            tagPrice: '3,450 ج.م'
        }
    };

    // 1. Channel Switcher
    channelBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const src = btn.getAttribute('data-hero-video-src');
            const key = btn.getAttribute('data-hero-channel-key');
            if (!src) return;

            // Update UI buttons
            channelBtns.forEach((b) => {
                b.classList.remove('bg-cyan-500/20', 'border-cyan-400', 'text-cyan-300');
                b.classList.add('bg-white/5', 'border-white/10', 'text-gray-400');
            });
            btn.classList.add('bg-cyan-500/20', 'border-cyan-400', 'text-cyan-300');
            btn.classList.remove('bg-white/5', 'border-white/10', 'text-gray-400');

            // Fade transition on video
            videoEl.style.opacity = '0.3';
            setTimeout(() => {
                videoEl.src = src;
                videoEl.play().catch(() => {});
                videoEl.style.opacity = '1';
            }, 200);

            // Update floating lookbook tag
            if (currentTag && channels[key]) {
                const data = channels[key];
                const isAr = document.documentElement.lang === 'ar';
                const titleNode = currentTag.querySelector('.tag-title');
                const priceNode = currentTag.querySelector('.tag-price');
                const linkNode = currentTag.querySelector('a');

                if (titleNode) titleNode.textContent = data.tagTitle;
                if (priceNode) priceNode.textContent = data.tagPrice;
                if (linkNode) linkNode.href = `/products/${data.tagSlug}`;
            }
        });
    });

    // 2. Play / Pause
    if (playPauseBtn) {
        playPauseBtn.addEventListener('click', () => {
            if (videoEl.paused) {
                videoEl.play();
                if (playPauseIcon) {
                    playPauseIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />`;
                }
            } else {
                videoEl.pause();
                if (playPauseIcon) {
                    playPauseIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />`;
                }
            }
        });
    }

    // 3. Timeline Progress
    if (progressBar) {
        videoEl.addEventListener('timeupdate', () => {
            if (videoEl.duration) {
                const pct = (videoEl.currentTime / videoEl.duration) * 100;
                progressBar.style.width = `${pct}%`;
            }
        });
    }

    // 4. Luxury Runway Soundscape (Web Audio API Synthesizer)
    let audioCtx = null;
    let masterGain = null;
    let osc1 = null;
    let osc2 = null;
    let isSoundOn = false;

    function initRunwayAudio() {
        if (audioCtx) return;
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        audioCtx = new AudioContext();

        masterGain = audioCtx.createGain();
        masterGain.gain.setValueAtTime(0, audioCtx.currentTime);

        // Low ambient fashion drone
        osc1 = audioCtx.createOscillator();
        osc1.type = 'sawtooth';
        osc1.frequency.setValueAtTime(55, audioCtx.currentTime); // Low A

        // Filter for deep warm muffled runway sound
        const filter = audioCtx.createBiquadFilter();
        filter.type = 'lowpass';
        filter.frequency.setValueAtTime(320, audioCtx.currentTime);

        // Sub harmonic oscillator
        osc2 = audioCtx.createOscillator();
        osc2.type = 'sine';
        osc2.frequency.setValueAtTime(110, audioCtx.currentTime);

        osc1.connect(filter);
        osc2.connect(filter);
        filter.connect(masterGain);
        masterGain.connect(audioCtx.destination);

        osc1.start();
        osc2.start();
    }

    if (soundBtn) {
        soundBtn.addEventListener('click', () => {
            initRunwayAudio();
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }

            isSoundOn = !isSoundOn;
            const isAr = document.documentElement.lang === 'ar';

            if (isSoundOn) {
                masterGain.gain.linearRampToValueAtTime(0.15, audioCtx.currentTime + 1.2);
                soundBtn.classList.add('bg-cyan-400', 'text-black', 'border-cyan-300');
                soundBtn.classList.remove('bg-black/60', 'text-white', 'border-white/20');
                if (soundText) soundText.textContent = isAr ? 'كتم الصوت 🔊' : 'SOUND ON 🔊';
            } else {
                masterGain.gain.linearRampToValueAtTime(0, audioCtx.currentTime + 0.6);
                soundBtn.classList.remove('bg-cyan-400', 'text-black', 'border-cyan-300');
                soundBtn.classList.add('bg-black/60', 'text-white', 'border-white/20');
                if (soundText) soundText.textContent = isAr ? 'تشغيل الصوت 🔈' : 'SOUND OFF 🔈';
            }
        });
    }

    // 5. Toggle between Interactive Video Mode vs 3D WebGL Studio
    const switchVideoBtn = document.getElementById('switch-mode-video');
    const switch3DBtn = document.getElementById('switch-mode-3d');
    const close3DBtn = document.getElementById('btn-close-3d-mode');
    const videoBox = document.getElementById('hero-video-box');
    const studio3DBox = document.getElementById('hero-3d-box');

    function activateVideoMode() {
        if (!switchVideoBtn || !switch3DBtn || !videoBox || !studio3DBox) return;
        switchVideoBtn.classList.add('bg-cyan-400', 'text-black');
        switchVideoBtn.classList.remove('bg-white/5', 'text-gray-300');
        switch3DBtn.classList.remove('bg-cyan-400', 'text-black');
        switch3DBtn.classList.add('bg-white/5', 'text-gray-300');

        videoBox.classList.remove('hidden');
        studio3DBox.classList.add('hidden');
        videoEl.play().catch(() => {});
    }

    function activate3DMode() {
        if (!switchVideoBtn || !switch3DBtn || !videoBox || !studio3DBox) return;
        switch3DBtn.classList.add('bg-cyan-400', 'text-black');
        switch3DBtn.classList.remove('bg-white/5', 'text-gray-300');
        switchVideoBtn.classList.remove('bg-cyan-400', 'text-black');
        switchVideoBtn.classList.add('bg-white/5', 'text-gray-300');

        studio3DBox.classList.remove('hidden');
        videoBox.classList.add('hidden');
        videoEl.pause();
        setTimeout(() => {
            window.dispatchEvent(new Event('resize'));
        }, 120);
    }

    if (switchVideoBtn && switch3DBtn) {
        switchVideoBtn.addEventListener('click', activateVideoMode);
        switch3DBtn.addEventListener('click', activate3DMode);
    }

    if (close3DBtn) {
        close3DBtn.addEventListener('click', activateVideoMode);
    }
}
