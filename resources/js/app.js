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

    // 2. Swiper Collection Slider ("SHOP BY COLLECTION")
    if (document.querySelector('.collection-swiper')) {
        new Swiper('.collection-swiper', {
            modules: [Navigation, Autoplay],
            slidesPerView: 1.2,
            spaceBetween: 16,
            autoplay: { delay: 4000, disableOnInteraction: false, pauseOnMouseEnter: true },
            navigation: {
                nextEl: '.collection-next',
                prevEl: '.collection-prev',
            },
            breakpoints: {
                640: { slidesPerView: 2.2, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 24 }
            }
        });
    }

    // 3. Swiper Trending Deals Carousel
    if (document.querySelector('.trending-swiper')) {
        new Swiper('.trending-swiper', {
            modules: [Navigation, Pagination],
            slidesPerView: 1.3,
            spaceBetween: 16,
            navigation: {
                nextEl: '.trending-next',
                prevEl: '.trending-prev',
            },
            pagination: { el: '.trending-pagination', clickable: true },
            breakpoints: {
                640: { slidesPerView: 2.3, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 24 }
            }
        });
    }

    // 4. Swiper Testimonials Slider
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

    // 5. Related Products Swiper
    if (document.querySelector('.related-swiper')) {
        new Swiper('.related-swiper', {
            modules: [Navigation, Autoplay],
            slidesPerView: 1.3,
            spaceBetween: 16,
            autoplay: { delay: 5000 },
            breakpoints: {
                640: { slidesPerView: 2.3, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 24 }
            }
        });
    }

    // 6. GSAP Smooth Animations
    if (document.querySelectorAll('.gsap-hero-title').length > 0) {
        gsap.from('.gsap-hero-title', {
            y: 40,
            opacity: 0,
            duration: 0.9,
            stagger: 0.12,
            ease: 'power3.out'
        });
    }

    // 7. Interactive 3D Card Hover Physics
    const tiltElements = document.querySelectorAll('.card-3d, .hero-3d-card, .category-card-3d');
    tiltElements.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = ((y - centerY) / centerY) * -8;
            const rotateY = ((x - centerX) / centerX) * 8;

            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
        });
    });

    // 8. Announcement Ticker Timer
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

    // Create 3D Particle Cloud
    const particleCount = 450;
    const geometry = new THREE.BufferGeometry();
    const positions = new Float32Array(particleCount * 3);
    const colors = new Float32Array(particleCount * 3);

    for (let i = 0; i < particleCount * 3; i += 3) {
        positions[i] = (Math.random() - 0.5) * 16;
        positions[i + 1] = (Math.random() - 0.5) * 16;
        positions[i + 2] = (Math.random() - 0.5) * 16;

        colors[i] = 0.9;
        colors[i + 1] = 0.9;
        colors[i + 2] = 0.95;
    }

    geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));

    const material = new THREE.PointsMaterial({
        size: 0.05,
        vertexColors: true,
        transparent: true,
        opacity: 0.6
    });

    const particles = new THREE.Points(geometry, material);
    scene.add(particles);

    // Add Rotating Wireframe Icosahedron Geometry
    const icoGeometry = new THREE.IcosahedronGeometry(2.5, 1);
    const icoMaterial = new THREE.MeshBasicMaterial({
        color: 0x818cf8,
        wireframe: true,
        transparent: true,
        opacity: 0.15
    });
    const icosahedron = new THREE.Mesh(icoGeometry, icoMaterial);
    icosahedron.position.set(3, 0, -2);
    scene.add(icosahedron);

    camera.position.z = 6;

    // Mouse Interaction
    let mouseX = 0;
    let mouseY = 0;
    window.addEventListener('mousemove', (e) => {
        mouseX = (e.clientX / window.innerWidth) * 2 - 1;
        mouseY = -(e.clientY / window.innerHeight) * 2 + 1;
    });

    // Animation Loop
    function animate() {
        requestAnimationFrame(animate);

        particles.rotation.y += 0.001;
        particles.rotation.x += 0.0005;

        icosahedron.rotation.x += 0.003;
        icosahedron.rotation.y += 0.004;

        camera.position.x += (mouseX * 0.5 - camera.position.x) * 0.05;
        camera.position.y += (mouseY * 0.5 - camera.position.y) * 0.05;
        camera.lookAt(scene.position);

        renderer.render(scene, camera);
    }

    animate();

    // Resize Handler
    window.addEventListener('resize', () => {
        if (!container) return;
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    });
}