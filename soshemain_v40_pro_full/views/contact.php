<?php
$pageTitle = 'Contacto';
$metaDescription = 'Ponte en contacto con el equipo de SOSHEMAIN para impulsar tu próxima etapa de crecimiento.';
?>
<section class="bg-slate-900 text-white">
    <div class="mx-auto max-w-6xl px-6 py-24">
        <div class="grid gap-12 lg:grid-cols-2">
            <div>
                <span class="badge badge-soft">Conversemos</span>
                <h1 class="mt-4 text-4xl font-serif leading-tight">Tu próximo salto estratégico comienza aquí</h1>
                <p class="mt-4 text-lg text-slate-300">Cuéntanos tus objetivos y diseñaremos una ruta clara con entregables medibles y acompañamiento dedicado.</p>
                <div class="mt-8 space-y-6 text-sm text-slate-200">
                    <div>
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-400">Contacto</h2>
                        <p class="mt-2">Tel: <?= htmlspecialchars(site_setting('phone', '+52 55 1234 5678')) ?></p>
                        <p>Email: <?= htmlspecialchars(site_setting('email', 'hola@soshemain.com')) ?></p>
                        <p>WhatsApp: <?= htmlspecialchars(site_setting('whatsapp', '+52 55 9876 5432')) ?></p>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-400">Oficina</h2>
                        <p class="mt-2"><?= htmlspecialchars(site_setting('address', 'Av. Paseo de la Reforma 123, Ciudad de México')) ?></p>
                        <p>Horario: <?= htmlspecialchars(site_setting('schedule', 'Lun-Vie 9:00-18:00')) ?></p>
                    </div>
                </div>
                <div class="mt-10 rounded-3xl border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold">Punto de reunión</h3>
                    <iframe src="https://maps.google.com/maps?q=Ciudad%20de%20Mexico&t=&z=13&ie=UTF8&iwloc=&output=embed" class="mt-4 h-64 w-full rounded-2xl" loading="lazy" title="Mapa SOSHEMAIN"></iframe>
                </div>
            </div>
            <div>
                <form method="post" action="contact.php" class="rounded-3xl border border-white/10 bg-white/5 p-8 shadow-xl backdrop-blur">
                    <h2 class="text-2xl font-semibold">Agenda una sesión estratégica</h2>
                    <p class="mt-2 text-sm text-slate-300">Un especialista te contactará en menos de 24 horas.</p>
                    <?php if (!empty($success)): ?>
                        <div class="mt-4 rounded-2xl border border-emerald-400/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                            ¡Gracias! Hemos recibido tu mensaje y nos pondremos en contacto muy pronto.
                        </div>
                    <?php elseif (!empty($error)): ?>
                        <div class="mt-4 rounded-2xl border border-red-400/40 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>
                    <?= csrf_input() ?>
                    <input type="hidden" name="action" value="contact">
                    <div class="mt-6 grid gap-4">
                        <div>
                            <label for="name" class="block text-sm font-semibold">Nombre completo</label>
                            <input id="name" name="name" type="text" required class="mt-1 w-full rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/50">
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="email" class="block text-sm font-semibold">Correo</label>
                                <input id="email" name="email" type="email" required class="mt-1 w-full rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/50">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-semibold">Teléfono</label>
                                <input id="phone" name="phone" type="tel" class="mt-1 w-full rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/50">
                            </div>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-semibold">Mensaje</label>
                            <textarea id="message" name="message" rows="5" required class="mt-1 w-full rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/50"></textarea>
                        </div>
                        <label class="flex items-center gap-2 text-xs text-slate-300"><input type="checkbox" name="privacy" required class="rounded border-white/20 bg-white/10">Acepto el aviso de privacidad</label>
                        <button type="submit" class="mt-4 inline-flex items-center justify-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/40 transition hover:-translate-y-0.5">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
