<tr valign="top" id="packing_options">
	<td class="titledesc" colspan="2" style="padding-left:0px">
	<strong><?php _e( 'Box Sizes', 'wf_fedEx_wooCommerce_shipping' ); ?></strong><br><br>
		<style type="text/css">
			.fedex_boxes td, .fedex_services td {
                            vertical-align: middle;
                            padding-top: 4px;
                            padding-bottom: 4px;
                            padding-left: 7px;
                            padding-right: 4px;
                            }
			.fedex_services th, .fedex_boxes th {
				padding: 9px 7px;
			}
			.fedex_boxes td input {
				margin-right: 4px;
			}
			.fedex_boxes .check-column {
				vertical-align: middle;
				text-align: left;
				padding: 0 7px;
			}
			.fedex_services th.sort {
				width: 16px;
				padding: 0 16px;
			}
			.fedex_services td.sort {
				cursor: move;
				width: 16px;
				padding: 0 16px;
				cursor: move;
				background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAICAYAAADED76LAAAAHUlEQVQYV2O8f//+fwY8gJGgAny6QXKETRgEVgAAXxAVsa5Xr3QAAAAASUVORK5CYII=) no-repeat center;
			}
		</style>
		<table class="fedex_boxes widefat">
			<thead>
				<tr>
					<th class="check-column"><input type="checkbox" /></th>
					<th><?php _e( 'Name', 'wf_fedEx_wooCommerce_shipping' ); ?></th>
					<th><?php _e( 'Length', 'wf_fedEx_wooCommerce_shipping' ); ?></th>
					<th><?php _e( 'Width', 'wf_fedEx_wooCommerce_shipping' ); ?></th>
					<th><?php _e( 'Height', 'wf_fedEx_wooCommerce_shipping' ); ?></th>
					<th><?php _e( 'Inner Length', 'wf_fedEx_wooCommerce_shipping' ); ?></th>
					<th><?php _e( 'Inner Width', 'wf_fedEx_wooCommerce_shipping' ); ?></th>
					<th><?php _e( 'Inner Height', 'wf_fedEx_wooCommerce_shipping' ); ?></th>
					<th><?php _e( 'Box Weight', 'wf_fedEx_wooCommerce_shipping' ); ?></th>
					<th><?php _e( 'Max Weight', 'wf_fedEx_wooCommerce_shipping' ); ?></th>
					<th><?php _e( 'Enabled', 'wf_fedEx_wooCommerce_shipping' ); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th colspan="3">
						<a href="#" class="button plus insert"><?php _e( 'Add Box', 'wf_fedEx_wooCommerce_shipping' ); ?></a>
						<a href="#" class="button minus remove"><?php _e( 'Remove selected box(es)', 'wf_fedEx_wooCommerce_shipping' ); ?></a>
					</th>
					<th colspan="6">
						<small class="description"><?php _e( 'Items will be packed into these boxes depending based on item dimensions and volume. Dimensions will be passed to FedEx and used for packing. Items not fitting into boxes will be packed individually.', 'wf_fedEx_wooCommerce_shipping' ); ?></small>
					</th>
				</tr>
			</tfoot>
			<tbody id="rates">
				<?php
					if ( $this->default_boxes ) {
						foreach ( $this->default_boxes as $key => $box ) {
							?>
							<tr>
								<td class="check-column"></td>
								<td><input type="text" size="18" readonly value="<?php echo esc_attr( $box['name'] ); ?>" /></td>
								<td><input type="text" size="1" readonly value="<?php echo esc_attr( $box['length'] ); ?>" /><?php echo $this->dimension_unit;?></td>
								<td><input type="text" size="1" readonly value="<?php echo esc_attr( $box['width'] ); ?>" /><?php echo $this->dimension_unit;?></td>
								<td><input type="text" size="1" readonly value="<?php echo esc_attr( $box['height'] ); ?>" /><?php echo $this->dimension_unit;?></td>
								<td><input type="text" size="1" readonly value="<?php echo esc_attr( $box['inner_length'] ); ?>" /><?php echo $this->dimension_unit;?></td>
								<td><input type="text" size="1" readonly value="<?php echo esc_attr( $box['inner_width'] ); ?>" /><?php echo $this->dimension_unit;?></td>
								<td><input type="text" size="1" readonly value="<?php echo esc_attr( $box['inner_height'] ); ?>" /><?php echo $this->dimension_unit;?></td>
								<td><input type="text" size="1" readonly value="<?php echo esc_attr( $box['box_weight'] ); ?>" /><?php echo $this->weight_unit;?></td>
								<td><input type="text" size="1" readonly value="<?php echo esc_attr( $box['max_weight'] ); ?>" /><?php echo $this->weight_unit;?></td>
								<td><input type="checkbox" name="boxes_enabled[<?php echo $box['id']; ?>]" <?php checked( ! isset( $this->settings['boxes'][ $box['id'] ]['enabled'] ) || $this->settings['boxes'][ $box['id'] ]['enabled'] == 1, true ); ?> /></td>
							</tr>
							<?php
						}
					}
					if ( !empty($this->settings['boxes'] ) ) {
						if( isset($this->settings['enable_speciality_box']) && $this->settings['enable_speciality_box'] == true ){
							$this->settings['boxes'] = $this->merge_with_speciality_box($this->settings['boxes']);
						}

						foreach ( $this->settings['boxes'] as $key => $box ) {
							if ( ! is_numeric( $key ) )
								continue;
							if( !$this->settings['enable_speciality_box'] ){
								if( strpos( $box['box_type'], 'speciality_boxes') !== false ){
									continue;
								}
							}
							?>

							<tr>
								<td class="check-column">
									<input type="checkbox" />
									<input type="hidden" name="box_type[]" value="<?php echo !empty($box['box_type']) ? $box['box_type'] : 'defaul_box';?>">
								</td>
                                <td><input type="text" size="18" name="boxes_name[<?php echo $key; ?>]" value="<?php echo esc_attr( $box['name'] ); ?>"/></td>
								<td><input type="text" size="1" name="boxes_length[<?php echo $key; ?>]" value="<?php echo esc_attr( $box['length'] ); ?>" /><?php echo $this->dimension_unit;?></td>
								<td><input type="text" size="1" name="boxes_width[<?php echo $key; ?>]" value="<?php echo esc_attr( $box['width'] ); ?>" /><?php echo $this->dimension_unit;?></td>
								<td><input type="text" size="1" name="boxes_height[<?php echo $key; ?>]" value="<?php echo esc_attr( $box['height'] ); ?>" /><?php echo $this->dimension_unit;?></td>
								
								<td><input type="text" size="1" name="boxes_inner_length[<?php echo $key; ?>]" value="<?php echo esc_attr( $box['inner_length'] ); ?>" /><?php echo $this->dimension_unit;?></td>
								<td><input type="text" size="1" name="boxes_inner_width[<?php echo $key; ?>]" value="<?php echo esc_attr( $box['inner_width'] ); ?>" /><?php echo $this->dimension_unit;?></td>
								<td><input type="text" size="1" name="boxes_inner_height[<?php echo $key; ?>]" value="<?php echo esc_attr( $box['inner_height'] ); ?>" /><?php echo $this->dimension_unit;?></td>
		
								<td><input type="text" size="1" name="boxes_box_weight[<?php echo $key; ?>]" value="<?php echo esc_attr( $box['box_weight'] ); ?>" /><?php echo $this->weight_unit;?></td>
								<td><input type="text" size="1" name="boxes_max_weight[<?php echo $key; ?>]" value="<?php echo esc_attr( $box['max_weight'] ); ?>" /><?php echo $this->weight_unit;?></td>
								<td><input type="checkbox" name="boxes_enabled[<?php echo $key; ?>]" <?php if( isset($box['enabled']) ) checked( $box['enabled'], true ); ?> /></td>
							</tr>
							<?php
						}
					}
				?>
			</tbody>
		</table>
		<fieldset style="padding:3px;" class="box-packing"><?php 
			$checked 		=  ( isset($this->settings['enable_speciality_box']) && $this->settings['enable_speciality_box'] ==='yes' )  ? 'checked' : '';
			$label 			= __('Include Speciality boxes', 'wf-shipping-fedex' );
			$description 	= __('Check this to load Speciality boxes with boxes.', 'wf-shipping-fedex' );
			$this->xa_load_input_checkbox( 'enable_speciality_box', $checked, $label, $description );?>						
		</fieldset>
	</td>
