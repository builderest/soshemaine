<?php
require_once BASE_PATH . '/core/helpers.php';
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? APP_NAME) ?></title>
    <meta name="description" content="<?= e($metaDescription ?? 'SOSHEMAIN is a digital innovation studio delivering strategy, design, and technology that drives measurable results.') ?>">
    <meta name="keywords" content="innovation, technology, marketing, ecommerce, consulting">
    <meta property="og:title" content="<?= e($metaOgTitle ?? ($title ?? APP_NAME)) ?>">
    <meta property="og:description" content="<?= e($metaOgDescription ?? ($metaDescription ?? APP_TAGLINE)) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e(APP_URL) ?>">
    <meta property="og:image" content="<?= e(APP_URL . '/public/images/og-image.jpg') ?>">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="canonical" href="<?= e(APP_URL . $_SERVER['REQUEST_URI']) ?>">
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="icon" type="image/png" href="/images/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5mZL5lw5yX04ec+4n2XyL9+4/2Lc" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/site.css">
    <script>
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.dataset.bsTheme = localStorage.getItem('soshemain-theme') || (prefersDark ? 'dark' : 'light');
    </script>
</head>
<body>
<header class="navbar navbar-expand-lg bg-body-tertiary shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/index.php">SOSHEMAIN</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="/about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="/services.php">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="/products.php">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="/blog.php">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="/cart.php"><i class="bi bi-cart"></i> Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="/account.php">Account</a></li>
            </ul>
            <button id="themeToggle" class="btn btn-outline-secondary ms-lg-3" type="button"><i class="bi bi-moon-stars"></i></button>
        </div>
    </div>
</header>
<main><?= $content ?? '' ?></main>
<footer class="bg-dark text-light py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="text-uppercase">About SOSHEMAIN</h5>
                <p>We are a strategy, design, and technology collective delivering measurable innovation for ambitious brands.</p>
                <p class="small mb-0">Innovation that drives results.</p>
            </div>
            <div class="col-md-4">
                <h5 class="text-uppercase">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a class="link-light" href="/privacy.php">Privacy Policy</a></li>
                    <li><a class="link-light" href="/terms.php">Terms of Service</a></li>
                    <li><a class="link-light" href="/returns.php">Returns Policy</a></li>
                    <li><a class="link-light" href="/careers.php">Careers</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="text-uppercase">Stay in Touch</h5>
                <p class="mb-1"><i class="bi bi-geo-alt"></i> 500 Innovation Way, Boston, MA</p>
                <p class="mb-1"><i class="bi bi-envelope"></i> hello@soshemain.com</p>
                <p class="mb-3"><i class="bi bi-telephone"></i> +1 (617) 555-0183</p>
                <div class="d-flex gap-3">
                    <a class="text-light" href="https://twitter.com" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                    <a class="text-light" href="https://www.linkedin.com" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                    <a class="text-light" href="https://www.instagram.com" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
        </div>
        <p class="text-center small mt-4 mb-0">&copy; <?= date('Y') ?> SOSHEMAIN. All rights reserved.</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="/js/main.js"></script>
</body>
</html>
