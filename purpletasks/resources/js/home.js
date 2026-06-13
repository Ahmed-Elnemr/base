const initHeroSlider = () => {
    const slider = document.querySelector('[data-hero-slider]');

    if (!slider) {
        return;
    }

    const slides = Array.from(slider.querySelectorAll('.hero-slide'));
    const dots = Array.from(document.querySelectorAll('[data-hero-dot]'));

    if (!slides.length) {
        return;
    }
    let current = 0;

    const activateSlide = (index) => {
        slides.forEach((slide, idx) => {
            slide.classList.toggle('is-active', idx === index);
        });

        dots.forEach((dot, idx) => {
            dot.classList.toggle('is-active', idx === index);
        });

        current = index;
    };

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => activateSlide(index));
    });

    setInterval(() => {
        if (!slides.length) {
            return;
        }
        const nextIndex = (current + 1) % slides.length;
        activateSlide(nextIndex);
    }, 6000);
};

const initFaqAccordion = () => {
    document.querySelectorAll('[data-faq-toggle]').forEach((toggle) => {
        toggle.addEventListener('click', () => {
            toggle.closest('[data-faq-item]').classList.toggle('is-open');
        });
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initHeroSlider();
    initFaqAccordion();
});

