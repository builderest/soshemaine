(function () {
    const toggle = document.getElementById('themeToggle');
    if (toggle) {
        toggle.addEventListener('click', function () {
            const html = document.documentElement;
            const nextTheme = html.dataset.bsTheme === 'dark' ? 'light' : 'dark';
            html.dataset.bsTheme = nextTheme;
            localStorage.setItem('soshemain-theme', nextTheme);
        });
    }

    document.querySelectorAll('[data-countup]').forEach(el => {
        const target = parseInt(el.getAttribute('data-countup'), 10);
        let current = 0;
        const step = Math.ceil(target / 60);
        const interval = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(interval);
            }
            if (el.innerText.startsWith('$')) {
                el.innerText = '$' + current.toLocaleString();
            } else {
                el.innerText = current.toLocaleString();
            }
        }, 16);
    });

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/sw.js').catch(console.error);
        });
    }
})();
