<div class="wrap">

  <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>

  <form method="post" action="options.php">
    <!-- Display necessary hidden fields for settings -->
    <?php settings_fields( 'wesay_plugin_settings' ); ?>
    <!-- Display the settings sections for the page -->
    <?php do_settings_sections( 'wesay_plugin' ); ?>
    <!-- Default Submit Button -->
    <?php submit_button(); ?>
  </form>

</div>
