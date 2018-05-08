<?php
$buffer = ob_get_contents(); 

ob_get_clean();
ob_start();

$buffer = str_replace('<h1>',"<h1 $h1style>", $buffer);
$buffer = str_replace('<h2>',"<br><h2 $h2style>", $buffer);
$buffer = str_replace('<h3>',"<br><h3 $h3style>", $buffer);
$buffer = str_replace('<p>',"<p $pstyle>", $buffer);
$buffer = str_replace('<li>',"<li $listyle>", $buffer);
$buffer = str_replace('class="link"', $h2style, $buffer);

// Order number.
if( isset($order) && $order->get_order_number() )
$buffer = str_replace('{order_number}',$order->get_order_number(), $buffer);


// Order date.

if( version_compare( WC_VERSION, '3.0', '>' ) ){

if( isset($order) && function_exists('wc_date_format') )
$buffer = str_replace('{order_date}', date_i18n( wc_date_format(), strtotime( $order->get_date_created() ) ), $buffer );

}else{

if( isset($order) && function_exists('wc_date_format') )
$buffer = str_replace('{order_date}', date_i18n( wc_date_format(), strtotime( $order->order_date ) ), $buffer );

}

// Site name.
$buffer = str_replace('{site-title}',wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ), $buffer );
$buffer = str_replace('{blogname}',wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ), $buffer );

// Magic Properties.

if( version_compare( WC_VERSION, '3.0', '>' ) ){

	preg_match_all('/\{\{(.*)\}\}/Uis', $buffer, $mps );

	if(is_array($mps) && !empty($mps[1]) ) :
		
		foreach ($mps[1] as $mp) {

			$fn = 'get_' . trim($mp);

			if( isset($order) && method_exists( $order, $fn ) )
				$buffer = str_replace('{{'.$mp.'}}', $order->$fn(), $buffer );
		}

	endif;

}else{

	$mps = array('id','billing_address_1', 'billing_address_2', 'billing_city', 'billing_company', 'billing_country', 'billing_email', 'billing_first_name', 'billing_last_name', 'billing_phone', 'billing_postcode', 'billing_state', 'cart_discount', 'cart_discount_tax', 'customer_ip_address', 'customer_user', 'customer_user_agent', 'order_currency', 'order_discount', 'order_key', 'order_shipping', 'order_shipping_tax', 'order_tax', 'order_total', 'payment_method', 'payment_method_title', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_company', 'shipping_country', 'shipping_first_name', 'shipping_last_name', 'shipping_method_title', 'shipping_postcode', 'shipping_state');

	foreach ($mps as $mp) {
		if( isset($order) && isset($order->$mp) )
			$buffer = str_replace('{{'.$mp.'}}', $order->$mp, $buffer );
	}

}


echo apply_filters('woocommerce_email_mbc_email_html_filter', $buffer );