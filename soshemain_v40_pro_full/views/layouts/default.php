<?php
require_once __DIR__ . '/../../models/Menu.php';
$settings = [
    'site_name' => site_setting('site_name', 'SOSHEMAIN'),
    'logo' => site_setting('logo', ''),
    'primary_color' => site_setting('primary_color', '#0EA5E9'),
    'secondary_color' => site_setting('secondary_color', '#111827'),
    'accent_color' => site_setting('accent_color', '#F59E0B'),
    'meta_description' => site_setting('meta_description', 'Innovación que impulsa resultados.'),
    'favicon' => site_setting('favicon', ''),
];
$menus = (new Menu())->findBy(['name' => 'principal']);
$menuItems = $menus && $menus['items'] ? json_decode($menus['items'], true) : [];
$language = current_language();
$availableLanguages = app_config('available_languages');
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($language) ?>" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title><?= htmlspecialchars(($pageTitle ?? $settings['site_name']) . ' | ' . $settings['site_name']) ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription ?? $settings['meta_description']) ?>">
    <meta name="theme-color" content="<?= htmlspecialchars($settings['primary_color']) ?>">
    <link rel="manifest" href="<?= asset('public/manifest.webmanifest') ?>">
    <?php if (!empty($settings['favicon'])): ?>
        <link rel="icon" href="<?= asset('public/uploads/' . $settings['favicon']) ?>">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '<?= $settings['primary_color'] ?>',
                        secondary: '<?= $settings['secondary_color'] ?>',
                        accent: '<?= $settings['accent_color'] ?>'
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        serif: ['Playfair Display', 'serif']
                    }
                }
            }
        };
    </script>
    <link rel="stylesheet" href="<?= asset('public/css/app.css') ?>">
    <script defer src="https://unpkg.com/scrollreveal"></script>
    <script defer src="<?= asset('public/js/app.js') ?>"></script>
    <meta property="og:title" content="<?= htmlspecialchars($ogTitle ?? $pageTitle ?? $settings['site_name']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($ogDescription ?? $metaDescription ?? $settings['meta_description']) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars(app_config('base_url')) ?>">
    <?php if (!empty($settings['logo'])): ?>
        <meta property="og:image" content="<?= asset('public/uploads/' . $settings['logo']) ?>">
    <?php endif; ?>
    <meta name="twitter:card" content="summary_large_image">
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= addslashes($settings['site_name']) ?>",
        "url": "<?= addslashes(app_config('base_url')) ?>",
        "logo": "<?= addslashes(!empty($settings['logo']) ? asset('public/uploads/' . $settings['logo']) : asset('public/images/logo.svg')) ?>",
        "sameAs": <?= json_encode(site_setting('social_links', [])) ?>,
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "<?= addslashes(site_setting('phone', '+52 55 0000 0000')) ?>",
            "contactType": "customer service",
            "availableLanguage": ["es", "en"]
        }
    }
    </script>
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-slate-900 dark:text-slate-100 transition-colors duration-300" data-theme="light">
<header class="fixed top-0 left-0 w-full z-50 backdrop-blur bg-slate-900/60 dark:bg-slate-950/60 text-white">
    <div class="mx-auto max-w-7xl px-6 py-4 flex items-center justify-between">
        <a href="<?= asset('public/index.php') ?>" class="flex items-center gap-3 font-bold text-lg tracking-tight">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-primary text-secondary font-serif text-xl">S</span>
            <span><?= htmlspecialchars($settings['site_name']) ?></span>
        </a>
        <nav class="hidden md:flex items-center gap-8 text-sm uppercase tracking-wide">
            <?php foreach ($menuItems as $item): ?>
                <a href="<?= htmlspecialchars($item['url'] ?? '#') ?>" class="relative group">
                    <span><?= htmlspecialchars($item['label'] ?? '') ?></span>
                    <span class="absolute left-0 -bottom-1 h-0.5 w-full scale-x-0 bg-primary transition-transform duration-300 group-hover:scale-x-100"></span>
                </a>
            <?php endforeach; ?>
        </nav>
        <div class="flex items-center gap-3">
            <a href="<?= asset('public/search.php') ?>" class="hidden md:inline-flex items-center gap-2 rounded-full border border-white/20 px-3 py-2 text-sm hover:bg-white/10 transition" aria-label="Buscar"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A6.75 6.75 0 1 0 9.75 16.5a6.75 6.75 0 0 0 6.9-5.85z"/></svg><span>Buscar</span></a>
            <button id="themeToggle" class="h-10 w-10 rounded-full border border-white/20 flex items-center justify-center hover:bg-white/10 transition" aria-label="Cambiar tema">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1.5m6.364.636-1.06 1.06M21 12h-1.5M17.303 17.303l-1.06-1.06M12 19.5V21m-4.243-4.243-1.06 1.06M4.5 12H3m4.243-4.243-1.06-1.06M12 6.75a5.25 5.25 0 0 1 0 10.5 5.25 5.25 0 0 1 0-10.5z"/></svg>
            </button>
            <div class="relative">
                <button class="flex items-center gap-2 border border-white/20 rounded-full px-3 py-1 text-sm" aria-haspopup="true" aria-expanded="false" id="languageSwitcher">
                    <?= htmlspecialchars($availableLanguages[$language] ?? 'Idioma') ?>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
                </button>
                <div class="hidden absolute right-0 mt-2 w-40 rounded-xl border border-white/20 bg-slate-900/90 backdrop-blur shadow-lg" id="languageMenu">
                    <?php foreach ($availableLanguages as $code => $label): ?>
                        <form method="post" action="<?= asset('public/index.php') ?>" class="border-b border-white/10 last:border-b-0">
                            <?= csrf_input() ?>
                            <input type="hidden" name="switch_language" value="<?= htmlspecialchars($code) ?>">
                            <button type="submit" class="w-full text-left px-4 py-2 text-xs uppercase tracking-wide hover:bg-white/10">
                                <?= htmlspecialchars($label) ?>
                            </button>
                        </form>
                    <?php endforeach; ?>
                </div>
            </div>
            <a href="#contacto" class="hidden md:inline-flex items-center gap-2 rounded-full bg-primary px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-primary/50 transition hover:-translate-y-0.5">Contáctanos</a>
            <button class="md:hidden inline-flex items-center justify-center h-10 w-10 rounded-full border border-white/20" id="mobileMenuToggle" aria-label="Abrir menú">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
    <div class="md:hidden hidden" id="mobileMenu">
        <nav class="px-6 pb-6 flex flex-col gap-4 text-sm uppercase">
            <?php foreach ($menuItems as $item): ?>
                <a href="<?= htmlspecialchars($item['url'] ?? '#') ?>" class="py-2 border-b border-white/10"><?= htmlspecialchars($item['label'] ?? '') ?></a>
            <?php endforeach; ?>
            <a href="<?= asset('public/search.php') ?>" class="py-2 border-b border-white/10">Buscar</a>
        </nav>
    </div>
