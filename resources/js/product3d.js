import * as THREE from 'three';
import gsap from 'gsap';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';

export function initProduct3D() {
    const container = document.getElementById('product-3d-canvas');
    if (!container) return;

    const wrapperEl = document.getElementById('product-3d-wrapper');
    const overlayEl = document.getElementById('hotspots-overlay');
    const cardEl = document.getElementById('annotation-card');
    const badgeEl = document.getElementById('annotation-badge');
    const titleEl = document.getElementById('annotation-title');
    const descEl = document.getElementById('annotation-desc');
    const closeBtn = document.getElementById('btn-annotation-close');
    const pillsContainer = document.getElementById('feature-tour-pills');

    const productData = window.__PRODUCT_DATA__ || {
        garment: 'hoodie',
        colors: [{ hex: '#2c2c36', label: 'Charcoal' }],
    };

    const isAr = document.documentElement.dir === 'rtl' || document.documentElement.lang === 'ar';

    const width = container.clientWidth;
    const height = container.clientHeight || 560;

    // 1. Scene & Camera Setup
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(40, width / height, 0.1, 100);
    const initialCamPos = { x: 0, y: 0.05, z: 2.65 };
    camera.position.set(initialCamPos.x, initialCamPos.y, initialCamPos.z);

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 2.1;
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    container.innerHTML = '';
    container.appendChild(renderer.domElement);

    // 2. High-Clarity Studio Lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 2.2);
    scene.add(ambientLight);

    const keyLight = new THREE.DirectionalLight(0xffffff, 4.2);
    keyLight.position.set(2.5, 3.5, 3.0);
    keyLight.castShadow = true;
    scene.add(keyLight);

    const fillLight = new THREE.DirectionalLight(0xe2e8f0, 3.0);
    fillLight.position.set(-2.5, 1.5, 2.5);
    scene.add(fillLight);

    const topRimLight = new THREE.DirectionalLight(0x38bdf8, 4.0);
    topRimLight.position.set(0, 4.0, -1.0);
    scene.add(topRimLight);

    const backRimL = new THREE.DirectionalLight(0xc084fc, 4.5);
    backRimL.position.set(-3.0, 1.5, -3.0);
    scene.add(backRimL);

    const backRimR = new THREE.DirectionalLight(0x38bdf8, 3.5);
    backRimR.position.set(3.0, 1.5, -3.0);
    scene.add(backRimR);

    const upLight = new THREE.PointLight(0xffffff, 2.0, 10);
    upLight.position.set(0, -1.8, 1.8);
    scene.add(upLight);

    // 3. Studio Pedestal Display Stand
    const pedestalGroup = new THREE.Group();
    pedestalGroup.position.y = -1.2;

    const diskGeo = new THREE.CylinderGeometry(1.35, 1.45, 0.08, 48);
    const diskMat = new THREE.MeshStandardMaterial({
        color: 0x0f0f18,
        roughness: 0.35,
        metalness: 0.65,
    });
    const disk = new THREE.Mesh(diskGeo, diskMat);
    disk.receiveShadow = true;
    pedestalGroup.add(disk);

    // Neon Glow Rings
    const ringVioletGeo = new THREE.RingGeometry(1.25, 1.32, 64);
    ringVioletGeo.rotateX(-Math.PI / 2);
    const ringViolet = new THREE.Mesh(ringVioletGeo, new THREE.MeshBasicMaterial({ color: 0x8b5cf6, side: THREE.DoubleSide }));
    ringViolet.position.y = 0.045;
    pedestalGroup.add(ringViolet);

    const ringCyanGeo = new THREE.RingGeometry(0.9, 0.95, 64);
    ringCyanGeo.rotateX(-Math.PI / 2);
    const ringCyan = new THREE.Mesh(ringCyanGeo, new THREE.MeshBasicMaterial({ color: 0x06b6d4, side: THREE.DoubleSide }));
    ringCyan.position.y = 0.046;
    pedestalGroup.add(ringCyan);

    scene.add(pedestalGroup);

    // Soft Floor Shadow
    const shadowGeo = new THREE.CircleGeometry(1.2, 32);
    shadowGeo.rotateX(-Math.PI / 2);
    const shadowMat = new THREE.MeshBasicMaterial({
        color: 0x000000,
        transparent: true,
        opacity: 0.5,
    });
    const shadow = new THREE.Mesh(shadowGeo, shadowMat);
    shadow.position.y = -1.18;
    scene.add(shadow);

    // 4. Subtle Floating Particles
    const particlesCount = 40;
    const particlePositions = new Float32Array(particlesCount * 3);
    for (let i = 0; i < particlesCount * 3; i += 3) {
        particlePositions[i] = (Math.random() - 0.5) * 4;
        particlePositions[i + 1] = (Math.random() - 0.5) * 3;
        particlePositions[i + 2] = (Math.random() - 0.5) * 3;
    }
    const particleGeo = new THREE.BufferGeometry();
    particleGeo.setAttribute('position', new THREE.BufferAttribute(particlePositions, 3));
    const particleMat = new THREE.PointsMaterial({
        color: 0xa855f7,
        size: 0.025,
        transparent: true,
        opacity: 0.45,
    });
    const particles = new THREE.Points(particleGeo, particleMat);
    scene.add(particles);

    // 5. Annotations Definition (Sketchfab / Eagle Creek 3D Feature Tour)
    const annotationsByGarment = {
        hoodie: [
            {
                id: 1,
                titleAr: 'خامة قطن مصري 400 GSM',
                titleEn: '400 GSM Egyptian Cotton',
                descAr: 'نسيج قطني ثقيل وفاخر محبوك بحلقات كثيفة يمنح دفئاً ونعومة فائقة مع مقاومة تامة للوبر والانكماش.',
                descEn: 'Ultra-heavyweight premium fleece knit providing superior warmth and softness with zero pilling.',
                pos: new THREE.Vector3(-0.12, 0.15, 0.36),
                camPos: { x: -0.12, y: 0.15, z: 1.35 },
            },
            {
                id: 2,
                titleAr: 'جيب كانجارو مدعم بالدرزات',
                titleEn: 'Reinforced Kangaroo Pocket',
                descAr: 'جيب أمامي واسع مبطن بالكامل مع خياطة بارتاك معززة عند نقاط الضغط لحمل المقتنيات بأمان.',
                descEn: 'Spacious front pocket with reinforced bar-tack stitching at stress points for durability.',
                pos: new THREE.Vector3(0.0, -0.26, 0.42),
                camPos: { x: 0.0, y: -0.26, z: 1.25 },
            },
            {
                id: 3,
                titleAr: 'كابيشون مزدوج وأربطة معدنية',
                titleEn: 'Double-Layer Hood & Metal Aglets',
                descAr: 'غطاء رأس مبطن بطبقتين ليحافظ على شكله الأنيق، مع أربطة قطنية سميكة بأطراف معدنية مقاومة للصدأ.',
                descEn: 'Double-layered structured hood with heavy-duty metal aglet drawstrings.',
                pos: new THREE.Vector3(0.08, 0.42, 0.32),
                camPos: { x: 0.08, y: 0.42, z: 1.15 },
            },
            {
                id: 4,
                titleAr: 'أساور وحواف مضلعة مرنة',
                titleEn: 'Heavy-Ribbed Cuffs & Hem',
                descAr: 'تضليع 2x2 محكم مع خيوط إيلاستين لمنع ارتخاء الأكمام والحفاظ على القصّة الأوفرسايز المثالية.',
                descEn: '2x2 elastane-infused ribbed knitting that retains fit and shape over years of wear.',
                pos: new THREE.Vector3(0.48, -0.22, 0.16),
                camPos: { x: 0.48, y: -0.22, z: 1.25 },
            },
        ],
        tee: [
            {
                id: 1,
                titleAr: '100% قطن مُمشّط ناعم',
                titleEn: '100% Combed Cotton',
                descAr: 'قطن طبيعي نقي وخفيف الوزن فائق النعومة ومسامي يتيح تنفس البشرة بحرية طوال اليوم.',
                descEn: 'Pure combed natural cotton, ultra-breathable and lightweight for daily luxury.',
                pos: new THREE.Vector3(-0.1, 0.1, 0.32),
                camPos: { x: -0.1, y: 0.1, z: 1.3 },
            },
            {
                id: 2,
                titleAr: 'ياقة مضلعة سميكة',
                titleEn: 'Thick Ribbed Collar',
                descAr: 'ياقة محاكة بحواف مضلعة سميكة لا ترتخي ولا تتمدد مع الغسيل المتكرر.',
                descEn: 'High-density ribbing that prevents stretching and keeps its crisp neckline.',
                pos: new THREE.Vector3(0.0, 0.38, 0.28),
                camPos: { x: 0.0, y: 0.38, z: 1.15 },
            },
            {
                id: 3,
                titleAr: 'قصّة بوكسي وأكتاف ساقطة',
                titleEn: 'Boxy Fit & Dropped Shoulders',
                descAr: 'تصميم ستريت وير عصري يمنح حرية حركة ومظهراً مريحاً وجذاباً.',
                descEn: 'Modern relaxed streetwear silhouette with dropped shoulder seams.',
                pos: new THREE.Vector3(0.42, 0.24, 0.12),
                camPos: { x: 0.42, y: 0.24, z: 1.25 },
            },
        ],
        shoe: [
            {
                id: 1,
                titleAr: 'نعل مطاطي عالي التماسك',
                titleEn: 'High-Traction Rubber Sole',
                descAr: 'نعل سفلي من المطاط الطبيعي بنقوش هندسية مانعة للانزلاق توفر ثباتاً مطلقاً وتحملاً فائقاً.',
                descEn: 'Engineered natural rubber outsole with multidirectional herringbone traction pattern.',
                pos: new THREE.Vector3(0.1, -0.32, 0.15),
                camPos: { x: 0.1, y: -0.3, z: 1.25 },
            },
            {
                id: 2,
                titleAr: 'جزء علوي من الجلد والشمواه الفاخر',
                titleEn: 'Genuine Leather & Suede Upper',
                descAr: 'طبقات متداخلة من الجلد الطبيعي والشمواه المتين مع درزات مزدوجة تمنح الحذاء رونقاً كلاسيكياً.',
                descEn: 'Multi-layered authentic full-grain leather and suede panels with precision double stitching.',
                pos: new THREE.Vector3(-0.25, 0.14, 0.22),
                camPos: { x: -0.25, y: 0.14, z: 1.3 },
            },
            {
                id: 3,
                titleAr: 'وسائد Zoom Air سريعة الارتداد',
                titleEn: 'Forefoot Zoom Air Cushioning',
                descAr: 'وحدة وسائد هوائية منخفضة الارتفاع أسفل مقدمة القدم تمتص الصدمات وتعيد الطاقة مع كل انطلاقة.',
                descEn: 'Low-profile responsive Zoom Air unit right under the forefoot for explosive energy return.',
                pos: new THREE.Vector3(0.5, -0.16, 0.14),
                camPos: { x: 0.5, y: -0.16, z: 1.2 },
            },
            {
                id: 4,
                titleAr: 'طوق مبطن ودعامة خلفية للكاحل',
                titleEn: 'Padded Collar & Heel Counter',
                descAr: 'بطانة إسفنجية داخلية محيطية تؤمن الكعب وتمنح راحة استثنائية طوال ساعات الارتداء اليومية.',
                descEn: 'Anatomically contoured padded ankle collar and molded heel cup for maximum lockdown.',
                pos: new THREE.Vector3(-0.55, 0.22, 0.05),
                camPos: { x: -0.55, y: 0.22, z: 1.3 },
            },
        ],
    };

    const garmentKey = productData.garment === 'tee' ? 'tee' : (productData.garment === 'shoe' ? 'shoe' : 'hoodie');
    const activeAnnotations = annotationsByGarment[garmentKey] || annotationsByGarment.hoodie;

    // 6. Build Hotspot DOM Elements
    const hotspotElements = [];
    if (overlayEl) {
        overlayEl.innerHTML = '';
        activeAnnotations.forEach((ann) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'hotspot-pin absolute pointer-events-auto transform -translate-x-1/2 -translate-y-1/2 transition-all duration-200 group focus:outline-none';
            btn.setAttribute('data-ann-id', ann.id);
            btn.innerHTML = `
                <div class="relative flex items-center justify-center">
                    <span class="absolute w-8 h-8 rounded-full bg-cyan-400/40 animate-ping"></span>
                    <span class="w-7 h-7 rounded-full bg-cyan-400 text-black font-black text-xs flex items-center justify-center shadow-lg border-2 border-white group-hover:scale-110 group-hover:bg-violet-400 transition transform font-mono">
                        ${ann.id}
                    </span>
                    <span class="absolute start-full ms-2 px-2.5 py-1 rounded-lg bg-black/85 backdrop-blur-md text-[11px] font-semibold text-white whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none shadow-xl border border-white/10 hidden sm:inline-block">
                        ${isAr ? ann.titleAr : ann.titleEn}
                    </span>
                </div>
            `;
            btn.addEventListener('click', () => selectAnnotation(ann));
            overlayEl.appendChild(btn);
            hotspotElements.push({ ann, el: btn });
        });
    }

    // 7. Build Feature Tour Pills Bar
    if (pillsContainer) {
        pillsContainer.innerHTML = '';
        activeAnnotations.forEach((ann) => {
            const pill = document.createElement('button');
            pill.type = 'button';
            pill.className = 'feature-pill px-3 py-1.5 rounded-xl bg-white/5 hover:bg-white/10 text-gray-300 hover:text-white border border-white/10 transition flex items-center gap-2';
            pill.setAttribute('data-ann-id', ann.id);
            pill.innerHTML = `
                <span class="w-5 h-5 rounded-full bg-cyan-400/20 text-cyan-300 border border-cyan-400/40 text-[11px] font-bold flex items-center justify-center font-mono">${ann.id}</span>
                <span class="font-medium">${isAr ? ann.titleAr : ann.titleEn}</span>
            `;
            pill.addEventListener('click', () => selectAnnotation(ann));
            pillsContainer.appendChild(pill);
        });
    }

    // 8. Annotation Selection Logic (Fly In + Open Tooltip Card)
    let selectedAnnotationId = null;

    function selectAnnotation(ann) {
        selectedAnnotationId = ann.id;
        autoRotate = false;
        if (autoRotateBtn) {
            autoRotateBtn.classList.remove('text-cyan-400', 'border-cyan-500/50');
        }

        // Animate camera directly to the feature hotspot view
        gsap.to(camera.position, {
            x: ann.camPos.x,
            y: ann.camPos.y,
            z: ann.camPos.z,
            duration: 1.1,
            ease: 'power3.inOut',
        });

        // Highlight selected pill
        if (pillsContainer) {
            pillsContainer.querySelectorAll('.feature-pill').forEach((p) => {
                const isSelected = p.getAttribute('data-ann-id') === String(ann.id);
                p.classList.toggle('bg-cyan-500/20', isSelected);
                p.classList.toggle('border-cyan-400/50', isSelected);
                p.classList.toggle('text-cyan-300', isSelected);
            });
        }

        // Populate and show tooltip card
        if (cardEl && badgeEl && titleEl && descEl) {
            badgeEl.textContent = ann.id;
            titleEl.textContent = isAr ? ann.titleAr : ann.titleEn;
            descEl.textContent = isAr ? ann.descAr : ann.descEn;
            cardEl.classList.remove('hidden');
            gsap.fromTo(cardEl, { opacity: 0, y: 15 }, { opacity: 1, y: 0, duration: 0.35, ease: 'back.out(1.5)' });
        }
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            if (cardEl) {
                gsap.to(cardEl, {
                    opacity: 0,
                    y: 10,
                    duration: 0.25,
                    onComplete: () => cardEl.classList.add('hidden'),
                });
            }
            selectedAnnotationId = null;
            if (pillsContainer) {
                pillsContainer.querySelectorAll('.feature-pill').forEach((p) => {
                    p.classList.remove('bg-cyan-500/20', 'border-cyan-400/50', 'text-cyan-300');
                });
            }
            // Return camera to overview
            gsap.to(camera.position, {
                x: initialCamPos.x,
                y: initialCamPos.y,
                z: initialCamPos.z,
                duration: 0.8,
                ease: 'power2.out',
            });
            autoRotate = true;
            if (autoRotateBtn) {
                autoRotateBtn.classList.add('text-cyan-400', 'border-cyan-500/50');
            }
        });
    }

    // 9. Model Loading (Realistic 3D Garments)
    const models = {
        hoodie: '/models/hoodie.glb',
        jacket: '/models/hoodie.glb',
        outerwear: '/models/hoodie.glb',
        tee: '/models/shirt_baked.glb',
        shoe: '/models/shoe.glb',
    };

    const garmentType = productData.garment || 'hoodie';
    const modelUrl = models[garmentType] || models.hoodie;

    let activeModelRoot = null;
    let isWireframe = false;

    function normalizeColor(hex) {
        if (!hex || hex === '#16161a' || hex === '#000000' || hex === '#111111') {
            return '#2d2d38';
        }
        return hex;
    }

    let currentColor = normalizeColor((productData.colors && productData.colors[0]?.hex) || '#2d2d38');

    function applyColor(hex) {
        currentColor = normalizeColor(hex);
        if (!activeModelRoot) return;

        if (garmentType === 'shoe') {
            // Preserve realistic PBR textures of the sneaker
            activeModelRoot.traverse((child) => {
                if (child.isMesh && child.material) {
                    const mats = Array.isArray(child.material) ? child.material : [child.material];
                    mats.forEach((mat) => {
                        if (mat.color) {
                            mat.color.setRGB(1, 1, 1);
                        }
                        mat.roughness = 0.55;
                        mat.metalness = 0.15;
                        mat.needsUpdate = true;
                    });
                }
            });
            return;
        }

        const targetColor = new THREE.Color(currentColor);

        activeModelRoot.traverse((child) => {
            if (child.isMesh && child.material) {
                const mats = Array.isArray(child.material) ? child.material : [child.material];
                mats.forEach((mat) => {
                    mat.roughness = 0.65;
                    mat.metalness = 0.05;
                    if (mat.color) {
                        gsap.to(mat.color, {
                            r: targetColor.r,
                            g: targetColor.g,
                            b: targetColor.b,
                            duration: 0.4,
                            ease: 'power2.out',
                        });
                    }
                });
            }
        });
    }

    const loader = new GLTFLoader();

    // Loader Indicator
    const loaderEl = document.createElement('div');
    loaderEl.className = 'absolute inset-0 flex flex-col items-center justify-center bg-black/50 backdrop-blur-sm z-30 transition-opacity duration-300';
    loaderEl.innerHTML = `
        <div class="w-10 h-10 border-2 border-red-500 border-t-cyan-400 rounded-full animate-spin mb-2"></div>
        <span class="text-xs font-mono text-cyan-300 tracking-wider">${garmentType === 'shoe' ? 'LOADING 3D SNEAKER...' : 'LOADING 3D GARMENT...'}</span>
    `;
    container.parentElement.appendChild(loaderEl);

    loader.load(
        modelUrl,
        (gltf) => {
            const model = gltf.scene;

            const box = new THREE.Box3().setFromObject(model);
            const size = box.getSize(new THREE.Vector3());
            const center = box.getCenter(new THREE.Vector3());

            const maxDim = Math.max(size.x, size.y, size.z);
            const targetScale = garmentType === 'shoe' ? 2.4 / maxDim : 1.7 / maxDim;
            model.scale.setScalar(targetScale);

            model.position.x = -center.x * targetScale;
            model.position.y = -center.y * targetScale + (garmentType === 'shoe' ? -0.12 : 0.05);
            model.position.z = -center.z * targetScale;

            model.traverse((child) => {
                if (child.isMesh) {
                    child.castShadow = true;
                    child.receiveShadow = true;
                    if (child.material) {
                        child.material.side = THREE.DoubleSide;
                        if (garmentType === 'shoe' && child.material.color) {
                            child.material.color.setRGB(1, 1, 1);
                        }
                    }
                }
            });

            const wrapper = new THREE.Group();
            wrapper.add(model);
            activeModelRoot = wrapper;
            scene.add(activeModelRoot);

            applyColor(currentColor);

            // Smooth entrance animation
            gsap.from(wrapper.scale, {
                x: 0.05,
                y: 0.05,
                z: 0.05,
                duration: 0.7,
                ease: 'back.out(1.5)',
            });

            // Gentle idle breathing floating animation
            gsap.to(wrapper.position, {
                y: 0.04,
                duration: 2.2,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut',
            });

            // Fade out loader
            loaderEl.style.opacity = '0';
            setTimeout(() => loaderEl.remove(), 350);
        },
        undefined,
        (err) => {
            console.error('Failed to load 3D garment:', err);
            loaderEl.remove();
        }
    );

    window.set3DColor = function (hex) {
        applyColor(hex);
    };

    // 10. Drag & Zoom Controls
    let isDragging = false;
    let previousMousePosition = { x: 0, y: 0 };
    let targetRotationY = garmentType === 'shoe' ? -0.75 : 0;
    let targetRotationX = garmentType === 'shoe' ? 0.08 : 0;
    let autoRotate = true;

    container.addEventListener('pointerdown', (e) => {
        isDragging = true;
        autoRotate = false;
        previousMousePosition = { x: e.clientX, y: e.clientY };
    });

    window.addEventListener('pointermove', (e) => {
        if (!isDragging) return;
        const deltaX = e.clientX - previousMousePosition.x;
        const deltaY = e.clientY - previousMousePosition.y;

        targetRotationY += deltaX * 0.008;
        targetRotationX = Math.max(-0.4, Math.min(0.4, targetRotationX + deltaY * 0.005));

        previousMousePosition = { x: e.clientX, y: e.clientY };
    });

    window.addEventListener('pointerup', () => {
        isDragging = false;
    });

    container.addEventListener('wheel', (e) => {
        e.preventDefault();
        camera.position.z = Math.max(1.5, Math.min(3.8, camera.position.z + e.deltaY * 0.003));
    }, { passive: false });

    // Auto-rotate button
    const autoRotateBtn = document.getElementById('btn-3d-autorotate');
    if (autoRotateBtn) {
        autoRotateBtn.addEventListener('click', () => {
            autoRotate = !autoRotate;
            autoRotateBtn.classList.toggle('text-cyan-400', autoRotate);
            autoRotateBtn.classList.toggle('border-cyan-500/50', autoRotate);
        });
    }

    // Wireframe button
    const wireframeBtn = document.getElementById('btn-3d-wireframe');
    if (wireframeBtn) {
        wireframeBtn.addEventListener('click', () => {
            isWireframe = !isWireframe;
            wireframeBtn.classList.toggle('text-cyan-400', isWireframe);
            wireframeBtn.classList.toggle('border-cyan-500/50', isWireframe);

            if (activeModelRoot) {
                activeModelRoot.traverse((child) => {
                    if (child.isMesh && child.material) {
                        const mats = Array.isArray(child.material) ? child.material : [child.material];
                        mats.forEach((mat) => {
                            mat.wireframe = isWireframe;
                        });
                    }
                });
            }
        });
    }

    // Reset Camera button
    const resetBtn = document.getElementById('btn-3d-reset');
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            if (closeBtn) closeBtn.click();
            gsap.to(camera.position, {
                x: initialCamPos.x,
                y: initialCamPos.y,
                z: initialCamPos.z,
                duration: 0.6,
                ease: 'power2.out',
            });
            targetRotationX = garmentType === 'shoe' ? 0.08 : 0;
            targetRotationY = garmentType === 'shoe' ? -0.75 : 0;
            autoRotate = true;
            if (autoRotateBtn) {
                autoRotateBtn.classList.add('text-cyan-400', 'border-cyan-500/50');
            }
        });
    }

    // Zoom Buttons
    const zoomInBtn = document.getElementById('btn-3d-zoom-in');
    if (zoomInBtn) {
        zoomInBtn.addEventListener('click', () => {
            gsap.to(camera.position, {
                z: Math.max(1.3, camera.position.z - 0.4),
                duration: 0.3,
            });
        });
    }

    const zoomOutBtn = document.getElementById('btn-3d-zoom-out');
    if (zoomOutBtn) {
        zoomOutBtn.addEventListener('click', () => {
            gsap.to(camera.position, {
                z: Math.min(3.8, camera.position.z + 0.4),
                duration: 0.3,
            });
        });
    }

    // Fullscreen Toggle
    const fullscreenBtn = document.getElementById('btn-3d-fullscreen');
    if (fullscreenBtn && wrapperEl) {
        fullscreenBtn.addEventListener('click', () => {
            if (!document.fullscreenElement) {
                wrapperEl.requestFullscreen().catch((err) => console.error(err));
            } else {
                document.exitFullscreen().catch((err) => console.error(err));
            }
        });
    }

    // Lighting Preset Buttons
    const lightBtns = document.querySelectorAll('[data-3d-light]');
    lightBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            lightBtns.forEach((b) => {
                b.classList.remove('bg-white/10', 'text-white', 'font-medium');
                b.classList.add('bg-white/5', 'text-gray-400');
            });
            btn.classList.add('bg-white/10', 'text-white', 'font-medium');
            btn.classList.remove('bg-white/5', 'text-gray-400');

            const preset = btn.getAttribute('data-3d-light');
            if (preset === 'studio') {
                gsap.to(keyLight, { intensity: 4.2, duration: 0.5 });
                keyLight.color.setHex(0xffffff);
                backRimL.color.setHex(0xc084fc);
                backRimR.color.setHex(0x38bdf8);
            } else if (preset === 'warm') {
                gsap.to(keyLight, { intensity: 4.8, duration: 0.5 });
                keyLight.color.setHex(0xffedd5);
                backRimL.color.setHex(0xfb923c);
                backRimR.color.setHex(0xf59e0b);
            } else if (preset === 'white') {
                gsap.to(keyLight, { intensity: 3.8, duration: 0.5 });
                keyLight.color.setHex(0xf8fafc);
                backRimL.color.setHex(0xe2e8f0);
                backRimR.color.setHex(0xe2e8f0);
            }
        });
    });

    // 11. Render Loop & Hotspot 3D-to-2D Projection
    const tempVec = new THREE.Vector3();
    let animationFrameId;

    function animate() {
        animationFrameId = requestAnimationFrame(animate);

        if (autoRotate && activeModelRoot) {
            targetRotationY += 0.005;
        }

        if (activeModelRoot) {
            activeModelRoot.rotation.y += (targetRotationY - activeModelRoot.rotation.y) * 0.08;
            activeModelRoot.rotation.x += (targetRotationX - activeModelRoot.rotation.x) * 0.08;
        }

        // Slowly spin pedestal neon rings
        ringViolet.rotation.z += 0.003;
        ringCyan.rotation.z -= 0.004;

        // Subtle particle float
        particles.rotation.y += 0.0008;

        // Project 3D Hotspot positions to 2D screen coordinates
        if (activeModelRoot && hotspotElements.length > 0) {
            const currentW = container.clientWidth;
            const currentH = container.clientHeight;

            hotspotElements.forEach(({ ann, el }) => {
                // Calculate world position taking model rotation & position into account
                tempVec.copy(ann.pos);
                tempVec.applyMatrix4(activeModelRoot.matrixWorld);

                // Check dot product with camera to detect if hotspot is facing camera or back of model
                const camDir = new THREE.Vector3().subVectors(camera.position, tempVec).normalize();
                const normal = tempVec.clone().normalize();
                const isFacing = normal.dot(camDir) > -0.2;

                tempVec.project(camera);

                // Convert NDC to screen pixels
                const screenX = (tempVec.x * 0.5 + 0.5) * currentW;
                const screenY = (-(tempVec.y * 0.5) + 0.5) * currentH;

                if (tempVec.z < 1.0 && isFacing && screenX >= 0 && screenX <= currentW && screenY >= 0 && screenY <= currentH) {
                    el.style.display = 'block';
                    el.style.left = `${screenX}px`;
                    el.style.top = `${screenY}px`;
                    el.style.opacity = '1';
                } else {
                    el.style.opacity = '0.15';
                }
            });
        }

        renderer.render(scene, camera);
    }
    animate();

    // 12. Resize Handler
    function onResize() {
        if (!container) return;
        const newW = container.clientWidth;
        const newH = container.clientHeight;
        camera.aspect = newW / newH;
        camera.updateProjectionMatrix();
        renderer.setSize(newW, newH);
    }
    window.addEventListener('resize', onResize);

    return () => {
        cancelAnimationFrame(animationFrameId);
        window.removeEventListener('resize', onResize);
        renderer.dispose();
    };
}
