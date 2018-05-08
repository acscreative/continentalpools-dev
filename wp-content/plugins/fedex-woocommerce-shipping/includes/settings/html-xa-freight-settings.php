<?php 
global $woocommerce;
$freight_classes = include( __DIR__ .'/../data-wf-freight-classes.php' );
?>
<table>
	<tr valign="top" ">
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Enable FedEx Freight','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<fieldset style="padding:3px;"><?php 
				$checked 		= ( isset($this->settings['freight_enabled']) && $this->settings['freight_enabled'] ==='yes' ) ? 'checked' : '';
				$label 			= __('Enable', 'wf-shipping-fedex' );
				$description 	= __('Enable this to setup FedEx Feright shipment', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'freight_enabled', $checked, $label, $description );?>
			</fieldset>
		</td>
	</tr>
	
	<tr valign="top" ">
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Freight Account Number','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<fieldset style="padding:3px;"><?php 
				$value 			= (isset($this->settings['freight_number'])) ? $this->settings['freight_number'] : '';
				$label 			= '';
				$description 	= __('Enable this to setup FedEx Feright shipment', 'wf-shipping-fedex' );
				$plceholder 	= __('Defaults to your main account number', 'wf-shipping-fedex' );
				$this->xa_load_input_field( 'text','freight_number', $value, $label, $description, $plceholder, 'freight-field' );?>
			</fieldset>
		</td>
	</tr>

	<tr valign="top" ">
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Freight Address','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<table>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['freight_bill_street'])) ? $this->settings['freight_bill_street'] : '';
							$label 			= __( 'Billing Street Address', 'wf-shipping-fedex' );
							$description 	= __( 'Billing Street Address', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'freight_bill_street', $value, '', '', '', 'freight-field' );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['billing_street_2'])) ? $this->settings['billing_street_2'] : '';
							$label 			= __( 'Billing Street Address 2', 'wf-shipping-fedex' );
							$description 	= __( 'Billing Street Address 2', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';

							$this->xa_load_input_field( 'text', 'billing_street_2', $value,'', '', '', 'freight-field' );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['freight_billing_city'])) ? $this->settings['freight_billing_city'] : '';
							$label 			= __( 'Billing City', 'wf-shipping-fedex' );
							$description 	= __( 'Billing City', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';
							$this->xa_load_input_field( 'text', 'freight_billing_city', $value,'', '', '', 'freight-field' );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['freight_billing_state'])) ? $this->settings['freight_billing_state'] : '';
							$label 			= __( 'Billing State Code', 'wf-shipping-fedex' );
							$description 	= __( 'Billing State Code', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';
							$this->xa_load_input_field( 'text', 'freight_billing_state', $value,'', '', '', 'freight-field' );?>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['billing_postcode'])) ? $this->settings['billing_postcode'] : '';
							$label 			= __( 'Billing ZIP / Postcode', 'wf-shipping-fedex' );
							$description 	= __( 'Billing ZIP / Postcode', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';
							$this->xa_load_input_field( 'text', 'billing_postcode', $value,'', '', '', 'freight-field' );?>
						</fieldset>
					</td>
					<td>
						<fieldset style="padding:3px;"><?php
							$value 			= (isset($this->settings['billing_country'])) ? $this->settings['billing_country'] : '';
							$label 			= __( 'Billing Country Code', 'wf-shipping-fedex' );
							$description 	= __( 'Billing Country Code', 'wf-shipping-fedex' );
							echo ' <label for="">'.$label.'</label><span class="woocommerce-help-tip" data-tip="'.$description.'"></span><br/>';
							$this->xa_load_input_field( 'text', 'billing_country', $value,'', '', '', 'freight-field' );?>
						</fieldset>
					</td>
				</tr>
			</table>			
		</td>
	</tr>

	<tr valign="top" ">
		<td style="width:40%;font-weight:800;">
			<label for=""><?php _e('Default Freight Class','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<fieldset style="padding:3px;"><?php
				$selected_value = isset($this->settings['freight_class']) ? $this->settings['freight_class'] : '';
				$options 		= $freight_classes;
				$label 			= '';
				$tool_tip 		= __( 'This is the default freight class for shipments. This can be overridden using shipping classes','wf-shipping-fedex' );
				$this->xa_load_input_select( 'freight_class', $selected_value, $options, $label, $tool_tip, 'freight-field' );?>
			</fieldset>
		</td>
	</tr>

	<tr>
		<td colspan="2" style="text-align:right;padding-right: 10%;">
			<br/>
			<input type="submit" value="<?php _e('Save Changes','wf-shipping-fedex') ?>" class="button button-primary" name="xa_save_fedex_freight_settings">
			
		</td>
	</tr>
</table>