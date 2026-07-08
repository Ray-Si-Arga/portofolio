import * as THREE from "three";

const container = document.getElementById("canvas-container");
if (!container) throw new Error("Canvas container tidak ditemukan");

const scene = new THREE.Scene();
const camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);
const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
renderer.setPixelRatio(window.devicePixelRatio);
renderer.setSize(window.innerWidth, window.innerHeight);
container.appendChild(renderer.domElement);

const textureLoader = new THREE.TextureLoader();
const textureColor = textureLoader.load("/images/gambar.jpeg");
const textureSketch = textureLoader.load("/images/gambar-sketsa.png");

// Enhanced uniforms untuk efek neon geometric
const uniforms = {
    u_textureColor: { value: textureColor },
    u_textureSketch: { value: textureSketch },
    u_mouse: { value: new THREE.Vector2(0.5, 0.5) },
    u_radius: { value: 0.12 },
    u_resolution: { value: new THREE.Vector2(window.innerWidth, window.innerHeight) },
    u_time: { value: 0.0 },
    u_neonIntensity: { value: 0.8 },
};

const vertexShader = `
    varying vec2 vUv;
    void main() {
        vUv = uv;
        gl_Position = vec4(position, 1.0);
    }
`;

// Enhanced Fragment Shader dengan neon geometric vibes
const fragmentShader = `
    varying vec2 vUv;
    uniform sampler2D u_textureColor;
    uniform sampler2D u_textureSketch;
    uniform vec2 u_mouse;
    uniform float u_radius;
    uniform vec2 u_resolution;
    uniform float u_time;
    uniform float u_neonIntensity;

    // Fungsi Hash untuk keacakan tingkat tinggi
    float hash(vec2 p) {
        p = fract(p * vec2(123.34, 456.21));
        p += dot(p, p + 45.32);
        return fract(p.x * p.y);
    }

    // Value Noise 2D
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

    // FBM (Fractal Brownian Motion)
    float fbm(vec2 p) {
        float value = 0.0;
        float amplitude = 0.5;
        float frequency = 1.0;
        for (int i = 0; i < 4; i++) {
            value += amplitude * noise(p * frequency);
            frequency *= 2.2;
            amplitude *= 0.5;
        }
        return value;
    }

    // Geometric pattern dengan garis-garis neon
    float geometricPattern(vec2 p) {
        float pattern = 0.0;
        
        // Grid lines dengan rotasi dinamis
        float grid1 = sin(p.x * 8.0 + u_time * 0.3) * cos(p.y * 8.0 - u_time * 0.2);
        float grid2 = sin((p.x + p.y) * 6.0 + u_time * 0.4) * cos((p.x - p.y) * 6.0 - u_time * 0.3);
        
        pattern = (grid1 + grid2) * 0.5;
        return smoothstep(-0.3, 0.3, pattern);
    }

    void main() {
        vec2 aspect = vec2(u_resolution.x / u_resolution.y, 1.0);
        vec2 uvCorrected = vUv * aspect;
        vec2 mouseCorrected = u_mouse * aspect;

        // Advanced shatter effect dengan geometric distortion
        vec2 noisePos1 = uvCorrected * 15.0 + vec2(u_time * 0.8, -u_time * 0.5);
        vec2 noisePos2 = uvCorrected * 28.0 + vec2(-u_time * 0.4, u_time * 0.9);
        vec2 noisePos3 = uvCorrected * 8.0 + vec2(u_time * 0.3, u_time * 0.4);
        
        float shatter = fbm(noisePos1) * 0.5 + fbm(noisePos2) * 0.3 + fbm(noisePos3) * 0.2;
        shatter = abs(shatter - 0.5) * 2.0;
        shatter = smoothstep(0.0, 1.0, shatter);

        // Geometric pattern layer
        float geom = geometricPattern(uvCorrected * 2.0 + u_time * 0.2);

        // Distance dari cursor
        float dist = distance(uvCorrected, mouseCorrected);
        
        // Enhanced radius dengan geometric influence
        float finalRadius = u_radius + (shatter - 0.5) * 0.1 + geom * 0.03;

        // Sampling dari texture
        vec4 colorImg = texture2D(u_textureColor, vUv);
        vec4 sketchImg = texture2D(u_textureSketch, vUv);

        // Main circle dengan smooth edges
        float circle = smoothstep(finalRadius, finalRadius - 0.01, dist);
        
        // Glow effect (neon)
        float glow = exp(-dist * 8.0) * u_neonIntensity * 0.3;
        
        vec4 finalColor = mix(colorImg, sketchImg, circle);
        
        // Apply glow dengan neon cyan-magenta tint
        vec3 neonGlow = vec3(
            sin(u_time * 0.5) * 0.5 + 0.5,  // Cyan
            0.2,
            cos(u_time * 0.5) * 0.5 + 0.5   // Magenta
        );
        
        finalColor.rgb += glow * neonGlow * 0.5;
        
        gl_FragColor = finalColor;
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

// Mouse events
window.addEventListener("mousemove", (e) => {
    updateMousePosition(e.clientX, e.clientY);
});

// Touch events
window.addEventListener("touchmove", (e) => {
    if (e.touches.length > 0) {
        updateMousePosition(e.touches[0].clientX, e.touches[0].clientY);
    }
}, { passive: true });

window.addEventListener("touchstart", (e) => {
    if (e.touches.length > 0) {
        updateMousePosition(e.touches[0].clientX, e.touches[0].clientY);
    }
}, { passive: true });

// Resize handler
window.addEventListener("resize", () => {
    renderer.setSize(window.innerWidth, window.innerHeight);
    uniforms.u_resolution.value.set(window.innerWidth, window.innerHeight);
});

// Animation loop
const clock = new THREE.Clock();

function animate() {
    requestAnimationFrame(animate);
    uniforms.u_time.value = clock.getElapsedTime();
    renderer.render(scene, camera);
}

animate();