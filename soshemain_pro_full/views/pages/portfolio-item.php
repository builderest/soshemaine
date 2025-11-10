<?php
$project = $project ?? [];
$gallery = $project['images'] ?? [];
$carouselId = 'portfolioCarousel' . ($project['id'] ?? uniqid());
$videoEmbed = '';
if (!empty($project['video_url'])) {
    $videoUrl = $project['video_url'];
    if (str_contains($videoUrl, 'youtube.com/watch')) {
        parse_str(parse_url($videoUrl, PHP_URL_QUERY) ?? '', $query);
        if (!empty($query['v'])) {
            $videoId = preg_replace('/[^A-Za-z0-9_-]/', '', $query['v']);
            if ($videoId !== '') {
                $videoEmbed = 'https://www.youtube.com/embed/' . $videoId;
            }
        }
    } elseif (str_contains($videoUrl, 'youtu.be/')) {
        $path = trim(basename(parse_url($videoUrl, PHP_URL_PATH) ?? ''), '/');
        $videoId = preg_replace('/[^A-Za-z0-9_-]/', '', $path);
        if ($videoId !== '') {
            $videoEmbed = 'https://www.youtube.com/embed/' . $videoId;
        }
    } elseif (str_contains($videoUrl, 'vimeo.com/')) {
        $path = basename(parse_url($videoUrl, PHP_URL_PATH) ?? '');
        $videoId = preg_replace('/[^0-9]/', '', $path);
        if ($videoId !== '') {
            $videoEmbed = 'https://player.vimeo.com/video/' . $videoId;
        }
    } else {
        $videoEmbed = $videoUrl;
    }
}
?>
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="portfolio.php">Portfolio</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo e($project['title']); ?></li>
            </ol>
        </nav>
        <div class="row g-5 align-items-start">
            <div class="col-lg-6">
                <?php if (!empty($gallery)): ?>
                    <div id="<?php echo e($carouselId); ?>" class="carousel slide shadow-sm rounded-4 overflow-hidden" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($gallery as $index => $image): ?>
                                <div class="carousel-item<?php echo $index === 0 ? ' active' : ''; ?>">
                                    <img src="<?php echo e(asset('uploads/' . $image)); ?>" class="d-block w-100 object-fit-cover" alt="<?php echo e($project['title']); ?> image <?php echo $index + 1; ?>" loading="lazy" decoding="async">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($gallery) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo e($carouselId); ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#<?php echo e($carouselId); ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php elseif (!empty($project['thumbnail'])): ?>
                    <div class="ratio ratio-4x3 rounded-4 overflow-hidden shadow-sm">
                        <img src="<?php echo e(asset('uploads/' . $project['thumbnail'])); ?>" class="img-fluid object-fit-cover" alt="<?php echo e($project['title']); ?>" loading="lazy" decoding="async">
                    </div>
                <?php else: ?>
                    <div class="alert alert-secondary">Imagery for this project will be added soon.</div>
                <?php endif; ?>
                <?php if ($videoEmbed): ?>
                    <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm mt-4">
                        <iframe src="<?php echo e($videoEmbed); ?>" title="<?php echo e($project['title']); ?> video" allowfullscreen loading="lazy"></iframe>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-3"><?php echo e($project['title']); ?></h1>
                <div class="d-flex flex-wrap gap-3 mb-4 text-muted">
                    <?php if (!empty($project['category'])): ?><span><i class="bi bi-grid me-1"></i><?php echo e($project['category']); ?></span><?php endif; ?>
                    <?php if (!empty($project['client'])): ?><span><i class="bi bi-building me-1"></i><?php echo e($project['client']); ?></span><?php endif; ?>
                </div>
                <div class="post-content mb-4">
                    <?php echo $project['description']; ?>
                </div>
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <?php if (!empty($project['link'])): ?>
                        <a href="<?php echo e($project['link']); ?>" class="btn btn-primary" target="_blank" rel="noopener">Visit project</a>
                    <?php endif; ?>
                    <a href="contact.php" class="btn btn-outline-primary">Start a similar engagement</a>
                </div>
            </div>
        </div>
    </div>
</section>