</header>
<main class="pt-32">
    <?= $content ?>
</main>
<footer class="bg-secondary text-slate-100 mt-24">
    <div class="mx-auto max-w-7xl px-6 py-16 grid gap-12 md:grid-cols-4">
        <div>
            <h3 class="text-xl font-semibold mb-4 font-serif"><?= htmlspecialchars($settings['site_name']) ?></h3>
            <p class="text-sm text-slate-300 leading-relaxed"><?= htmlspecialchars(site_setting('footer_intro', 'Innovación que impulsa resultados con estrategias digitales inteligentes y soluciones tecnológicas personalizadas.')) ?></p>
            <div class="mt-6 flex gap-3">
                <?php $social = site_setting('social_links', []); if (is_array($social)):
                    foreach ($social as $network => $url): ?>
                        <a href="<?= htmlspecialchars($url) ?>" class="h-10 w-10 flex items-center justify-center rounded-full border border-white/20 hover:bg-white/10 transition" target="_blank" rel="noopener" aria-label="<?= htmlspecialchars($network) ?>">
                            <span class="text-sm uppercase"><?= htmlspecialchars(substr($network, 0, 2)) ?></span>
                        </a>
                    <?php endforeach; endif; ?>
            </div>
        </div>
        <div>
            <h4 class="text-lg font-semibold mb-4">Contacto</h4>
            <ul class="space-y-3 text-sm text-slate-300">
                <li><strong class="text-white block">Dirección</strong><?= htmlspecialchars(site_setting('address', 'Av. Reforma 123, Ciudad de México')) ?></li>
                <li><strong class="text-white block">Teléfono</strong><?= htmlspecialchars(site_setting('phone', '+52 55 1234 5678')) ?></li>
                <li><strong class="text-white block">Correo</strong><?= htmlspecialchars(site_setting('email', 'hola@soshemain.com')) ?></li>
                <li><strong class="text-white block">Horario</strong><?= htmlspecialchars(site_setting('schedule', 'Lun-Vie 9:00-18:00')) ?></li>
            </ul>
        </div>
        <div>
            <h4 class="text-lg font-semibold mb-4">Recursos</h4>
            <ul class="space-y-3 text-sm text-slate-300">
                <li><a href="<?= asset('public/services.php') ?>" class="hover:text-primary transition">Servicios</a></li>
                <li><a href="<?= asset('public/products.php') ?>" class="hover:text-primary transition">Soluciones</a></li>
                <li><a href="<?= asset('public/blog.php') ?>" class="hover:text-primary transition">Blog & Insights</a></li>
                <li><a href="<?= asset('public/careers.php') ?>" class="hover:text-primary transition">Carreras</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-lg font-semibold mb-4">Newsletter</h4>
            <p class="text-sm text-slate-300 leading-relaxed">Recibe ideas, tendencias y casos de éxito directamente en tu correo.</p>
            <form class="mt-4 space-y-3" method="post" action="<?= asset('public/index.php') ?>">
                <?= csrf_input() ?>
                <input type="hidden" name="action" value="subscribe_newsletter">
                <label class="sr-only" for="newsletterEmail">Correo electrónico</label>
                <input id="newsletterEmail" name="email" type="email" required class="w-full rounded-full border border-white/10 bg-white/10 px-4 py-2 text-sm text-white placeholder:text-slate-300 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="tu@email.com">
                <button type="submit" class="w-full rounded-full bg-primary px-4 py-2 text-sm font-semibold text-white hover:-translate-y-0.5 transition">Suscribirme</button>
            </form>
        </div>
    </div>
    <div class="border-t border-white/10 py-6 text-center text-xs text-slate-400">
        © <?= date('Y') ?> <?= htmlspecialchars($settings['site_name']) ?>. Todos los derechos reservados.
        <div class="mt-2 space-x-4">
            <a href="<?= asset('public/privacy.php') ?>" class="hover:text-primary">Privacidad</a>
            <a href="<?= asset('public/terms.php') ?>" class="hover:text-primary">Términos</a>
            <a href="<?= asset('public/contact.php') ?>" class="hover:text-primary">Contacto</a>
        </div>
    </div>
</footer>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.getElementById('themeToggle');
        const languageBtn = document.getElementById('languageSwitcher');
        const languageMenu = document.getElementById('languageMenu');
        const mobileToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            document.body.dataset.theme = 'dark';
        }
        toggle?.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            document.body.dataset.theme = isDark ? 'dark' : 'light';
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
        languageBtn?.addEventListener('click', () => {
            languageMenu?.classList.toggle('hidden');
        });
        document.addEventListener('click', (event) => {
            if (!languageBtn.contains(event.target)) {
                languageMenu?.classList.add('hidden');
            }
        });
        mobileToggle?.addEventListener('click', () => {
            mobileMenu?.classList.toggle('hidden');
        });
        ScrollReveal().reveal('[data-animate]', { distance: '40px', duration: 800, interval: 80, origin: 'bottom', easing: 'ease-in-out' });
    });
</script>
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('<?= asset('public/sw.js') ?>');
        });
    }
</script>
</body>
</html>
