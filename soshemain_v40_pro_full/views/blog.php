<?php
$pageTitle = 'Blog';
$metaDescription = 'Insights estratégicos de SOSHEMAIN sobre innovación, marketing y experiencia digital.';
$posts = $posts ?? [];
?>
<section class="bg-white dark:bg-slate-900">
    <div class="mx-auto max-w-7xl px-6 py-24">
        <div class="max-w-3xl" data-animate>
            <span class="badge badge-soft">Insights</span>
            <h1 class="mt-4 text-4xl font-serif leading-tight">Ideas que inspiran movimientos estratégicos</h1>
            <p class="mt-4 text-lg text-slate-600 dark:text-slate-300">Artículos, reportes y guías que compartimos desde la experiencia de co-crear con organizaciones líderes en América Latina.</p>
        </div>
        <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($posts as $post): ?>
            <article class="card-hover rounded-3xl border border-slate-200/70 bg-white/80 shadow-lg dark:border-slate-800 dark:bg-slate-800/80">
                <img src="uploads/<?= htmlspecialchars($post['cover']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="h-48 w-full rounded-t-3xl object-cover" loading="lazy">
                <div class="p-6">
                    <span class="badge badge-soft text-xs uppercase tracking-wide"><?= htmlspecialchars(date('M Y', strtotime($post['published_at']))) ?></span>
                    <h2 class="mt-3 text-xl font-semibold text-secondary dark:text-white"><?= htmlspecialchars($post['title']) ?></h2>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-300 leading-relaxed"><?= htmlspecialchars($post['excerpt']) ?></p>
                    <div class="mt-6 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                        <span>Por <?= htmlspecialchars(site_setting('site_name')) ?></span>
                        <a href="post.php?slug=<?= urlencode($post['slug']) ?>" class="inline-flex items-center gap-2 text-primary">Leer más</a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
