<?php
$pageTitle = 'Inicio';
$metaDescription = $home['meta_desc'] ?? 'Innovación que impulsa resultados con experiencias digitales y soluciones tecnológicas premium.';
$heroContent = json_decode($home['content'] ?? '', true);
$testimonials = json_decode(site_setting('testimonials', '[]'), true);
$faqs = json_decode(site_setting('faqs', '[]'), true);
?>
<section class="hero-gradient text-white">
    <div class="mx-auto max-w-7xl px-6 py-32">
        <div class="grid gap-12 lg:grid-cols-[1.1fr,0.9fr] items-center">
            <div data-animate>
                <span class="badge badge-soft mb-6">Innovación que impulsa resultados</span>
                <h1 class="text-4xl md:text-6xl font-serif leading-tight">Desatamos el potencial de tu marca con estrategias integrales de tecnología, creatividad y datos.</h1>
                <p class="mt-6 text-lg text-slate-200 max-w-2xl">SOSHEMAIN crea ecosistemas digitales que combinan diseño, automatización, inteligencia de datos y experiencias memorables para acelerar el crecimiento de empresas ambiciosas.</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#contacto" class="inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3 font-semibold shadow-lg shadow-primary/40 hover:-translate-y-0.5 transition">Agenda una consultoría</a>
                    <a href="services.php" class="inline-flex items-center gap-2 rounded-full border border-white/30 px-6 py-3 font-semibold hover:bg-white/10 transition">Explorar servicios</a>
                </div>
                <div class="mt-12 grid grid-cols-3 gap-6 text-sm text-slate-200">
                    <div class="gradient-border rounded-2xl p-4">
                        <span class="text-3xl font-bold" data-counter="120">0</span>
                        <p class="mt-2 text-xs uppercase tracking-wide">Proyectos de transformación</p>
                    </div>
                    <div class="gradient-border rounded-2xl p-4">
                        <span class="text-3xl font-bold" data-counter="48">0</span>
                        <p class="mt-2 text-xs uppercase tracking-wide">Clientes activos</p>
                    </div>
                    <div class="gradient-border rounded-2xl p-4">
                        <span class="text-3xl font-bold" data-counter="12">0</span>
                        <p class="mt-2 text-xs uppercase tracking-wide">Países con presencia</p>
                    </div>
                </div>
            </div>
            <div class="relative" data-animate>
                <div class="absolute -inset-6 rounded-3xl bg-gradient-to-br from-primary/30 via-white/5 to-accent/30 blur-3xl"></div>
                <div class="relative rounded-[32px] border border-white/10 bg-white/5 p-8 shadow-2xl">
                    <div class="flex items-center gap-3 text-sm text-white/70">
                        <span class="pill"><span class="h-2 w-2 rounded-full bg-emerald-400"></span>Panel en vivo</span>
                        <span class="pill">KPIs inteligentes</span>
                    </div>
                    <h2 class="mt-6 text-2xl font-semibold">Dashboard inteligente SOSHEMAIN</h2>
                    <p class="mt-3 text-sm text-white/70">Analiza conversión, engagement y performance en tiempo real con visualizaciones avanzadas y escenarios predictivos.</p>
                    <img src="images/dashboard-preview.png" alt="Panel administrativo de SOSHEMAIN" class="mt-6 w-full rounded-2xl border border-white/10 shadow-xl" loading="lazy">
                    <div class="mt-6 grid grid-cols-2 gap-4 text-xs text-white/70">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-3xl font-bold text-white">+58%</p>
                            <p class="mt-1">Incremento promedio en generación de leads</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-3xl font-bold text-white">4.9/5</p>
                            <p class="mt-1">Satisfacción de clientes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-white dark:bg-slate-900">
    <div class="mx-auto max-w-7xl px-6 py-24">
        <div class="flex flex-col gap-12 lg:flex-row lg:items-center">
            <div class="lg:w-1/2" data-animate>
                <span class="badge badge-gold">Servicios a la medida</span>
                <h2 class="mt-4 text-3xl font-serif leading-tight">Integramos estrategia, creatividad y tecnología en un solo equipo.</h2>
                <p class="mt-4 text-slate-600 dark:text-slate-300">Acompañamos a empresas en procesos de innovación, creación de experiencias digitales, optimización de operaciones y posicionamiento de marca.</p>
                <ul class="mt-6 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                    <li class="flex items-start gap-3"><span class="mt-1 h-2 w-2 rounded-full bg-primary"></span>Implementaciones omnicanal con personalización en tiempo real.</li>
                    <li class="flex items-start gap-3"><span class="mt-1 h-2 w-2 rounded-full bg-primary"></span>Laboratorio creativo para prototipos interactivos, UX y storytelling.</li>
                    <li class="flex items-start gap-3"><span class="mt-1 h-2 w-2 rounded-full bg-primary"></span>Arquitecturas cloud seguras, escalables y con observabilidad integrada.</li>
                </ul>
            </div>
            <div class="lg:w-1/2 grid gap-6 sm:grid-cols-2" data-animate>
                <?php foreach ($services as $service): $meta = json_decode($service['meta_data'] ?? '[]', true); ?>
                <article class="card-hover rounded-3xl border border-slate-200/60 bg-white/70 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-700 dark:bg-slate-800/80">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-secondary dark:text-white"><?= htmlspecialchars($service['name']) ?></h3>
                        <span class="badge badge-soft">Premium</span>
                    </div>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-300"><?= htmlspecialchars($meta['description'] ?? 'Solución modular adaptable a tu crecimiento.') ?></p>
                    <ul class="mt-4 space-y-2 text-xs text-slate-500 dark:text-slate-400">
                        <?php foreach (($meta['benefits'] ?? []) as $benefit): ?>
                            <li class="flex items-start gap-2"><span class="mt-1 h-1.5 w-1.5 rounded-full bg-primary"></span><?= htmlspecialchars($benefit) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<section class="bg-slate-900 text-white py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex flex-col gap-12 lg:flex-row lg:items-center">
            <div class="lg:w-2/5" data-animate>
                <span class="badge badge-soft">Soluciones insignia</span>
                <h2 class="mt-4 text-3xl font-serif">Productos modulares para acelerar cada etapa del crecimiento</h2>
                <p class="mt-4 text-slate-300">Integra soluciones listas para desplegar en marketing, ventas y operaciones. Cada módulo se configura desde un único panel inteligente.</p>
                <a href="products.php" class="mt-6 inline-flex items-center gap-2 rounded-full border border-white/30 px-6 py-3 text-sm font-semibold hover:bg-white/10">Ver catálogo completo</a>
            </div>
            <div class="lg:w-3/5 grid gap-6 sm:grid-cols-2" data-animate>
                <?php foreach (array_slice($featuredProducts, 0, 4) as $product): $images = json_decode($product['images'] ?? '[]', true); ?>
                <article class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-lg">
                    <?php if (!empty($images)): $image = $images[0]; ?>
                        <picture>
                            <img src="uploads/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="h-40 w-full rounded-2xl object-cover" loading="lazy">
                        </picture>
                    <?php else: ?>
                        <div class="h-40 rounded-2xl bg-gradient-to-br from-primary/40 to-accent/40"></div>
                    <?php endif; ?>
                    <div class="mt-4 flex items-start justify-between">
                        <h3 class="text-xl font-semibold"><?= htmlspecialchars($product['name']) ?></h3>
                        <?php if ($product['featured']): ?><span class="badge badge-gold">Destacado</span><?php endif; ?>
                    </div>
                    <p class="mt-3 text-sm text-slate-300 leading-relaxed"><?= strip_tags(substr($product['description'], 0, 120)) ?>...</p>
                    <div class="mt-4 flex items-center justify-between text-sm text-slate-200">
                        <span><?= format_currency($product['price']) ?></span>
                        <a href="products.php#<?= htmlspecialchars($product['slug']) ?>" class="inline-flex items-center gap-2 text-primary">Descubrir</a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<section class="bg-white dark:bg-slate-900">
    <div class="mx-auto max-w-7xl px-6 py-24">
        <div class="grid gap-12 lg:grid-cols-[0.9fr,1.1fr]">
            <div data-animate>
                <span class="badge badge-soft">Casos reales</span>
                <h2 class="mt-4 text-3xl font-serif">Historias de éxito que escalan con nosotros</h2>
                <p class="mt-4 text-slate-600 dark:text-slate-300">Acompañamos a empresas en su evolución digital con entregables que generan impacto medible en ciclos de 90 días.</p>
            </div>
            <div class="grid gap-8">
                <?php foreach ($testimonials as $testimonial): ?>
                <article class="rounded-3xl border border-slate-200/60 bg-white/80 p-8 shadow-lg shadow-slate-200/30 dark:border-slate-800 dark:bg-slate-800/80">
                    <p class="text-lg text-slate-700 dark:text-slate-200 italic leading-relaxed">“<?= htmlspecialchars($testimonial['quote']) ?>”</p>
                    <div class="mt-6 flex items-center justify-between text-sm text-slate-500 dark:text-slate-400">
                        <div>
                            <strong class="text-secondary dark:text-white block"><?= htmlspecialchars($testimonial['name']) ?></strong>
                            <span><?= htmlspecialchars($testimonial['company']) ?></span>
                        </div>
                        <span class="pill"><?= htmlspecialchars($testimonial['industry']) ?></span>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<section class="bg-slate-50 dark:bg-slate-900" id="blog">
    <div class="mx-auto max-w-7xl px-6 py-24">
        <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div>
                <span class="badge badge-soft">Insights</span>
                <h2 class="mt-3 text-3xl font-serif">Ideas accionables para innovar hoy</h2>
                <p class="mt-2 text-slate-600 dark:text-slate-400">Explora perspectivas del equipo SOSHEMAIN sobre estrategia, marketing experiencial y tecnología emergente.</p>
            </div>
            <a href="blog.php" class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold hover:-translate-y-0.5 transition">Ver más artículos</a>
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            <?php foreach ($latestPosts as $post): ?>
            <article class="card-hover rounded-3xl border border-slate-200/60 bg-white/80 shadow-lg shadow-slate-200/40 dark:border-slate-700 dark:bg-slate-800/80">
                <img src="uploads/<?= htmlspecialchars($post['cover']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="h-52 w-full rounded-t-3xl object-cover" loading="lazy">
                <div class="p-6">
                    <span class="badge badge-soft">Blog</span>
                    <h3 class="mt-4 text-xl font-semibold text-secondary dark:text-white"><?= htmlspecialchars($post['title']) ?></h3>
                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-300"><?= htmlspecialchars($post['excerpt']) ?></p>
                    <div class="mt-4 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                        <span><?= date('d M Y', strtotime($post['published_at'])) ?></span>
                        <a href="post.php?slug=<?= urlencode($post['slug']) ?>" class="inline-flex items-center gap-2 text-primary">Leer artículo</a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section id="contacto" class="relative isolate overflow-hidden bg-gradient-to-br from-primary/10 via-white to-accent/10 py-24 dark:from-primary/10 dark:via-slate-900 dark:to-accent/10">
    <div class="mx-auto max-w-7xl px-6">
        <div class="grid gap-12 lg:grid-cols-[0.9fr,1.1fr]">
            <div data-animate>
                <span class="badge badge-soft">Conversemos</span>
                <h2 class="mt-4 text-3xl font-serif">Diseñemos la próxima evolución de tu negocio</h2>
                <p class="mt-4 text-slate-600 dark:text-slate-300">Cuéntanos tus objetivos y un especialista SOSHEMAIN te contactará en menos de 24 horas con una propuesta clara.</p>
                <div class="mt-8 grid gap-6 sm:grid-cols-2 text-sm text-slate-600 dark:text-slate-300">
                    <div class="rounded-2xl border border-slate-200/80 bg-white/70 p-6 shadow-sm dark:border-slate-800 dark:bg-slate-800/80">
                        <h3 class="text-lg font-semibold text-secondary dark:text-white">Contacto directo</h3>
                        <p class="mt-3">Tel: <?= htmlspecialchars(site_setting('phone', '+52 55 1234 5678')) ?></p>
                        <p>Email: <?= htmlspecialchars(site_setting('email', 'hola@soshemain.com')) ?></p>
                        <p>WhatsApp: <?= htmlspecialchars(site_setting('whatsapp', '+52 55 9876 5432')) ?></p>
                    </div>
                    <div class="rounded-2xl border border-slate-200/80 bg-white/70 p-6 shadow-sm dark:border-slate-800 dark:bg-slate-800/80">
                        <h3 class="text-lg font-semibold text-secondary dark:text-white">Oficinas</h3>
                        <p class="mt-3"><?= htmlspecialchars(site_setting('address', 'Av. Paseo de la Reforma 123, Ciudad de México')) ?></p>
                        <p>Horario: <?= htmlspecialchars(site_setting('schedule', 'Lun-Vie 9:00-18:00')) ?></p>
                        <p>Visitas con cita previa</p>
                    </div>
                </div>
            </div>
            <div data-animate>
                <form method="post" action="contact.php" class="rounded-3xl border border-slate-200/80 bg-white/90 p-8 shadow-xl backdrop-blur dark:border-slate-800 dark:bg-slate-900/90">
                    <h3 class="text-2xl font-semibold text-secondary dark:text-white">Agenda una llamada estratégica</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Con gusto te contactaremos en un máximo de 24 horas hábiles.</p>
                    <?= csrf_input() ?>
                    <input type="hidden" name="action" value="contact">
                    <div class="mt-6 grid gap-4">
                        <div>
                            <label for="contactName" class="block text-sm font-medium text-slate-600 dark:text-slate-300">Nombre completo</label>
                            <input id="contactName" name="name" type="text" required class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-700 dark:bg-slate-800">
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="contactEmail" class="block text-sm font-medium text-slate-600 dark:text-slate-300">Correo electrónico</label>
                                <input id="contactEmail" name="email" type="email" required class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-700 dark:bg-slate-800">
                            </div>
                            <div>
                                <label for="contactPhone" class="block text-sm font-medium text-slate-600 dark:text-slate-300">Teléfono</label>
                                <input id="contactPhone" name="phone" type="tel" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-700 dark:bg-slate-800">
                            </div>
                        </div>
                        <div>
                            <label for="contactMessage" class="block text-sm font-medium text-slate-600 dark:text-slate-300">¿Cómo podemos ayudarte?</label>
                            <textarea id="contactMessage" name="message" rows="4" required class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-700 dark:bg-slate-800"></textarea>
                        </div>
                        <label class="flex items-center gap-2 text-xs text-slate-500"><input type="checkbox" name="privacy" required class="rounded border-slate-300">Acepto el aviso de privacidad</label>
                        <button type="submit" class="mt-2 inline-flex items-center justify-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/40 transition hover:-translate-y-0.5">Enviar mensaje</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-16 rounded-3xl overflow-hidden shadow-2xl">
            <iframe src="https://maps.google.com/maps?q=Ciudad%20de%20M%C3%A9xico&t=&z=13&ie=UTF8&iwloc=&output=embed" title="Mapa SOSHEMAIN" class="h-80 w-full" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
<section class="bg-white dark:bg-slate-900 py-24">
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div>
                <span class="badge badge-soft">Preguntas frecuentes</span>
                <h2 class="mt-3 text-3xl font-serif">Resolvemos tus dudas clave</h2>
            </div>
            <a href="contact.php" class="inline-flex items-center gap-2 rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold hover:-translate-y-0.5 transition">Habla con un experto</a>
        </div>
        <div class="mt-10 rounded-3xl border border-slate-200/80 bg-white/80 p-8 shadow-lg backdrop-blur dark:border-slate-800 dark:bg-slate-800/80" data-accordion>
            <?php foreach ($faqs as $index => $faq): ?>
            <div class="border-b border-slate-200 last:border-b-0 dark:border-slate-700">
                <button type="button" class="flex w-full items-center justify-between py-4 text-left text-base font-medium text-secondary dark:text-white">
                    <?= htmlspecialchars($faq['question']) ?>
                    <span class="text-primary">+</span>
                </button>
                <div class="max-h-0 overflow-hidden text-sm text-slate-600 transition-all duration-300 dark:text-slate-300">
                    <p class="pb-4 pr-6 leading-relaxed"><?= htmlspecialchars($faq['answer']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
