import * as THREE from 'three';

/**
 * Creates a procedural weave bump texture to give 3D cloth realistic fabric micro-texture.
 */
export function createFabricTexture(type = 'cotton') {
    const canvas = document.createElement('canvas');
    canvas.width = 512;
    canvas.height = 512;
    const ctx = canvas.getContext('2d');

    ctx.fillStyle = '#808080';
    ctx.fillRect(0, 0, 512, 512);

    // Generate weave pattern
    const step = type === 'satin' ? 4 : 3;
    const intensity = type === 'satin' ? 12 : 25;

    for (let x = 0; x < 512; x += step) {
        for (let y = 0; y < 512; y += step) {
            const isWeave = (Math.floor(x / step) + Math.floor(y / step)) % 2 === 0;
            const noise = (Math.random() - 0.5) * intensity;
            const val = Math.min(255, Math.max(0, 128 + (isWeave ? 20 : -20) + noise));
            ctx.fillStyle = `rgb(${val},${val},${val})`;
            ctx.fillRect(x, y, step, step);
        }
    }

    const texture = new THREE.CanvasTexture(canvas);
    texture.wrapS = THREE.RepeatWrapping;
    texture.wrapT = THREE.RepeatWrapping;
    texture.repeat.set(type === 'satin' ? 12 : 8, type === 'satin' ? 12 : 8);
    return texture;
}

/**
 * Creates a high quality MeshStandardMaterial or MeshPhysicalMaterial for clothing.
 */
export function createClothMaterial(colorHex, type = 'cotton', wireframe = false) {
    const bumpTex = createFabricTexture(type);

    const isSatin = type === 'satin';
    const isLeather = type === 'leather';

    return new THREE.MeshStandardMaterial({
        color: new THREE.Color(colorHex),
        roughness: isSatin ? 0.35 : isLeather ? 0.4 : 0.82,
        metalness: isSatin ? 0.2 : isLeather ? 0.15 : 0.05,
        bumpMap: bumpTex,
        bumpScale: isSatin ? 0.002 : isLeather ? 0.008 : 0.015,
        side: THREE.DoubleSide,
        wireframe: wireframe,
    });
}

/**
 * Metal material for zippers, aglets, and buttons.
 */
export function createMetalMaterial() {
    return new THREE.MeshStandardMaterial({
        color: new THREE.Color(0xd0d4dc),
        metalness: 0.9,
        roughness: 0.25,
    });
}

/**
 * Build 3D Garment Group
 */
export function buildGarmentMesh(garmentType, colorHex, wireframe = false) {
    const group = new THREE.Group();
    group.name = 'garmentGroup';

    const fabricType = garmentType === 'dress' ? 'satin' : garmentType === 'jacket' ? 'leather' : 'cotton';
    const mainMat = createClothMaterial(colorHex, fabricType, wireframe);
    const metalMat = createMetalMaterial();

    switch (garmentType) {
        case 'hoodie':
            buildHoodie(group, mainMat, metalMat);
            break;
        case 'jacket':
            buildJacket(group, mainMat, metalMat);
            break;
        case 'pants':
            buildCargoPants(group, mainMat, metalMat);
            break;
        case 'dress':
            buildSatinDress(group, mainMat);
            break;
        case 'sweatshirt':
            buildSweatshirt(group, mainMat);
            break;
        case 'tee':
        default:
            buildTee(group, mainMat);
            break;
    }

    return { group, mainMat, metalMat };
}

/**
 * T-SHIRT 3D GEOMETRY
 */
