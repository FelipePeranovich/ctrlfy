<?php

require_once __DIR__ . "/meliHelper.php";

/**
 * GET com cache integrado ao meli_get()
 * 
 * @param string $url
 * @param string $access_token
 * @param int $minutes tempo do cache
 * @return array resposta no mesmo formato do meli_get()
 */
function meli_cached_get($url, $access_token, $minutes = 30)
{
    $cacheDir = __DIR__ . '/cache';

    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0777, true);
    }

    $cacheFile = $cacheDir . '/' . md5($url) . '.json';

    // ---- Se existe cache válido ----
    if (file_exists($cacheFile)) {
        $data = json_decode(file_get_contents($cacheFile), true);

        if ($data && isset($data['time']) && (time() - $data['time'] < $minutes * 60)) {
            return $data['content']; // retorna no mesmo formato do meli_get
        }
    }

    // ---- Senão, chama API normalmente ----
    $apiResp = meli_get($url, $access_token);

    // ---- Salva no cache ----
    file_put_contents($cacheFile, json_encode([
        "time"    => time(),
        "content" => $apiResp
    ], JSON_PRETTY_PRINT));

    return $apiResp;
}
