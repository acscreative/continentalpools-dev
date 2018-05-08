<?php 
global $woocommerce;
$pickup_start_time_options	=	array();
foreach(range(8,18,0.5) as $pickup_start_time){ // Pickup ready time must contain a time between 08:00am and 06:00pm
	$pickup_start_time_options[(string)$pickup_start_time]	=	date("H:i",strtotime(date('Y-m-d'))+3600*$pickup_start_time);
}

$pickup_close_time_options	=	array();
foreach(range(8.5,24,0.5) as $pickup_close_time){ // Pickup ready time must contain a time between 08:00am and 06:00pm
	$pickup_close_time_options[(string)$pickup_close_time]	=	date("H:i",strtotime(date('Y-m-d'))+3600*$pickup_close_time);
}
?>
<table>
	<tr valign="top" ">
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Show/Hide','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<fieldset style="padding:3px;"><?php 
				$checked 		= ( isset($this->settings['pickup_enabled']) && $this->settings['pickup_enabled'] ==='yes' ) ? 'checked' : '';
				$label 			= __('Enable Pickup', 'wf-shipping-fedex' );
				$description 	= __('Enable this to setup pickup request', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'pickup_enabled', $checked, $label, $description );?>
			</fieldset>
			
			<fieldset style="padding:3px;"><?php 
				$checked 		= ( isset($this->settings['use_pickup_address']) && $this->settings['use_pickup_address'] ==='yes') ? 'checked' : '';
				$label 			= __('Use Different Pickup Address', 'wf-shipping-fedex' );
				$description 	= __('Check this to set a defferent store address to pick up from', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'use_pickup_address', $checked, $label, $description, 'pickup-field' );?>
			</fieldset>

			<table>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['pickup_contact_name'])) ? $this->settings['pickup_contact_name'] : '';
							$label 			= __( 'Contact Person Name', 'wf-shipping-fedex' );
							$description 	= __( 'Contact person name', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'pickup_contact_name', $value, '', '', '', 'pickup-address-field');?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['pickup_company_name'])) ? $this->settings['pickup_company_name'] : '';
							$label 			= __( 'Pickup Company Name', 'wf-shipping-fedex' );
							$description 	= __( 'Name of the company', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'pickup_company_name', $value, '', '', '', 'pickup-address-field' );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['pickup_phone_number'])) ? $this->settings['pickup_phone_number'] : '';
							$label 			= __( 'Pickup Phone Number', 'wf-shipping-fedex' );
							$description 	= __( 'Contact number', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'pickup_phone_number', $value, '', '', '', 'pickup-address-field' );?>
						</fieldset>
					</td>
					<td>

						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['pickup_address_line'])) ? $this->settings['pickup_address_line'] : '';
							$label 			= __( 'Pickup Address', 'wf-shipping-fedex' );
							$description 	= __( 'Address line', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'pickup_address_line', $value, '', '', '', 'pickup-address-field' );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['pickup_address_city'])) ? $this->settings['pickup_address_city'] : '';
							$label 			= __( 'Pickup City', 'wf-shipping-fedex' );
							$description 	= __( 'City', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'pickup_address_city', $value, '', '', '', 'pickup-address-field' );?>
						</fieldset>

					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['pickup_address_state_code'])) ? $this->settings['pickup_address_state_code'] : '';
							$label 			= __( 'Pickup State Code', 'wf-shipping-fedex' );
							$description 	= __( 'State code. Eg: CA', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'pickup_address_state_code', $value, '', '', '', 'pickup-address-field' );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['pickup_address_postal_code'])) ? $this->settings['pickup_address_postal_code'] : '';
							$label 			= __( 'Pickup Zip Code', 'wf-shipping-fedex' );
							$description 	= __( 'Postal code', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'pickup_address_postal_code', $value, '', '', '', 'pickup-address-field' );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['pickup_address_country_code'])) ? $this->settings['pickup_address_country_code'] : '';
							$label 			= __( 'Pickup Country Code', 'wf-shipping-fedex' );
							$description 	= __( 'Country code Eg: US', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'pickup_address_country_code', $value, '', '', '', 'pickup-address-field' );?>
						</fieldset>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Pickup Start Time','wf-shipping-fedex') ?></label>
		</td>		
		<td>
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['pickup_start_time']) ? $this->settings['pickup_start_time'] : current($pickup_start_time_options);
				$options 		= $pickup_start_time_options;
				$label 			= '';
				$tool_tip 		= __( 'Items will be ready for pickup by this time from shop','wf-shipping-fedex' );
				
				$this->xa_load_input_select( 'pickup_start_time', $selected_value, $options, $label, $tool_tip,'pickup-field' );?>
			</fieldset>
		</td>		
	</tr>
	<tr>
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Company Close Time','wf-shipping-fedex') ?></label>
		</td>		
		<td>
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['pickup_close_time']) ? $this->settings['pickup_close_time'] : '18';
				$options 		= $pickup_close_time_options;
				$label 			= '';
				$tool_tip 		= __( 'Your shop closing time. It must be greater than company open time','wf-shipping-fedex' );
				
				$this->xa_load_input_select( 'pickup_close_time', $selected_value, $options, $label, $tool_tip,'pickup-field' );?>
			</fieldset>
		</td>		
	</tr>
	<tr>
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Pickup Service','wf-shipping-fedex') ?></label>
		</td>		
		<td>
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['pickup_service']) ? $this->settings['pickup_service'] : 'FEDEX_NEXT_DAY_EARLY_MORNING';
				$options 		= array(
					'SAME_DAY'						=>'SAME DAY',
					'SAME_DAY_CITY'					=>'SAME DAY CITY',
					'FEDEX_DISTANCE_DEFERRED'		=>'FEDEX DISTANCE DEFERRED',
					'FEDEX_NEXT_DAY_EARLY_MORNING'	=>'FEDEX NEXT DAY EARLY MORNING',
					'FEDEX_NEXT_DAY_MID_MORNING'	=>'FEDEX NEXT DAY MID MORNING',
					'FEDEX_NEXT_DAY_AFTERNOON'		=>'FEDEX NEXT DAY AFTERNOON',
					'FEDEX_NEXT_DAY_END_OF_DAY'		=>'FEDEX NEXT DAY END OF DAY',
					'FEDEX_NEXT_DAY_FREIGHT'		=>'FEDEX NEXT DAY FREIGHT',
				);
				$label 			= '';
				$tool_tip 		= __( 'Service category for FedEx pickup','wf-shipping-fedex' );
				
				$this->xa_load_input_select( 'pickup_service', $selected_value, $options, $label, $tool_tip,'pickup-field' );?>
			</fieldset>
		</td>		
	</tr>
	
	<tr>
		<td colspan="2" style="text-align:right;padding-right: 10%;">
			<br/>
			<input type="submit" value="<?php _e('Save Changes','wf-shipping-fedex') ?>" class="button button-primary" name="xa_save_fedex_pickup_settings">
			
		</td>
	</tr>
</table>