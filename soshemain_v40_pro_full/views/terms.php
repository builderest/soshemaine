<?php
$pageTitle = 'Términos y Condiciones';
$metaDescription = 'Condiciones de uso del sitio y servicios SOSHEMAIN.';
$terms = $terms ?? null;
?>
<section class="bg-white dark:bg-slate-900">
    <div class="mx-auto max-w-5xl px-6 py-24">
        <h1 class="text-4xl font-serif text-secondary dark:text-white">Términos y Condiciones</h1>
        <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">Última actualización: <?= date('d/m/Y') ?></p>
        <div class="mt-8 space-y-6 text-slate-600 dark:text-slate-300 leading-relaxed">
            <?= $terms['content'] ?? '<p>El uso del sitio web de SOSHEMAIN implica la aceptación de los presentes términos. Los servicios se rigen por acuerdos comerciales específicos, confidencialidad y políticas de propiedad intelectual compartidas con cada cliente.</p>' ?>
        </div>
    </div>
</section>
