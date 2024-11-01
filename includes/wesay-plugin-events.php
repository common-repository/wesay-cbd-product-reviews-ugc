<?php

add_action('woocommerce_thankyou', 'wesay_payment_complete', 10, 1);

function wesay_payment_complete($order_id)
{
    $order = wc_get_order($order_id);
    $_current_user = $order->get_user();
    $items = $order->get_items();

    if ($_current_user) {
    ?>
        <script>
            const checkIfWeSayLoadedPurchase = setInterval(() => {

                if (WeSay) {
                    clearInterval(checkIfWeSayLoadedPurchase);
                    <?php
                    foreach ($items as $item) {
                        $product_id = $item->get_product_id();
                        $_pf = new WC_Product_Factory();
                        $_product = $_pf->get_product($product_id);
                        $_product_name = $_product->get_name();
                        $_product_category_ids = wc_get_product_cat_ids($product_id);
                        $_category = get_the_category_by_ID($_product_category_ids[0]);
                    ?>
                        WeSay.event({
                            event: 'purchase',
                            props: {
                                email: '<?php echo $_current_user->user_email  ?>',
                                fname: '<?php echo $_current_user->first_name  ?>',
                                lname: '<?php echo $_current_user->last_name  ?>',
                                mobile_no: '<?php echo $_current_user->billing_phone  ?>',
                                lang: '<?php echo get_locale() ?>',
                                product_name: '<?php echo $_product_name ?>',
                                product_id: '<?php echo $product_id ?>',
                                category: '<?php echo $_category  ?>',
                            }
                        });
                    <?php
                    }
                    ?>
                }
            }, 100);
        </script>
    <?php

    }
}

add_filter('woocommerce_add_cart_item_data', 'wesay_woo_custom_add_to_cart', 10, 2);

function wesay_woo_custom_add_to_cart($cart_item_data, $productId)
{
    $_pf = new WC_Product_Factory();
    $_product = $_pf->get_product($productId);
    $_product_name = $_product->get_name();
    $_product_category_ids = wc_get_product_cat_ids($productId);
    $_category = get_the_category_by_ID($_product_category_ids[0]);
    $_current_user = wp_get_current_user();
    ?>

    <script type="text/javascript">
        const checkIfWeSayLoadedAddToCart = setInterval(() => {
            if (WeSay) {
                clearInterval(checkIfWeSayLoadedAddToCart);

                WeSay.event({
                    event: 'add_to_cart',
                    props: {
                        email: '<?php echo $_current_user->user_email  ?>',
                        fname: '<?php echo $_current_user->first_name  ?>',
                        lname: '<?php echo $_current_user->last_name  ?>',
                        product_name: '<?php echo $_product_name ?>',
                        product_id: '<?php echo $productId ?>',
                        mobile_no: '<?php echo $_current_user->billing_phone  ?>',
                        category: '<?php echo $_category  ?>',
                        lang: '<?php echo get_locale() ?>',
                    }
                });
            }
        }, 100);
    </script>
<?php

    return $cart_item_data;
}
