add_action( 'woocommerce_review_order_before_submit','wc_check_taxes', 10 ); 
function wc_check_taxes() { 
    global $woocommerce; 

    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) 
    return;
	
	
	$bWarm = false;
    foreach ( $woocommerce->cart->get_cart() as $cart_item ) {
   		$item_name = $cart_item['data']->get_title();
		/* echo $item_name . '<br>'; */
		
		// if simple or variable product, this should now work 
		$the_product = wc_get_product( $cart_item['product_id'] );
		$catlist = $the_product->get_category_ids();

		// is product delivered warm? 
		if ( in_array(37, $catlist )) {
			$bWarm = true;
			/* echo 'true'; */
		}	
	}
	
	if ( $bWarm ) { /* restaurant delivery */
        $woocommerce->customer->set_is_vat_exempt( false ); 
    }
    else { /* all grocery items */
        $woocommerce->customer->set_is_vat_exempt( true );
    }
}
