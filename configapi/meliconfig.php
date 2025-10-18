<?php
define('MELI_CLIENT_ID', '862257925000725');
define('MELI_CLIENT_SECRET', '2v4LU4UHyZpZ3OFfuNDYXaxy8COtEJe8');
define('MELI_REDIRECT_URI', 'https://floppily-sightless-zayden.ngrok-free.dev/ctrlfy/configapi/melicallback.php');
define('MELI_TOKEN_FILE', __DIR__ . '/meli_tokens.json');

if (session_status() === PHP_SESSION_NONE) session_start();

function meli_save_tokens(array $data) {
    file_put_contents(MELI_TOKEN_FILE, json_encode($data));
}

function meli_load_tokens() {
    if (!file_exists(MELI_TOKEN_FILE)) return null;
    $c = json_decode(file_get_contents(MELI_TOKEN_FILE), true);
    return is_array($c) ? $c : null;
}
