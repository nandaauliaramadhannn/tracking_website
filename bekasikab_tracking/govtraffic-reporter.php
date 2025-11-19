<?php
/**
 * Plugin Name: BekasiKab Reporter Tracking
 * Description: Mengirim data kunjungan website ke server tracking pemerintah.
 * Version: 1.0
 * Author: Medstudio
 */

if (!defined('ABSPATH')) exit;

// Constants
define('GOVTRAFFIC_API_URL', 'https://127.0.0.1:8000/api/app/public/tracktrack'); // GANTI SESUAI API LARAVEL

// Load settings page
require_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';

/**
 * Send tracking data on each page load
 */
function govtraffic_send_tracking()
{
    $website_id = get_option('govtraffic_website_id');
    $token      = get_option('govtraffic_token');

    if (!$website_id || !$token) {
        return; // jangan kirim kalau belum diisi
    }

    $body = json_encode([
        'website_id' => $website_id,
        'token'      => $token,
        'referrer'   => $_SERVER['HTTP_REFERER'] ?? '',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    ]);

    wp_remote_post(GOVTRAFFIC_API_URL, [
        'method'  => 'POST',
        'headers' => ['Content-Type' => 'application/json'],
        'body'    => $body,
        'timeout' => 5
    ]);
}
add_action('wp_head', 'govtraffic_send_tracking');
