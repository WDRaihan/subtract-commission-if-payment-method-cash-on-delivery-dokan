```php
<?php
add_filter( 'dokan_prepare_for_calculation', 'wd_dokan_prepare_for_calculation', 10, 6 );
function wd_dokan_prepare_for_calculation($earning, $commission_rate, $commission_type, $additional_fee, $product_price, $order_id){
	$order = wc_get_order($order_id);
	$payment_method = $order->get_payment_method();
	
	$product_authors = get_product_author_id_by_order_id($order_id);

	$subtract_cod_payment = get_user_meta($product_authors[0], 'subtract_cod_payment', true);
	
	if($payment_method == 'cod' && $subtract_cod_payment != 'off'){
		return $earning - $product_price;
	}else{
		return $earning;
	}
	
}

function get_product_author_id_by_order_id($order_id) {
    $order = wc_get_order($order_id);

    if (!$order) {
        return 'Order not found';
    }

    $author_id = array();

    // Loop through the order items (products)
    foreach ($order->get_items() as $item_id => $item) {
        $product_id = $item->get_product_id();
        // Get the product's post object
        $product = wc_get_product($product_id);

        if ($product) {
            // Get the post author's user ID
            $author_id[] = $product->get_post_data()->post_author;
        }
    }

    return array_unique($author_id);
}

add_action('wp_footer', function(){
	
});

```
