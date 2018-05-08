<?php
/**
 * Email Addresses
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


?>
<table cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top;" border="0">

	<tr>

		<td valign="top" width="50%">

			<h3><?php _e( 'Billing address', 'woocommerce' ); ?></h3>

			<p><?php echo $order->get_formatted_billing_address(); ?></p>
			
			<?php if( method_exists($order, 'get_billing_phone') ) : ?>

			<?php if ( $order->get_billing_phone() )  ?>
					<p><?php echo esc_html( $order->get_billing_phone() ); ?></p>

			<?php endif; ?>

			<?php if( method_exists($order, 'get_billing_email') ) : ?>

			<?php if ( $order->get_billing_email() ) ?>
					<p><?php echo esc_html( $order->get_billing_email() ); ?></p>

			<?php endif; ?>

		</td>

		<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && ( $shipping = $order->get_formatted_shipping_address() ) ) : ?>

		<td valign="top" width="50%">

			<h3><?php _e( 'Shipping address', 'woocommerce' ); ?></h3>

			<p><?php echo $shipping; ?></p>

		</td>

		<?php endif; ?>

	</tr>

</table>
