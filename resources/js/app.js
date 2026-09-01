import { animate as animeAnimate, stagger as animeStagger } from 'animejs';
import { inView, animate as motionAnimate } from 'motion';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initial Hero Stagger Animation (Anime.js v4)
    if (document.querySelectorAll('.hero-stagger').length > 0) {
        animeAnimate('.hero-stagger', {
            translateY: [40, 0],
            opacity: [0, 1],
            duration: 900,
            delay: animeStagger(120, { start: 150 }),
            ease: 'outCubic'
        });
    }

    // 2. Floating 3D Badges & Orbs (Anime.js v4)
    animeAnimate('.animate-orb-1', {
        translateX: [-25, 25],
        translateY: [-20, 20],
        scale: [1, 1.12],
        duration: 7000,
        alternate: true,
        loop: true,
        ease: 'inOutSine'
    });

    animeAnimate('.animate-orb-2', {
        translateX: [20, -20],
        translateY: [25, -25],
        scale: [1, 1.15],
        duration: 8500,
        alternate: true,
        loop: true,
        ease: 'inOutSine'
    });

    animeAnimate('.hero-float-badge-1', {
        translateY: [-8, 8],
        rotate: [-1.5, 1.5],
        duration: 3500,
        alternate: true,
        loop: true,
        ease: 'inOutQuad'
    });

    animeAnimate('.hero-float-badge-2', {
        translateY: [8, -8],
        rotate: [1.5, -1.5],
        duration: 4000,
        alternate: true,
        loop: true,
        ease: 'inOutQuad',
        delay: 500
    });

    // 3. Interactive 3D Card Tilt Effect (Physics with Mousemove)
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

    // 4. Scroll-Triggered Reveal Animations (Motion.dev / inView)
    inView('.scroll-reveal', ({ target }) => {
        motionAnimate(
            target,
            { opacity: [0, 1], transform: ['translateY(30px)', 'translateY(0px)'] },
            { duration: 0.65, easing: [0.22, 1, 0.36, 1] }
        );
    });

    inView('.stagger-grid', ({ target }) => {
        const children = target.children;
        animeAnimate(children, {
            translateY: [40, 0],
            opacity: [0, 1],
            duration: 700,
            delay: animeStagger(100),
            ease: 'outQuad'
        });
    });

    // 5. Add to Cart Pulse & Bounce Feedback
    document.querySelectorAll('form[action*="/cart/add"]').forEach(form => {
        form.addEventListener('submit', () => {
            const badge = document.querySelector('#nav-cart-badge');
            if (badge) {
                badge.classList.remove('hidden');
                badge.classList.add('flex');
                animeAnimate(badge, {
                    scale: [1, 1.5, 0.9, 1.15, 1],
                    duration: 600,
                    ease: 'outElastic'
                });
            }
        });
    });

    // 6. Nano Banner Live Countdown Timer
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

