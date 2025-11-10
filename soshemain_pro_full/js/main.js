(function(){
  const THEME_KEY = 'soshemaine_theme';
  const root = document.documentElement;
  const toggle = document.getElementById('themeToggle');
  const saved = localStorage.getItem(THEME_KEY);
  if (saved) {
    root.setAttribute('data-theme', saved);
    document.cookie = `soshemaine_theme=${saved};path=/;max-age=31536000`;
  }
  if (toggle) {
    toggle.addEventListener('click', () => {
      const current = root.getAttribute('data-theme') || 'light';
      const themes = ['light', 'dark', 'brand-ocean', 'brand-violet'];
      const next = themes[(themes.indexOf(current) + 1) % themes.length];
      root.setAttribute('data-theme', next);
      localStorage.setItem(THEME_KEY, next);
      document.cookie = `soshemaine_theme=${next};path=/;max-age=31536000`;
      toggle.innerHTML = '<i class="bi bi-moon-stars"></i>';
    });
  }

  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('sw.js').catch(() => {});
    });
  }
})();
