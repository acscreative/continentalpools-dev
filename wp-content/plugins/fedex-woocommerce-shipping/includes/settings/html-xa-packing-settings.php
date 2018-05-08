<table>
	<tr valign="top" ">
		<td style="width:35%;font-weight:800;">
			<label for=""><?php _e('Packing Options','wf-shipping-fedex') ?></label>
		</td><td scope="row" class="titledesc" style="display: block;width:100%;margin-bottom: 20px;margin-top: 3px;">
			<fieldset style="padding:3px;"><?php
				$value 	= isset($this->settings['dimension_weight_unit']) ? $this->settings['dimension_weight_unit'] : '';
				$options = array( 
					'LBS_IN'	=> __( 'Pounds & Inches', 			'wf-shipping-fedex'),
					'KG_CM' 	=> __( 'Kilograms & Centimeters', 	'wf-shipping-fedex')
				);
				$this->xa_load_input_radio( 'dimension_weight_unit', $value, $options ); ?>
			</fieldset>
			
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['packing_method']) ? $this->settings['packing_method'] : '';
				$options 		= array(
					'per_item'		=> __( 'Pack items individually', 'wf-shipping-fedex' ),
					'box_packing'	=> __( 'Recommended: Pack into boxes with weights and dimensions', 'wf-shipping-fedex' ),
					'weight_based'	=> __( 'Weight based: Calculate shipping based on weight', 'wf-shipping-fedex' ),
				);
				$label 			= __( 'Print Label Size', 'wf-shipping-fedex' );
				$tool_tip 		= __( 'Select here the label size to be generated','wf-shipping-fedex' );
				
				$this->xa_load_input_select( 'packing_method', $selected_value, $options, $label, $tool_tip );?>
			</fieldset>

			<!-- Weight based -->
			<fieldset style="padding:3px;" class="weight-based"><?php
				$value 			= (isset($this->settings['box_max_weight'])) ? $this->settings['box_max_weight'] : '';
				$label 			= __( 'Max Package Weight', 'wf-shipping-fedex' );
				$description 	= __( 'Maximum weight allowed for single box.', 'wf-shipping-fedex' );
				$this->xa_load_input_field( 'text', 'box_max_weight', $value, $label, $description );?>
			</fieldset>
			
			<fieldset style="padding:3px;" class="weight-based"><?php
				$value 	= isset($this->settings['weight_pack_process']) ? $this->settings['weight_pack_process'] : 'pack_descending';
				$options = array( 
					'pack_descending'		=> __( 'Pack heavier items first', 'wf-shipping-fedex' ),
					'pack_ascending'		=> __( 'Pack lighter items first.', 'wf-shipping-fedex' ),
					'pack_simple'			=> __( 'Pack purely divided by weight.', 'wf-shipping-fedex' ),
				);
				$this->xa_load_input_radio( 'weight_pack_process', $value, $options ); ?>
			</fieldset>
		</td>
	</tr>
	
	<tr>
		<td colspan="2">
			<fieldset style="padding:3px;" class="box-packing"><?php
				ob_start();
				include( 'html-wf-box-packing.php' );
				echo ob_get_clean();?>
			</fieldset>
		</td>
	</tr>

	<tr>
		<td colspan="2" style="text-align:right;">
			<button type="submit" class="button button-primary" name="xa_save_fedex_packing_settings"> <?php _e('Save Changes','wf-shipping-fedex') ?> </button>
		</td>
	</tr>
</table>