<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../models/Settings.php';
$settingsModel = new Settings();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $message = 'Token inválido.';
    } else {
        foreach ($_POST as $key => $value) {
            if (in_array($key, ['site_name','logo','favicon','primary_color','secondary_color','accent_color','meta_description','address','phone','email','schedule','whatsapp','analytics_id','maintenance_mode'])) {
                $settingsModel->update($key, ['value' => is_array($value) ? json_encode($value) : $value]);
            }
        }
        if (!empty($_POST['social_links'])) {
            $links = array_filter(array_map('trim', explode('\n', $_POST['social_links'])));
            $pairs = [];
            foreach ($links as $link) {
                [$network, $url] = array_pad(explode('|', $link), 2, '');
                if ($network && $url) {
                    $pairs[$network] = $url;
                }
            }
            $settingsModel->update('social_links', ['value' => json_encode($pairs)]);
        }
        $message = 'Ajustes actualizados.';
    }
}
$settings = [
    'site_name' => site_setting('site_name', 'SOSHEMAIN'),
    'logo' => site_setting('logo', ''),
    'favicon' => site_setting('favicon', ''),
    'primary_color' => site_setting('primary_color', '#0EA5E9'),
    'secondary_color' => site_setting('secondary_color', '#111827'),
    'accent_color' => site_setting('accent_color', '#F59E0B'),
    'meta_description' => site_setting('meta_description', ''),
    'address' => site_setting('address', ''),
    'phone' => site_setting('phone', ''),
    'email' => site_setting('email', ''),
    'schedule' => site_setting('schedule', ''),
    'whatsapp' => site_setting('whatsapp', ''),
    'analytics_id' => site_setting('analytics_id', ''),
    'maintenance_mode' => site_setting('maintenance_mode', 'off'),
    'social_links' => site_setting('social_links', [])
];
?>
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3">Ajustes generales</h1>
            <p class="text-secondary">Actualiza branding, datos de contacto y preferencias.</p>
        </div>
    </div>
    <?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <form method="post" class="card-glass p-4 d-grid gap-4">
        <?= csrf_input() ?>
        <section>
            <h2 class="h5">Identidad</h2>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nombre del sitio</label>
                    <input type="text" name="site_name" class="form-control" value="<?= htmlspecialchars($settings['site_name']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Logo</label>
                    <input type="text" name="logo" class="form-control" placeholder="logo.png" value="<?= htmlspecialchars($settings['logo']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Favicon</label>
                    <input type="text" name="favicon" class="form-control" placeholder="favicon.ico" value="<?= htmlspecialchars($settings['favicon']) ?>">
                </div>
            </div>
        </section>
        <section>
            <h2 class="h5">Colores</h2>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Primario</label>
                    <input type="color" name="primary_color" class="form-control form-control-color" value="<?= htmlspecialchars($settings['primary_color']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Secundario</label>
                    <input type="color" name="secondary_color" class="form-control form-control-color" value="<?= htmlspecialchars($settings['secondary_color']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Acento</label>
                    <input type="color" name="accent_color" class="form-control form-control-color" value="<?= htmlspecialchars($settings['accent_color']) ?>">
                </div>
            </div>
        </section>
        <section>
            <h2 class="h5">Información de contacto</h2>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($settings['address']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($settings['phone']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">WhatsApp</label>
                    <input type="text" name="whatsapp" class="form-control" value="<?= htmlspecialchars($settings['whatsapp']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($settings['email']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Horario</label>
                    <input type="text" name="schedule" class="form-control" value="<?= htmlspecialchars($settings['schedule']) ?>">
                </div>
            </div>
        </section>
        <section>
            <h2 class="h5">SEO & Analytics</h2>
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Meta descripción</label>
                    <textarea name="meta_description" class="form-control" rows="2"><?= htmlspecialchars($settings['meta_description']) ?></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Google Analytics ID</label>
                    <input type="text" name="analytics_id" class="form-control" value="<?= htmlspecialchars($settings['analytics_id']) ?>">
                </div>
            </div>
        </section>
        <section>
            <h2 class="h5">Redes sociales</h2>
            <p class="text-secondary small">Formato: red|https://url.com (una por línea)</p>
            <textarea name="social_links" class="form-control" rows="3"><?php foreach ($settings['social_links'] as $network => $url) { echo $network . '|' . $url . "\n"; } ?></textarea>
        </section>
        <section>
            <h2 class="h5">Mantenimiento</h2>
            <select name="maintenance_mode" class="form-select" style="max-width: 240px;">
                <option value="off" <?= $settings['maintenance_mode'] === 'off' ? 'selected' : '' ?>>Activo</option>
                <option value="on" <?= $settings['maintenance_mode'] === 'on' ? 'selected' : '' ?>>Modo mantenimiento</option>
            </select>
        </section>
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Guardar ajustes</button>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
