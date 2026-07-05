const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

document.documentElement.classList.add('motion-ready');

const navbar = document.querySelector('[data-navbar]');
const toggle = document.getElementById('menu-toggle');
const menu = document.getElementById('mobile-menu');

const updateNavbar = () => navbar?.classList.toggle('is-scrolled', window.scrollY > 12);
updateNavbar();
window.addEventListener('scroll', updateNavbar, { passive: true });

const setMobileMenu = (isOpen) => {
    menu?.classList.toggle('is-open', isOpen);
    toggle.setAttribute('aria-expanded', String(isOpen));
    toggle.setAttribute('aria-label', isOpen ? 'Fermer le menu' : 'Ouvrir le menu');
    menu.setAttribute('aria-hidden', String(!isOpen));
    document.body.classList.toggle('mobile-menu-open', isOpen);
};

toggle?.addEventListener('click', () => {
    const isOpen = !menu.classList.contains('is-open');
    setMobileMenu(isOpen);
    if (isOpen) menu.querySelector('a')?.focus();
});

menu?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => {
    setMobileMenu(false);
}));

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && menu?.classList.contains('is-open')) {
        setMobileMenu(false);
        toggle?.focus();
    }
});

window.addEventListener('resize', () => {
    if (window.innerWidth >= 1024 && menu?.classList.contains('is-open')) setMobileMenu(false);
});

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

document.querySelectorAll('[data-office-carousel]').forEach((carousel) => {
    const track = carousel.querySelector('[data-office-track]');
    const panels = [...carousel.querySelectorAll('[data-office-panel]')];
    const tabs = [...carousel.querySelectorAll('[data-office-tab]')];
    const previous = carousel.querySelector('[data-office-previous]');
    const next = carousel.querySelector('[data-office-next]');
    const status = carousel.querySelector('[data-office-status]');
    let activeIndex = 0;

    const showOffice = (index) => {
        activeIndex = (index + panels.length) % panels.length;
        track.style.transform = `translateX(-${activeIndex * 100}%)`;

        tabs.forEach((tab, tabIndex) => {
            const active = tabIndex === activeIndex;
            tab.setAttribute('aria-selected', String(active));
            tab.classList.toggle('border-coral', active);
            tab.classList.toggle('bg-coral', active);
            tab.classList.toggle('text-white', active);
            tab.classList.toggle('border-slate-200', !active);
            tab.classList.toggle('bg-white', !active);
            tab.classList.toggle('text-charcoal', !active);
        });

        panels.forEach((panel, panelIndex) => {
            const hidden = panelIndex !== activeIndex;
            panel.setAttribute('aria-hidden', String(hidden));
            panel.inert = hidden;
        });
        if (status) status.textContent = `${activeIndex + 1} / ${panels.length} · ${tabs[activeIndex].textContent.trim()}`;
    };

    tabs.forEach((tab, index) => tab.addEventListener('click', () => showOffice(index)));
    tabs.forEach((tab, index) => tab.addEventListener('keydown', (event) => {
        if (!['ArrowLeft', 'ArrowRight'].includes(event.key)) return;
        event.preventDefault();
        const targetIndex = index + (event.key === 'ArrowRight' ? 1 : -1);
        showOffice(targetIndex);
        tabs[(targetIndex + tabs.length) % tabs.length].focus();
    }));
    previous?.addEventListener('click', () => showOffice(activeIndex - 1));
    next?.addEventListener('click', () => showOffice(activeIndex + 1));
    showOffice(0);
});

const cookieNotice = document.querySelector('[data-cookie-notice]');

if (cookieNotice) {
    const hideCookieNotice = () => {
        cookieNotice.hidden = true;
    };

    let consent = null;
    try {
        consent = window.localStorage.getItem('mccg_analytics_consent');
    } catch (_) {
        // The notice remains available when browser storage is restricted.
    }

    if (!consent) cookieNotice.hidden = false;

    cookieNotice.querySelector('[data-cookie-accept]')?.addEventListener('click', () => {
        try {
            window.localStorage.setItem('mccg_analytics_consent', 'accepted');
        } catch (_) {
            // Consent still applies for the current page when storage is unavailable.
        }
        window.mccgLoadGoogleAnalytics?.();
        hideCookieNotice();
    });

    cookieNotice.querySelector('[data-cookie-reject]')?.addEventListener('click', () => {
        try {
            window.localStorage.setItem('mccg_analytics_consent', 'declined');
        } catch (_) {
            // Tracking stays disabled even when the preference cannot be persisted.
        }
        hideCookieNotice();
    });
}
