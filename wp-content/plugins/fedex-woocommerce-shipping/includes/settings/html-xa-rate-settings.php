<?php 
global $woocommerce;
?>
<table>
	<tr valign="top" ">
		<td style="width:30%;font-weight:800;">
			<label for=""><?php _e('Show/Hide','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<fieldset style="padding:3px;"><?php 
				$checked 		= (!isset($this->settings['delivery_time']) || ( isset($this->settings['delivery_time']) && $this->settings['delivery_time'] ==='yes' ) ) ? 'checked' : '';
				$label 			= __('Show Delivery Time', 'wf-shipping-fedex' );
				$description 	= __('Enable Show delivery time to show delivery information on the cart/checkout. Applicable for US destinations only.', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'delivery_time', $checked, $label, $description );?>
			</fieldset>
			
			<fieldset style="padding:3px;"><?php 
				$checked 		= ( isset($this->settings['request_type']) && $this->settings['request_type'] ==='ACCOUNT') ? 'checked' : '';
				$label 			= __('Show Account rates', 'wf-shipping-fedex' );
				$description 	= __('On enabling this, the plugin will fetch the account specific rates of the shipper.', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'request_type', $checked, $label, $description );?>
			</fieldset>

			<fieldset style="padding:3px;"><?php 
				$checked 		= ( isset($this->settings['offer_rates']) && $this->settings['offer_rates'] ==='cheapest') ? 'checked' : '';
				$label 			= __('Offer the customer the cheapest rate only', 'wf-shipping-fedex' );
				$description 	= __('Offer the customer the cheapest rate only, anonymously.', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'offer_rates', $checked, $label, $description );?>
			</fieldset>

			<fieldset style="padding:3px;"><?php 
				$checked 		= ( ( isset($this->settings['fedex_one_rate']) && $this->settings['fedex_one_rate'] ==='yes' ) ) ? 'checked' : '';
				$label 			= __('Fedex One Rates', 'wf-shipping-fedex' );
				$description 	= __('Fedex One Rates will be offered if the items are packed into a valid Fedex One box, and the origin and destination is the US. For other countries this option will enable FedEx packing. Note: All FedEx boxes are not available for all countries, disable this option or disable different boxes if you are not receiving any shipping services.', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'fedex_one_rate', $checked, $label, $description );?>
			</fieldset>

			<fieldset style="padding:3px;"><?php 
				$checked 		= ( ( isset($this->settings['convert_currency']) && $this->settings['convert_currency'] ==='yes' ) ) ? 'checked' : '';
				$label 			= __('Rates in Base Currency', 'wf-shipping-fedex' );
				$description 	= __('Ex: FedEx returned rates in USD and would like to convert to the base currency EUR. Convertion happens only FedEx API provide the exchange rate.', 'wf-shipping-fedex' );
				$this->xa_load_input_checkbox( 'convert_currency', $checked, $label, $description );?>
			</fieldset>			
		</td>
	</tr>


	<tr valign="top" >
		<td style="width:30%;font-weight:800;">
			<label for="title"><?php _e('Method Config','wf-shipping-fedex') ?></label>
		</td>
		<td scope="row" class="titledesc" style="display: block;margin-bottom: 20px;margin-top: 3px;">
			<fieldset style="padding:3px;"><?php
				$value 			= (isset($this->settings['title'])) ? $this->settings['title'] : 'FedEx';
				$label 			= __( 'Method Title / Availability', 'wf-shipping-fedex' );
				$description 	= __( 'Provide the Method title which will be reflected as the service name if "Show cheapest rates only" is enabled', 'wf-shipping-fedex' );
				$this->xa_load_input_field( 'text', 'title', $value, $label, $description, 'FedEx' );?>
			</fieldset>
			
			<fieldset style="padding:3px;"><?php
				$value 	= isset($this->settings['availability']) ?  $this->settings['availability'] : 'all';
				$labels = array( 
					'all' 		=> __( 'Supports All Countries',	'wf-shipping-fedex' ),
					'specific' 	=> __( 'Specific Countries',		'wf-shipping-fedex' ),
				);
				$this->xa_load_input_radio( 'availability', $value, $labels ) ?>
			</fieldset>

			<fieldset style="padding:3px;" id="sepecific_countries">
				<label for="countries"><?php _e('Specific Countries','wf-shipping-fedex') ?></label> <span class="woocommerce-help-tip" data-tip="<?php _e('You can select the shipping method to be available for all countries or selective countries.','wf-shipping-fedex') ?>"></span><br/>

				<select class="chosen_select" multiple="true" name="countries[]" >
					<?php 
					$woocommerce_countys = $woocommerce->countries->get_countries();
					$selected_country =  (isset($this->settings['countries']) && !empty($this->settings['countries']) ) ? $this->settings['countries'] : array($woocommerce->countries->get_base_country());

					foreach ($woocommerce_countys as $key => $value) {
						if(in_array($key, $selected_country))
						{
							echo '<option value="'.$key.'" selected>'.$value.'</option>';
						}
						echo '<option value="'.$key.'">'.$value.'</option>';
					}
					?>
				</fieldset>
			</td>
		</tr>

		<tr valign="top" ">
			<td style="width:40%;font-weight:800;">
				<label for=""><?php _e('Minimum Order Amount','wf-shipping-fedex') ?></label>
			</td>
			<td colspan="2"><?php
				$value 			= (isset($this->settings['min_amount'])) ? $this->settings['min_amount'] : '';
				$label 			= __( 'Minimum Order Amount', 'wf-shipping-fedex' );
				$description 	= __( 'Users will need to spend this amount to get this shipping available.', 'wf-shipping-fedex' );
				$placeholder	= wc_format_localized_price( 0 );
				$this->xa_load_input_field( 'text', 'min_amount', $value, $label, $description, $placeholder );?>
			</td>
		</tr>
		

		<tr valign="top" ">
			<td style="width:40%;font-weight:800;">
				<label for=""><?php _e('Conversion Rate','wf-shipping-fedex') ?></label>
			</td>
			<td colspan="2"><?php
				$value 			= (isset($this->settings['conversion_rate'])) ? $this->settings['conversion_rate'] : '';
				$label 			= '';
				$description 	= __( 'Enter the conversion amount in case you have a different currency set up comparing to the currency of origin location. This amount will be multiplied with the shipping rates. Leave it empty if no conversion required.', 'wf-shipping-fedex' );
				$this->xa_load_input_field( 'text', 'conversion_rate', $value, $label, $description );?>
			</td>
		</tr>
		

		<tr valign="top" ">
			<td style="width:40%;font-weight:800;">
				<label for=""><?php _e('Services','wf-shipping-fedex') ?></label>
			</td>
			<td colspan="2"><?php
				ob_start();
				include( 'html-wf-services.php' );
				echo ob_get_clean();
				?>
			</td>
		</tr>
		


		<tr>
			<td colspan="2" style="text-align:right;padding-right: 10%;">
				<br/>
				<input type="submit" value="<?php _e('Save Changes','wf-shipping-fedex') ?>" class="button button-primary" name="xa_save_fedex_rate_settings">
				
			</td>
		</tr>

		

	</table>