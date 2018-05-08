<?php 
global $woocommerce;
$services = include(__DIR__ .'/../data-wf-service-codes.php');
$int_services = array();
$dom_services = array();
foreach ($services as $key => $value) {
	if( strpos($key, 'INTERNATIONAL') !== false ){
		$int_services = array_merge($int_services, array($key=>$value));
	}
	else {
		$dom_services = array_merge($dom_services, array($key=>$value));
	}
}
?>

<table>
	<tr>
		<td style="width:50%;font-weight:800;vertical-align: top;">
			<label for=""><?php _e('Shipping Label','wf-shipping-fedex') ?></label>
		</td>
		<td>
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['output_format']) ? $this->settings['output_format'] : '';
				$options 		= array(
					'PAPER_4X6' 						=> __( 'PAPER_4X6', 						'wf-shipping-fedex'),
					'PAPER_4X8' 						=> __( 'PAPER_4X8', 						'wf-shipping-fedex'),
					'PAPER_4X9' 						=> __( 'PAPER_4X9', 						'wf-shipping-fedex'),
					//'PAPER_6X4' 						=> __( 'PAPER_6X4', 						'wf-shipping-fedex'),
					'PAPER_7X4.75' 						=> __( 'PAPER_7X4.75', 					'wf-shipping-fedex'),
					'PAPER_8.5X11_BOTTOM_HALF_LABEL' 	=> __( 'PAPER_8.5X11_BOTTOM_HALF_LABEL','wf-shipping-fedex'),
					'PAPER_8.5X11_TOP_HALF_LABEL'		=> __( 'PAPER_8.5X11_TOP_HALF_LABEL', 	'wf-shipping-fedex'),
					'PAPER_LETTER' 						=> __( 'PAPER_LETTER', 					'wf-shipping-fedex'),
					'STOCK_4X6' 						=> __( 'STOCK_4X6 (For Thermal Printer Only)', 					'wf-shipping-fedex'),
					'STOCK_4X6.75_LEADING_DOC_TAB' 		=> __( 'STOCK_4X6.75_LEADING_DOC_TAB (For Thermal Printer Only)', 	'wf-shipping-fedex'),
					'STOCK_4X6.75_TRAILING_DOC_TAB' 	=> __( 'STOCK_4X6.75_TRAILING_DOC_TAB (For Thermal Printer Only)', 'wf-shipping-fedex'),
					'STOCK_4X8' 						=> __( 'STOCK_4X8 (For Thermal Printer Only)', 					'wf-shipping-fedex'),
					'STOCK_4X9_LEADING_DOC_TAB' 		=> __( 'STOCK_4X9_LEADING_DOC_TAB (For Thermal Printer Only)', 	'wf-shipping-fedex'),
					'STOCK_4X9_TRAILING_DOC_TAB' 		=> __( 'STOCK_4X9_TRAILING_DOC_TAB (For Thermal Printer Only)', 	'wf-shipping-fedex'),	
				);
				$label 			= __( 'Print Label Size', 'wf-shipping-fedex' );
				$tool_tip 		= __( 'Select here the label size to be generated','wf-shipping-fedex' );
				
				$this->xa_load_input_select( 'output_format', $selected_value, $options, $label, $tool_tip );?>
			</fieldset>
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['image_type']) ? $this->settings['image_type'] : '';
				$options 		= array(
					'pdf' 			=> __( 'PDF', 'wf-shipping-fedex'),
					'png' 			=> __( 'PNG', 'wf-shipping-fedex'),
					'dpl' 			=> __( 'DPL', 'wf-shipping-fedex'),
					'epl2' 			=> __( 'EPL2', 'wf-shipping-fedex'),
					'zplii' 		=> __( 'ZPLII', 'wf-shipping-fedex'),
				);
				$label 			= __( 'Image Type', 'wf-shipping-fedex' );
				$tool_tip 		= __( '4x6 output format best fit with type PNG','wf-shipping-fedex' );
				
				$this->xa_load_input_select( 'image_type', $selected_value, $options, $label, $tool_tip );?>
			</fieldset>
		</td>
	</tr>

	<tr valign="top">
		<td style="width:50%;font-weight:800;vertical-align: top;">
			<label for=""><?php _e('Enable/Disable','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			
			<fieldset style="padding:3px;"><?php 
				$checked 		=  ( isset($this->settings['frontend_retun_label']) && $this->settings['frontend_retun_label'] ==='yes' )  ? 'checked' : '';
				$label 			= __('Enable return label in my account page', 'wf-shipping-fedex' );
				$description 	= __('By enabling this the customers can generate the return label themself from my account page', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'frontend_retun_label', $checked, $label, $description );?>						
			</fieldset>

			<fieldset style="padding:3px;"><?php 
				$checked 		=  ( isset($this->settings['xa_show_all_shipping_methods']) && $this->settings['xa_show_all_shipping_methods'] ==='yes' )  ? 'checked' : '';
				$label 			= __('Show All Services In Order Edit Page', 'wf-shipping-fedex' );
				$description 	= __('Check this option to show all services in create label drop down(FEDEX).', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'xa_show_all_shipping_methods', $checked, $label, $description );?>						
			</fieldset>

			<fieldset style="padding:3px;"><?php 
				$checked 		=  ( isset($this->settings['automate_package_generation']) && $this->settings['automate_package_generation'] ==='yes' )  ? 'checked' : '';
				$label 			= __('Generate Packages Automatically After Order Received', 'wf-shipping-fedex' );
				$description 	= __('This will generate packages automatically after order is received and payment is successful', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'automate_package_generation', $checked, $label, $description );?>						
			</fieldset>

			<fieldset style="padding:3px;"><?php 
				$checked 		=  ( isset($this->settings['automate_label_generation']) && $this->settings['automate_label_generation'] ==='yes' )  ? 'checked' : '';
				$label 			= __('Generate Shipping Labels Automatically After Order Received', 'wf-shipping-fedex' );
				$description 	= __('This will generate shipping labels automatically after order is received and payment is successful', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'automate_label_generation', $checked, $label, $description );?>						
			</fieldset>

			<fieldset style="padding:3px;"><?php 
				$checked 		=  ( isset($this->settings['auto_email_label']) && $this->settings['auto_email_label'] ==='yes' )  ? 'checked' : '';
				$label 			= __('Send label in email to customer after label generation', 'wf-shipping-fedex' );
				$description 	= '';
				$this->xa_load_input_checkbox( 'auto_email_label', $checked, $label, $description );?>						
			</fieldset>

			<fieldset style="padding:3px;"><?php
				$value 			= (isset($this->settings['email_content'])) ? $this->settings['email_content'] : '';
				$label 			= __( 'Content of Email With Label', 'wf-shipping-fedex' );
				$description 	= __( 'Content of Email With Label', 'wf-shipping-fedex' );
				$this->xa_load_input_field( 'text', 'email_content', $value, $label, $description );?>
			</fieldset>

			<fieldset style="padding:3px;"><?php 
				$checked 		=  ( isset($this->settings['commercial_invoice']) && $this->settings['commercial_invoice'] ==='yes' )  ? 'checked' : '';
				$label 			= __('Commercial Invoice', 'wf-shipping-fedex' );
				$description 	= __('On enabling this option (which means you have enabled electronic trade documents), the shipment details will be sent electronically and also a copy of this document as commercial invoice will be received as an additional label. Applicable for international shipping only.', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'commercial_invoice', $checked, $label, $description );?>						
			</fieldset>
			<fieldset style="padding:3px;" class="commercial-invoice">
				<label>Company Logo (Optional)</label></br>
				<input size="60" class="input-text regular-input commercialinvoice-image-uploader" type="text" name="company_logo" id="company_logo" style="" value="" placeholder="Upload an image to set Company Logo on Commercial Invoice">
				<p class="description"><span class="button" id="company_logo_picker">Choose Image</span> </p><div id="company_logo_result"></div><p></p>
			</fieldset>
			<fieldset style="padding:3px;" class="commercial-invoice">
				<label>Digital Signature (Optional)</label></br>
				<input size="60" class="input-text regular-input commercialinvoice-image-uploader" type="text" name="digital_signature" id="digital_signature" style="" value="" placeholder="Upload an image to set Digital Signature on Commercial Invoice">
				<p class="description"><span class="button" id="digital_signature_picker">Choose Image</span> </p><div id="digital_signature_result"></div><p></p>
			</fieldset>
		</td>
	</tr>

	<tr>
		<td style="width:50%;font-weight:800;vertical-align: top;">
			<label for=""><?php _e('Default Services','wf-shipping-fedex') ?></label>
		</td>
		<td>
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['default_dom_service']) ? $this->settings['default_dom_service'] : '';
				$options 		= array_merge(array(''=>'Select once'), $dom_services);
				$label 			= __( 'Default service for domestic', 'wf-shipping-fedex' );
				$tool_tip 		= __( 'Default service for domestic label. This will consider if no FedEx services selected from frond end while placing the order','wf-shipping-fedex' );
				$this->xa_load_input_select( 'default_dom_service', $selected_value, $options, $label, $tool_tip );?>
			</fieldset>

			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['default_int_service']) ? $this->settings['default_int_service'] : '';
				$options 		= array_merge(array(''=>'Select once'), $dom_services);
				$label 			= __( 'Default service for International', 'wf-shipping-fedex' );
				$tool_tip 		= __( 'Default service for International label. This will consider if no FedEx services selected from frond end while placing the order','wf-shipping-fedex' );
				$this->xa_load_input_select( 'default_int_service', $selected_value, $options, $label, $tool_tip );?>
			</fieldset>
		</td>
	</tr>

	<tr>
		<td></td>
		<td><hr></td>
	</tr>

	<tr>
		<td style="width:50%;font-weight:800;vertical-align: top;">
			<label for=""><?php _e('Purpose of Shipment','wf-shipping-fedex') ?></label>
		</td>
		<td>
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['customs_ship_purpose']) ? $this->settings['customs_ship_purpose'] : '';
				$options 		= array(
					'GIFT' 				=> __( 'Gift', 				'wf-shipping-fedex'),
					'NOT_SOLD' 			=> __( 'Not Sold', 			'wf-shipping-fedex'),
					'PERSONAL_EFFECTS' 	=> __( 'Personal effects', 	'wf-shipping-fedex'),
					'REPAIR_AND_RETURN' => __( 'Repair and return', 'wf-shipping-fedex'),
					'SAMPLE' 			=> __( 'Sample', 			'wf-shipping-fedex'),
					'SOLD' 				=> __( 'Sold', 	 			'wf-shipping-fedex'),
				);
				$label 			= '';
				$tool_tip 		= __( 'Select purpose of shipment','wf-shipping-fedex' );
				$this->xa_load_input_select( 'customs_ship_purpose', $selected_value, $options, $label, $tool_tip );?>
			</fieldset>
		</td>
	</tr>
	
	<tr>
		<td></td>
		<td><hr></td>
	</tr>
	
	<tr>
		<td style="width:50%;font-weight:800;vertical-align: top;">
			<label for=""><?php _e('Tracking','wf-shipping-fedex') ?></label>
		</td>
		<td>
			<fieldset style="padding:3px;"><?php
				$checked 		=  ( isset($this->settings['tracking_shipmentid']) && $this->settings['tracking_shipmentid'] ==='yes' )  ? 'checked' : '';
				$label 			= __('Enable Tracking', 'wf-shipping-fedex' );
				$description 	= __('Add Tracking PIN to customer order notes.', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'tracking_shipmentid', $checked, $label, $description );?>
			</fieldset>
			<fieldset style="padding:3px;"><?php
				$value 			= (isset($this->settings['custom_message'])) ? $this->settings['custom_message'] : '';
				$label 			= __( 'Custom Shipment Message', 'wf-shipping-fedex' );
				$description 	= __( 'Define your own shipment message. Use the place holder tags [ID], [SERVICE] and [DATE] for Shipment Id, Shipment Service and Shipment Date respectively. Leave it empty for default message.<br>', 'wf-shipping-fedex' );
				$placeholder 	= 'Your order was shipped on [DATE] via [SERVICE]. To track shipment, please follow the link of shipment ID(s) [ID]';
				$this->xa_load_input_field( 'text', 'custom_message', $value, $label, $description, $placeholder );?>
			</fieldset>
		</td>
	</tr>

	<tr>
		<td></td>
		<td><hr></td>
	</tr>

	<tr>
		<td style="width:50%;font-weight:800;vertical-align: top;">
			<label for=""><?php _e('Email Notification','wf-shipping-fedex') ?></label>
		</td>
		<td>
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['email_notification']) ? $this->settings['email_notification'] : '';
				$options 		= array(
					''					=> __('None',					'wf-shipping-fedex'),
					'CUSTOMER'			=> __('Customer',				'wf-shipping-fedex'),
					'SHIPPER'			=> __('Shipper',				'wf-shipping-fedex'),
					'BOTH'				=> __('Customer and Shipper',	'wf-shipping-fedex'),
				);
				$label 			= '';
				$tool_tip 		= __( 'Select recipients for email notifications regarding the shipment from FedEx','wf-shipping-fedex' );
				
				$this->xa_load_input_select( 'email_notification', $selected_value, $options, $label, $tool_tip );?>
			</fieldset>
		</td>
	</tr>

	<tr>
		<td style="width:50%;font-weight:800;vertical-align: top;">
			<label for=""><?php _e('Time Zone Offset (Minutes)','wf-shipping-fedex') ?></label>
		</td>
		<td>
			<fieldset style="padding:3px;"><?php
				$value 			= (isset($this->settings['timezone_offset'])) ? $this->settings['timezone_offset'] : '';
				$label 			= __( 'Time Zone Offset (Minutes)', 'wf-shipping-fedex' );
				$description 	= __( 'Please enter a value in this field, if you want to change the shipment time while Label Printing. Enter a negetive value to reduce the time.', 'wf-shipping-fedex' );
				$this->xa_load_input_field( 'text', 'timezone_offset', $value, $label, $description, $placeholder );?>
			</fieldset>
		</td>
	</tr>

	<tr>
		<td></td>
		<td><hr></td>
	</tr>
	
	<tr>
		<td style="width:50%;font-weight:800;vertical-align: top;">
			<label for=""><?php _e('TIN number','wf-shipping-fedex') ?></label>
		</td>
		<td>
			<fieldset style="padding:3px;"><?php
				$value 			= (isset($this->settings['tin_number'])) ? $this->settings['tin_number'] : '';
				$label 			= __( 'TIN number', 'wf-shipping-fedex' );
				$description 	= __( 'TIN or VAT number', 'wf-shipping-fedex' );
				$this->xa_load_input_field( 'text', 'tin_number', $value, $label, $description, $placeholder );?>
			</fieldset>

			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['tin_type']) ? $this->settings['tin_type'] : '';
				$options 		= array(
					'BUSINESS_STATE'	=>'BUSINESS_STATE',
					'BUSINESS_NATIONAL'	=>'BUSINESS_NATIONAL',
					'BUSINESS_UNION'	=>'BUSINESS_UNION',
					'PERSONAL_NATIONAL'	=>'PERSONAL_NATIONAL',
					'PERSONAL_STATE'	=>'PERSONAL_STATE',
				);
				$label 			= __( 'Tin Type','wf-shipping-fedex' );
				$tool_tip 		= __( 'The category of the taxpayer identification','wf-shipping-fedex' );
				
				$this->xa_load_input_select( 'tin_type', $selected_value, $options, $label, $tool_tip, '', 2 );?>
			</fieldset>
		</td>
	</tr>

	<tr>
		<td style="width:50%;font-weight:800;vertical-align: top;">
			<label for=""><?php _e('COD Collection Type','wf-shipping-fedex') ?></label>
		</td>
		<td>
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['cod_collection_type']) ? $this->settings['cod_collection_type'] : '';
				$options 		= array(
					'ANY' 				=> __( 'ANY', 						'wf-shipping-fedex'),
					'CASH' 				=> __( 'CASH', 						'wf-shipping-fedex'),
					'GUARANTEED_FUNDS'  => __( 'GUARANTEED_FUNDS',			'wf-shipping-fedex')
				);
				$label 			= '';
				$tool_tip 		= __( 'Identifies the type of funds FedEx should collect upon shipment delivery.','wf-shipping-fedex' );
				
				$this->xa_load_input_select( 'cod_collection_type', $selected_value, $options, $label, $tool_tip, '', 2 );?>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:right;">
			<button type="submit" class="button button-primary" name="xa_save_fedex_label_settings"> <?php _e('Save Changes','wf-shipping-fedex') ?> </button>
		</td>
	</tr>
</table>