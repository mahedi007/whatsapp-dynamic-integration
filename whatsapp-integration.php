<?php
/*
Plugin Name: WhatsApp Integration
Plugin URI: https://mahedi.whizbd.com/whatsapp-integration
Description: A simple plugin to integrate WhatsApp chat with your WordPress site.
Version: 1.3
Author: Mahedi Hasan
Author URI: https://mahedi.whizbd.com
License: GPL2
*/

if (!defined('ABSPATH')) {
    exit;
}


function whatsapp_button_styles() {
    wp_enqueue_style('whatsapp-integration-styles', plugin_dir_url(__FILE__) . 'css/whatsapp-integration.css');
    wp_enqueue_script('whatsapp-integration-script', plugin_dir_url(__FILE__) . 'js/whatsapp-integration.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'whatsapp_button_styles');

// Add the WhatsApp chat button to the site
function whatsapp_chat_button() {
    $phone_number = get_option('whatsapp_phone_number', '1234567890'); // Default number if not set
    $qr_code_url = get_option('whatsapp_qr_code_url', plugin_dir_url(__FILE__) . 'images/whatsapp-qr-code.png'); // QR code URL from settings
    ?>
    <div id="whatsapp-button-container">
        <img src="<?php echo plugin_dir_url(__FILE__) . 'images/whatsapp-logo.png'; ?>" alt="WhatsApp" class="whatsapp-button">
        <div id="whatsapp-chat-box">
            <div class="chat-header">
                Chat with Us
                <span class="close-chat-box">&times;</span>
            </div>
            <div class="chat-body">
                <div class="message-bubble">Please text us by clicking start chat button or scan the QR code!</div>
            </div>
            <div class="chat-footer">
                <a href="https://wa.me/<?php echo esc_attr($phone_number); ?>" target="_blank" class="chat-button">Start Chat</a>
                <?php if ($qr_code_url && $qr_code_url !== plugin_dir_url(__FILE__) . 'images/whatsapp-qr-code.png'): ?>
                <div id="qr-code-container">
                    <img src="<?php echo esc_url($qr_code_url); ?>" alt="QR Code">
                    <div class="scan-text">Scan me</div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}

add_action('wp_footer', 'whatsapp_chat_button');

// Add settings link on plugin page
function whatsapp_integration_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=whatsapp-integration">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}

add_filter("plugin_action_links_" . plugin_basename(__FILE__), 'whatsapp_integration_settings_link');

function whatsapp_integration_menu() {
    add_options_page(
        'WhatsApp Integration Settings',
        'WhatsApp Integration',
        'manage_options',
        'whatsapp-integration',
        'whatsapp_integration_options_page'
    );
}

add_action('admin_menu', 'whatsapp_integration_menu');

function whatsapp_integration_options_page() {
    ?>
    <div class="wrap">
        <h1>WhatsApp Integration Settings</h1>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php
            settings_fields('whatsapp_integration_options_group');
            do_settings_sections('whatsapp-integration');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register and define the settings
function whatsapp_integration_settings_init() {
    register_setting('whatsapp_integration_options_group', 'whatsapp_phone_number');
    register_setting('whatsapp_integration_options_group', 'whatsapp_qr_code_url');

    add_settings_section(
        'whatsapp_integration_section',
        'WhatsApp Chat Settings',
        'whatsapp_integration_section_callback',
        'whatsapp-integration'
    );

    add_settings_field(
        'whatsapp_phone_number',
        'WhatsApp Phone Number',
        'whatsapp_phone_number_callback',
        'whatsapp-integration',
        'whatsapp_integration_section'
    );

    add_settings_field(
        'whatsapp_qr_code_url',
        'WhatsApp QR Code',
        'whatsapp_qr_code_url_callback',
        'whatsapp-integration',
        'whatsapp_integration_section'
    );
}

add_action('admin_init', 'whatsapp_integration_settings_init');

function whatsapp_integration_section_callback() {
    echo 'Enter your WhatsApp phone number with country code and upload your QR code image.';
}

function whatsapp_phone_number_callback() {
    $phone_number = get_option('whatsapp_phone_number');
    echo '<input type="text" name="whatsapp_phone_number" value="' . esc_attr($phone_number) . '" />';
}

function whatsapp_qr_code_url_callback() {
    $qr_code_url = get_option('whatsapp_qr_code_url');
    echo '<input type="text" id="whatsapp_qr_code_url" name="whatsapp_qr_code_url" value="' . esc_attr($qr_code_url) . '" />';
    echo '<input type="button" id="upload_qr_code_button" class="button-secondary" value="Upload QR Code" />';
    if ($qr_code_url) {
        echo '<br><img src="' . esc_url($qr_code_url) . '" alt="QR Code" style="max-width: 100px; max-height: 100px;" />';
    }
}

// Enqueue necessary scripts for media uploader
function whatsapp_integration_admin_scripts() {
    wp_enqueue_media();
    wp_enqueue_script('whatsapp_integration_admin_script', plugin_dir_url(__FILE__) . 'js/admin-script.js', array('jquery'), null, true);
}

add_action('admin_enqueue_scripts', 'whatsapp_integration_admin_scripts');
?>