function buildTee(group, mat) {
    // Torso body
    const torsoGeo = new THREE.CylinderGeometry(0.85, 0.9, 1.8, 32, 16, true);
    // Add subtle organic curve/flare
    const pos = torsoGeo.attributes.position;
    for (let i = 0; i < pos.count; i++) {
        const y = pos.getY(i);
        const z = pos.getZ(i);
        // Chest depth
        pos.setZ(i, z * 0.75 + Math.sin((y + 0.9) * 1.5) * 0.05);
    }
    torsoGeo.computeVertexNormals();
    const torso = new THREE.Mesh(torsoGeo, mat);
    torso.position.y = 0;
    group.add(torso);

    // Collar ribbing
    const collarGeo = new THREE.TorusGeometry(0.48, 0.045, 16, 32);
    collarGeo.rotateX(Math.PI / 2);
    const collar = new THREE.Mesh(collarGeo, mat);
    collar.position.y = 0.9;
    group.add(collar);

    // Left Sleeve
    const sleeveGeoL = new THREE.CylinderGeometry(0.38, 0.34, 0.75, 24);
    sleeveGeoL.rotateZ(-Math.PI / 4);
    const sleeveL = new THREE.Mesh(sleeveGeoL, mat);
    sleeveL.position.set(-1.05, 0.62, 0);
    group.add(sleeveL);

    // Right Sleeve
    const sleeveGeoR = new THREE.CylinderGeometry(0.38, 0.34, 0.75, 24);
    sleeveGeoR.rotateZ(Math.PI / 4);
    const sleeveR = new THREE.Mesh(sleeveGeoR, mat);
    sleeveR.position.set(1.05, 0.62, 0);
    group.add(sleeveR);

    // Hem bottom band
    const hemGeo = new THREE.TorusGeometry(0.9, 0.035, 16, 32);
    hemGeo.rotateX(Math.PI / 2);
    const hem = new THREE.Mesh(hemGeo, mat);
    hem.position.y = -0.9;
    group.add(hem);
}

/**
 * HOODIE 3D GEOMETRY
 */
function buildHoodie(group, mat, metalMat) {
    // Torso (oversized heavyweight)
    const torsoGeo = new THREE.CylinderGeometry(0.92, 0.88, 1.9, 32, 16, true);
    const pos = torsoGeo.attributes.position;
    for (let i = 0; i < pos.count; i++) {
        const y = pos.getY(i);
        const z = pos.getZ(i);
        pos.setZ(i, z * 0.82 + Math.sin((y + 1) * 1.4) * 0.07);
    }
    torsoGeo.computeVertexNormals();
    const torso = new THREE.Mesh(torsoGeo, mat);
    group.add(torso);

    // Kangaroo Pocket
    const pocketShape = new THREE.Shape();
    pocketShape.moveTo(-0.5, -0.6);
    pocketShape.lineTo(0.5, -0.6);
    pocketShape.lineTo(0.42, -0.15);
    pocketShape.lineTo(-0.42, -0.15);
    pocketShape.closePath();

    const pocketGeo = new THREE.ShapeGeometry(pocketShape);
    const pocket = new THREE.Mesh(pocketGeo, mat);
    pocket.position.set(0, 0, 0.47);
    group.add(pocket);

    // Ribbed bottom hem
    const hemGeo = new THREE.CylinderGeometry(0.87, 0.87, 0.16, 32);
    const hem = new THREE.Mesh(hemGeo, mat);
    hem.position.y = -0.98;
    group.add(hem);

    // Sleeves with cuffs
    const sleeveGeoL = new THREE.CylinderGeometry(0.42, 0.32, 1.35, 24);
    sleeveGeoL.rotateZ(-Math.PI / 4.8);
    const sleeveL = new THREE.Mesh(sleeveGeoL, mat);
    sleeveL.position.set(-1.25, 0.35, 0);
    group.add(sleeveL);

    const cuffL = new THREE.CylinderGeometry(0.3, 0.3, 0.14, 24);
    cuffL.rotateZ(-Math.PI / 4.8);
    const cuffMeshL = new THREE.Mesh(cuffL, mat);
    cuffMeshL.position.set(-1.75, -0.18, 0);
    group.add(cuffMeshL);

    const sleeveGeoR = new THREE.CylinderGeometry(0.42, 0.32, 1.35, 24);
    sleeveGeoR.rotateZ(Math.PI / 4.8);
    const sleeveR = new THREE.Mesh(sleeveGeoR, mat);
    sleeveR.position.set(1.25, 0.35, 0);
    group.add(sleeveR);

    const cuffR = new THREE.CylinderGeometry(0.3, 0.3, 0.14, 24);
    cuffR.rotateZ(Math.PI / 4.8);
    const cuffMeshR = new THREE.Mesh(cuffR, mat);
    cuffMeshR.position.set(1.75, -0.18, 0);
    group.add(cuffMeshR);

    // 3D Draped Hood (Torus/Sphere combination)
    const hoodGeo = new THREE.SphereGeometry(0.68, 32, 24, 0, Math.PI * 2, 0, Math.PI * 0.7);
    const hood = new THREE.Mesh(hoodGeo, mat);
    hood.position.set(0, 1.05, -0.15);
    hood.rotation.x = -0.35;
    group.add(hood);

    // Drawstrings with metal aglets
    const stringGeoL = new THREE.CylinderGeometry(0.015, 0.015, 0.55, 8);
    const stringL = new THREE.Mesh(stringGeoL, mat);
    stringL.position.set(-0.16, 0.65, 0.45);
    group.add(stringL);

    const agletL = new THREE.CylinderGeometry(0.02, 0.02, 0.07, 8);
    const agletMeshL = new THREE.Mesh(agletL, metalMat);
    agletMeshL.position.set(-0.16, 0.35, 0.45);
    group.add(agletMeshL);

    const stringGeoR = new THREE.CylinderGeometry(0.015, 0.015, 0.55, 8);
    const stringR = new THREE.Mesh(stringGeoR, mat);
    stringR.position.set(0.16, 0.65, 0.45);
    group.add(stringR);

    const agletR = new THREE.CylinderGeometry(0.02, 0.02, 0.07, 8);
    const agletMeshR = new THREE.Mesh(agletR, metalMat);
    agletMeshR.position.set(0.16, 0.35, 0.45);
    group.add(agletMeshR);
}

