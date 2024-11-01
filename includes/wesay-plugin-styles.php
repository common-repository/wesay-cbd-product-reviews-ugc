<?php

// Conditionally load CSS on plugin settings pages only
function wesay_widget_enqueue_style( $hook ) {

    wp_register_style(
      'wesay-plugin-admin',
      WESAY_PLUGIN_URL . 'admin/style.css',
      [],
      time()
    );
  
    if('toplevel_page_wesay-plugin' == $hook ) {
      wp_enqueue_style( 'wesay-plugin-admin' );
    }
  }
  add_action( 'admin_enqueue_scripts', 'wesay_widget_enqueue_style' );