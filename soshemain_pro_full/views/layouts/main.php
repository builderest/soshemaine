<?php
$settings = $GLOBALS['settings'] ?? [];
$meta = $page['seo'] ?? [];
$theme = $_COOKIE['soshemaine_theme'] ?? ($settings['theme_default'] ?? Theme::getDefault());
$primaryMenu = (new MenuModel())->findByLocation('primary');
$footerMenu = (new MenuModel())->findByLocation('footer');
?><!DOCTYPE html>
<html lang="en" data-theme="<?php echo e($theme); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(($meta['meta_title'] ?? $title ?? APP_NAME) . ' | ' . APP_NAME); ?></title>
    <meta name="description" content="<?php echo e($meta['meta_description'] ?? ($settings['meta_description'] ?? 'SOSHEMAIN digital solutions.')); ?>">
    <link rel="canonical" href="<?php echo url(current_path()); ?>">
    <meta property="og:site_name" content="<?php echo e(APP_NAME); ?>">
    <meta property="og:title" content="<?php echo e($meta['meta_title'] ?? $title ?? APP_NAME); ?>">
    <meta property="og:description" content="<?php echo e($meta['meta_description'] ?? ($settings['meta_description'] ?? 'SOSHEMAIN digital solutions.')); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo url(current_path()); ?>">
    <link rel="manifest" href="manifest.webmanifest">
    <link rel="icon" href="<?php echo asset('images/icon-192.svg'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/tokens.css">
    <link rel="stylesheet" href="css/site.css">
</head>
<body>
<a href="#main" class="skip-link">Skip to content</a>
<?php include BASE_PATH . '/views/partials/header.php'; ?>
<main id="main">
    <?php echo $content; ?>
</main>
<?php include BASE_PATH . '/views/partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js" defer></script>
</body>
</html>
