<?php
$pageTitle = 'Soluciones';
$metaDescription = 'Catálogo de productos inteligentes SOSHEMAIN con precios de referencia.';
$products = $products ?? [];
$categories = $categories ?? [];
$categoryMap = [];
foreach ($categories as $category) {
    if (isset($category['id'])) {
        $categoryMap[$category['id']] = $category['slug'] ?? '';
    }
}
?>
<section class="bg-slate-900 text-white">
    <div class="mx-auto max-w-7xl px-6 py-24">
        <div class="max-w-3xl" data-animate>
            <span class="badge badge-soft">Catálogo premium</span>
            <h1 class="mt-4 text-4xl font-serif leading-tight">Soluciones modulares listas para desplegar</h1>
            <p class="mt-4 text-lg text-slate-300">Integra experiencias conectadas que optimizan ventas, marketing y operaciones con monitoreo inteligente desde el dashboard SOSHEMAIN.</p>
        </div>
        <div class="mt-12 grid gap-8 lg:grid-cols-[1fr,1.5fr]">
            <aside class="space-y-6" data-animate>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <h2 class="text-lg font-semibold">Por categorías</h2>
                    <ul class="mt-4 space-y-3 text-sm text-slate-200">
                        <li><a href="#" data-filter-value="all" class="hover:text-primary">Todas</a></li>
                        <?php foreach ($categories as $category): ?>
                        <li><a href="#" data-filter-value="<?= htmlspecialchars($category['slug']) ?>" class="hover:text-primary"><?= htmlspecialchars($category['name']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold">¿Necesitas ayuda?</h3>
                    <p class="mt-3 text-sm text-slate-300">Un consultor SOSHEMAIN te guía para seleccionar la combinación ideal de soluciones para tus objetivos de negocio.</p>
                    <a href="contact.php" class="mt-4 inline-flex items-center gap-2 rounded-full border border-white/40 px-5 py-2 text-sm font-semibold hover:bg-white/10">Hablar con un especialista</a>
                </div>
            </aside>
            <div class="grid gap-8" data-animate data-filter data-filter-target="[data-product]">
                <?php foreach ($products as $product): $images = json_decode($product['images'] ?? '[]', true); $meta = json_decode($product['meta_json'] ?? '[]', true); $categorySlug = $categoryMap[$product['category_id']] ?? 'all'; ?>
                <article id="<?= htmlspecialchars($product['slug']) ?>" data-product data-category="<?= htmlspecialchars($categorySlug) ?>" class="card-hover rounded-3xl border border-white/10 bg-white/5 p-8 shadow-xl">
                    <div class="flex flex-col gap-6 lg:flex-row">
                        <div class="lg:w-1/3">
                            <?php if (!empty($images)): $image = $images[0]; ?>
                                <picture>
                                    <img src="uploads/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="h-52 w-full rounded-2xl object-cover" loading="lazy">
                                </picture>
                            <?php else: ?>
                                <div class="h-52 rounded-2xl bg-gradient-to-br from-primary/40 to-accent/40"></div>
                            <?php endif; ?>
                        </div>
                        <div class="lg:flex-1 space-y-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="badge badge-soft"><?= htmlspecialchars($meta['segment'] ?? 'B2B') ?></span>
                                <?php if ($product['featured']): ?><span class="badge badge-gold">Destacado</span><?php endif; ?>
                                <span class="pill">SKU: <?= htmlspecialchars($product['sku']) ?></span>
                            </div>
                            <h2 class="text-2xl font-semibold text-white"><?= htmlspecialchars($product['name']) ?></h2>
                            <p class="text-sm text-slate-200 leading-relaxed"><?= strip_tags($product['description']) ?></p>
                            <div class="grid gap-4 md:grid-cols-2 text-sm text-slate-200">
                                <div>
                                    <h3 class="text-xs uppercase tracking-wide text-slate-400">Incluye</h3>
                                    <ul class="mt-2 space-y-2">
                                        <?php foreach (($meta['includes'] ?? []) as $include): ?>
                                            <li class="flex items-start gap-2"><span class="mt-1 h-1.5 w-1.5 rounded-full bg-primary"></span><?= htmlspecialchars($include) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div>
                                    <h3 class="text-xs uppercase tracking-wide text-slate-400">Resultados clave</h3>
                                    <ul class="mt-2 space-y-2">
                                        <?php foreach (($meta['outcomes'] ?? []) as $outcome): ?>
                                            <li class="flex items-start gap-2"><span class="mt-1 h-1.5 w-1.5 rounded-full bg-accent"></span><?= htmlspecialchars($outcome) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div>
                                    <span class="text-xs uppercase tracking-wide text-slate-400">Inversión base</span>
                                    <p class="text-2xl font-semibold text-white"><?= format_currency($product['price']) ?></p>
                                </div>
                                <div>
                                    <span class="text-xs uppercase tracking-wide text-slate-400">Disponibilidad</span>
                                    <p class="text-lg font-semibold text-white"><?= (int)$product['stock'] > 0 ? 'Entrega inmediata' : 'Bajo pedido' ?></p>
                                </div>
                                <a href="contact.php?product=<?= urlencode($product['slug']) ?>" class="inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-white hover:-translate-y-0.5 transition">Solicitar demo</a>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
