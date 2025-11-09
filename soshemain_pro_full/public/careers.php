<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/db.php';

$jobs = run_query('SELECT title, location, employment_type, summary, slug FROM jobs WHERE status = "open" ORDER BY posted_at DESC');

ob_start();
?>
<section class="py-5 bg-body-tertiary">
    <div class="container text-center">
        <span class="badge bg-primary-subtle text-primary mb-3">Careers</span>
        <h1 class="display-5 fw-bold mb-3">Join a team obsessed with outcomes</h1>
        <p class="lead text-secondary mb-0">SOSHEMAIN is built by strategists, designers, engineers, and growth experts solving the hardest customer challenges.</p>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($jobs as $job): ?>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h2 class="h4 fw-bold"><?= e($job['title']) ?></h2>
                        <p class="text-secondary mb-2"><i class="bi bi-geo-alt"></i> <?= e($job['location']) ?> • <?= e($job['employment_type']) ?></p>
                        <p class="text-secondary mb-3"><?= e($job['summary']) ?></p>
                        <a class="fw-semibold" href="/careers.php?job=<?= urlencode($job['slug']) ?>">View details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (!$jobs): ?>
                <div class="col">
                    <div class="alert alert-info">We are not hiring at the moment. Connect with us on LinkedIn for future openings.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = 'Careers at SOSHEMAIN';
$metaDescription = 'Explore current roles at SOSHEMAIN across strategy, design, engineering, and growth. Apply to join our remote-first team.';
require BASE_PATH . '/views/layouts/main.php';
