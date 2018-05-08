<?php
/**
 * Email Order Items
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

include( MBWPE_TPL_PATH.'/settings.php' );


if ( version_compare( WOOCOMMERCE_VERSION, '3.0', '>' ) ) :

$text_align = is_rtl() ? 'right' : 'left';

foreach ( $items as $item_id => $item ) :
	if ( apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
		$product = $item->get_product();
		?>
		<tr>
			<td style="<?php echo $missingstyle;?>text-align:<?php echo is_rtl() ? 'right' : 'left' ?>; vertical-align:middle; border: solid 1px <?php echo $bordercolor;?>; word-wrap:break-word;"><?php

				if($link_product){

					echo '<a href="'.get_permalink( $product->get_id() ).'" style="text-decoration:none;'.$missingstyle.'">';

				}

				// Show title/image etc
				if ( $show_image ) {
					echo apply_filters( 'woocommerce_order_item_thumbnail', '<img src="' . ( $product->get_image_id() ? @current( wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail') ) : wc_placeholder_img_src() ) .'" alt="' . __( 'Product Image', 'woocommerce' ) . '" height="' . esc_attr( $imgsize ) . '" width="' . esc_attr( $imgsize ) . '" style="vertical-align:middle; margin-right: 10px;" />', $item );
				}

				// Product name
				echo apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false );

				if($link_product){

					echo '</a>';

				}

				// SKU
				if ( $show_sku && is_object( $product ) && $product->get_sku() ) {
					echo ' (#' . $product->get_sku() . ')';
				}

				// allow other plugins to add additional product information here
				do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, $plain_text );

				wc_display_item_meta( $item );

				if ( $show_download_links ) {
					wc_display_item_downloads( $item );
				}

				// allow other plugins to add additional product information here
				do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, $plain_text );

			?></td>
			<td align="center" style="<?php echo $missingstyle;?>text-align:center; vertical-align:middle; border: 1px solid <?php echo $bordercolor;?>;"><?php echo apply_filters( 'woocommerce_email_order_item_quantity', $item->get_quantity(), $item ); ?></td>
			<td align="center" style="<?php echo $missingstyle;?>text-align:center; vertical-align:middle; border: 1px solid <?php echo $bordercolor;?>;"><?php echo $order->get_formatted_line_subtotal( $item ); ?></td>
		</tr>
		<?php
	}

	if ( $show_purchase_note && is_object( $product ) && ( $purchase_note = $product->get_purchase_note() ) ) : ?>
		<tr>
			<td colspan="3" style="<?php echo $missingstyle;?>text-align:left; vertical-align:middle; border: 1px solid <?php echo $bordercolor;?>;"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); ?></td>
		</tr>
	<?php endif; ?>

<?php endforeach;

else :

foreach ( $items as $item ) :

	$_product     = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
	
	if ( version_compare( WOOCOMMERCE_VERSION, '2.4', '<' ) ){

	$item_meta    = new WC_Order_Item_Meta( $item['item_meta'], $_product );

	} else {

	$item_meta    = new WC_Order_Item_Meta( $item, $_product );

	}	
	

	?>
	<tr>
		<td style="<?php echo $missingstyle;?>text-align:<?php echo is_rtl() ? 'right' : 'left' ?>; vertical-align:middle; border: solid 1px <?php echo $bordercolor;?>; word-wrap:break-word;"><?php

			if($link_product){

				echo '<a href="'.get_permalink($_product->id).'" style="text-decoration:none;'.$missingstyle.'">';

			}

			// Show title/image etc
			if ( $show_image ) {
				echo apply_filters( 'woocommerce_order_item_thumbnail', '<img src="' . ( $_product->get_image_id() ? @current( wp_get_attachment_image_src( $_product->get_image_id(), 'thumbnail') ) : wc_placeholder_img_src() ) .'" alt="' . __( 'Product Image', 'woocommerce' ) . '" height="' . esc_attr( $imgsize ) . '" width="' . esc_attr( $imgsize ) . '" style="vertical-align:middle; margin-right: 10px;" />', $item );
			}

			// Product name
			echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item );

			if($link_product){

				echo '</a>';

			}

			// SKU
			if ( $show_sku && is_object( $_product ) && $_product->get_sku() ) {
				echo ' (#' . $_product->get_sku() . ')';
			}

			// File URLs
			if ( $show_download_links && is_object( $_product ) && $_product->exists() && $_product->is_downloadable() ) {

				$download_files = $order->get_item_downloads( $item );
				$i              = 0;

				foreach ( $download_files as $download_id => $file ) {
					$i++;

					if ( count( $download_files ) > 1 ) {
						$prefix = sprintf( __( 'Download %d', 'woocommerce' ), $i );
					} elseif ( $i == 1 ) {
						$prefix = __( 'Download', 'woocommerce' );
					}

					echo '<br/><small style="'.$dlstyle.'">' . $prefix . ': <a href="' . esc_url( $file['download_url'] ) . '" target="_blank" style="'.$dlstyle.'">' . esc_html( $file['name'] ) . '</a></small>';
				}
			}

			// Variation
			if ( $item_meta->meta ) {
				echo '<br/><small style="'.$dlstyle.'">' . nl2br( $item_meta->display( true, true, '_', "\n" ) ) . '</small>';
			}

		?></td>
		<td align="center" style="<?php echo $missingstyle;?>text-align:center; vertical-align:middle; border: 1px solid <?php echo $bordercolor;?>;"><?php echo $item['qty'] ;?></td>
		<td align="center" style="<?php echo $missingstyle;?>text-align:center; vertical-align:middle; border: 1px solid <?php echo $bordercolor;?>;"><?php echo $order->get_formatted_line_subtotal( $item ); ?></td>
	</tr>

	<?php if ( $show_purchase_note && is_object( $_product ) && $purchase_note = get_post_meta( $_product->id, '_purchase_note', true ) ) : ?>
		<tr>
			<td colspan="3" style="<?php echo $missingstyle;?>text-align:left; vertical-align:middle; border: 1px solid <?php echo $bordercolor;?>;"><?php echo wpautop( do_shortcode( $purchase_note ) ); ?></td>
		</tr>
	<?php endif; ?>

<?php endforeach;

endif;