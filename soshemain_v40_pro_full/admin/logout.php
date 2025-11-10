<?php
require_once __DIR__ . '/../core/auth.php';
Auth::logout();
header('Location: index.php');
exit;
