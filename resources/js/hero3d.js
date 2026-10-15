import * as THREE from 'three';
import gsap from 'gsap';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';

export function initHero3D() {
    const container = document.getElementById('hero-3d-canvas');
    if (!container) return;

    const width = container.clientWidth;
    const height = container.clientHeight || 560;

    // 1. Scene setup
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(42, width / height, 0.1, 100);
    camera.position.set(0, 0.1, 2.7);

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

    const mainKeyLight = new THREE.DirectionalLight(0xffffff, 4.2);
    mainKeyLight.position.set(2.5, 3.5, 3.0);
    mainKeyLight.castShadow = true;
    scene.add(mainKeyLight);

    const cyanFill = new THREE.DirectionalLight(0xe2e8f0, 3.0);
    cyanFill.position.set(-2.5, 1.5, 2.5);
    scene.add(cyanFill);

    const violetRim = new THREE.DirectionalLight(0xc084fc, 4.5);
    violetRim.position.set(0, 3.5, -2.5);
    scene.add(violetRim);

    const bottomUpLight = new THREE.PointLight(0xffffff, 2.2, 10);
    bottomUpLight.position.set(0, -1.8, 1.8);
    scene.add(bottomUpLight);

    // 3. Glowing Sci-Fi Pedestal
    const pedestalGroup = new THREE.Group();
    pedestalGroup.position.y = -1.25;

    const diskGeo = new THREE.CylinderGeometry(1.4, 1.5, 0.08, 48);
    const diskMat = new THREE.MeshStandardMaterial({
        color: 0x0f0f18,
        roughness: 0.3,
        metalness: 0.7,
    });
    const disk = new THREE.Mesh(diskGeo, diskMat);
    disk.receiveShadow = true;
    pedestalGroup.add(disk);

    // Neon Glow Rings
    const ringVioletGeo = new THREE.RingGeometry(1.3, 1.36, 64);
    ringVioletGeo.rotateX(-Math.PI / 2);
    const ringViolet = new THREE.Mesh(ringVioletGeo, new THREE.MeshBasicMaterial({ color: 0x8b5cf6, side: THREE.DoubleSide }));
    ringViolet.position.y = 0.045;
    pedestalGroup.add(ringViolet);

    const ringCyanGeo = new THREE.RingGeometry(0.95, 1.0, 64);
    ringCyanGeo.rotateX(-Math.PI / 2);
    const ringCyan = new THREE.Mesh(ringCyanGeo, new THREE.MeshBasicMaterial({ color: 0x06b6d4, side: THREE.DoubleSide }));
    ringCyan.position.y = 0.046;
    pedestalGroup.add(ringCyan);

    scene.add(pedestalGroup);

    // 4. Subtle Floating Dust Particles
    const particlesCount = 60;
    const particlePositions = new Float32Array(particlesCount * 3);
    for (let i = 0; i < particlesCount * 3; i += 3) {
        particlePositions[i] = (Math.random() - 0.5) * 5;
        particlePositions[i + 1] = (Math.random() - 0.5) * 4;
        particlePositions[i + 2] = (Math.random() - 0.5) * 4;
    }
    const particleGeo = new THREE.BufferGeometry();
    particleGeo.setAttribute('position', new THREE.BufferAttribute(particlePositions, 3));
    const particleMat = new THREE.PointsMaterial({
        color: 0xa855f7,
        size: 0.03,
        transparent: true,
        opacity: 0.5,
    });
    const particles = new THREE.Points(particleGeo, particleMat);
    scene.add(particles);

    // 5. GLTF Loader Setup
    const loader = new GLTFLoader();
    const models = {
        hoodie: '/models/hoodie.glb',
        tee: '/models/shirt_baked.glb',
        shoe: '/models/shoe.glb',
    };

    let activeModelRoot = null;
    let currentColor = '#16161a';
    let currentGarmentKey = 'hoodie';

    // Loading indicator element
    let loaderEl = document.getElementById('hero-3d-loader');
    if (!loaderEl) {
        loaderEl = document.createElement('div');
        loaderEl.id = 'hero-3d-loader';
        loaderEl.className = 'absolute inset-0 flex flex-col items-center justify-center bg-black/40 backdrop-blur-sm z-30 transition-opacity duration-300';
        loaderEl.innerHTML = `
            <div class="w-10 h-10 border-2 border-violet-500 border-t-cyan-400 rounded-full animate-spin mb-2"></div>
            <span class="text-xs font-mono text-cyan-300 tracking-wider">LOADING 3D MESH...</span>
        `;
        container.parentElement.appendChild(loaderEl);
    }

    function showLoader(show) {
        if (!loaderEl) return;
        if (show) {
            loaderEl.classList.remove('opacity-0', 'pointer-events-none');
            loaderEl.classList.add('opacity-100');
        } else {
            loaderEl.classList.remove('opacity-100');
            loaderEl.classList.add('opacity-0', 'pointer-events-none');
        }
    }

    function normalizeColor(hex) {
        if (!hex || hex === '#16161a' || hex === '#000000' || hex === '#111111') {
            return '#33333f';
        }
        return hex;
    }

    function applyColorToModel(root, hex) {
        const normalized = normalizeColor(hex);
        currentColor = normalized;

        if (currentGarmentKey === 'shoe') {
            root.traverse((child) => {
                if (child.isMesh && child.material) {
                    const mats = Array.isArray(child.material) ? child.material : [child.material];
                    mats.forEach((mat) => {
                        if (mat.color) {
                            mat.color.setRGB(1, 1, 1);
                        }
                        mat.roughness = 0.55;
                        mat.metalness = 0.15;
                    });
                }
            });
            return;
        }

        const targetColor = new THREE.Color(normalized);

        root.traverse((child) => {
            if (child.isMesh && child.material) {
                const mats = Array.isArray(child.material) ? child.material : [child.material];
                mats.forEach((mat) => {
                    mat.roughness = 0.52;
                    mat.metalness = 0.08;
                    if (mat.color) {
                        gsap.to(mat.color, {
                            r: targetColor.r,
                            g: targetColor.g,
                            b: targetColor.b,
                            duration: 0.45,
                            ease: 'power2.out',
                        });
                    }
                });
            }
        });
    }

    function loadModel(garmentKey) {
        currentGarmentKey = garmentKey;
        const url = models[garmentKey] || models.hoodie;
        showLoader(true);

        loader.load(
            url,
            (gltf) => {
                if (activeModelRoot) {
                    scene.remove(activeModelRoot);
                }

                const model = gltf.scene;

                // Center & Scale normalization
                const box = new THREE.Box3().setFromObject(model);
                const size = box.getSize(new THREE.Vector3());
                const center = box.getCenter(new THREE.Vector3());

                // Scale to fit ~1.6 units high
                const maxDim = Math.max(size.x, size.y, size.z);
                const targetScale = garmentKey === 'shoe' ? 2.2 / maxDim : 1.7 / maxDim;
                model.scale.setScalar(targetScale);

                // Re-center
                model.position.x = -center.x * targetScale;
                model.position.y = -center.y * targetScale + (garmentKey === 'shoe' ? -0.1 : 0.05);
                model.position.z = -center.z * targetScale;

                // Configure materials for realistic rendering
                model.traverse((child) => {
                    if (child.isMesh) {
                        child.castShadow = true;
                        child.receiveShadow = true;
                        if (child.material) {
                            child.material.side = THREE.DoubleSide;
                        }
                    }
                });

                // Create a parent wrapper for smooth animations
                const wrapper = new THREE.Group();
                wrapper.add(model);
                activeModelRoot = wrapper;
                scene.add(activeModelRoot);

                // Apply currently selected color
                applyColorToModel(activeModelRoot, currentColor);

                // Entrance animation
                gsap.from(wrapper.scale, {
                    x: 0.01,
                    y: 0.01,
                    z: 0.01,
                    duration: 0.7,
                    ease: 'back.out(1.5)',
                });

                showLoader(false);
            },
            undefined,
            (err) => {
                console.error('Failed to load 3D model:', err);
                showLoader(false);
            }
        );
    }

    // Initial load
    loadModel('hoodie');

    // 6. Interactive Drag Controls
    let isDragging = false;
    let previousMousePosition = { x: 0, y: 0 };
    let targetRotationY = 0;
    let targetRotationX = 0;
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
        setTimeout(() => {
            if (!isDragging) autoRotate = true;
        }, 3500);
    });

    // 7. Interactive Color Buttons
    const colorButtons = document.querySelectorAll('[data-hero-color]');
    colorButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const hex = btn.getAttribute('data-hero-color');
            colorButtons.forEach((b) => b.classList.remove('ring-2', 'ring-cyan-400', 'scale-110'));
            btn.classList.add('ring-2', 'ring-cyan-400', 'scale-110');

            if (activeModelRoot) {
                applyColorToModel(activeModelRoot, hex);
            }
        });
    });

    // 8. Garment Switcher Buttons
    const garmentButtons = document.querySelectorAll('[data-hero-garment]');
    garmentButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const type = btn.getAttribute('data-hero-garment');
            garmentButtons.forEach((b) => {
                b.classList.remove('bg-violet-600', 'text-white', 'border-violet-500');
                b.classList.add('bg-white/5', 'text-gray-300', 'border-white/10');
            });
            btn.classList.add('bg-violet-600', 'text-white', 'border-violet-500');
            btn.classList.remove('bg-white/5', 'text-gray-300', 'border-white/10');

            targetRotationX = 0;
            targetRotationY = 0;
            loadModel(type);
        });
    });

    // 9. Animation Loop
    const clock = new THREE.Clock();

    function animate() {
        requestAnimationFrame(animate);
        const elapsedTime = clock.getElapsedTime();

        if (activeModelRoot) {
            // Floating bobbing effect
            activeModelRoot.position.y = Math.sin(elapsedTime * 1.8) * 0.04;

            if (autoRotate) {
                targetRotationY += 0.007;
            }

            // Smooth interpolation
            activeModelRoot.rotation.y += (targetRotationY - activeModelRoot.rotation.y) * 0.08;
            activeModelRoot.rotation.x += (targetRotationX - activeModelRoot.rotation.x) * 0.08;
        }

        // Rotate pedestal slowly
        pedestalGroup.rotation.y = elapsedTime * 0.12;

        // Dust drift
        particles.rotation.y = elapsedTime * 0.05;

        renderer.render(scene, camera);
    }

    animate();

    // 10. Responsive Resize
    function handleResize() {
        if (!container) return;
        const newWidth = container.clientWidth;
        const newHeight = container.clientHeight || 560;
        camera.aspect = newWidth / newHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(newWidth, newHeight);
    }

    window.addEventListener('resize', handleResize);
}
