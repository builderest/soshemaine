<?php
$pageTitle = 'Carreras';
$metaDescription = 'Vacantes abiertas en SOSHEMAIN para talentos que impulsan innovación.';
$jobs = $jobs ?? [];
?>
<section class="bg-white dark:bg-slate-900">
    <div class="mx-auto max-w-6xl px-6 py-24">
        <div class="max-w-3xl" data-animate>
            <span class="badge badge-soft">Talento</span>
            <h1 class="mt-4 text-4xl font-serif leading-tight">Únete a la experiencia SOSHEMAIN</h1>
            <p class="mt-4 text-lg text-slate-600 dark:text-slate-300">Buscamos mentes curiosas, colaborativas y orientadas a resultados para co-crear soluciones memorables con marcas líderes.</p>
        </div>
        <div class="mt-12 grid gap-6">
            <?php foreach ($jobs as $job): ?>
            <article class="rounded-3xl border border-slate-200/80 bg-white/80 p-8 shadow-lg dark:border-slate-800 dark:bg-slate-800/80">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-semibold text-secondary dark:text-white"><?= htmlspecialchars($job['title']) ?></h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Área: <?= htmlspecialchars($job['area']) ?> · Tipo: <?= htmlspecialchars($job['type']) ?> · Ubicación: <?= htmlspecialchars($job['location']) ?></p>
                    </div>
                    <span class="pill">Publicado: <?= date('d M Y', strtotime($job['created_at'])) ?></span>
                </div>
                <div class="mt-4 text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    <?= $job['description'] ?>
                </div>
                <div class="mt-6 flex flex-wrap items-center justify-between gap-4">
                    <span class="text-sm text-slate-500 dark:text-slate-400">Enviar CV a: <strong class="text-secondary dark:text-white"><?= htmlspecialchars($job['apply_email']) ?></strong></span>
                    <a href="mailto:<?= htmlspecialchars($job['apply_email']) ?>" class="inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-white hover:-translate-y-0.5 transition">Aplicar ahora</a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
