<?php

function wesay_plugin_reviews_markup()
{
    global $product;
    $product_id = $product->get_id();
    $product_name = $product->get_name();
    $product_url = get_permalink($product->get_id());
    $image_url = wp_get_attachment_image_url($product->get_image_id(), 'full');
    $options = get_option('wesay_plugin_settings');

    $token = '';
    if (isset($options['token'])) {
        $token = esc_html($options['token']);

        if ($token != '') {
?>
            <script type="text/javascript">
                WeSay.init('<?php echo $token ?>');
                WeSay.reviews({
                    productId: '<?php echo $product_id ?>',
                    productName: '<?php echo $product_name ?>',
                    productUrl: '<?php echo $product_url ?>',
                    productImageUrl: '<?php echo $image_url ?>',
                });
            </script>
            <div id="WeSayReviews"></div>
    <?php
        }
    }
    ?>
    <?php
}

$options = get_option('wesay_plugin_settings');

$ratingBadgeLocationSettings = $options['wesay_plugin_rating_badge_location_settings'];


add_action('woocommerce_after_single_product',  'wesay_plugin_reviews_markup');

if ($ratingBadgeLocationSettings === "before_add_to_cart") {
    add_action('woocommerce_before_add_to_cart_button',  'wesay_plugin_reviews_rating_badge');
}

if ($ratingBadgeLocationSettings === "after_add_to_cart") {
    add_action('woocommerce_after_add_to_cart_button',  'wesay_plugin_reviews_rating_badge');
}

if ($ratingBadgeLocationSettings === "product_summary") {
    add_action('woocommerce_single_product_summary',  'wesay_plugin_reviews_rating_badge');
}

if ($ratingBadgeLocationSettings === "after_product_description") {
    add_action('woocommerce_before_add_to_cart_form',  'wesay_plugin_reviews_rating_badge');
}

add_shortcode( 'wesay_life', function( $atts = array(), $content = null, $tag = ''){
    ob_start();
    ?>
        <div id="WeSayReviewsShort"></div>
        <script>
            jQuery(function($){
                jQuery("#WeSayReviews").appendTo("#WeSayReviewsShort");
            });
        </script> 
    <?php
    return ob_get_clean();
});

function wesay_plugin_reviews_rating_badge() {
    global $product;
    $product_id = $product->get_id();
    $options = get_option('wesay_plugin_settings');

    $token = '';
    if (isset($options['token'])) {
        $token = esc_html($options['token']);

        if ($token != '') {
?>
            <script type="text/javascript">
                WeSay.productRating({
        productId: '<?php echo $product_id ?>',
    });
            </script>
            <div id="WeSayProductRating"></div>
    <?php
        }
    }
    ?>
    <?php
}