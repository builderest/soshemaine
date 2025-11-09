<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/db.php';

$page = run_query_one('SELECT * FROM pages WHERE slug = "about" LIMIT 1');
$team = run_query('SELECT name, role, bio, photo FROM team_members ORDER BY sort_order');
$values = run_query('SELECT title, description FROM company_values ORDER BY sort_order');

ob_start();
?>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="badge bg-primary-subtle text-primary mb-3">Who we are</span>
                <h1 class="display-5 fw-bold mb-4"><?= e($page['title'] ?? 'About SOSHEMAIN') ?></h1>
                <p class="lead text-secondary"><?= nl2br(e($page['excerpt'] ?? 'We are an innovation collective blending strategy, design, and engineering.')) ?></p>
            </div>
            <div class="col-lg-6">
                <img class="img-fluid rounded-4 shadow-lg" src="/images/about-team.jpg" alt="SOSHEMAIN leadership team collaborating">
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($values as $value): ?>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= e($value['title']) ?></h5>
                        <p class="card-text text-secondary"><?= e($value['description']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col">
                <h2 class="fw-bold">Leadership team</h2>
                <p class="text-secondary">Human-centered experts committed to measurable business outcomes.</p>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($team as $member): ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <img class="rounded-circle mb-3" src="/images/team/<?= e($member['photo']) ?>" alt="<?= e($member['name']) ?> portrait" width="120" height="120">
                    <h5 class="fw-semibold mb-1"><?= e($member['name']) ?></h5>
                    <p class="text-primary fw-semibold mb-2"><?= e($member['role']) ?></p>
                    <p class="text-secondary mb-0"><?= e($member['bio']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Mission</h2>
                <p class="text-secondary"><?= nl2br(e($page['body'] ?? 'We accelerate innovation by empowering teams with research, design, and technology.')) ?></p>
            </div>
            <div class="col-lg-6">
                <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-lg">
                    <iframe src="https://www.youtube.com/embed/kN1XDsbV6y4" title="SOSHEMAIN capabilities" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = 'About SOSHEMAIN';
$metaDescription = 'Discover SOSHEMAIN’s mission, leadership team, and values guiding our innovation and ecommerce solutions.';
require BASE_PATH . '/views/layouts/main.php';
