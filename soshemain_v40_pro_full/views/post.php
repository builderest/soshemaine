<?php
$pageTitle = $post['title'] ?? 'Artículo';
$metaDescription = $post['meta_desc'] ?? ($post['excerpt'] ?? 'Contenido de innovación SOSHEMAIN');
$related = array_filter($controller->posts(), fn($item) => $item['slug'] !== $post['slug']);
?>
<section class="bg-white dark:bg-slate-900">
    <div class="mx-auto max-w-4xl px-6 py-24">
        <article class="prose prose-lg mx-auto dark:prose-invert">
            <span class="badge badge-soft"><?= htmlspecialchars(date('d F Y', strtotime($post['published_at']))) ?></span>
            <h1 class="mt-4 font-serif text-4xl leading-tight text-secondary dark:text-white"><?= htmlspecialchars($post['title']) ?></h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Por <?= htmlspecialchars(site_setting('site_name')) ?></p>
            <img src="uploads/<?= htmlspecialchars($post['cover']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="mt-8 w-full rounded-3xl" loading="lazy">
            <div class="mt-8 leading-relaxed text-slate-700 dark:text-slate-300">
                <?= $post['content'] ?>
            </div>
        </article>
        <section class="mt-16">
            <h2 class="text-2xl font-semibold text-secondary dark:text-white">También podría interesarte</h2>
            <div class="mt-6 grid gap-6 md:grid-cols-2">
                <?php foreach (array_slice($related, 0, 2) as $item): ?>
                <article class="rounded-3xl border border-slate-200/70 bg-white/80 p-6 shadow-lg dark:border-slate-800 dark:bg-slate-800/80">
                    <h3 class="text-xl font-semibold text-secondary dark:text-white"><?= htmlspecialchars($item['title']) ?></h3>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-300"><?= htmlspecialchars($item['excerpt']) ?></p>
                    <a href="post.php?slug=<?= urlencode($item['slug']) ?>" class="mt-4 inline-flex items-center gap-2 text-primary">Leer artículo</a>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</section>
