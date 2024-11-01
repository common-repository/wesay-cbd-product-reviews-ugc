<?php

function wesay_add_settings_field($name, $title, $type, $subtitle)
{
  add_settings_field(
    // Unique identifier for field
    'wesay_plugin_settings_' . $name,
    // Field Title
    __($title, 'wesay_plugin'),
    // Callback for field markup
    'wesay_plugin_settings_' . $type . '_callback',
    // Page to go on
    'wesay_plugin',
    // Section to go in
    'wesay_plugin_settings_section',
    // Args
    [$name, $subtitle]
  );
}

function wesay_plugin_settings()
{
  // Set default values
  $default_options = [];

  // If plugin settings don't exist, then create them
  if (false == get_option('wesay_plugin_settings')) {
    add_option('wesay_plugin_settings', $default_options);
  }


  $options = get_option('wesay_plugin_settings');

  if (!isset($options['token']) || $options['token'] == '') {
    wesay_display_message('Set your API key in order the WeSay plugin to work correctly. grab the key from ', true);
  }

  // Define (at least) one section for our fields
  add_settings_section(
    // Unique identifier for the section
    'wesay_plugin_settings_section',
    // Section Title
    __('Welcome to WeSay!', 'wesay_plugin'),
    // Callback for an optional description
    'wesay_plugin_settings_section_callback',
    // Admin page to add section to
    'wesay_plugin'
  );

  // Define (at least) one section for our fields
  add_settings_section(
    // Unique identifier for the section
    'wesay_plugin_settings_configuration_section',
    // Section Title
    __('Customization', 'wesay_plugin'),
    // Callback for an optional description
    'wesay_plugin_settings_configuration_section_callback',
    // Admin page to add section to
    'wesay_plugin'
  );

  add_settings_field(
    // Unique identifier for field
    'wesay_plugin_settings_token',
    // Field Title
    __('Api key', 'wesay_plugin'),
    // Callback for field markup
    'wesay_plugin_settings_token_callback',
    // Page to go on
    'wesay_plugin',
    // Section to go in
    'wesay_plugin_settings_section'
  );

  wesay_add_settings_field('token', 'Api key', 'text', '');

  add_settings_field(
    'wesay_plugin_rating_badge_location_settings', // id
    'Product page- rating badge location', // title
    'wesay_plugin_rating_badge_location_settings_callback', // callback
    'wesay_plugin', // page
    'wesay_plugin_settings_section' // section
);

  register_setting(
    'wesay_plugin_settings',
    'wesay_plugin_settings'
  );

}
add_action('admin_init', 'wesay_plugin_settings');


function wesay_plugin_rating_badge_location_settings_callback() {
  $options = get_option('wesay_plugin_settings');

  ?> 
  
  <select name="wesay_plugin_settings[wesay_plugin_rating_badge_location_settings]" id="wesay_plugin_settings[wesay_plugin_rating_badge_location_settings]">
           <?php $selected = (isset( $options['wesay_plugin_rating_badge_location_settings'] ) && $options['wesay_plugin_rating_badge_location_settings'] === 'none') ? 'selected' : '' ; ?>
            <option value="none" <?php echo $selected; ?>>None</option>
            <?php $selected = (isset( $options['wesay_plugin_rating_badge_location_settings'] ) && $options['wesay_plugin_rating_badge_location_settings'] === 'before_add_to_cart') ? 'selected' : '' ; ?>
            <option value="before_add_to_cart" <?php echo $selected; ?>>Before Add to cart</option>
            <?php $selected = (isset($options['wesay_plugin_rating_badge_location_settings'] ) && $options['wesay_plugin_rating_badge_location_settings'] === 'after_add_to_cart') ? 'selected' : '' ; ?>
            <option value="after_add_to_cart" <?php echo $selected; ?>>After Add to cart</option>
            <?php $selected = (isset( $options['wesay_plugin_rating_badge_location_settings'] ) && $options['wesay_plugin_rating_badge_location_settings'] === 'product_summary') ? 'selected' : '' ; ?>
            <option value="product_summary" <?php echo $selected; ?>>Product Summary</option>
            <?php $selected = (isset( $options['wesay_plugin_rating_badge_location_settings'] ) && $options['wesay_plugin_rating_badge_location_settings'] === 'after_product_description') ? 'selected' : '' ; ?>
            <option value="after_product_description" <?php echo $selected; ?>>After Description</option>
        </select> <?php

}
function wesay_plugin_settings_section_callback()
{
?>
  <ul class="ws_list">
    <li>To learn more about the WeSay ecosystem visit <a href="https://business.wesay.life" target="_blank">https://business.wesay.life</a>.</li>
    <li>To login/register: <a href="https://console.wesay.life" target="_blank">https://console.wesay.life</a>.</li>
    <li>"How to" articles, find here: <a href="https://help.wesay.life" target="_blank">https://help.wesay.life</a>.</li>
  </ul>
<?php
}

function wesay_plugin_settings_configuration_section_callback()
{
?>
  <a href="https://console.wesay.life/app/ugc/displays/reviews-widget" target="_blank">Widget Customization</a>
<?php
}
function wesay_plugin_settings_text_callback($args)
{
  $options = get_option('wesay_plugin_settings');
  $option_name = $args[0];
  $subtitle = $args[1];

  $value = '';

  if (isset($options[$option_name])) {
    $value = $options[$option_name];
  }

  $input = '<input type="text" name="wesay_plugin_settings[' . $option_name . ']" value="' . $value . '" />';

  if (isset($subtitle)) {
    $input .= '<span> ' . $subtitle . '</span>';
  }

  echo $input;
}

function wesay_plugin_settings_checkbox_callback($args)
{
  $options = get_option('wesay_plugin_settings');
  $option_name = $args[0];
  $checked = '';

  if (isset($options[$option_name])) {
    $checked = 'checked';
  }

  echo '<input type="checkbox" name="wesay_plugin_settings[' . $option_name . ']" ' . $checked . ' ">';
}
