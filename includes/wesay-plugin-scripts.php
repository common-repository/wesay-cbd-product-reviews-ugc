<?php

// Frontend Script
function wesay_widget_enqueue_script()
{
    wp_enqueue_script('wesay_plugin_script', 'https://scripts.wesay.life/widget/v1.1/reviews-widget.js');
}
add_action('wp_enqueue_scripts', 'wesay_widget_enqueue_script');


// Admin Script
add_action('admin_enqueue_scripts', 'wesay_widget_enqueue_script');
