<?php

if (!defined('ABSPATH')) exit;

/**
 * Tambahkan menu Settings → GovTraffic
 */
function govtraffic_settings_menu()
{
    add_options_page(
        'GovTraffic Settings',
        'GovTraffic',
        'manage_options',
        'govtraffic-settings',
        'govtraffic_settings_page'
    );
}
add_action('admin_menu', 'govtraffic_settings_menu');


/**
 * Halaman pengaturan plugin
 */
function govtraffic_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    // Simpan pengaturan
    if (isset($_POST['govtraffic_save'])) {
        update_option('govtraffic_website_id', sanitize_text_field($_POST['website_id']));
        update_option('govtraffic_token', sanitize_text_field($_POST['token']));

        echo '<div class="updated"><p>Pengaturan berhasil disimpan.</p></div>';
    }

    $website_id = get_option('govtraffic_website_id');
    $token      = get_option('govtraffic_token');
    ?>

    <div class="wrap">
        <h1>GovTraffic Reporter</h1>

        <p>Masukkan <b>Website ID</b> dan <b>Token</b> yang diberikan oleh backend Laravel.</p>

        <form method="POST">
            <table class="form-table">

                <tr>
                    <th scope="row"><label>Website ID</label></th>
                    <td>
                        <input type="text" name="website_id" value="<?= esc_attr($website_id); ?>" class="regular-text" required>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label>API Token</label></th>
                    <td>
                        <input type="text" name="token" value="<?= esc_attr($token); ?>" class="regular-text" required>
                    </td>
                </tr>

            </table>

            <p class="submit">
                <button type="submit" name="govtraffic_save" class="button button-primary">Simpan</button>
            </p>
        </form>
    </div>

<?php
}
