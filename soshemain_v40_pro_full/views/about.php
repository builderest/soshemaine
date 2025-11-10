<?php
$pageTitle = 'Sobre SOSHEMAIN';
$metaDescription = 'Conoce la historia, misión y visión de SOSHEMAIN, el colectivo de innovación que impulsa resultados extraordinarios.';
$aboutPage = $aboutPage ?? null;
$team = $team ?? [];
$timeline = $timeline ?? [];
$values = $values ?? [];
?>
<section class="bg-white dark:bg-slate-900">
    <div class="mx-auto max-w-7xl px-6 py-24">
        <div class="grid gap-12 lg:grid-cols-[1fr,0.9fr] lg:items-center">
            <div data-animate>
                <span class="badge badge-soft">Nuestra esencia</span>
                <h1 class="mt-4 text-4xl font-serif leading-tight"><?= htmlspecialchars($aboutPage['title'] ?? 'Historia de SOSHEMAIN') ?></h1>
                <div class="mt-4 text-lg text-slate-600 dark:text-slate-300 leading-relaxed">
                    <?= $aboutPage['content'] ?? '<p>SOSHEMAIN es un colectivo de estrategas, tecnólogos y creativos que construyen experiencias significativas para marcas que buscan trascender.</p>' ?>
                </div>
                <div class="mt-8 grid gap-4 md:grid-cols-3 text-sm text-slate-500 dark:text-slate-400">
                    <div class="rounded-3xl border border-slate-200/80 bg-white/80 p-6 shadow-md dark:border-slate-800 dark:bg-slate-800/80">
                        <h3 class="text-sm font-semibold text-secondary dark:text-white uppercase tracking-wide">Misión</h3>
                        <p class="mt-3 leading-relaxed"><?= htmlspecialchars(site_setting('mission', 'Acelerar el crecimiento de nuestros clientes mediante soluciones creativas, tecnológicas y centradas en las personas.')) ?></p>
                    </div>
                    <div class="rounded-3xl border border-slate-200/80 bg-white/80 p-6 shadow-md dark:border-slate-800 dark:bg-slate-800/80">
                        <h3 class="text-sm font-semibold text-secondary dark:text-white uppercase tracking-wide">Visión</h3>
                        <p class="mt-3 leading-relaxed"><?= htmlspecialchars(site_setting('vision', 'Ser el aliado más confiable para líderes que buscan innovar sin límites.')) ?></p>
                    </div>
                    <div class="rounded-3xl border border-slate-200/80 bg-white/80 p-6 shadow-md dark:border-slate-800 dark:bg-slate-800/80">
                        <h3 class="text-sm font-semibold text-secondary dark:text-white uppercase tracking-wide">Manifiesto</h3>
                        <p class="mt-3 leading-relaxed">Innovación, estrategia y ejecución impecable en cada interacción.</p>
                    </div>
                </div>
            </div>
            <div class="relative" data-animate>
                <div class="absolute -inset-6 rounded-3xl bg-gradient-to-br from-primary/20 via-accent/20 to-white blur-2xl"></div>
                <img src="images/about-team.jpg" alt="Equipo creativo de SOSHEMAIN" class="relative rounded-[40px] border border-white/40 shadow-2xl" loading="lazy">
            </div>
        </div>
    </div>
</section>
<section class="bg-slate-900 text-white py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="grid gap-12 lg:grid-cols-[0.8fr,1.2fr]">
            <div data-animate>
                <span class="badge badge-soft">Línea de tiempo</span>
                <h2 class="mt-4 text-3xl font-serif">Una trayectoria marcada por la innovación</h2>
                <p class="mt-4 text-slate-300">Evolucionamos junto a nuestros clientes, integrando soluciones que anticipan el futuro y generan impacto.</p>
            </div>
            <div class="relative timeline" data-animate>
                <div class="grid gap-10">
                    <?php foreach ($timeline as $milestone): ?>
                    <div class="timeline-item">
                        <div class="ml-16 rounded-3xl border border-white/10 bg-white/5 p-6 shadow-lg">
                            <span class="text-sm uppercase tracking-wide text-primary"><?= htmlspecialchars($milestone['year']) ?></span>
                            <h3 class="mt-2 text-xl font-semibold text-white"><?= htmlspecialchars($milestone['title']) ?></h3>
                            <p class="mt-2 text-sm text-slate-200 leading-relaxed"><?= htmlspecialchars($milestone['description']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-white dark:bg-slate-900 py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div>
                <span class="badge badge-soft">Nuestro ADN</span>
                <h2 class="mt-3 text-3xl font-serif">Valores que guían cada proyecto</h2>
            </div>
            <p class="max-w-2xl text-sm text-slate-600 dark:text-slate-400">Creemos en la ética, la excelencia y la empatía como pilares para crear experiencias sostenibles que generen resultados tangibles.</p>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($values as $value): ?>
            <article class="card-hover rounded-3xl border border-slate-200/80 bg-white/80 p-6 shadow-lg dark:border-slate-800 dark:bg-slate-800/80">
                <h3 class="text-xl font-semibold text-secondary dark:text-white"><?= htmlspecialchars($value['title']) ?></h3>
                <p class="mt-3 text-sm text-slate-600 dark:text-slate-300 leading-relaxed"><?= htmlspecialchars($value['description']) ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="bg-slate-50 dark:bg-slate-900 py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div>
                <span class="badge badge-soft">Leadership</span>
                <h2 class="mt-3 text-3xl font-serif">Personas que hacen posible lo extraordinario</h2>
            </div>
            <p class="max-w-2xl text-sm text-slate-600 dark:text-slate-400">Multidisciplinario, diverso y obsesionado con los detalles. Así es el equipo que acompaña a cada cliente.</p>
        </div>
        <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <?php foreach ($team as $member): ?>
            <article class="rounded-3xl border border-slate-200/70 bg-white/90 p-6 text-center shadow-lg dark:border-slate-800 dark:bg-slate-800/80">
                <img src="uploads/<?= htmlspecialchars($member['photo']) ?>" alt="<?= htmlspecialchars($member['name']) ?>" class="mx-auto h-32 w-32 rounded-full object-cover" loading="lazy">
                <h3 class="mt-4 text-lg font-semibold text-secondary dark:text-white"><?= htmlspecialchars($member['name']) ?></h3>
                <p class="text-sm text-primary uppercase tracking-wide"><?= htmlspecialchars($member['role']) ?></p>
                <p class="mt-3 text-sm text-slate-600 dark:text-slate-300 leading-relaxed"><?= htmlspecialchars($member['bio']) ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