/**
 * SWEATSHIRT 3D GEOMETRY
 */
function buildSweatshirt(group, mat) {
    const torsoGeo = new THREE.CylinderGeometry(0.88, 0.84, 1.85, 32, 16, true);
    const torso = new THREE.Mesh(torsoGeo, mat);
    group.add(torso);

    const collarGeo = new THREE.TorusGeometry(0.44, 0.055, 16, 32);
    collarGeo.rotateX(Math.PI / 2);
    const collar = new THREE.Mesh(collarGeo, mat);
    collar.position.y = 0.92;
    group.add(collar);

    const sleeveGeoL = new THREE.CylinderGeometry(0.4, 0.3, 1.3, 24);
    sleeveGeoL.rotateZ(-Math.PI / 4.6);
    const sleeveL = new THREE.Mesh(sleeveGeoL, mat);
    sleeveL.position.set(-1.2, 0.32, 0);
    group.add(sleeveL);

    const sleeveGeoR = new THREE.CylinderGeometry(0.4, 0.3, 1.3, 24);
    sleeveGeoR.rotateZ(Math.PI / 4.6);
    const sleeveR = new THREE.Mesh(sleeveGeoR, mat);
    sleeveR.position.set(1.2, 0.32, 0);
    group.add(sleeveR);

    const hemGeo = new THREE.CylinderGeometry(0.83, 0.83, 0.14, 32);
    const hem = new THREE.Mesh(hemGeo, mat);
    hem.position.y = -0.96;
    group.add(hem);
}

/**
 * JACKET (BOMBER / BIKER) 3D GEOMETRY
 */
function buildJacket(group, mat, metalMat) {
    // Torso
    const torsoGeo = new THREE.CylinderGeometry(0.92, 0.88, 1.8, 32, 16, true);
    const torso = new THREE.Mesh(torsoGeo, mat);
    group.add(torso);

    // Central zipper strip (metal)
    const zipGeo = new THREE.BoxGeometry(0.04, 1.76, 0.03);
    const zipMesh = new THREE.Mesh(zipGeo, metalMat);
    zipMesh.position.set(0, 0, 0.46);
    group.add(zipMesh);

    // Zipper pull slider
    const pullGeo = new THREE.BoxGeometry(0.06, 0.12, 0.05);
    const pull = new THREE.Mesh(pullGeo, metalMat);
    pull.position.set(0, 0.3, 0.49);
    group.add(pull);

    // Collar
    const collarGeo = new THREE.TorusGeometry(0.47, 0.07, 16, 32);
    collarGeo.rotateX(Math.PI / 2);
    const collar = new THREE.Mesh(collarGeo, mat);
    collar.position.y = 0.9;
    group.add(collar);

    // Sleeves
    const sleeveGeoL = new THREE.CylinderGeometry(0.44, 0.34, 1.35, 24);
    sleeveGeoL.rotateZ(-Math.PI / 4.6);
    const sleeveL = new THREE.Mesh(sleeveGeoL, mat);
    sleeveL.position.set(-1.25, 0.32, 0);
    group.add(sleeveL);

    const sleeveGeoR = new THREE.CylinderGeometry(0.44, 0.34, 1.35, 24);
    sleeveGeoR.rotateZ(Math.PI / 4.6);
    const sleeveR = new THREE.Mesh(sleeveGeoR, mat);
    sleeveR.position.set(1.25, 0.32, 0);
    group.add(sleeveR);

    // Waistband
    const hemGeo = new THREE.CylinderGeometry(0.86, 0.86, 0.14, 32);
    const hem = new THREE.Mesh(hemGeo, mat);
    hem.position.y = -0.93;
    group.add(hem);
}

