<?php
$validation = get_option('xa_fedex_shipping_validation_data');
$smartpost_hubs  = include( __DIR__ .'/../data-wf-smartpost-hubs.php' );
$smartpost_hubs  = array_merge( array( '' => __( 'N/A', 'wf-shipping-fedex' ) ), $smartpost_hubs );
$success_mark 	 =  ($validation === 'done') ? '<span style="vertical-align: bottom;color:green" class="dashicons dashicons-yes"></span>' : '';

?>
<table>
	<tr valign="top">
		<td style="width:40%;font-weight:800;">
			<label for="production"><?php _e('FedEx Account Information','wf-shipping-fedex') ?> </label> <span class="woocommerce-help-tip" data-tip="<?php _e('','wf-shipping-fedex') ?>"></span>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<fieldset style="padding:3px;">
				<?php
				$name  		= 'production';
				$value 		= isset($this->settings['production']) ? $this->settings['production'] : '';
				$disabled 	= ($validation === 'done') ? true : '';
				$labels 	= array( 
					'no' 		=> __('Test Mode','wf-shipping-fedex'),
					'yes' 		=> __('Live Mode','wf-shipping-fedex')
				);
				$this->xa_load_input_radio($name, $value, $labels, '', $disabled)?>
				<br>
			</fieldset>
			<fieldset style="padding:3px;"><?php
				$value 			= (isset($this->settings['account_number'])) ? $this->settings['account_number'] : '510087127';
				$label 			= $success_mark.__( 'FedEx Account Number', 'wf-shipping-fedex' );
				$description 	= '';
				$disabled 		= ($validation === 'done') ? true : '';
				$this->xa_load_input_field( 'text', 'account_number', $value, $label, $description, '510087127', '', $disabled );?>
			</fieldset>
			<fieldset style="padding:3px;"><?php 
				$value 			= (isset($this->settings['meter_number'])) ? $this->settings['meter_number'] : '118675423';
				$label 			= $success_mark.__( 'Fedex Meter Number', 'wf-shipping-fedex' );
				$description 	= '';
				$disabled 		= ($validation === 'done') ? true : '';
				$this->xa_load_input_field( 'text', 'meter_number', $value, $label, $description, '118675423', '', $disabled );?>
			</fieldset>
			<fieldset style="padding:3px;"><?php 
				$value 			= (isset($this->settings['api_key'])) ? $this->settings['api_key'] : 'q8ncE6XYWCf4kPNx';
				$label 			= $success_mark.__( 'Fedex Web Services Key', 'wf-shipping-fedex' );
				$description 	= '';
				$disabled 		= ($validation === 'done') ? true : '';
				$this->xa_load_input_field( 'password', 'api_key', $value, $label, $description, '118675423', '', $disabled );?>
			</fieldset>
			<fieldset style="padding:3px;"><?php 
				$value 			= (isset($this->settings['api_pass'])) ? $this->settings['api_pass'] : 'WwVzOMiam84RYDrn98nZL5Wo3';
				$label 			= $success_mark.__( 'Web Services Password', 'wf-shipping-fedex' );
				$description 	= '';
				$disabled 		= ($validation === 'done') ? true : '';
				$this->xa_load_input_field( 'password', 'api_pass', $value, $label, $description, 'WwVzOMiam84RYDrn98nZL5Wo3', '', $disabled );?>
			</fieldset>
			<?php echo get_option('xa_fedex_validation_error'); ?>
			<fieldset style="padding:3px;">
				<?php
				if($validation === 'done'){
					echo '<input type="submit" value="Edit Credentials" class="button button-secondary" name="xa_fedex_validate_credentials_edit" >';
				}else{
					echo '<input type="submit" value=" Validate Credentials" class="button button-secondary" name="xa_fedex_validate_credentials" >';
				}?>
			</fieldset>
		</td>
	</tr>
	<tr valign="top">
		<td style="width:40%;font-weight:800;">
			<label for="rates"><?php _e('Enable/Disable','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<fieldset style="padding:3px;"><?php 
				$checked 		= (!isset($this->settings['enabled']) || isset($this->settings['enabled']) && $this->settings['enabled'] ==='yes') ? 'checked' : '';
				$label 			= __('Enable Real time Rates', 'wf-shipping-fedex' );
				$description 	= __('Enable this to fetch the rates in cart/checkout page.', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'rates', $checked, $label, $description );?>
			</fieldset>

			<fieldset style="padding:3px;"><?php 
				$checked 		= ( !isset($this->settings['insure_contents']) || isset( $this->settings['insure_contents'] ) && $this->settings['insure_contents'] === 'yes' ) ? 'checked' : '';
				$label 			= __('Enable Insurance', 'wf-shipping-fedex' );
				$description 	= __('Enable this to insure your products. The insured value will be the total cart value.', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'insure_contents', $checked, $label, $description );?>
				
			</fieldset>

			<fieldset style="padding:3px;"><?php 
				$checked 		= ( !isset($this->settings['debug']) || isset( $this->settings['debug'] ) && $this->settings['debug'] === 'yes' ) ? 'checked' : '';
				$label 			= __('Enable Developer Mode', 'wf-shipping-fedex' );
				$description 	= __('Enable this option to troubleshoot the plugin. On enabling this, request and response information will be shown in the cart/checkout page.', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'debug', $checked, $label, $description );?>
			</fieldset>

			<fieldset style="padding:3px;"><?php 
				$checked 		= ( !isset($this->settings['residential']) || isset( $this->settings['residential'] ) && $this->settings['residential'] === 'yes' ) ? 'checked' : '';
				$label 			= __('Default to residential delivery', 'wf-shipping-fedex' );
				$description 	= __('Enables residential flag. If you account has Address Validation enabled, this will be turned off/on automatically', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'residential', $checked, $label, $description );?>
			</fieldset>

			<fieldset style="padding:3px;"><?php 
				$checked 		= ( !isset($this->settings['exclude_tax']) || isset( $this->settings['exclude_tax'] ) && $this->settings['exclude_tax'] === 'yes' ) ? 'checked' : '';
				$label 			= __('Exclude Product Tax', 'wf-shipping-fedex' );
				$description 	= __('Taxes will be excluded from product prices while generating label', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'exclude_tax', $checked, $label, $description );?>
			</fieldset>

			<fieldset style="padding:3px;"><?php 
				$checked 		= ( !isset($this->settings['dry_ice_enabled']) || isset( $this->settings['dry_ice_enabled'] ) && $this->settings['dry_ice_enabled'] === 'yes' ) ? 'checked' : '';
				$label 			= __('Ship dry ice', 'wf-shipping-fedex' );
				$description 	= __('Enable this to activate dry ice option to product level', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'dry_ice_enabled', $checked, $label, $description );?>
			</fieldset>
		</td>
	</tr>
	<tr valign="top">
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Dimension/Weight Unit','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<fieldset style="padding:3px;"><?php
				$name 			= 'dimension_weight_unit';
				$selected_value = isset($this->settings['dimension_weight_unit']) ? $this->settings['dimension_weight_unit'] : '';
				$options 		= array(
					'LBS_IN'		=> __( 'Pounds & Inches', 'wf-shipping-fedex'),
					'KG_CM' 		=> __( 'Kilograms & Centimeters', 'wf-shipping-fedex'),	
				);
				$label 			= '';
				$tool_tip 		= __( 'Product dimensions and weight will be converted to the selected unit and will be passed to FedEx.','wf-shipping-fedex' );
				
				$this->xa_load_input_select( $name, $selected_value, $options, $label, $tool_tip );?>
			</fieldset>
		</td>
	</tr>
	<tr valign="top">
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Indicia','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<fieldset style="padding:3px;"><?php
				$name 			= 'indicia';
				$selected_value = isset($this->settings['indicia']) ? $this->settings['indicia'] : '';
				$options 		= array(
					'MEDIA_MAIL'		 => __( 'MEDIA MAIL', 'wf-shipping-fedex' ),
					'PARCEL_RETURN'	=> __( 'PARCEL RETURN', 'wf-shipping-fedex' ),
					'PARCEL_SELECT'	=> __( 'PARCEL SELECT', 'wf-shipping-fedex' ),
					'PRESORTED_BOUND_PRINTED_MATTER' => __( 'PRESORTED BOUND PRINTED MATTER', 'wf-shipping-fedex' ),
					'PRESORTED_STANDARD' => __( 'PRESORTED STANDARD', 'wf-shipping-fedex' ),
					'AUTOMATIC' => __( 'AUTOMATIC', 'wf-shipping-fedex' ),	
				);
				$label 			= '';
				$tool_tip 		= __( 'Applicable only for SmartPost. Ex: Parcel Select option requires weight of at-least 1LB. Automatic will choose PRESORTED STANDARD if the weight is less than 1lb and PARCEL SELECT if the weight is more than 1lb','wf-shipping-fedex' );

				$this->xa_load_input_select( $name, $selected_value, $options, $label, $tool_tip );?>
			</fieldset>
		</td>
	</tr>
	<tr valign="top">
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Shipping charge payor','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<fieldset style="padding:3px;"><?php
				$name 			= 'charges_payment_type';
				$selected_value = isset($this->settings['charges_payment_type']) ? $this->settings['charges_payment_type'] : '';
				$options 		= array(
					'SENDER' 							  	=> __( 'Sender', 						'wf-shipping-fedex'),
					//'RECIPIENT' 							  	=> __( 'Recipient', 						'wf-shipping-fedex'),
					'THIRD_PARTY' 							 => __( 'Third Party', 						'wf-shipping-fedex'),
				);
				$label 			= '';
				$tool_tip 		= __( 'Choose who is going to pay shipping and customs charges. Please fill Third Party settings below if Third Party is choosen. It will override freight shipement also', 'wf-shipping-fedex' );

				$this->xa_load_input_select( $name, $selected_value, $options, $label, $tool_tip );?>
			</fieldset>

			<table id="table_charges_payment_type_thirdparty">
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['shipping_payor_acc_no'])) ? $this->settings['shipping_payor_acc_no'] : '';
							$label 			= __( 'Third party Account Number', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><br/>';
							$this->xa_load_input_field( 'text', 'shipping_payor_acc_no', $value );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['shipping_payor_cname'])) ? $this->settings['shipping_payor_cname'] : '';
							$label 			= __( 'Contact Person', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><br/>';
							$this->xa_load_input_field( 'text', 'shipping_payor_cname', $value );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['shipp_payor_company'])) ? $this->settings['shipp_payor_company'] : '';
							$label 			= __( 'Company', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><br/>';
							$this->xa_load_input_field( 'text', 'shipp_payor_company', $value );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['shipping_payor_phone'])) ? $this->settings['shipping_payor_phone'] : '';
							$label 			= __( 'Contact Number', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><br/>';
							$this->xa_load_input_field( 'text', 'shipping_payor_phone', $value );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['shipping_payor_email'])) ? $this->settings['shipping_payor_email'] : '';
							$label 			= __( 'Contact Email', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><br/>';
							$this->xa_load_input_field( 'text', 'shipping_payor_email', $value );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['shipp_payor_address1'])) ? $this->settings['shipp_payor_address1'] : '';
							$label 			= __( 'Address Line 1', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><br/>';
							$this->xa_load_input_field( 'text', 'shipp_payor_address1', $value );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['shipp_payor_address2'])) ? $this->settings['shipp_payor_address2'] : '';
							$label 			= __( 'Address Line 2', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><br/>';
							$this->xa_load_input_field( 'text', 'shipp_payor_address2', $value );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['shipping_payor_city'])) ? $this->settings['shipping_payor_city'] : '';
							$label 			= __( 'City', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><br/>';
							$this->xa_load_input_field( 'text', 'shipping_payor_city', $value );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['shipping_payor_state'])) ? $this->settings['shipping_payor_state'] : '';
							$label 			= __( 'State Code', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><br/>';
							$this->xa_load_input_field( 'text', 'shipping_payor_state', $value );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['shipping_payor_zip'])) ? $this->settings['shipping_payor_zip'] : '';
							$label 			= __( 'Postal Code', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><br/>';
							$this->xa_load_input_field( 'text', 'shipping_payor_zip', $value );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['shipp_payor_country'])) ? $this->settings['shipp_payor_country'] : '';
							$label 			= __( 'Country', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><br/>';
							$this->xa_load_input_field( 'text', 'shipp_payor_country', $value );?>
						</fieldset>
					</td>
					<td>
						
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr valign="top">
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Customs Duties Payer','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<fieldset style="padding:3px;"><?php
				$name 			= 'customs_duties_payer';
				$selected_value = isset($this->settings['customs_duties_payer']) ? $this->settings['customs_duties_payer'] : '';
				$options 		= array(
					'SENDER' 	  => __( 'Sender', 'wf-shipping-fedex'),
					'RECIPIENT'	  => __( 'Recipient', 'wf-shipping-fedex'),
					'THIRD_PARTY' => __( 'Third Party (Broker)', 'wf-shipping-fedex'),
				);
				$label 			= '';
				$tool_tip 		= '';

				$this->xa_load_input_select( $name, $selected_value, $options, $label, $tool_tip );?>
			</fieldset>

			<table id="table_duties_payer_boker">
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['broker_acc_no'])) ? $this->settings['broker_acc_no'] : '';
							$label 			= __( 'Broker Account number', 'wf-shipping-fedex' );
							$description 	= __( 'Broker Account number', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'broker_acc_no', $value );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['broker_name'])) ? $this->settings['broker_name'] : '';
							$label 			= __( 'Broker name', 'wf-shipping-fedex' );
							$description 	= __( 'Name of the Broker', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'broker_name', $value );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['broker_company'])) ? $this->settings['broker_company'] : '';
							$label 			= __( 'Broker Company name', 'wf-shipping-fedex' );
							$description 	= __( 'Broker Company name', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'broker_company', $value );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['broker_phone'])) ? $this->settings['broker_phone'] : '';
							$label 			= __( 'Broker phone number', 'wf-shipping-fedex' );
							$description 	= __( 'Broker phone number', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'broker_phone', $value );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['broker_email'])) ? $this->settings['broker_email'] : '';
							$label 			= __( 'Brocker Email Address', 'wf-shipping-fedex' );
							$description 	= __( 'Brocker Email Address', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';
							$this->xa_load_input_field( 'text', 'broker_email', $value );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['broker_address'])) ? $this->settings['broker_address'] : '';
							$label 			= __( 'Broker Address', 'wf-shipping-fedex' );
							$description 	= __( 'Broker Address', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'broker_address', $value );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['broker_city'])) ? $this->settings['broker_city'] : '';
							$label 			= __( 'Broker City', 'wf-shipping-fedex' );
							$description 	= __( 'Broker City', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'broker_city', $value );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['broker_state'])) ? $this->settings['broker_state'] : '';
							$label 			= __( 'Broker State', 'wf-shipping-fedex' );
							$description 	= __( 'Broker State', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'broker_state', $value );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['broker_zipcode'])) ? $this->settings['broker_zipcode'] : '';
							$label 			= __( 'Zip Code', 'wf-shipping-fedex' );
							$description 	= __( 'Zip Code', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'broker_zipcode', $value );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['broker_country'])) ? $this->settings['broker_country'] : '';
							$label 			= __( 'Country Code', 'wf-shipping-fedex' );
							$description 	= __( 'Country Code', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'broker_country', $value );?>
						</fieldset>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Ship From Address Preference','wf-shipping-fedex') ?></label>
		</td>
		<td>
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['ship_from_address']) ? $this->settings['ship_from_address'] : 'origin_address';
				$options 		= apply_filters('wf_filter_label_ship_from_address_options', array(
						'origin_address' => __('Origin Address', 'wf-shipping-fedex'),
						'shipping_address' => __('Shipping Address', 'wf-shipping-fedex')
					)
				);

				$this->xa_load_input_select( 'ship_from_address', $selected_value, $options );?>
			</fieldset>
		</td>
	</tr>
	<tr valign="top">
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Shipper Address','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<table>
				<tr>
					<td>
						<fieldset style="padding-left:3px;">
							<label for=""><?php _e('Shipper Name','wf-shipping-fedex') ?><font style="color:red;">*</font></label> <span class="woocommerce-help-tip" data-tip="<?php _e('Name of the person responsible for shipping.','wf-shipping-fedex') ?>"></span>	<br/>
							<input class="input-text regular-input " type="text" name="shipper_person_name" id="shipper_person_name" style="" value="<?php echo (isset($this->settings['shipper_person_name'])) ? $this->settings['shipper_person_name'] : ''; ?>" placeholder=""> 	
						</fieldset>
					</td>
					<td>
						<fieldset style="padding-left:3px;">
							<label for=""><?php _e('Company Name','wf-shipping-fedex') ?><font style="color:red;">*</font></label> <span class="woocommerce-help-tip" data-tip="<?php _e('Company name of the shipper.','wf-shipping-fedex') ?>"></span>	 <br/>
							<input class="input-text regular-input " type="text" name="shipper_company_name" id="shipper_company_name" style="" value="<?php echo (isset($this->settings['shipper_company_name'])) ? $this->settings['shipper_company_name'] : ''; ?>" placeholder=""> 	
						</fieldset>

					</td>
				</tr>
				<tr>
					<td>

						<fieldset style="padding-left:3px;">
							<label for=""><?php _e('Phone Number','wf-shipping-fedex') ?><font style="color:red;">*</font></label> <span class="woocommerce-help-tip" data-tip="<?php _e('Phone number of the shipper.','wf-shipping-fedex') ?>"></span>	<br/>
							<input class="input-text regular-input " type="text" name="shipper_phone_number" id="shipper_phone_number" style="" value="<?php echo (isset($this->settings['shipper_phone_number'])) ? $this->settings['shipper_phone_number'] : ''; ?>" placeholder=""> 	
						</fieldset>
					</td>
					<td>

						<fieldset style="padding-left:3px;">
							<label for=""><?php _e('Email Address','wf-shipping-fedex') ?></label> <span class="woocommerce-help-tip" data-tip="<?php _e('Email address of the shipper.','wf-shipping-fedex') ?>"></span>	<br/>
							<input class="input-text regular-input " type="text" name="shipper_email" id="shipper_email" style="" value="<?php echo (isset($this->settings['shipper_email'])) ? $this->settings['shipper_email'] : ''; ?>" placeholder=""> 	
						</fieldset>

					</td>
				</tr>
				<tr>
					<td>

						<fieldset style="padding-left:3px;">
							<label for=""><?php _e('Address Line 1','wf-shipping-fedex') ?><font style="color:red;">*</font></label> <span class="woocommerce-help-tip" data-tip="<?php _e('Official address line 1 of the shipper.','wf-shipping-fedex') ?>"></span>	<br> 
							<input class="input-text regular-input " type="text" name="frt_shipper_street" id="frt_shipper_street" style="" value="<?php echo (isset($this->settings['frt_shipper_street'])) ? $this->settings['frt_shipper_street'] : ''; ?>" placeholder=""> 	
						</fieldset>

					</td>
					<td>

						<fieldset style="padding-left:3px;">
							<label for=""><?php _e('Address Line 2','wf-shipping-fedex') ?></label> <span class="woocommerce-help-tip" data-tip="<?php _e('Official address line 2 of the shipper.','wf-shipping-fedex') ?>"></span>	<br/> 
							<input class="input-text regular-input " type="text" name="shipper_street_2" id="shipper_street_2" style="" value="<?php echo (isset($this->settings['shipper_street_2'])) ? $this->settings['shipper_street_2'] : ''; ?>" placeholder=""> 	
						</fieldset>

					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding-left:3px;">
							<label for="freight_shipper_city"><?php _e('City','wf-shipping-fedex') ?><font style="color:red;">*</font></label> <span class="woocommerce-help-tip" data-tip="<?php _e('City of the shipper.','wf-shipping-fedex') ?>"></span>	 <br/>

							<input class="input-text regular-input " type="text" name="freight_shipper_city" id="freight_shipper_city" style="" value="<?php echo (isset($this->settings['freight_shipper_city'])) ? $this->settings['freight_shipper_city'] : ''; ?>" placeholder="">
						</fieldset>
					</td>
					<td>
						<fieldset style="padding-left:3px;">
							<label for="origin_country"><?php _e('Country and State','wf-shipping-fedex') ?><font style="color:red;">*</font></label> <span class="woocommerce-help-tip" data-tip="<?php _e('State of the shipper.','wf-shipping-fedex') ?>"></span><br/>
							<?php 
							$origin = $this->get_origin_country_state($this->settings);
							$this->xa_load_select_country( $origin['origin_country'], $origin['origin_state'] );?>
						</fieldset>	
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding-left:3px;">
							<label for="origin"><?php _e('Postal Code','wf-shipping-fedex') ?><font style="color:red;">*</font></label> <span class="woocommerce-help-tip" data-tip="<?php _e('Postal code of the shipper(Used for fetching rates and label generation).','wf-shipping-fedex') ?>"></span><br/>
							<input class="input-text regular-input " type="text" name="origin" id="origin" style="" value="<?php echo (isset($this->settings['origin'])) ? $this->settings['origin'] : ''; ?>" placeholder="">
						</fieldset>
					</td>
					<td>	
						<fieldset style="padding:3px;">
							<label for="origin">&nbsp;</label><br/>
							<input class="input-text regular-input " type="checkbox" name="shipper_residential" id="shipper_residential" style="" value="yes" <?php echo (isset($this->settings['shipper_residential']) && $this->settings['shipper_residential'] ==='yes') ? 'checked' : ''; ?> placeholder=""> <?php _e('Shipper Address is Residential','wf-shipping-fedex') ?> <span class="woocommerce-help-tip" data-tip="<?php _e('Enable this if the shipper Address is Residential.','wf-shipping-fedex') ?>"></span>
						</fieldset>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Delivery Signature','wf-shipping-fedex') ?></label>
		</td>
		<td>
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['signature_option']) ? $this->settings['signature_option'] : '';
				$options 		=  array(
					''	   					=> __( '-Select one-', 'wf-shipping-fedex' ),
					'ADULT'	   				=> __( 'Adult', 'wf-shipping-fedex' ),
					'DIRECT'	  			=> __( 'Direct', 'wf-shipping-fedex' ),
					'INDIRECT'	  			=> __( 'Indirect', 'wf-shipping-fedex' ),
					'NO_SIGNATURE_REQUIRED' => __( 'No Signature Required', 'wf-shipping-fedex' ),
					'SERVICE_DEFAULT'	  	=> __( 'Service Default', 'wf-shipping-fedex' ),
				);

				$this->xa_load_input_select( 'signature_option', $selected_value, $options );?>
			</fieldset>
		</td>
	</tr>

	<tr>
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Fedex SmartPost Hub','wf-shipping-fedex') ?></label>
		</td>
		<td>
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['smartpost_hub']) ? $this->settings['smartpost_hub'] : '';
				$options 		= $smartpost_hubs ;
				$label 			= '';
				$tool_tip		= __( 'Only required if using SmartPost.', 'wf-shipping-fedex' );
				$this->xa_load_input_select( 'smartpost_hub', $selected_value, $options, $label, $tool_tip );?>
			</fieldset>
		</td>
	</tr>

	<tr>
		<td colspan="2" style="text-align:right;">

			<button type="submit" class="button button-primary" name="xa_save_fedex_general_settings"> <?php _e('Save Changes','wf-shipping-fedex') ?> </button>
			
		</td>
	</tr>
</table>