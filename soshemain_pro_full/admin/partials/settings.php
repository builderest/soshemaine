<?php $settings = $data['settings'] ?? []; $themes = $data['themes'] ?? []; ?>
<div class="card shadow-sm border-0">
    <div class="card-header">
        <h2 class="h5 mb-0">Global settings</h2>
    </div>
    <div class="card-body">
        <form method="post">
            <?php echo Csrf::field(); ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Company name</label>
                    <input type="text" name="company_name" class="form-control" value="<?php echo e($settings['company_name'] ?? 'SOSHEMAIN'); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Company email</label>
                    <input type="email" name="company_email" class="form-control" value="<?php echo e($settings['company_email'] ?? 'hello@example.com'); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="company_phone" class="form-control" value="<?php echo e($settings['company_phone'] ?? '+1 555 123 4567'); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    <input type="text" name="company_address" class="form-control" value="<?php echo e($settings['company_address'] ?? '123 Innovation Way, Portland ME'); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Default theme</label>
                    <select name="theme_default" class="form-select">
                        <?php foreach ($themes as $theme): ?>
                            <option value="<?php echo e($theme); ?>" <?php echo (($settings['theme_default'] ?? 'light') === $theme) ? 'selected' : ''; ?>><?php echo ucfirst(str_replace('-', ' ', $theme)); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Brand colors (JSON)</label>
                    <textarea name="brand_colors" class="form-control" rows="2"><?php echo e($settings['brand_colors'] ?? '{"primary":"#0066ff","secondary":"#1a1a1a"}'); ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Primary font</label>
                    <input type="text" name="font_primary" class="form-control" value="<?php echo e($settings['font_primary'] ?? 'Inter'); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Site meta description</label>
                    <textarea name="meta_description" class="form-control" rows="2"><?php echo e($settings['meta_description'] ?? 'SOSHEMAIN helps organizations modernize their digital presence.'); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Social links (JSON)</label>
                    <textarea name="social_links" class="form-control" rows="2"><?php echo e($settings['social_links'] ?? '[{"platform":"LinkedIn","url":"https://linkedin.com"}]'); ?></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Save settings</button>
                </div>
            </div>
        </form>
    </div>
</div>