/**
 * CARGO PANTS 3D GEOMETRY
 */
function buildCargoPants(group, mat, metalMat) {
    // Waistband
    const waistGeo = new THREE.CylinderGeometry(0.72, 0.72, 0.22, 32);
    const waist = new THREE.Mesh(waistGeo, mat);
    waist.position.y = 0.95;
    group.add(waist);

    // Metal waist button
    const btnGeo = new THREE.CylinderGeometry(0.04, 0.04, 0.02, 16);
    btnGeo.rotateX(Math.PI / 2);
    const btn = new THREE.Mesh(btnGeo, metalMat);
    btn.position.set(0, 0.95, 0.37);
    group.add(btn);

    // Left Leg
    const legGeoL = new THREE.CylinderGeometry(0.38, 0.28, 1.85, 24);
    const legL = new THREE.Mesh(legGeoL, mat);
    legL.position.set(-0.38, -0.05, 0);
    group.add(legL);

    // Right Leg
    const legGeoR = new THREE.CylinderGeometry(0.38, 0.28, 1.85, 24);
    const legR = new THREE.Mesh(legGeoR, mat);
    legR.position.set(0.38, -0.05, 0);
    group.add(legR);

    // Cargo Pockets (left & right outer thighs)
    const pocketGeoL = new THREE.BoxGeometry(0.12, 0.45, 0.35);
    const pocketL = new THREE.Mesh(pocketGeoL, mat);
    pocketL.position.set(-0.76, 0.05, 0);
    group.add(pocketL);

    const pocketGeoR = new THREE.BoxGeometry(0.12, 0.45, 0.35);
    const pocketR = new THREE.Mesh(pocketGeoR, mat);
    pocketR.position.set(0.76, 0.05, 0);
    group.add(pocketR);

    // Ankle cuffs
    const cuffL = new THREE.CylinderGeometry(0.28, 0.28, 0.1, 24);
    cuffL.position.set(-0.38, -1.0, 0);
    group.add(new THREE.Mesh(cuffL, mat));

    const cuffR = new THREE.CylinderGeometry(0.28, 0.28, 0.1, 24);
    cuffR.position.set(0.38, -1.0, 0);
    group.add(new THREE.Mesh(cuffR, mat));
}

/**
 * SATIN SLIP DRESS 3D GEOMETRY
 */
function buildSatinDress(group, mat) {
    // Elegant flowing bodice & skirt (curved lathe / cylinder)
    const dressGeo = new THREE.CylinderGeometry(0.55, 1.15, 2.3, 32, 24, true);
    const pos = dressGeo.attributes.position;
    for (let i = 0; i < pos.count; i++) {
        const y = pos.getY(i);
        const z = pos.getZ(i);
        const x = pos.getX(i);
        // Cinch waist at y = 0.5
        const waistFactor = 1 - 0.2 * Math.exp(-Math.pow((y - 0.4) / 0.5, 2));
        pos.setX(i, x * waistFactor);
        pos.setZ(i, z * waistFactor * 0.75);
    }
    dressGeo.computeVertexNormals();
    const dress = new THREE.Mesh(dressGeo, mat);
    dress.position.y = -0.15;
    group.add(dress);

    // Delicate Spaghetti Straps
    const strapGeoL = new THREE.CylinderGeometry(0.015, 0.015, 0.45, 8);
    strapGeoL.rotateZ(0.15);
    const strapL = new THREE.Mesh(strapGeoL, mat);
    strapL.position.set(-0.28, 1.15, 0);
    group.add(strapL);

    const strapGeoR = new THREE.CylinderGeometry(0.015, 0.015, 0.45, 8);
    strapGeoR.rotateZ(-0.15);
    const strapR = new THREE.Mesh(strapGeoR, mat);
    strapR.position.set(0.28, 1.15, 0);
    group.add(strapR);
}