</tr>


<script type="text/javascript">

	jQuery(window).load(function(){

		jQuery('.fedex_boxes .insert').click( function() {
			var $tbody = jQuery('.fedex_boxes').find('tbody');
			var size = $tbody.find('tr').size();
			var code = '<tr class="new">\
					<td><input type="checkbox"/></td>\
					<td><input type="text" size="18" name="boxes_name[' + size +']" /></td>\
					<td><input type="text" size="1" name="boxes_length[' + size + ']" />in</td>\
					<td><input type="text" size="1" name="boxes_width[' + size + ']" />in</td>\
					<td><input type="text" size="1" name="boxes_height[' + size + ']" />in</td>\
					<td><input type="text" size="1" name="boxes_inner_length[' + size + ']" />in</td>\
					<td><input type="text" size="1" name="boxes_inner_width[' + size + ']" />in</td>\
					<td><input type="text" size="1" name="boxes_inner_height[' + size + ']" />in</td>\
					<td><input type="text" size="1" name="boxes_box_weight[' + size + ']" />lbs</td>\
					<td><input type="text" size="1" name="boxes_max_weight[' + size + ']" />lbs</td>\
					<td><input type="checkbox" name="boxes_enabled[' + size + ']" /></td>\
				</tr>';

			$tbody.append( code );

			return false;
		} );

		jQuery('.fedex_boxes .remove').click(function() {
			var $tbody = jQuery('.fedex_boxes').find('tbody');

			$tbody.find('.check-column input:checked').each(function() {
				jQuery(this).closest('tr').hide().find('input').val('');
			});

			return false;
		});

	});

</script>