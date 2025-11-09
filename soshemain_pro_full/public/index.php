<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/db.php';
require_once BASE_PATH . '/core/ecommerce.php';
require_once BASE_PATH . '/core/security.php';

$featuredServices = run_query('SELECT title, summary FROM services WHERE is_featured = 1 ORDER BY sort_order LIMIT 4');
$featuredProducts = run_query('SELECT id, name, slug, price, short_description FROM products WHERE status = "published" AND featured = 1 LIMIT 4');
$testimonials = run_query('SELECT author_name, author_title, quote FROM testimonials ORDER BY sort_order LIMIT 6');
$blogPosts = run_query('SELECT id, title, slug, excerpt, published_at FROM posts WHERE status = "published" ORDER BY published_at DESC LIMIT 3');
$stats = run_query_one('SELECT SUM(total) as total_sales, COUNT(*) as total_orders FROM orders WHERE status IN ("paid", "completed")');

ob_start();
?>
<section class="py-5 bg-gradient position-relative overflow-hidden">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="badge bg-primary-subtle text-primary mb-3">Innovation that drives results.</span>
                <h1 class="display-4 fw-bold mb-4">Transform your digital footprint with a partner built for speed and scale.</h1>
                <p class="lead mb-4">SOSHEMAIN is a full-service innovation studio delivering strategy, design, and technology for forward-thinking teams who demand measurable growth.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a class="btn btn-primary btn-lg" href="/services.php">Explore services</a>
                    <a class="btn btn-outline-secondary btn-lg" href="/products.php">Shop products</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img class="img-fluid rounded-4 shadow-lg" src="/images/hero-collage.jpg" alt="Team working on digital strategy">
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col">
                <h2 class="fw-bold">Strategic outcomes in every engagement</h2>
                <p class="text-secondary">We unite research, design, and engineering to launch resilient digital experiences.</p>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($featuredServices as $service): ?>
            <div class="col-md-6 col-xl-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-lightning-charge text-primary fs-1 mb-3"></i>
                        <h5 class="card-title"><?= e($service['title']) ?></h5>
                        <p class="card-text text-secondary"><?= e($service['summary']) ?></p>
                        <a class="stretched-link" href="/services.php">Learn more</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Featured products</h2>
            <a class="btn btn-outline-primary btn-sm" href="/products.php">View all</a>
        </div>
        <div class="row g-4">
            <?php foreach ($featuredProducts as $product): ?>
            <div class="col-md-6 col-xl-3">
                <div class="card h-100 border-0 shadow-sm">
                    <img class="card-img-top" src="/images/products/<?= e($product['slug']) ?>.jpg" alt="<?= e($product['name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= e($product['name']) ?></h5>
                        <p class="text-secondary"><?= e($product['short_description']) ?></p>
                        <p class="fw-semibold"><?= format_currency((float) $product['price']) ?></p>
                        <a class="stretched-link" href="/product.php?slug=<?= urlencode($product['slug']) ?>">View details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="p-4 border rounded-4 shadow-sm bg-body">
                    <p class="fs-2 fw-bold mb-1" data-countup="<?= (int) ($stats['total_sales'] ?? 75000) ?>">$<?= number_format($stats['total_sales'] ?? 75000) ?></p>
                    <p class="text-secondary mb-0">Revenue generated</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 border rounded-4 shadow-sm bg-body">
                    <p class="fs-2 fw-bold mb-1">98%</p>
                    <p class="text-secondary mb-0">Client satisfaction</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 border rounded-4 shadow-sm bg-body">
                    <p class="fs-2 fw-bold mb-1" data-countup="<?= (int) ($stats['total_orders'] ?? 250) ?>"><?= (int) ($stats['total_orders'] ?? 250) ?></p>
                    <p class="text-secondary mb-0">Orders fulfilled</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 border rounded-4 shadow-sm bg-body">
                    <p class="fs-2 fw-bold mb-1">24/7</p>
                    <p class="text-secondary mb-0">Strategic support</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Trusted by leaders who expect more from digital.</h2>
                <p class="lead">"SOSHEMAIN re-engineered our customer acquisition strategy and doubled our qualified pipeline in under 90 days."</p>
                <p class="text-secondary">— Jordan Ellis, Chief Revenue Officer at Velocity Labs</p>
                <a class="btn btn-primary" href="/contact.php">Start your project</a>
            </div>
            <div class="col-lg-6">
                <div class="carousel slide" data-bs-ride="carousel" id="testimonialCarousel">
                    <div class="carousel-inner">
                        <?php foreach ($testimonials as $index => $testimonial): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <div class="card border-0 shadow-lg p-4">
                                <p class="fs-5">“<?= e($testimonial['quote']) ?>”</p>
                                <p class="text-secondary mb-0 fw-semibold"><?= e($testimonial['author_name']) ?>, <?= e($testimonial['author_title']) ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3">Industry insights to accelerate your strategy</h2>
                <p class="text-secondary mb-4">Stay ahead with articles on AI, growth marketing, experience design, and emerging technology trends.</p>
                <ul class="list-unstyled mb-0">
                    <?php foreach ($blogPosts as $post): ?>
                    <li class="mb-3">
                        <a class="text-decoration-none" href="/post.php?slug=<?= urlencode($post['slug']) ?>">
                            <span class="fw-semibold d-block"><?= e($post['title']) ?></span>
                            <span class="text-secondary small">Published <?= date('M j, Y', strtotime($post['published_at'])) ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-3">Start a conversation</h3>
                        <form method="post" action="/contact.php">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label" for="contactName">Name</label>
                                <input class="form-control" id="contactName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="contactEmail">Email</label>
                                <input class="form-control" type="email" id="contactEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="contactMessage">Project goal</label>
                                <textarea class="form-control" id="contactMessage" name="message" rows="3" required></textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = 'SOSHEMAIN — Innovation that drives results';
$metaDescription = 'SOSHEMAIN is a digital innovation studio delivering strategy, design, and technology that drives measurable results across ecommerce and customer experience.';
require BASE_PATH . '/views/layouts/main.php';
