<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/db.php';

$services = run_query('SELECT title, summary, description, icon FROM services ORDER BY sort_order');
$faqs = run_query('SELECT question, answer FROM faqs WHERE category = "services" ORDER BY sort_order');

ob_start();
?>
<section class="py-5 bg-primary text-light">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <h1 class="display-4 fw-bold mb-4">Services engineered for measurable growth</h1>
                <p class="lead">From discovery to launch, our multidisciplinary team delivers end-to-end capabilities that transform customer experiences and accelerate revenue.</p>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body text-dark">
                        <h3 class="fw-bold mb-3">Engage with SOSHEMAIN</h3>
                        <form method="post" action="/contact.php">
                            <div class="mb-3">
                                <label class="form-label" for="serviceName">Full name</label>
                                <input class="form-control" id="serviceName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="serviceEmail">Email</label>
                                <input class="form-control" id="serviceEmail" type="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="serviceService">Primary service</label>
                                <select class="form-select" id="serviceService" name="interest">
                                    <?php foreach ($services as $service): ?>
                                        <option value="<?= e($service['title']) ?>"><?= e($service['title']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button class="btn btn-primary w-100" type="submit">Request consultation</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($services as $service): ?>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi <?= e($service['icon'] ?? 'bi-stars') ?> text-primary fs-2 me-3"></i>
                            <h3 class="h4 mb-0"><?= e($service['title']) ?></h3>
                        </div>
                        <p class="text-secondary"><?= e($service['summary']) ?></p>
                        <div><?= nl2br(e($service['description'])) ?></div>
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
                <h2 class="fw-bold">Frequently asked questions</h2>
                <p class="text-secondary">Transparent answers to help you plan your next initiative.</p>
            </div>
        </div>
        <div class="accordion" id="serviceFaq">
            <?php foreach ($faqs as $index => $faq): ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeading<?= $index ?>">
                    <button class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="faqCollapse<?= $index ?>">
                        <?= e($faq['question']) ?>
                    </button>
                </h2>
                <div id="faqCollapse<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" aria-labelledby="faqHeading<?= $index ?>" data-bs-parent="#serviceFaq">
                    <div class="accordion-body"><?= nl2br(e($faq['answer'])) ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = 'Services — SOSHEMAIN';
$metaDescription = 'Review SOSHEMAIN’s strategic services spanning research, brand experience, ecommerce, and growth enablement.';
require BASE_PATH . '/views/layouts/main.php';
