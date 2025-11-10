(function(){
  const THEME_KEY = 'soshemaine_theme';
  const root = document.documentElement;
  const toggle = document.getElementById('themeToggle');

  const themes = ['light', 'dark', 'brand-ocean', 'brand-violet'];

  const applyTheme = (theme) => {
    root.setAttribute('data-theme', theme);
    root.setAttribute('data-bs-theme', theme === 'dark' ? 'dark' : 'light');
    localStorage.setItem(THEME_KEY, theme);
    document.cookie = `soshemaine_theme=${theme};path=/;max-age=31536000`;
  };

  const saved = localStorage.getItem(THEME_KEY);
  const initial = saved || root.getAttribute('data-theme') || 'dark';
  applyTheme(initial);

  if (toggle) {
    toggle.addEventListener('click', () => {
      const current = root.getAttribute('data-theme') || 'dark';
      const next = themes[(themes.indexOf(current) + 1) % themes.length];
      applyTheme(next);
      toggle.innerHTML = '<i class="bi bi-moon-stars"></i>';
    });
  }

  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('sw.js').catch(() => {});
    });
  }
})();
