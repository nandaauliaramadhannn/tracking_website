<?php

if (!defined('ABSPATH')) exit;

/**
 * Tracking visitor function (dipanggil dari file utama)
 */
function govtraffic_execute_tracking()
{
    $website_id = get_option('govtraffic_website_id');
    $token      = get_option('govtraffic_token');

    // Jika belum diisi → jangan tracking
    if (!$website_id || !$token) {
        return;
    }

    // API endpoint Laravel (HARUS diganti sesuai server)
    $api_url = defined('GOVTRAFFIC_API_URL')
                ? GOVTRAFFIC_API_URL
                : 'https://tracking-web.medstudio.cloud/api/app/public/track';

    // Data yang dikirim ke Laravel
    $body = json_encode([
        'website_id' => $website_id,
        'token'      => $token,
        'referrer'   => $_SERVER['HTTP_REFERER'] ?? '',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    ]);

    // Kirim tracking via wp_remote_post
    $response = wp_remote_post($api_url, [
        'method'      => 'POST',
        'headers'     => ['Content-Type' => 'application/json'],
        'body'        => $body,
        'timeout'     => 5,
        'data_format' => 'body'
    ]);

    // Optional: log file untuk debug (bisa aktifkan jika perlu)
    // file_put_contents(__DIR__ . '/debug.log', print_r($response, true), FILE_APPEND);

    return $response;
}
