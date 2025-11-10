<?php
$pageTitle = 'Buscar';
$metaDescription = 'Resultados de búsqueda en SOSHEMAIN';
$term = $term ?? '';
$results = $results ?? [];
?>
<section class="bg-white dark:bg-slate-900">
    <div class="mx-auto max-w-6xl px-6 py-24">
        <h1 class="text-4xl font-serif">Buscar</h1>
        <p class="mt-2 text-slate-600 dark:text-slate-300">Explora páginas, artículos y soluciones de SOSHEMAIN.</p>
        <form method="get" class="mt-8 flex flex-col gap-4 md:flex-row">
            <label class="w-full md:flex-1">
                <span class="sr-only">Término de búsqueda</span>
                <input type="search" name="q" value="<?= htmlspecialchars($term) ?>" class="w-full rounded-full border border-slate-200 px-6 py-3 text-sm shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/30 dark:border-slate-700 dark:bg-slate-800" placeholder="¿Qué estás buscando?">
            </label>
            <button class="inline-flex items-center justify-center rounded-full bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/40">Buscar</button>
        </form>
        <?php if ($term === ''): ?>
            <p class="mt-12 text-sm text-slate-500">Introduce un término para comenzar.</p>
        <?php else: ?>
            <h2 class="mt-12 text-lg font-semibold text-secondary dark:text-white">Resultados para “<?= htmlspecialchars($term) ?>”</h2>
            <?php if (empty($results)): ?>
                <p class="mt-4 text-sm text-slate-500">No encontramos coincidencias. Prueba con otro término o contáctanos.</p>
            <?php else: ?>
                <div class="mt-6 space-y-4">
                    <?php foreach ($results as $result): ?>
                    <article class="rounded-3xl border border-slate-200/80 bg-white/80 p-6 shadow-lg dark:border-slate-800 dark:bg-slate-800/80">
                        <p class="text-xs uppercase tracking-wide text-primary"><?= htmlspecialchars(strtoupper($result['type'])) ?></p>
                        <a href="<?= htmlspecialchars($result['url']) ?>" class="mt-2 block text-xl font-semibold text-secondary dark:text-white hover:text-primary transition"><?= htmlspecialchars($result['title']) ?></a>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300 leading-relaxed"><?= htmlspecialchars($result['excerpt']) ?></p>
                    </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
