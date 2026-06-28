const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

document.documentElement.classList.add('motion-ready');

const navbar = document.querySelector('[data-navbar]');
const toggle = document.getElementById('menu-toggle');
const menu = document.getElementById('mobile-menu');

const updateNavbar = () => navbar?.classList.toggle('is-scrolled', window.scrollY > 12);
updateNavbar();
window.addEventListener('scroll', updateNavbar, { passive: true });

toggle?.addEventListener('click', () => {
    const isOpen = menu.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', String(isOpen));
    menu.setAttribute('aria-hidden', String(!isOpen));
});

menu?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => {
    menu.classList.remove('is-open');
    toggle?.setAttribute('aria-expanded', 'false');
}));

document.querySelectorAll('[data-stagger]').forEach((container) => {
    container.querySelectorAll(':scope > [data-reveal]').forEach((item, index) => {
        item.style.setProperty('--reveal-delay', `${Math.min(index * 90, 360)}ms`);
    });
});

const revealItems = document.querySelectorAll('[data-reveal]');

if (reducedMotion || !('IntersectionObserver' in window)) {
    revealItems.forEach((item) => item.classList.add('reveal-visible'));
} else {
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('reveal-visible');
            const delay = Number.parseInt(entry.target.style.getPropertyValue('--reveal-delay') || '0', 10);
            window.setTimeout(() => entry.target.classList.add('reveal-complete'), 650 + delay);
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px' });

    revealItems.forEach((item) => revealObserver.observe(item));
}

const counters = document.querySelectorAll('[data-counter]');
const animateCounter = (element) => {
    const target = Number(element.dataset.counter);
    const suffix = element.dataset.suffix ?? '';
    const duration = 700;
    const startedAt = performance.now();

    const tick = (now) => {
        const progress = Math.min((now - startedAt) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        element.textContent = `${Math.round(target * eased).toLocaleString('fr-FR')}${suffix}`;
        if (progress < 1) requestAnimationFrame(tick);
    };

    requestAnimationFrame(tick);
};

if (reducedMotion || !('IntersectionObserver' in window)) {
    counters.forEach((counter) => counter.textContent = `${counter.dataset.counter}${counter.dataset.suffix ?? ''}`);
} else {
    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            animateCounter(entry.target);
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.5 });

    counters.forEach((counter) => counterObserver.observe(counter));
}

const parallax = document.querySelector('[data-parallax]');
if (parallax && !reducedMotion && window.matchMedia('(min-width: 1024px)').matches) {
    let ticking = false;
    const updateParallax = () => {
        const rect = parallax.getBoundingClientRect();
        const offset = Math.max(-12, Math.min(12, (window.innerHeight / 2 - rect.top - rect.height / 2) * 0.025));
        parallax.style.setProperty('--parallax-y', `${offset}px`);
        ticking = false;
    };
    window.addEventListener('scroll', () => {
        if (!ticking) requestAnimationFrame(updateParallax);
        ticking = true;
    }, { passive: true });
    updateParallax();
}
