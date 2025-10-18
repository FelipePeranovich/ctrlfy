<?php
require __DIR__ . '/meliConfig.php';

/**
 * Faz requisições GET à API do Mercado Livre
 */
function meli_get($url, $access_token) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $access_token"]);
    $resp = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['http_code' => $code, 'body' => json_decode($resp, true)];
}

/**
 * Renova o token quando expira
 */
function meli_refresh_token() {
    $tokens = meli_load_tokens();
    if (!$tokens || empty($tokens['refresh_token'])) return false;

    $ch = curl_init('https://api.mercadolibre.com/oauth/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'grant_type' => 'refresh_token',
        'client_id' => MELI_CLIENT_ID,
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
 * Retorna um token válido (renova se necessário)
 */
function meli_get_valid_token() {
    $tokens = meli_load_tokens();
    if (!$tokens) return false;

    $obtained = (int)($tokens['obtained_at'] ?? 0);
    $expires_in = (int)($tokens['expires_in'] ?? 0);

    if (time() > ($obtained + $expires_in - 60)) {
        $new = meli_refresh_token();
        if ($new) return $new['access_token'];
        return false;
    }

    return $tokens['access_token'];
}
