<tfoot>
		<?php
			if ( $totals = $order->get_order_item_totals() ) {
				$i = 0;
				foreach ( $totals as $total ) {
					$i++;
					?><tr>
						<th width="75%" style="<?php echo $missingstyle;?>text-align: <?php echo is_rtl() ? 'right' : 'left' ?>; border: 1px solid <?php echo $bordercolor;?>; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>" scope="row" colspan="2"><?php echo $total['label']; ?></th>
						<td width="25%" style="<?php echo $missingstyle;?>text-align: <?php echo is_rtl() ? 'right' : 'left' ?>; border: 1px solid <?php echo $bordercolor;?>; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['value']; ?></td>
					</tr><?php
				}
			}

			if ( method_exists($order, 'get_customer_note' ) && $order->get_customer_note() ) {
				?><tr>
					<td colspan="3" width="100%" style="<?php echo $missingstyle;?>text-align: <?php echo is_rtl() ? 'right' : 'left' ?>; border: 1px solid <?php echo $bordercolor;?>; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>" scope="row" colspan="2"><?php _e( 'Note:', 'woocommerce' ); ?> <?php echo wptexturize( $order->get_customer_note() ) ; ?></td>
				</tr><?php
			}
		?>
</tfoot>