<?php
require_once BASE_PATH . '/core/helpers.php';
require_once BASE_PATH . '/core/db.php';

function render_cms_page(string $slug, string $fallbackTitle, string $fallbackBody): void
{
    global $title, $metaDescription, $content;

    $page = run_query_one('SELECT * FROM pages WHERE slug = ? LIMIT 1', [$slug]);
    $title = $page['title'] ?? $fallbackTitle;
    $metaDescription = $page['meta_description'] ?? substr(strip_tags($page['excerpt'] ?? $fallbackBody), 0, 155);

    ob_start();
    ?>
    <section class="py-5 bg-body-tertiary">
        <div class="container">
            <h1 class="display-5 fw-bold mb-4"><?= e($page['title'] ?? $fallbackTitle) ?></h1>
            <div class="lead text-secondary mb-5">
                <?= nl2br(e($page['excerpt'] ?? 'Updated insights from SOSHEMAIN.')) ?>
            </div>
            <div class="content fs-5 lh-lg">
                <?= $page['body'] ?? nl2br(e($fallbackBody)) ?>
            </div>
        </div>
    </section>
    <?php
    $content = ob_get_clean();
    require BASE_PATH . '/views/layouts/main.php';
}
