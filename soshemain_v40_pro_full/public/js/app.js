(() => {
    const counters = document.querySelectorAll('[data-counter]');
    const options = { threshold: 0.35 };
    const animateCounter = (entry) => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const target = parseInt(el.dataset.counter, 10);
        let start = 0;
        const duration = 1500;
        const stepTime = Math.abs(Math.floor(duration / target));
        const increment = () => {
            start += 1;
            el.textContent = start.toLocaleString('es-MX');
            if (start < target) {
                setTimeout(increment, stepTime);
            }
        };
        increment();
        observer.unobserve(el);
    };
    const observer = new IntersectionObserver((entries) => entries.forEach(animateCounter), options);
    counters.forEach(counter => observer.observe(counter));

    const accordions = document.querySelectorAll('[data-accordion]');
    accordions.forEach((accordion) => {
        accordion.addEventListener('click', (event) => {
            const header = event.target.closest('button');
            if (!header) return;
            const panel = header.nextElementSibling;
            const expanded = header.getAttribute('aria-expanded') === 'true';
            header.setAttribute('aria-expanded', expanded ? 'false' : 'true');
            panel.style.maxHeight = expanded ? '0px' : panel.scrollHeight + 'px';
        });
    });

    const filters = document.querySelectorAll('[data-filter] button');
    filters.forEach((btn) => {
        btn.addEventListener('click', () => {
            const group = btn.closest('[data-filter]');
            const items = document.querySelectorAll(group.dataset.filterTarget);
            group.querySelectorAll('button').forEach(b => b.classList.remove('bg-primary', 'text-white'));
            btn.classList.add('bg-primary', 'text-white');
            const value = btn.dataset.filterValue;
            items.forEach(item => {
                if (value === 'all' || item.dataset.category === value) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        });
    });
})();
