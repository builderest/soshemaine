<?php
$pageTitle = 'Servicios';
$metaDescription = 'Servicios premium de innovación, marketing y tecnología de SOSHEMAIN.';
$services = $services ?? [];
?>
<section class="bg-white dark:bg-slate-900">
    <div class="mx-auto max-w-7xl px-6 py-24">
        <div class="max-w-3xl" data-animate>
            <span class="badge badge-soft">Expertise</span>
            <h1 class="mt-4 text-4xl font-serif leading-tight">Servicios que conectan estrategia, diseño y tecnología</h1>
            <p class="mt-4 text-lg text-slate-600 dark:text-slate-300">SOSHEMAIN desarrolla iniciativas end-to-end para marcas que desean construir experiencias memorables, eficientes y centradas en las personas.</p>
        </div>
        <div class="mt-16" data-filter data-filter-target="[data-service]">
            <div class="flex flex-wrap gap-3 text-sm">
                <button type="button" class="rounded-full border border-slate-200 px-4 py-2 font-semibold" data-filter-value="all">Todos</button>
                <?php foreach ($services as $service): ?>
                    <button type="button" class="rounded-full border border-slate-200 px-4 py-2 font-semibold" data-filter-value="<?= htmlspecialchars($service['slug']) ?>"><?= htmlspecialchars($service['name']) ?></button>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="mt-12 grid gap-8 md:grid-cols-2">
            <?php foreach ($services as $service): $meta = json_decode($service['meta_data'] ?? '[]', true); ?>
            <article id="<?= htmlspecialchars($service['slug']) ?>" data-service data-category="<?= htmlspecialchars($service['slug']) ?>" class="card-hover rounded-3xl border border-slate-200/80 bg-white/90 p-8 shadow-lg dark:border-slate-800 dark:bg-slate-800/80">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="badge badge-soft text-xs uppercase tracking-wide">Servicio insignia</span>
                        <h2 class="mt-3 text-2xl font-semibold text-secondary dark:text-white"><?= htmlspecialchars($service['name']) ?></h2>
                    </div>
                    <span class="pill"><?= htmlspecialchars($meta['tier'] ?? 'Enterprise') ?></span>
                </div>
                <p class="mt-4 text-sm text-slate-600 dark:text-slate-300 leading-relaxed"><?= htmlspecialchars($meta['description'] ?? 'Estrategia y ejecución integral con acompañamiento continuo.') ?></p>
                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    <div>
                        <h3 class="text-sm font-semibold text-secondary dark:text-white uppercase tracking-wide">Beneficios</h3>
                        <ul class="mt-3 space-y-2 text-sm text-slate-600 dark:text-slate-300">
                            <?php foreach (($meta['benefits'] ?? []) as $benefit): ?>
                                <li class="flex items-start gap-2"><span class="mt-1 h-1.5 w-1.5 rounded-full bg-primary"></span><?= htmlspecialchars($benefit) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-secondary dark:text-white uppercase tracking-wide">Entregables clave</h3>
                        <ul class="mt-3 space-y-2 text-sm text-slate-600 dark:text-slate-300">
                            <?php foreach (($meta['deliverables'] ?? []) as $deliverable): ?>
                                <li class="flex items-start gap-2"><span class="mt-1 h-1.5 w-1.5 rounded-full bg-accent"></span><?= htmlspecialchars($deliverable) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="mt-6 flex flex-wrap items-center justify-between gap-3 text-sm">
                    <div>
                        <span class="text-slate-500 dark:text-slate-400">Tiempo estimado:</span>
                        <strong class="text-secondary dark:text-white"><?= htmlspecialchars($meta['timeline'] ?? '12 semanas') ?></strong>
                    </div>
                    <a href="contact.php?service=<?= urlencode($service['slug']) ?>" class="inline-flex items-center gap-2 rounded-full border border-primary px-6 py-3 font-semibold text-primary hover:bg-primary hover:text-white transition">Solicitar propuesta</a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
