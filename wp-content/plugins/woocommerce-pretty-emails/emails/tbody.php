<?php 

if ( version_compare( WOOCOMMERCE_VERSION, '2.5', '<' ) ){

echo $order->email_order_items_table( $order->is_download_permitted(), $displaysku, $order->has_status( array( 'processing', 'completed' ) ), $displayimage, array($imgsize, $imgsize) ); 

}

else if ( version_compare( WOOCOMMERCE_VERSION, '3.0', '<' ) ) {

echo $order->email_order_items_table( array(
			'show_sku'    => $displaysku,
			'show_image'  => $displayimage,
			'$image_size' => array($imgsize, $imgsize),
			'sent_to_admin' => $sent_to_admin,
			'plain_text'  => false
		
));

}
else{

	echo wc_get_email_order_items( $order, array(

			'show_sku'    => $displaysku,
			'show_image'  => $displayimage,
			'$image_size' => array($imgsize, $imgsize),
			'sent_to_admin' => $sent_to_admin,
			'plain_text'  => false
		
	));

}

?>
