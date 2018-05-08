<?php
$this->services  = include( __DIR__ .'/../data-wf-service-codes.php' );
$this->custom_services = $this->settings['services'];
?>
<tr valign="top" id="service_options">
	<td class="titledesc" colspan="2" style="padding-left:0px"><br><br>
		<table class="fedex_services widefat">
			<thead>
				<th class="sort">&nbsp;</th>
				<th><?php _e( 'Service Code', 'wf-shipping-fedex' ); ?></th>
				<th><?php _e( 'Name', 'wf-shipping-fedex' ); ?></th>
				<th><?php _e( 'Enabled', 'wf-shipping-fedex' ); ?></th>
				<th><?php echo sprintf( __( 'Price Adjustment (%s)', 'wf-shipping-fedex' ), get_woocommerce_currency_symbol() ); ?></th>
				<th><?php _e( 'Price Adjustment (%)', 'wf-shipping-fedex' ); ?></th>
			</thead>
			<tbody>
				<?php
					$sort = 0;
					$this->ordered_services = array();

					foreach ( $this->services as $code => $name ) {

						if ( isset( $this->custom_services[ $code ]['order'] ) ) {
							$sort = $this->custom_services[ $code ]['order'];
						}

						while ( isset( $this->ordered_services[ $sort ] ) )
							$sort++;

						$this->ordered_services[ $sort ] = array( $code, $name );

						$sort++;
					}

					ksort( $this->ordered_services );

					foreach ( $this->ordered_services as $value ) {
						$code = $value[0];
						$name = $value[1];
						?>
						<tr>
							<td class="sort"><input type="hidden" class="order" name="fedex_service[<?php echo $code; ?>][order]" value="<?php echo isset( $this->custom_services[ $code ]['order'] ) ? $this->custom_services[ $code ]['order'] : ''; ?>" /></td>
							<td><strong><?php echo $code; ?></strong></td>
							<td><input type="text" name="fedex_service[<?php echo $code; ?>][name]" placeholder="<?php echo $name; ?>" value="<?php echo isset( $this->custom_services[ $code ]['name'] ) ? $this->custom_services[ $code ]['name'] : ''; ?>" size="50" /></td>
							<td><input type="checkbox" name="fedex_service[<?php echo $code; ?>][enabled]" <?php checked( ( ! isset( $this->custom_services[ $code ]['enabled'] ) || ! empty( $this->custom_services[ $code ]['enabled'] ) ), true ); ?> /></td>
							<td><input type="text" name="fedex_service[<?php echo $code; ?>][adjustment]" placeholder="N/A" value="<?php echo isset( $this->custom_services[ $code ]['adjustment'] ) ? $this->custom_services[ $code ]['adjustment'] : ''; ?>" size="4" /></td>
							<td><input type="text" name="fedex_service[<?php echo $code; ?>][adjustment_percent]" placeholder="N/A" value="<?php echo isset( $this->custom_services[ $code ]['adjustment_percent'] ) ? $this->custom_services[ $code ]['adjustment_percent'] : ''; ?>" size="4" /></td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>
	</td>
</tr>

<script type="text/javascript">

	jQuery(window).load(function(){
		// Ordering
		jQuery('.fedex_services').sortable({
			items:'tr',
			cursor:'move',
			axis:'y',
			handle: '.sort',
			scrollSensitivity:40,
			forcePlaceholderSize: true,
			helper: 'clone',
			opacity: 0.65,
			placeholder: 'wc-metabox-sortable-placeholder',
			start:function(event,ui){
				ui.item.css('baclbsround-color','#f6f6f6');
			},
			stop:function(event,ui){
				ui.item.removeAttr('style');
				fedex_services_row_indexes();
			}
		});

	function fedex_services_row_indexes() {
		jQuery('.fedex_services tbody tr').each(function(index, el){
			jQuery('input.order', el).val( parseInt( jQuery(el).index('.fedex_services tr') ) );
		});
	};
});
	
</script>