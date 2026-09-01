import Alpine from 'alpinejs';
import { gsap } from 'gsap';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';
import ApexCharts from 'apexcharts';
import * as THREE from 'three';
import '@google/model-viewer';
import { animate as animeAnimate, stagger as animeStagger } from 'animejs';

window.Alpine = Alpine;
window.ApexCharts = ApexCharts;
window.gsap = gsap;
window.Swiper = Swiper;
window.THREE = THREE;

// Start Alpine
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    // 1. Interactive 3D Canvas Background in Hero (Three.js)
    const heroCanvas = document.getElementById('hero-3d-canvas');
    if (heroCanvas) {
        initHero3DCanvas(heroCanvas);
    }

    // 2. Swiper Testimonials & Featured Sliders
    if (document.querySelector('.testimonial-swiper')) {
        new Swiper('.testimonial-swiper', {
            modules: [Pagination, Autoplay, Navigation],
            slidesPerView: 1,
            spaceBetween: 24,
            autoplay: { delay: 4500, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            }
        });
    }

    if (document.querySelector('.related-swiper')) {
        new Swiper('.related-swiper', {
            modules: [Navigation, Autoplay],
            slidesPerView: 1,
            spaceBetween: 20,
            autoplay: { delay: 5000 },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 4 }
            }
        });
    }

    // 3. GSAP Staggered Intro Animations
    if (document.querySelectorAll('.gsap-hero-title').length > 0) {
        gsap.from('.gsap-hero-title', {
            y: 50,
            opacity: 0,
            duration: 1,
            stagger: 0.15,
            ease: 'power3.out'
        });
    }

    // 4. Interactive 3D Card Tilt Effect (Mouse Physics)
    const tiltElements = document.querySelectorAll('.card-3d, .hero-3d-card, .category-card-3d');
    tiltElements.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = ((y - centerY) / centerY) * -10;
            const rotateY = ((x - centerX) / centerX) * 10;

            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
        });
    });

    // 5. Nano Banner Countdown Timer
    const timerElement = document.getElementById('nano-banner-timer');
    if (timerElement) {
        let totalSeconds = 5 * 3600 + 42 * 60 + 19;
        setInterval(() => {
            if (totalSeconds > 0) {
                totalSeconds--;
                const hours = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
                const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
                const seconds = String(totalSeconds % 60).padStart(2, '0');
                timerElement.innerText = `${hours}:${minutes}:${seconds}`;
            }
        }, 1000);
    }
});

// Three.js 3D Particles & Mesh Canvas Function
function initHero3DCanvas(container) {
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(60, container.clientWidth / container.clientHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    container.appendChild(renderer.domElement);

    // Particle Sphere Geometry
    const geometry = new THREE.BufferGeometry();
    const particlesCount = 350;
    const posArray = new Float32Array(particlesCount * 3);

    for (let i = 0; i < particlesCount * 3; i++) {
        posArray[i] = (Math.random() - 0.5) * 12;
    }

    geometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));

    const material = new THREE.PointsMaterial({
        size: 0.045,
        color: 0x818cf8,
        transparent: true,
        opacity: 0.75,
        blending: THREE.AdditiveBlending
    });

    const particlesMesh = new THREE.Points(geometry, material);
    scene.add(particlesMesh);

    // Torus Knot Accent Mesh
    const torusGeo = new THREE.TorusKnotGeometry(1.6, 0.45, 64, 16);
    const torusMat = new THREE.MeshBasicMaterial({
        color: 0x4f46e5,
        wireframe: true,
        transparent: true,
        opacity: 0.18
    });
    const torusMesh = new THREE.Mesh(torusGeo, torusMat);
    scene.add(torusMesh);

    camera.position.z = 6;

    // Mouse Parallax Interaction
    let mouseX = 0;
    let mouseY = 0;

    window.addEventListener('mousemove', (e) => {
        mouseX = (e.clientX / window.innerWidth) - 0.5;
        mouseY = (e.clientY / window.innerHeight) - 0.5;
    });

    // Animation Loop
    const animate = () => {
        requestAnimationFrame(animate);

        particlesMesh.rotation.y += 0.002;
        particlesMesh.rotation.x += 0.001;

        torusMesh.rotation.x += 0.004;
        torusMesh.rotation.y += 0.005;

        // Smooth camera follow mouse
        camera.position.x += (mouseX * 2 - camera.position.x) * 0.05;
        camera.position.y += (-mouseY * 2 - camera.position.y) * 0.05;
        camera.lookAt(scene.position);

        renderer.render(scene, camera);
    };

    animate();

    // Window Resize Handler
    window.addEventListener('resize', () => {
        if (container.clientWidth > 0 && container.clientHeight > 0) {
            camera.aspect = container.clientWidth / container.clientHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(container.clientWidth, container.clientHeight);
        }
    });
}