import * as THREE from "three";

const container = document.getElementById("canvas-container");
const scene = new THREE.Scene();

const camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);
const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
renderer.setPixelRatio(window.devicePixelRatio);
renderer.setSize(window.innerWidth, window.innerHeight);
container.appendChild(renderer.domElement);

const textureLoader = new THREE.TextureLoader();
const textureColor = textureLoader.load("/images/gambar.jpeg");
const textureSketch = textureLoader.load("/images/gambar-sketsa.png");

// 1. Tambahkan u_time ke dalam Uniforms agar noise-nya bisa bergerak dinamis
const uniforms = {
    u_textureColor: { value: textureColor },
    u_textureSketch: { value: textureSketch },
    u_mouse: { value: new THREE.Vector2(0.5, 0.5) },
    u_radius: { value: 0.15 },
    u_resolution: {
        value: new THREE.Vector2(window.innerWidth, window.innerHeight),
    },
    u_time: { value: 0.0 }, // Menyimpan data waktu berjalan
};

const vertexShader = `
    varying vec2 vUv;
    void main() {
        vUv = uv;
        gl_Position = vec4(position, 1.0);
    }
`;

// 2. Fragment Shader dengan algoritma Pseudo-Random & Distortion Noise
const fragmentShader = `
    varying vec2 vUv;
    uniform sampler2D u_textureColor;
    uniform sampler2D u_textureSketch;
    uniform vec2 u_mouse;
    uniform float u_radius;
    uniform vec2 u_resolution;
    uniform float u_time;

    // Fungsi Hash untuk keacakan tingkat tinggi
    float hash(vec2 p) {
        p = fract(p * vec2(123.34, 456.21));
        p += dot(p, p + 45.32);
        return fract(p.x * p.y);
    }

    // Value Noise 2D standard
    float noise(vec2 p) {
        vec2 i = floor(p);
        vec2 f = fract(p);
        float a = hash(i);
        float b = hash(i + vec2(1.0, 0.0));
        float c = hash(i + vec2(0.0, 1.0));
        float d = hash(i + vec2(1.0, 1.0));
        vec2 u = f * f * (3.0 - 2.0 * f);
        return mix(a, b, u.x) + (c - a) * u.y * (1.0 - u.x) + (d - b) * u.x * u.y;
    }

    // FBM (Fractal Brownian Motion) untuk menumpuk noise agar tekstur pecahannya sangat kompleks
    float fbm(vec2 p) {
        float value = 0.0;
        float amplitude = 0.5;
        float frequency = 1.0;
        for (int i = 0; i < 3; i++) { // 3 Iterasi untuk detail pecahan tajam
            value += amplitude * noise(p * frequency);
            frequency *= 2.5;
            amplitude *= 0.5;
        }
        return value;
    }

    void main() {
        vec2 aspect = vec2(u_resolution.x / u_resolution.y, 1.0);
        vec2 uvCorrected = vUv * aspect;
        vec2 mouseCorrected = u_mouse * aspect;

        // --- PROSES EFEK SHATTER SANGAT ACAK (ASYMMETRIC DISTORTION) ---
        // Membuat dua arah distorsi koordinat yang berbeda berdasarkan FBM Noise
        vec2 noisePos1 = uvCorrected * 12.0 + vec2(u_time * 0.8, -u_time * 0.5);
        vec2 noisePos2 = uvCorrected * 24.0 + vec2(-u_time * 0.4, u_time * 0.9);
        
        // Gabungkan kedua noise untuk menciptakan distorsi pecahan yang benar-benar tidak beraturan
        float shatter = fbm(noisePos1) * 0.6 + fbm(noisePos2) * 0.4;
        
        // Menggunakan fungsi matematika tajam (fract/abs) untuk memberikan efek patahan/gerigi runcing
        shatter = abs(shatter - 0.5) * 2.0; 
        shatter = smoothstep(0.0, 1.0, shatter);

        // Hitung jarak murni dari cursor
        float dist = distance(uvCorrected, mouseCorrected);
        
        // Aplikasikan efek hancur (shatter) langsung ke radius lingkaran secara agresif
        // Angka 0.09 mengatur seberapa jauh jangkauan pecahan berantakan tersebut ke luar-dalam lingkaran
        float finalRadius = u_radius + (shatter - 0.5) * 0.09; 

        // Mengambil sampel warna dari kedua gambar (Berwarna & Sketsa)
        vec4 colorImg = texture2D(u_textureColor, vUv);
        vec4 sketchImg = texture2D(u_textureSketch, vUv);

        // Potong lingkaran dengan hasil radius baru yang sudah hancur total
        // Angka 0.008 memberikan sedikit kelembutan pada pinggiran pecahannya agar tidak patah-patah pixelated
        float circle = smoothstep(finalRadius, finalRadius - 0.008, dist);
        
        gl_FragColor = mix(colorImg, sketchImg, circle);
    }
`;

const geometry = new THREE.PlaneGeometry(2, 2);
const material = new THREE.ShaderMaterial({
    vertexShader,
    fragmentShader,
    uniforms,
});

const mesh = new THREE.Mesh(geometry, material);
scene.add(mesh);

function updateMousePosition(x, y) {
    uniforms.u_mouse.value.x = x / window.innerWidth;
    uniforms.u_mouse.value.y = 1.0 - y / window.innerHeight;
}

window.addEventListener("mousemove", (e) => {
    updateMousePosition(e.clientX, e.clientY);
});
window.addEventListener(
    "touchmove",
    (e) => {
        if (e.touches.length > 0)
            updateMousePosition(e.touches[0].clientX, e.touches[0].clientY);
    },
    { passive: true },
);
window.addEventListener(
    "touchstart",
    (e) => {
        if (e.touches.length > 0)
            updateMousePosition(e.touches[0].clientX, e.touches[0].clientY);
    },
    { passive: true },
);

window.addEventListener("resize", () => {
    renderer.setSize(window.innerWidth, window.innerHeight);
    uniforms.u_resolution.value.set(window.innerWidth, window.innerHeight);
});

// 3. Update u_time di dalam Loop Animasi
const clock = new THREE.Clock();

function animate() {
    requestAnimationFrame(animate);

    // Perbarui nilai waktu agar efek noise shatter-nya terlihat "hidup" dan bergerak halus
    uniforms.u_time.value = clock.getElapsedTime();

    renderer.render(scene, camera);
}
animate();
