<?php
define('MELI_CLIENT_ID', '862257925000725');
define('MELI_CLIENT_SECRET', '2v4LU4UHyZpZ3OFfuNDYXaxy8COtEJe8');
define('MELI_REDIRECT_URI', 'https://floppily-sightless-zayden.ngrok-free.dev/ctrlfy/configapi/melicallback.php');
define('MELI_TOKEN_FILE', __DIR__ . '/meli_tokens.json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
