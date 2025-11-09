<?php
require_once __DIR__ . '/../core/helpers.php';
require_once BASE_PATH . '/core/auth.php';
logout();
flash('success', 'You have been logged out.');
redirect('/admin/index.php');
