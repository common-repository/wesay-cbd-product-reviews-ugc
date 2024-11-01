<?php

/**
 * @copyright 2020 WeSay.life
 * @package WeSay
 * @author Ori Diamant
 * @license GPLv2 or later
 * 
 * Plugin Name: WeSay CBD Product Reviews UGC
 * Plugin URI: https://business.wesay.life/
 * Description: Collect and manage product reviews to boost your revenue
 * Version: 1.1.4
 * Author: WeSay
 * Author URI: https://business.wesay.life
 * Plugin URI: https://business.wesay.life
 * Requires at least: 3.0
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('WPINC')) {
    die;
}

define('WESAY_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WESAY_PLUGIN_DIR', plugin_dir_path(__FILE__));

include(plugin_dir_path(__FILE__) . 'includes/wesay-plugin-menus.php');
include(plugin_dir_path(__FILE__) . 'includes/wesay-plugin-scripts.php');
include(plugin_dir_path(__FILE__) . 'includes/wesay-plugin-styles.php');
include(plugin_dir_path(__FILE__) . 'includes/wesay-plugin-front-ui.php');
include(plugin_dir_path(__FILE__) . 'includes/wesay-plugin-settings-fields.php');
include(plugin_dir_path(__FILE__) . 'includes/wesay-plugin-events.php');

/**
 * Disable reviews.
 */
function wesay_disable_reviews()
{
    remove_post_type_support('product', 'comments');
}

add_action('init', 'wesay_disable_reviews');

// Add a link to settings page
function wesay_plugin_add_settings_link($links)
{
    $settings_link = '<a href="admin.php?page=wesay-plugin">' . __('Settings', 'wesay-plugin') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

$filter_name = "plugin_action_links_" . plugin_basename(__FILE__);
add_filter($filter_name, 'wesay_plugin_add_settings_link');

function wesay_display_message($messages = array(), $is_error = false)
{
    $class = $is_error ? 'error' : 'updated fade';
    if (is_array($messages)) {
        foreach ($messages as $message) {
            echo "<div id='message' class='$class'><p><strong>$message</strong></p></div>";
        }
    } elseif (is_string($messages)) {
        echo "<div id='message' class='$class'><p><strong>$messages <a href='https://console.wesay.life/app/ugc/displays/reviews-widget' target='_blank'>WeSay UGC Platform</a></strong></p></div>";
    }
}
