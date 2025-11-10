<?php
require_once __DIR__ . '/init.php';
$data = [
    'aboutPage' => $controller->page('sobre-nosotros'),
    'team' => json_decode(site_setting('team_members', '[]'), true),
    'timeline' => json_decode(site_setting('timeline', '[]'), true),
    'values' => json_decode(site_setting('values', '[]'), true)
];
render_view('about', $data);
