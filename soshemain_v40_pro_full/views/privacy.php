<?php
$pageTitle = 'Aviso de Privacidad';
$metaDescription = 'Aviso de privacidad de SOSHEMAIN para la protección de datos personales.';
$privacy = $privacy ?? null;
?>
<section class="bg-white dark:bg-slate-900">
    <div class="mx-auto max-w-5xl px-6 py-24">
        <h1 class="text-4xl font-serif text-secondary dark:text-white">Aviso de Privacidad</h1>
        <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">Última actualización: <?= date('d/m/Y') ?></p>
        <div class="mt-8 space-y-6 text-slate-600 dark:text-slate-300 leading-relaxed">
            <?= $privacy['content'] ?? '<p>SOSHEMAIN protege los datos personales conforme a la Ley Federal de Protección de Datos Personales en Posesión de los Particulares. La información recabada se utiliza para gestionar la relación con nuestros clientes, ofrecer servicios personalizados y enviar comunicaciones relacionadas con nuestras soluciones.</p>' ?>
        </div>
    </div>
</section>
