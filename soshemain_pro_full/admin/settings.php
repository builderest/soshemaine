<?php
$title = 'Settings';
require_once __DIR__ . '/includes/header.php';
require_once BASE_PATH . '/core/db.php';
$settings = run_query('SELECT `key`, `value` FROM settings ORDER BY `key`');
?>
<h1 class="h4 fw-bold mb-4">Global settings</h1>
<div class="row">
    <div class="col-lg-8">
        <form class="card shadow-sm border-0">
            <div class="card-body">
                <?php foreach ($settings as $setting): ?>
                <div class="mb-3">
                    <label class="form-label text-uppercase small fw-semibold"><?= e(str_replace('_', ' ', $setting['key'])) ?></label>
                    <input class="form-control" value="<?= e($setting['value']) ?>">
                </div>
                <?php endforeach; ?>
                <button class="btn btn-primary" type="button">Save changes</button>
            </div>
        </form>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h2 class="h6 fw-bold">Sitemap</h2>
                <p class="text-secondary small">Generate the latest sitemap.xml for SEO.</p>
                <button class="btn btn-outline-primary btn-sm" type="button">Generate sitemap</button>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
