<?php
require __DIR__ . '/meliConfig.php';

/**
 * -------------------------------------------------------
 * FUNÇÃO PRINCIPAL DE REQUISIÇÃO GET + CACHE AUTOMÁTICO
 * -------------------------------------------------------
 */
function meli_get($url, $access_token)
{
    $cacheDir = __DIR__ . '/cache';
    if (!is_dir($cacheDir)) mkdir($cacheDir, 0777, true);

    $cacheFile = $cacheDir . '/' . md5($url) . '.json';
    $cacheTTL  = 1800; // 30 minutos

    // Se existe cache válido
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTTL) {
        $cached = json_decode(file_get_contents($cacheFile), true);

        return [
            'http_code' => $cached['http_code'] ?? 0,
            'body'      => $cached['body'] ?? null
        ];
    }

    // Se token inválido
    if (!$access_token) {
        return ['http_code' => 0, 'body' => null];
    }

    // Requisição real
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $access_token"]);
    $resp = curl_exec($ch);
    $err  = curl_error($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Se erro de CURL
    if ($resp === false || $err) {
        $safeResp = ['http_code' => $code ?: 0, 'body' => null];
        file_put_contents($cacheFile, json_encode($safeResp));
        return $safeResp;
    }

    $json = json_decode($resp, true);

    // JSON inválido
    if (!is_array($json)) {
        $safeResp = ['http_code' => $code, 'body' => null];
        file_put_contents($cacheFile, json_encode($safeResp));
        return $safeResp;
    }

    // Estrutura final
    $data = ['http_code' => $code, 'body' => $json];
    file_put_contents($cacheFile, json_encode($data));

    return $data;
}

/**
 * -------------------------------------------------------
 * RENOVA O TOKEN QUANDO EXPIRA
 * -------------------------------------------------------
 */
function meli_refresh_token()
{
    $tokens = meli_load_tokens();
    if (!$tokens || empty($tokens['refresh_token'])) return false;

    $ch = curl_init('https://api.mercadolibre.com/oauth/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'grant_type'    => 'refresh_token',
        'client_id'     => MELI_CLIENT_ID,
        'client_secret' => MELI_CLIENT_SECRET,
        'refresh_token' => $tokens['refresh_token']
    ]));

    $resp = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($resp, true);

    if ($code === 200 && isset($data['access_token'])) {
        $data['obtained_at'] = time();
        meli_save_tokens($data);
        return $data;
    }

    return false;
}

/**
 * -------------------------------------------------------
 * GARANTE UM TOKEN VÁLIDO
 * -------------------------------------------------------
 */
function meli_get_valid_token()
{
    $tokens = meli_load_tokens();
    if (!$tokens) return false;

    $obtained   = $tokens['obtained_at'] ?? 0;
    $expires_in = $tokens['expires_in'] ?? 0;

    // Se expira em menos de 60s → renova
    if (time() > ($obtained + $expires_in - 60)) {

        $new = meli_refresh_token();
        if ($new) return $new['access_token'];

        return false;
    }

    return $tokens['access_token'];
}

/**
 * -------------------------------------------------------
 * SALVAR E CARREGAR TOKENS
 * -------------------------------------------------------
 */
function meli_save_tokens(array $data)
{
    file_put_contents(MELI_TOKEN_FILE, json_encode($data));
}

function meli_load_tokens()
{
    if (!file_exists(MELI_TOKEN_FILE)) return null;

    $json = json_decode(file_get_contents(MELI_TOKEN_FILE), true);
    return is_array($json) ? $json : null;
}
