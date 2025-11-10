<?php
$pageTitle = $page['meta_title'] ?? $page['title'] ?? 'Página';
$metaDescription = $page['meta_desc'] ?? site_setting('meta_description');
?>
<section class="bg-white dark:bg-slate-900">
    <div class="mx-auto max-w-5xl px-6 py-24">
        <h1 class="text-4xl font-serif text-secondary dark:text-white"><?= htmlspecialchars($page['title'] ?? '') ?></h1>
        <div class="mt-8 prose prose-lg max-w-none dark:prose-invert">
            <?= $page['content'] ?? '' ?>
        </div>
    </div>
</section>
