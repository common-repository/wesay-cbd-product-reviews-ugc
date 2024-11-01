<?php

function wesay_plugin_settings_page()
{
    add_menu_page(
        'WeSay',
        'WeSay',
        'manage_options',
        'wesay-plugin',
        'wesay_plugin_settings_page_markup',
        'https://res.cloudinary.com/wesay/image/upload/w_18/v1589360504/logos/ms-icon-144x144.png',
        100
    );
};

add_action('admin_menu', 'wesay_plugin_settings_page');

function wesay_plugin_settings_page_markup()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    include(WESAY_PLUGIN_DIR . 'templates/admin/settings-page.php');
};