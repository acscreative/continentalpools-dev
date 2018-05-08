<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class wf_fedex_woocommerce_shipping_method extends WC_Shipping_Method {
	private $default_boxes;
	private $found_rates;
	private $services;
	private $transit_time = array(
		'ONE_DAY'		=> '+1day',
		'TWO_DAYS'		=> '+2days',
		'THREE_DAYS'		=> '+3days',
		'FOUR_DAYS'		=> '+4days',
		'FIVE_DAYS'		=> '+5days',
		'SIX_DAYS'		=> '+6days',
		'SEVEN_DAYS'		=> '+7days',
		'EIGHT_DAYS'		=> '+8days',
		'NINE_DAYS'		=> '+9days',
		'TEN_DAYS'		=> '+10days',
		'ELEVEN_DAYS'		=> '+11days',
		'TWELVE_DAYS'		=> '+12days',
		'THIRTEEN_DAYS'		=> '+13days',
		'FOURTEEN_DAYS'		=> '+14days',
		'FIFTEEN_DAYS'		=> '+15days',
		'SIXTEEN_DAYS'		=> '+16days',
		'SEVENTEEN_DAYS'	=> '+17days',
		'EIGHTEEN_DAYS'		=> '+18days',
		'NINETEEN_DAYS'		=> '+19days',
		'TWENTY_DAYS'		=> '+20days'
	);

	public function __construct() {
		$this->id							   = WF_Fedex_ID;

		$this->method_title					 = __( 'FedEx', 'wf-shipping-fedex' );
		$this->method_description			   = __( 'Obtains  real time shipping rates and Print shipping labels via FedEx Shipping API.', 'wf-shipping-fedex' );
		$this->rateservice_version			  = 22;
		$this->addressvalidationservice_version = 2;
		$this->default_boxes					= include( 'data-wf-box-sizes.php' );
		$this->speciality_boxes				 = include( 'data-wf-speciality-boxes.php' );
		$this->services						 = include( 'data-wf-service-codes.php' );
		$this->init();
	}


	/**
	 * is_available function.
	 *
	 * @param array $package
	 * @return bool
	 */
	public function is_available( $package ) {
		if ( "no" === $this->enabled ) {
			return false;
		}

		if ( 'specific' === $this->availability ) {
			if ( is_array( $this->countries ) && ! in_array( $package['destination']['country'], $this->countries ) ) {
				return false;
			}
		} elseif ( 'excluding' === $this->availability ) {
			if ( is_array( $this->countries ) && ( in_array( $package['destination']['country'], $this->countries ) || ! $package['destination']['country'] ) ) {
				return false;
			}
		}
		
		$has_met_min_amount = false;
		
		if(!method_exists(WC()->cart, 'get_displayed_subtotal')){// WC version below 2.6
			$total = WC()->cart->subtotal;
		}else{
			$total = WC()->cart->get_displayed_subtotal();
			if ( 'incl' === WC()->cart->tax_display_cart ) {
				$total = $total - ( WC()->cart->get_cart_discount_total() + WC()->cart->get_cart_discount_tax_total() );
			} else {
				$total = $total - WC()->cart->get_cart_discount_total();
			}
		}
		
		if ( $total >= $this->min_amount ) {
			$has_met_min_amount = true;
		}
		$is_available	= $has_met_min_amount;
		
		return apply_filters( 'woocommerce_shipping_' . $this->id . '_is_available', $is_available, $package );
	}

	
	function custom_price_message( $price ) { 
		global $post;
		return apply_filters( 'woocommerce_shipping_' . $this->id . '_is_available', true, $package );
	}
	
	private function is_soap_available(){
		if( extension_loaded( 'soap' ) ){
			return true;
		}
		return false;
	}
	
	private function init() {
		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		$this->soap_method = $this->is_soap_available() ? 'soap' : 'nusoap';
		if( $this->soap_method == 'nusoap' && !class_exists('nusoap_client') ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/nusoap/lib/nusoap.php';
		}

		// Define user set variables
		$this->enabled				= isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : $this->enabled;
		$this->title				= $this->get_option( 'title', $this->method_title );
		$this->availability			= isset( $this->settings['availability'] ) ? $this->settings['availability'] : 'all';
		$this->countries			= isset( $this->settings['countries'] ) ? $this->settings['countries'] : array();
		$this->origin				= apply_filters( 'woocommerce_fedex_origin_postal_code', str_replace( ' ', '', strtoupper( $this->get_option( 'origin' ) ) ) );
		$this->account_number			= $this->get_option( 'account_number' );
		$this->meter_number			= $this->get_option( 'meter_number' );
		$this->smartpost_hub			= $this->get_option( 'smartpost_hub' );
		$this->indicia				= $this->get_option( 'indicia' );
		
		$this->ship_from_address 		= isset($this->settings['ship_from_address'])? $this->settings['ship_from_address'] : 'origin_address';
		
		$this->api_key				= $this->get_option( 'api_key' );
		$this->api_pass				= $this->get_option( 'api_pass' );
		$this->production			= ( $bool = $this->get_option( 'production' ) ) && $bool == 'yes' ? true : false;
		$this->debug				= ( $bool = $this->get_option( 'debug' ) ) && $bool == 'yes' ? true : false;
		$this->delivery_time			= ( $bool = $this->get_option( 'delivery_time' ) ) && $bool == 'yes' ? true : false;
		$this->insure_contents			= ( $bool = $this->get_option( 'insure_contents' ) ) && $bool == 'yes' ? true : false;
		$this->request_type			= $this->get_option( 'request_type', 'LIST' );

		$this->packing_method			= $this->get_option( 'packing_method', 'per_item' );
		$this->conversion_rate			= ! empty( $this->settings['conversion_rate'] ) ? $this->settings['conversion_rate'] : '';
		$this->boxes				= $this->get_option( 'boxes', array( ));
		$this->custom_services			= $this->get_option( 'services', array( ));
		$this->offer_rates			= $this->get_option( 'offer_rates', 'all' );
		$this->convert_currency_to_base		= $this->get_option( 'convert_currency');		
		$this->residential			= ( $bool = $this->get_option( 'residential' ) ) && $bool == 'yes' ? true : false;
		$this->freight_enabled			= ( $bool = $this->get_option( 'freight_enabled' ) ) && $bool == 'yes' ? true : false;
		$this->fedex_one_rate			= ( $bool = $this->get_option( 'fedex_one_rate' ) ) && $bool == 'yes' ? true : false;
		$this->fedex_one_rate_package_ids = array(
			'FEDEX_SMALL_BOX',
			'FEDEX_MEDIUM_BOX',
			'FEDEX_LARGE_BOX',
			'FEDEX_EXTRA_LARGE_BOX',
			'FEDEX_PAK',
			'FEDEX_ENVELOPE',
		);
		
		$this->delivery_time_details		= '';
		$this->box_max_weight			= $this->get_option( 'box_max_weight' );
		$this->weight_pack_process		= $this->get_option( 'weight_pack_process' );
		
		if($this->get_option( 'dimension_weight_unit' ) == 'LBS_IN'){
			$this->dimension_unit		= 'in';
			$this->weight_unit		= 'lbs';
			$this->labelapi_dimension_unit	= 'IN';
			$this->labelapi_weight_unit 	= 'LB';
		}else{
			$this->dimension_unit		= 'cm';
			$this->weight_unit		= 'kg';
			$this->labelapi_dimension_unit	= 'CM';
			$this->labelapi_weight_unit 	= 'KG';
			$this->default_boxes		= include( 'data-wf-box-sizes-cm.php' );
		}
		if ( $this->freight_enabled ) {
			$this->freight_class			= $this->get_option( 'freight_class' );
			$this->freight_number			= $this->get_option( 'freight_number', $this->account_number );
			$this->freight_bill_street		= $this->get_option( 'freight_bill_street' );
			$this->freight_billing_street_2		= $this->get_option( 'billing_street_2' );
			$this->freight_billing_city		= $this->get_option( 'freight_billing_city' );
			$this->freight_billing_state		= $this->get_option( 'freight_billing_state' );
			$this->freight_billing_postcode		= $this->get_option( 'billing_postcode' );
			$this->freight_billing_country		= $this->get_option( 'billing_country' );
			$this->frt_shipper_street		= $this->get_option( 'frt_shipper_street' );
			$this->freight_shipper_street_2		= $this->get_option( 'shipper_street_2' );
			$this->freight_shipper_city		= $this->get_option( 'freight_shipper_city' );
			$this->freight_shipper_residential	= ( $bool = $this->get_option( 'shipper_residential' ) ) && $bool == 'yes' ? true : false;
			$this->freight_class			= str_replace( array( 'CLASS_', '.' ), array( '', '_' ), $this->freight_class );
		}
		$this->is_dry_ice_enabled 	= isset( $this->settings['dry_ice_enabled'] ) && $this->settings['dry_ice_enabled'] =='yes' ? true : false;
		
		$this->signature_option 	= isset ( $this->settings['signature_option'] ) ? $this->settings['signature_option'] : '';
		$this->min_amount	  		= isset( $this->settings['min_amount'] ) ? $this->settings['min_amount'] : 0;
		$this->customs_duties_payer	= isset ( $this->settings['customs_duties_payer'] ) ? $this->settings['customs_duties_payer'] : '';
		$this->enable_speciality_box	= ( $bool = $this->get_option( 'enable_speciality_box' ) ) && $bool == 'yes' ? true : false;

		$this->set_origin_country_state();

		// Insure contents requires matching currency to country
		switch ( $this->origin_country ) {
			case 'US' :
				if ( 'USD' !== get_woocommerce_currency() ) {
					$this->insure_contents = false;
				}
			break;
			case 'CA' :
				if ( 'CAD' !== get_woocommerce_currency() ) {
					$this->insure_contents = false;
				}
			break;
		}
		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	private function set_origin_country_state(){
		$origin_country_state 		= isset( $this->settings['origin_country'] ) ? $this->settings['origin_country'] : '';
		if ( strstr( $origin_country_state, ':' ) ) :
			// WF: Following strict php standards.
			$origin_country_state_array			= explode(':',$origin_country_state);
			$origin_country					= current($origin_country_state_array);
			$origin_country_state_array			= explode(':',$origin_country_state);
			$origin_state					= end($origin_country_state_array);
		else :
			$origin_country					= $origin_country_state;
			$origin_state					= '';
			$this->settings[ 'freight_shipper_state' ]	= '';
		endif;

		$this->origin_country  	= apply_filters( 'woocommerce_fedex_origin_country_code', $origin_country );
		$this->origin_state 	= !empty($origin_state) ? $origin_state : ( isset($this->settings[ 'freight_shipper_state' ]) ? $this->settings[ 'freight_shipper_state' ] : '' );
	}

	public function debug( $message, $type = 'notice' ) {
		if ( $this->debug ) {
			wc_add_notice( $message, $type );
		}
	}
	
	private function wf_get_fedex_currency(){
		$wc_currency = get_woocommerce_currency();
		$fedex_currency = '';
		switch ( $wc_currency ) {
			case 'ARS':
				$fedex_currency = 'ARN';
				break;
			case 'GBP':
				$fedex_currency = 'UKL';
				break;
			case 'CHF':
				$fedex_currency = 'SFR';
				break;	
			case 'MXN':
				$fedex_currency = 'NMP';
				break;	
			case 'SGD':
				$fedex_currency = 'SID';
				break;		
			case 'AED':
				$fedex_currency = 'DHS';
				break;			
			default:
				$fedex_currency = $wc_currency;
				break;
		}
		return $fedex_currency;
	}

	private function environment_check() {
		if ( ! in_array( get_woocommerce_currency(), array( 'USD' ) )) {
			echo '<div class="notice">
				<p>' . __( 'FedEx API returns the rates in USD. Please enable Rates in base currency option in the plugin. Conversion happens only if FedEx API provide the exchange rates.', 'wf-shipping-fedex' ) . '</p>
			</div>'; 
		} 
			
		if ( ! $this->origin && $this->enabled == 'yes' ) {
			echo '<div class="error">
				<p>' . __( 'FedEx is enabled, but the origin postcode has not been set.', 'wf-shipping-fedex' ) . '</p>
			</div>';
		}
	}

	public function admin_options() {
		// Check users environment supports this method
		$this->environment_check();

		// Show settings
		parent::admin_options();
	}

	public function init_form_fields() {
		if( is_admin() && ! did_action('wp_enqueue_media') && isset($_GET['section']) &&  $_GET['section'] == 'wf_fedex_woocommerce_shipping'){
			wp_enqueue_media();
		}
		$this->form_fields  = include( 'data-wf-settings.php' );
	}

	public function generate_activate_box_html() {
		ob_start();
		$plugin_name = 'fedex';
		include( 'wf_api_manager/html/html-wf-activation-window.php' );
		return ob_get_clean();
	}



	public function generate_single_select_country_html() {
		global $woocommerce;
		ob_start();
		?>
		<tr valign="top" class="fedex_general_tab">
			<th scope="row" class="titledesc">
				<label for="origin_country"><?php _e( 'Origin Country and State', 'wf-shipping-fedex' ); ?></label>
			</th>
			<td class="forminp">
				<select name="woocommerce_origin_country_state" id="woocommerce_origin_country_state" style="width: 250px;" data-placeholder="<?php _e('Choose a country&hellip;', 'woocommerce'); ?>" title="Country" class="chosen_select">
					<?php echo $woocommerce->countries->country_dropdown_options( $this->origin_country, $this->origin_state ? $this->origin_state : '*' ); ?>
				</select>
			</td>
		</tr>
		<?php
		return ob_get_clean();
	}
	
	public function generate_settings_tabs_html()
	{
	    $current_tab = (!empty($_GET['subtab'])) ? esc_attr($_GET['subtab']) : 'general';

		echo '
			<div class="wrap">
		    <style>
			    .wrap {
					min-height: 800px;
				    }
			    a.nav-tab{
					cursor: default;
			    }
			    .nav-tab-active{
			    	height: 24px;
			    }
		    </style>
		    <hr class="wp-header-end">';

		    $tabs = array(
				'general' => __("General", 'wf-shipping-fedex'),
				'rates' => __("Rates & Services", 'wf-shipping-fedex'),
				'labels' => __("Label Generation", 'wf-shipping-fedex'),
				'packaging' => __("Packaging", 'wf-shipping-fedex'),
				'pickup' => __("Pickup", 'wf-shipping-fedex'),
				'freight' => __("Freight", 'wf-shipping-fedex'),
				'licence' => __("License", 'wf-shipping-fedex')
		    );

		    $html = '<h2 class="nav-tab-wrapper">';
		    foreach ($tabs as $stab => $name) {
				$class = ($stab == $current_tab) ? 'nav-tab-active' : '';
				$html .= '<a style="text-decoration:none !important;" class="nav-tab ' . $class." tab_".$stab . '" >' . $name . '</a>';
		    }
		    $html .= '</h2>';
		    echo $html;

	}
	public function generate_services_html() {
		ob_start();
		include( 'html-wf-services.php' );
		return ob_get_clean();
	}

	public function generate_box_packing_html() {
		ob_start();
		include( 'html-wf-box-packing.php' );
		return ob_get_clean();
	}

	public function generate_validate_button_html(){
		ob_start();?>
			<tr style="padding-top: 0px;" class="fedex_general_tab">
				<td></td>
				<td style="vertical-align: top;padding-top: 0px;">
					<input type="button" value=" Validate Credentials" id="xa_fedex_validate_credentials" class="button button-secondary" name="xa_fedex_validate_credentials" >
					<p class="fedex-validation-result"></p>
				</td>
			</tr><?php
		return ob_get_clean();
	}

	private function merge_with_speciality_box($boxes=''){
		if( empty($boxes) )
			return;
		foreach ($this->speciality_boxes as $sp_key => $sp_box) {
			$found = 0;
			foreach ($boxes as $key => $box) {
				if( isset( $box['box_type'] ) && $box['box_type'] == $sp_box['box_type'] ){
					$found = 1;
				}
			}
			if( $found == 0 ){
				array_unshift($boxes, $sp_box);
			}
		}
		return $boxes;
	}
	public function validate_box_packing_field( $key ) {
		$box_type	 		= isset( $_POST['box_type'] ) ? $_POST['box_type'] : array();
		$boxes_name			 = isset( $_POST['boxes_name'] ) ? $_POST['boxes_name'] : array();
				$boxes_length	 	= isset( $_POST['boxes_length'] ) ? $_POST['boxes_length'] : array();
		$boxes_width	  	= isset( $_POST['boxes_width'] ) ? $_POST['boxes_width'] : array();
		$boxes_height	 	= isset( $_POST['boxes_height'] ) ? $_POST['boxes_height'] : array();

		$boxes_inner_length	= isset( $_POST['boxes_inner_length'] ) ? $_POST['boxes_inner_length'] : array();
		$boxes_inner_width	= isset( $_POST['boxes_inner_width'] ) ? $_POST['boxes_inner_width'] : array();
		$boxes_inner_height	= isset( $_POST['boxes_inner_height'] ) ? $_POST['boxes_inner_height'] : array();
		
		$boxes_box_weight 	= isset( $_POST['boxes_box_weight'] ) ? $_POST['boxes_box_weight'] : array();
		$boxes_max_weight 	= isset( $_POST['boxes_max_weight'] ) ? $_POST['boxes_max_weight'] :  array();
		$boxes_enabled		= isset( $_POST['boxes_enabled'] ) ? $_POST['boxes_enabled'] : array();

		$boxes = array();
		if ( ! empty( $boxes_length ) && sizeof( $boxes_length ) > 0 ) {
			for ( $i = 0; $i <= max( array_keys( $boxes_length ) ); $i ++ ) {

				if ( ! isset( $boxes_length[ $i ] ) )
					continue;

				if ( $boxes_length[ $i ] && $boxes_width[ $i ] && $boxes_height[ $i ] ) {

					$boxes[] = array(
						'box_type'	=> isset( $box_type[ $i ] ) ? $box_type[ $i ] : '',
						'name'		=> strval($boxes_name[$i]),
												'length'	=> floatval( $boxes_length[ $i ] ),
						'width'		=> floatval( $boxes_width[ $i ] ),
						'height'	=> floatval( $boxes_height[ $i ] ),

						/* Old version compatibility: If inner dimensions are not provided, assume outer dimensions as inner.*/
						'inner_length'	=> isset( $boxes_inner_length[ $i ] ) ? floatval( $boxes_inner_length[ $i ] ) : floatval( $boxes_length[ $i ] ),
						'inner_width'	=> isset( $boxes_inner_width[ $i ] ) ? floatval( $boxes_inner_width[ $i ] ) : floatval( $boxes_width[ $i ] ), 
						'inner_height'	=> isset( $boxes_inner_height[ $i ] ) ? floatval( $boxes_inner_height[ $i ] ) : floatval( $boxes_height[ $i ] ),
						
						'box_weight'	=> floatval( $boxes_box_weight[ $i ] ),
						'max_weight'	=> floatval( $boxes_max_weight[ $i ] ),
						'enabled'	=> isset( $boxes_enabled[ $i ] ) ? true : false
					);
				}
			}
		}
		foreach ( $this->default_boxes as $box ) {
			$boxes[ $box['id'] ] = array(
				'enabled' => isset( $boxes_enabled[ $box['id'] ] ) ? true : false
			);
		}
		return $boxes;
	}

	public function validate_single_select_country_field( $key ) {

		if ( isset( $_POST['woocommerce_origin_country_state'] ) )
			return $_POST['woocommerce_origin_country_state'];
		return '';
	}
	
	public function validate_services_field( $key ) {
		$services		 = array();
		$posted_services  = $_POST['fedex_service'];

		foreach ( $posted_services as $code => $settings ) {
			$services[ $code ] = array(
				'name'			   => wc_clean( $settings['name'] ),
				'order'			  => wc_clean( $settings['order'] ),
				'enabled'			=> isset( $settings['enabled'] ) ? true : false,
				'adjustment'		 => wc_clean( $settings['adjustment'] ),
				'adjustment_percent' => str_replace( '%', '', wc_clean( $settings['adjustment_percent'] ) )
			);
		}

		return $services;
	}

	public function get_fedex_packages( $package ) {
		switch ( $this->packing_method ) {
			case 'box_packing' :
				$fedex_packages = $this->box_shipping( $package );
			break;
			case 'weight_based' :
				$fedex_packages = $this->weight_based_shipping( $package );
			break;
			case 'per_item' :
			default :
				$fedex_packages = $this->per_item_shipping( $package );
			break;
		}
		return apply_filters( 'wf_fedex_packages', $fedex_packages );
	}

	public function get_freight_class( $item_data ){
		$item_data = $this->wf_load_product($item_data);
		if($item_data->variation_id){
			$class	=	get_post_meta( $item_data->variation_id, '_wf_freight_class', true );
		}
		
		if(!$class)
			$class	=	get_post_meta($item_data->id, '_wf_freight_class', true );
		
		// To be deprecated after WC 2.6
		if(!$class){
			$shipping_class_id	=	$item_data->get_shipping_class_id();
			if($shipping_class_id){
				$class = get_woocommerce_term_meta( $shipping_class_id, 'fedex_freight_class', true );
			}
		}
		return $class ? $class : '';
	}

	private function per_item_shipping( $package ) {
		$to_ship  = array();
		$group_id = 1;

		// Get weight of order
		foreach ( $package['contents'] as $item_id => $values ) {
			$values['data'] = $this->wf_load_product( $values['data'] );
			if ( ! $values['data']->needs_shipping() ) {
				$this->debug( sprintf( __( 'Product # is virtual. Skipping.', 'wf-shipping-fedex' ), $item_id ), 'error' );
				continue;
			}
			
			$skip_product = apply_filters('wf_shipping_skip_product',false, $values, $package['contents']);
			if($skip_product){
				continue;
			}

			if ( ! $values['data']->get_weight() ) {
				$this->debug( sprintf( __( 'Product # is missing weight. Aborting.', 'wf-shipping-fedex' ), $item_id ), 'error' );
				return;
			}

			$group = array();

			$group = array(
				'GroupNumber'	   => $group_id,
				'GroupPackageCount' => $values['quantity'],
				'Weight'		=> array(
					'Value' => $this->round_up( wc_get_weight( $values['data']->get_weight(), $this->weight_unit ), 2 ),
					'Units' => $this->labelapi_weight_unit
				),
				'packed_products' => array( $values['data'] )
			);

			$group['InsuredValue'] = array(
				'Amount'   => round( $values['data']->get_price() ),
				'Currency' => $this->wf_get_fedex_currency()
			);

			$custom_field_index=1;

			$custom_field = '';
			while( $custom_field_index==1 || !empty( $custom_field ) ){
				
				if($values['data']->get_type()=='simple'){
					$length = $custom_field_index == 1 ? $values['data']->get_length() : get_post_meta( $values['data']->id, '_length'.$custom_field_index, true );
					$height = $custom_field_index == 1 ? $values['data']->get_height() : get_post_meta( $values['data']->id, '_height'.$custom_field_index, true );
					$width 	= $custom_field_index == 1 ? $values['data']->get_width()  : get_post_meta( $values['data']->id, '_width' .$custom_field_index, true );
					$weight = $custom_field_index == 1 ? $values['data']->get_weight() : get_post_meta( $values['data']->id, '_weight'.$custom_field_index, true );
				}

				$dimensions = array( 
					!empty($length) ? $length : $values['data']->get_length(),
					!empty($width)  ? $width  : $values['data']->get_width(),
					!empty($height) ? $height : $values['data']->get_height()
				);
				if ( $dimensions[0] && $dimensions[1] && $dimensions[2] ) {
					sort( $dimensions );
	
					$group['Dimensions'] = array(
						'Length' => max( 1, round( wc_get_dimension( $dimensions[2], $this->dimension_unit ), 0 ) ),
						'Width'  => max( 1, round( wc_get_dimension( $dimensions[1], $this->dimension_unit ), 0 ) ),
						'Height' => max( 1, round( wc_get_dimension( $dimensions[0], $this->dimension_unit ), 0 ) ),
						'Units'  => $this->labelapi_dimension_unit
					);
					$group['Weight'] = array(
						'Value' => $this->round_up( wc_get_weight( !empty($weight) ? $weight : $values['data']->get_weight(), $this->weight_unit ), 2 ),
						'Units' => $this->labelapi_weight_unit
					);
				}
				$custom_field_index++;
				$custom_field = get_post_meta( $values['data']->id, '_weight'.$custom_field_index, true );

				$to_ship[] = $group;
				$group_id++;
			}
			
		}

		return $to_ship;
	}


	private function wf_fedex_add_pre_packed_product( $pre_packed_items, $group_id=1 ) {
		$to_ship  = array();

		foreach ( $pre_packed_items as $item_id => $values ) {
			$values['data'] = $this->wf_load_product( $values['data'] );
			if ( ! $values['data']->needs_shipping() ) {
				$this->debug( sprintf( __( 'Product # is virtual. Skipping.', 'wf-shipping-fedex' ), $item_id ), 'error' );
				continue;
			}

			if ( ! $values['data']->get_weight() ) {
				$this->debug( sprintf( __( 'Product # is missing weight. Aborting.', 'wf-shipping-fedex' ), $item_id ), 'error' );
				return;
			}

			$group = array();

			$group = array(
				'GroupNumber'	   => $group_id,
				'GroupPackageCount' => $values['quantity'],
				'Weight' => array(
					'Value' => $this->round_up( wc_get_weight( $values['data']->get_weight(), $this->weight_unit ), 2 ),
					'Units' => $this->labelapi_weight_unit
				),
				'packed_products' => array( $values['data'] )
			);

			$group['InsuredValue'] = array(
				'Amount'   => round( $values['data']->get_price() ),
				'Currency' => $this->wf_get_fedex_currency()
			);

			$custom_field_index=1;

			$custom_field = '';
			while( $custom_field_index==1 || !empty( $custom_field ) )
			{
				if($values['data']->get_type()=='simple')
				{
					$values['data']->length = get_post_meta( $values['data']->id, '_length'.($custom_field_index==1 ? '' : $custom_field_index), true );
					$values['data']->height = get_post_meta( $values['data']->id, '_height'.($custom_field_index==1 ? '' : $custom_field_index), true );
					$values['data']->width 	= get_post_meta( $values['data']->id, '_width'.($custom_field_index==1 ? '' : $custom_field_index), true );
				}	
				if ( $values['data']->length && $values['data']->height && $values['data']->width ) {
	
					$dimensions = array( $values['data']->length, $values['data']->width  , $values['data']->height );
	
					sort( $dimensions );
	
					$group['Dimensions'] = array(
						'Length' => max( 1, round( wc_get_dimension( $dimensions[2], $this->dimension_unit ), 0 ) ),
						'Width'  => max( 1, round( wc_get_dimension( $dimensions[1], $this->dimension_unit ), 0 ) ),
						'Height' => max( 1, round( wc_get_dimension( $dimensions[0], $this->dimension_unit ), 0 ) ),
						'Units'  => $this->labelapi_dimension_unit
					);
					$group['Weight']=array(
											'Value' => $this->round_up( wc_get_weight( get_post_meta( $values['data']->id, '_weight'.($custom_field_index==1?'':$custom_field_index), true ), $this->weight_unit ), 2 ),
											'Units' => $this->labelapi_weight_unit
											);
				}
				$custom_field_index++;
				$custom_field = get_post_meta( $values['data']->id, '_weight'.$custom_field_index, true );
				$to_ship[] = $group;
				$group_id++;
			}
			
		}

		return $to_ship;
	}


	private function round_up( $value, $precision=2 ) { 
		$pow = pow ( 10, $precision ); 
		return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 
	}
	
	private function box_shipping( $package ) {
		if ( ! class_exists( 'WF_Boxpack' ) ) {
			include_once 'class-wf-packing.php';
		}

		$boxpack = new WF_Boxpack();

		// Merge default boxes
		foreach ( $this->default_boxes as $key => $box ) {
			$box['enabled'] = isset( $this->boxes[ $box['id'] ]['enabled'] ) ? $this->boxes[ $box['id'] ]['enabled'] : true;
			$this->boxes[] = $box;
		}
		

		// Define boxes
		foreach ( $this->boxes as $key => $box ) {
			if ( ! is_numeric( $key ) ) {
				continue;
			}

			if ( ! $box['enabled'] ) {
				continue;
			}

			$newbox = $boxpack->add_box( $box['length'], $box['width'], $box['height'], $box['box_weight'] );
			$newbox->set_inner_dimensions($box['inner_length'], $box['inner_width'], $box['inner_height']);

			if ( isset( $box['id'] ) ) {
				$newbox->set_id( current( explode( ':', $box['id'] ) ) );
			}

			if ( $box['max_weight'] ) {
				$newbox->set_max_weight( $box['max_weight'] );
			}
		}

		// Add items
		foreach ( $package['contents'] as $item_id => $values ) {
			$values['data'] = $this->wf_load_product( $values['data'] );
			if ( ! $values['data']->needs_shipping() ) {
				$this->debug( sprintf( __( 'Product # is virtual. Skipping.', 'wf-shipping-fedex' ), $item_id ), 'error' );
				continue;
			}
			
			$skip_product = apply_filters('wf_shipping_skip_product',false, $values, $package['contents']);
			if($skip_product){
				continue;
			}

			
			$pre_packed = get_post_meta($values['data']->id , '_wf_fedex_pre_packed_var', 1);
			if( empty( $pre_packed ) ){
				$pre_packed = get_post_meta( ($values['data']->id) , '_wf_fedex_pre_packed', 1);
			}
			$pre_packed = apply_filters('wf_fedex_is_pre_packed',$pre_packed,$values);
			if( !empty($pre_packed) && $pre_packed == 'yes' ){
				$pre_packed_contents[$item_id] = $values;
				$this->debug( sprintf( __( 'Pre Packed product. Skipping the product '.$values['data']->id, 'wf-shipping-fedex' ), $item_id ) );
				continue;
			}

			$custom_field_index=1;
			$custom_field = '';
			
			while($custom_field_index==1 || !empty( $custom_field ) ){
				if($values['data']->get_type()=='simple'){
					$length = $custom_field_index == 1 ? $values['data']->get_length() : get_post_meta( $values['data']->id, '_length'.$custom_field_index, true );
					$height = $custom_field_index == 1 ? $values['data']->get_height() : get_post_meta( $values['data']->id, '_height'.$custom_field_index, true );
					$width 	= $custom_field_index == 1 ? $values['data']->get_width()  : get_post_meta( $values['data']->id, '_width' .$custom_field_index, true );
					$weight = $custom_field_index == 1 ? $values['data']->get_weight() : get_post_meta( $values['data']->id, '_weight'.$custom_field_index, true );
				}
				$dimensions = array( 
					!empty($length) ? $length : $values['data']->get_length(),
					!empty($width)  ? $width  : $values['data']->get_width(),
					!empty($height) ? $height : $values['data']->get_height()
				);
				if( empty($weight) ){
					$weight = $values['data']->get_weight();
				}

				if ( $dimensions[0] && $dimensions[1] && $dimensions[2] && $weight ) {	
					for ( $i = 0; $i < $values['quantity']; $i ++ ) {
						$boxpack->add_item(
							wc_get_dimension( $dimensions[2], $this->dimension_unit ),
							wc_get_dimension( $dimensions[1], $this->dimension_unit ),
							wc_get_dimension( $dimensions[0], $this->dimension_unit ),
							round(wc_get_weight( $weight, $this->weight_unit ),2),
							$values['data']->get_price(),
							array(
								'data' => $values['data']
							)
						);
					}
	
				} else {
					$this->debug( sprintf( __( 'Product #%s is missing dimensions. Aborting.', 'wf-shipping-fedex' ), $item_id ), 'error' );
					return;
				}
				$custom_field_index++;
				$custom_field = get_post_meta( $values['data']->id, '_weight'.$custom_field_index, true );
			}
		}

		// Pack it
		$boxpack->pack();
		$packages = $boxpack->get_packages();
		$to_ship  = array();
		$group_id = 1;

		foreach ( $packages as $package ) {
			if ( $package->unpacked === true ) {
				$this->debug( 'Unpacked Item' );
			} else {
				$this->debug( 'Packed ' . $package->id );
			}

			$dimensions = array( $package->length, $package->width, $package->height );

			sort( $dimensions );

			$group = array(
				'GroupNumber'	   => $group_id,
				'GroupPackageCount' => 1,
				'Weight' => array(
					'Value' => $this->round_up( $package->weight, 2 ),
					'Units' => $this->labelapi_weight_unit
				),
				'Dimensions'		=> array(
					'Length' => max( 1, round( $dimensions[2], 0 ) ),
					'Width'  => max( 1, round( $dimensions[1], 0 ) ),
					'Height' => max( 1, round( $dimensions[0], 0 ) ),
					'Units'  => $this->labelapi_dimension_unit
				),
				'InsuredValue'	  => array(
					'Amount'   => round( $package->value ),
					'Currency' => $this->wf_get_fedex_currency()
				),
				'packed_products' => array(),
				'package_id'	  => $package->id
			);

			if ( ! empty( $package->packed ) && is_array( $package->packed ) ) {
				foreach ( $package->packed as $packed ) {
					$group['packed_products'][] = $packed->get_meta( 'data' );
				}
			}

			if ( $this->freight_enabled ) {
				$highest_freight_class = '';

				if ( ! empty( $package->packed ) && is_array( $package->packed ) ) {
					foreach( $package->packed as $item ) {
						$freight_class = $this->get_freight_class( $item->get_meta( 'data' ));
						if ( $freight_class > $highest_freight_class ) {
							$highest_freight_class = $freight_class;
						}
					}
				}

				$group['freight_class'] = $highest_freight_class ? $highest_freight_class : '';
			}

			$to_ship[] = $group;
			$group_id++;

		}

		//add pre packed item with the packagee
		if( !empty($pre_packed_contents) ){
			$prepacked_requests = $this->wf_fedex_add_pre_packed_product( $pre_packed_contents, $group_id );
			$to_ship = array_merge($to_ship, $prepacked_requests);
		}

		return $to_ship;
	}
	
	private function weight_based_shipping( $package ){
		if ( ! class_exists( 'WeightPack' ) ) {
			include_once 'weight_pack/class-wf-weight-packing.php';
		}
		
		$weight_pack = new WeightPack($this->weight_pack_process);
		$weight_pack->set_max_weight($this->box_max_weight);
		
		foreach ( $package['contents'] as $item_id => $values ) {
			$weight = null;
			$values['data'] = $this->wf_load_product( $values['data'] );

			if ( ! $values['data']->needs_shipping() ) {
				$this->debug( sprintf( __( 'Product # is virtual. Skipping.', 'wf-shipping-fedex' ), $item_id ), 'error' );
				continue;
			}
			
			$skip_product = apply_filters('wf_shipping_skip_product', false, $values, $package['contents']);
			if($skip_product){
				continue;
			}


			$pre_packed = get_post_meta($values['data']->id , '_wf_fedex_pre_packed_var', 1);
			if( empty( $pre_packed ) ){
				$pre_packed = get_post_meta( ($values['data']->id) , '_wf_fedex_pre_packed', 1);
			}
			$pre_packed = apply_filters('wf_fedex_is_pre_packed',$pre_packed,$values);
			if( !empty($pre_packed) && $pre_packed == 'yes' ){
				$pre_packed_contents[$item_id] = $values;
				$this->debug( sprintf( __( 'Pre Packed product. Skipping the product '.$values['data']->id, 'wf-shipping-fedex' ), $item_id ) );
				continue;
			}
				

			$custom_field_index=1;
			$custom_field = '';
			while($custom_field_index==1 || !empty( $custom_field )){
				if($values['data']->get_type()=='simple'){
					$weight = $custom_field_index == 1 ? $values['data']->get_weight() : get_post_meta( $values['data']->id, '_weight'.$custom_field_index, true );
				}

				if( empty($weight) ){
					$weight = $values['data']->get_weight();
				}

				if( !empty($weight) ){
					$weight_pack->add_item( wc_get_weight( $weight, $this->weight_unit ), $values['data'], $values['quantity'] );
				}else{
					$this->debug( sprintf( __( 'Product # is missing weight. Aborting.', 'wf-shipping-fedex' ), $item_id ), 'error' );
					return;
				}
				$custom_field_index++;
				$custom_field = get_post_meta( $values['data']->id, '_weight'.$custom_field_index, true );
			}
		}		
		
		$pack	=	$weight_pack->pack_items();
		
		$errors	=	$pack->get_errors();
		if( !empty($errors) ){
			//do nothing
			return;
		} else {
			$boxes		=	$pack->get_packed_boxes();
			$unpacked_items	=	$pack->get_unpacked_items();
			
			$to_ship  				= 	array();
			$group_id 				= 	1;		
			$group					= 	array();
			$packed_products		=	array();
			$insured_value			=	0;
			
			
			$packages	=	array_merge( $boxes,	$unpacked_items ); // merge items if unpacked are allowed
			foreach($packages as $package){
				if((sizeof($packages)	==	1) && isset($this->order)){
					$insured_value	=	$this->order->get_total();
				}else{
					$insured_value	=	0;
					foreach($package['items'] as $item){						
						$insured_value			=	$insured_value+$item->get_price();
					}	
				}
				$group = array(
					'GroupNumber'	   => $group_id,
					'GroupPackageCount' => 1,
					'Weight' => array(
						'Value' => $this->round_up($package['weight'],2),
						'Units' => $this->labelapi_weight_unit
					),
					'packed_products' => $package['items']
				);
				$group['InsuredValue'] = array(
					'Amount'   => $insured_value,
					'Currency' => $this->wf_get_fedex_currency()
				);

				$to_ship[] = $group;
			}
		}

		//add pre packed item with the package
		if( !empty($pre_packed_contents) ){
			$prepacked_requests = $this->wf_fedex_add_pre_packed_product( $pre_packed_contents, $group_id );
			$to_ship = array_merge($to_ship, $prepacked_requests);
		}

		return $to_ship;
	}

	public function residential_address_validation( $package ) {
		$residential = $this->residential;

		// Address Validation API only available for production
		if ( $this->production ) {

			// Check if address is residential or commerical
			try {


				$request = array();

				$request['WebAuthenticationDetail'] = array(
					'UserCredential' => array(
						'Key'	  => $this->api_key,
						'Password' => $this->api_pass
					)
				);
				$request['ClientDetail'] = array(
					'AccountNumber' => $this->account_number,
					'MeterNumber'   => $this->meter_number
				);
				$request['TransactionDetail'] = array( 'CustomerTransactionId' => ' *** Address Validation Request v2 from WooCommerce ***' );
				$request['Version'] = array( 'ServiceId' => 'aval', 'Major' => $this->addressvalidationservice_version, 'Intermediate' => '0', 'Minor' => '0' );
				$request['RequestTimestamp'] = date( 'c' );
				$request['Options'] = array(
					'CheckResidentialStatus' => 1,
					'MaximumNumberOfMatches' => 1,
					'StreetAccuracy' => 'LOOSE',
					'DirectionalAccuracy' => 'LOOSE',
					'CompanyNameAccuracy' => 'LOOSE',
					'ConvertToUpperCase' => 1,
					'RecognizeAlternateCityNames' => 1,
					'ReturnParsedElements' => 1
				);
				$request['AddressesToValidate'] = array(
					0 => array(
						'AddressId' => 'WTC',
						'Address' => array(
							'StreetLines' => array( $package['destination']['address'], $package['destination']['address_2'] ),
							'PostalCode'  => $package['destination']['postcode'],
						)
					)
				);
				$client = $this->wf_create_soap_client( plugin_dir_path( dirname( __FILE__ ) ) . 'fedex-wsdl/production/AddressValidationService_v' . $this->addressvalidationservice_version. '.wsdl' );
				if( $this->soap_method == 'nusoap' ){
					$response = $client->call( 'addressValidation', array( 'AddressValidationRequest' => $request ) );
					$response = json_decode( json_encode( $result ), false );
				}else{
					$response = $client->addressValidation( $request );
				}

				if ( WF_FEDEX_ADV_DEBUG_MODE == "on" ) { // Test mode is only for development purpose.
					$xml_request 	= $this->soap_method != 'nusoap' ? $client->__getLastRequest() : $client->request();
					$xml_response 	= $this->soap_method != 'nusoap' ? $client->__getLastResponse() : $client->response();
					
					$this->debug( 'FedEx ADDRESS VALIDATION REQUEST: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;">' . print_r( htmlspecialchars( $xml_request ), true ) . "</pre>\n" );
					$this->debug( 'FedEx ADDRESS VALIDATION RESPONSE: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;">' . print_r( htmlspecialchars( $xml_response ), true ) . "</pre>\n" );
					
				}
			 	$this->debug( 'FedEx ADDRESS VALIDATION REQUEST: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;">' . print_r( $request, true ) . '</pre>' );				
			 	$this->debug( 'FedEx ADDRESS VALIDATION RESPONSE: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;">' . print_r( $response, true ) . '</pre>' );

				if ( $response->HighestSeverity == 'SUCCESS' ) {
					if ( is_array( $response->AddressResults ) )
						$addressResult = $response->AddressResults[0];
					else
						$addressResult = $response->AddressResults;

					if ( $addressResult->ProposedAddressDetails->ResidentialStatus == 'BUSINESS' )
						$residential = false;
					elseif ( $addressResult->ProposedAddressDetails->ResidentialStatus == 'RESIDENTIAL' )
						$residential = true;
				}

			} catch (Exception $e) {
				$this->debug( 'FedEx ADDRESS VALIDATION: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;">' .'An Unexpected error occured while calling API.' . '</pre>' );
				$this->debug( 'FedEx ADDRESS VALIDATION Error Code:'.$e->getMessage().'</pre>' );
			}
		}

		if(isset($_POST['post_data'])){
			parse_str($_POST['post_data'],$str);
			if(isset($str['eha_is_residential'])){
				$residential = true;
			}
		}

		$this->residential = apply_filters( 'woocommerce_fedex_address_type', $residential, $package );

		if ( $this->residential == false ) {
			$this->debug( __( 'Business Address', 'wf-shipping-fedex' ) );
		}
	}

	private function get_origin_address($package){
		$from_address = array(
			'postcode' 	=> $this->origin,
			'country' 	=> $this->origin_country,
		);
		//Filter for origin address switcher plugin.
		$from_address =  apply_filters( 'wf_filter_label_from_address', $from_address , $package );
		return array(
			'PostalCode'	=>	$from_address['postcode'],
			'CountryCode'	=>	$from_address['country']
		);
	}

	private function get_fedex_api_request( $package ) {
		$request = array();
		
		$package_origin	= $this->get_origin_address($package);
		
		//If vendor country set, then use vendor address
		if(isset($package['origin'])){
			if(isset($package['origin']['country'])){
				$package_origin['PostalCode']	=	$package['origin']['postcode'];
				$package_origin['CountryCode']	=	$package['origin']['country'];
			}
		}
		
		// Prepare Shipping Request for FedEx
		$request['WebAuthenticationDetail'] = array(
			'UserCredential' => array(
				'Key'	  => $this->api_key,
				'Password' => $this->api_pass
			)
		);
		$request['ClientDetail'] = array(
			'AccountNumber' => $this->account_number,
			'MeterNumber'   => $this->meter_number
		);
		$request['TransactionDetail'] = array(
			'CustomerTransactionId'	 => ' *** WooCommerce Rate Request ***'
		);
		$request['Version'] = array(
			'ServiceId'			  => 'crs',
			'Major'				  => $this->rateservice_version,
			'Intermediate'		   => '0',
			'Minor'				  => '0'
		);
		$request['ReturnTransitAndCommit'] = true;
		$request['RequestedShipment']['EditRequestType'] = true;
		$request['RequestedShipment']['PreferredCurrency'] = $this->wf_get_fedex_currency();
		$request['RequestedShipment']['DropoffType']	   = 'REGULAR_PICKUP';
		$request['RequestedShipment']['ShipTimestamp']	 = date( 'c' , strtotime( '+1 Weekday' ) );
		$request['RequestedShipment']['PackagingType']	 = $this->packaging_type;
		$request['RequestedShipment']['Shipper']		   = array(
			'Address'			   => array(
				'PostalCode'			  => $package_origin['PostalCode'],
				'CountryCode'			 => $package_origin['CountryCode'],
			)
		);
		$request['RequestedShipment']['ShippingChargesPayment'] = array(
			'PaymentType' => 'SENDER',
			'Payor' => array(
				'ResponsibleParty' => array(
					'AccountNumber'		   => $this->account_number,
					'CountryCode'			 => $this->origin_country
				)
			)
		);
		$request['RequestedShipment']['RateRequestTypes'] = $this->request_type === 'LIST' ? 'LIST' : 'NONE';
		$request['RequestedShipment']['Recipient'] = array(
			'Address' => array(
				'Residential'		 => $this->residential,
				'PostalCode'		  => str_replace( ' ', '', strtoupper( $package['destination']['postcode'] ) ),
				'City'				=> strtoupper( $package['destination']['city'] ),
				'StateOrProvinceCode' => strlen( $package['destination']['state'] ) == 2 ? strtoupper( $package['destination']['state'] ) : '',
				'CountryCode'		 => $package['destination']['country']
			)
		);

		return $request;
	}

	private function get_fedex_requests( $fedex_packages, $package, $request_type = '' ) {
		$requests = array();
		$this->packaging_type = empty($fedex_packages['package_id']) ? 'YOUR_PACKAGING' : $fedex_packages['package_id'];

		// All reguests for this package get this data
		$package_request = $this->get_fedex_api_request( $package );

		if ( $fedex_packages ) {
			// Fedex Supports a Max of 99 per request
			$parcel_chunks = array_chunk( $fedex_packages, 99 );

			foreach ( $parcel_chunks as $parcels ) {
				$request		= $package_request;
				$total_value	= 0;
				$total_packages = 0;
				$total_weight   = 0;
				$commodoties	= array();
				$freight_class  = '';

				// Store parcels as line items
				$request['RequestedShipment']['RequestedPackageLineItems'] = array();

				foreach ( $parcels as $key => $parcel ) {
					$request['RequestedShipment']['PackagingType']  = empty($parcel['package_id']) ? 'YOUR_PACKAGING' : $parcel['package_id'];
					$is_dry_ice_shipment = false;
					$single_package_weight = $parcel['Weight']['Value'];
				
					$parcel_request = $parcel;
					$total_value	+= $parcel['InsuredValue']['Amount'] * $parcel['GroupPackageCount'];
					$total_packages += $parcel['GroupPackageCount'];
					$total_weight   += $parcel['Weight']['Value'] * $parcel['GroupPackageCount'];

					if ( 'freight' === $request_type ) {
						// Get the highest freight class for shipment
						if ( isset( $parcel['freight_class'] ) && $parcel['freight_class'] > $freight_class ) {
							$freight_class = $parcel['freight_class'];
						}
					} else {
						// Work out the commodoties for CA shipments
						if ( $parcel_request['packed_products'] ) {
							
							$dry_ice_total_weight 			= 0;
							$contain_non_standard_product 	= false;

							foreach ( $parcel_request['packed_products'] as $product ) {
								$product = $this->wf_load_product( $product );
								if ( isset( $commodoties[ $product->id ] ) ) {
									$commodoties[ $product->get_id() ]['Quantity'] ++;
									$commodoties[ $product->get_id() ]['CustomsValue']['Amount'] += round( $product->get_price() );
									continue;
								}
								$commodoties[ $product->get_id() ] = array(
									'Name'				 => sanitize_title( $product->get_title() ),
									'NumberOfPieces'	   => 1,
									'Description'		  => '',
									'CountryOfManufacture' => ( $country = get_post_meta( $product->get_id(), '_wf_manufacture_country', true ) ) ? $country : $this->origin_country,
									'Weight'			   => array(
										'Units'			=> $this->labelapi_weight_unit,
										'Value'			=> round( wc_get_weight( $product->get_weight(), $this->weight_unit ), 2 ),
									),
									'Quantity'			 => $parcel['GroupPackageCount'],
									'UnitPrice'			=> array(
										'Amount'		   => round( $product->get_price() ),
										'Currency'		 => $this->wf_get_fedex_currency()
									),
									'CustomsValue'		 => array(
										'Amount'		   => $parcel['InsuredValue']['Amount'] * $parcel['GroupPackageCount'],
										'Currency'		 => $this->wf_get_fedex_currency()
									)
								);

								$is_dry_ice_product = get_post_meta($product->get_id() , '_wf_dry_ice', 1);
								if( $is_dry_ice_product=='yes' ){
									$is_dry_ice_shipment = true;
									$dry_ice_total_weight += wc_get_weight( $product->get_weight(), 'kg' ); //Fedex support dry ice weight in KG only
								}
							}
						}

						// Is this valid for a ONE rate? Smart post does not support it
						if ( $this->fedex_one_rate && '' === $request_type && isset($parcel_request['package_id']) && in_array( $parcel_request['package_id'], $this->fedex_one_rate_package_ids )) {
							$this->packaging_type = $parcel_request['package_id'];
							$request['RequestedShipment']['PackagingType'] = $parcel_request['package_id'];
							
							if('US' === $package['destination']['country'] && 'US' === $this->origin_country){
								$request['RequestedShipment']['SpecialServicesRequested']['SpecialServiceTypes'] = 'FEDEX_ONE_RATE';
							}
						}
					}					

					// Remove temp elements
					unset( $parcel_request['freight_class'] );
					unset( $parcel_request['packed_products'] );
					unset( $parcel_request['package_id'] );

					if ( ! $this->insure_contents || 'smartpost' === $request_type ) {
						unset( $parcel_request['InsuredValue'] );
					}

					$parcel_request = array_merge( array( 'SequenceNumber' => $key + 1 ), $parcel_request );
					
					$SpecialServices = array();
					if(isset($this->signature_option) && !empty($this->signature_option)){
						$signature = array();
						$SpecialServices['SpecialServiceTypes'][] = 'SIGNATURE_OPTION';
						$SpecialServices['SignatureOptionDetail'] = array('OptionType'=>$this->signature_option);
					}
					if( $this->is_dry_ice_enabled && $is_dry_ice_shipment ){
						$SpecialServices['SpecialServiceTypes'][] = 'DRY_ICE';
						$SpecialServices['DryIceWeight'] = array('Units' => 'KG','Value' => round($dry_ice_total_weight,2) );
					}
					
					$non_standard_product = $this->xa_get_custom_product_option_details( $parcel['packed_products'], '_wf_fedex_non_standard_product' );
					if( !empty($non_standard_product) ){
						$SpecialServices['SpecialServiceTypes'][] = 'NON_STANDARD_CONTAINER';
					}
					
					if( !empty($SpecialServices) ){
						$parcel_request = array_merge( array( 'SpecialServicesRequested' => $SpecialServices), $parcel_request );
					}

					//Priority boxed no need dimensions
					if( $this->packaging_type != 'YOUR_PACKAGING' ){
						unset( $parcel_request['Dimensions'] );
					}
					$request['RequestedShipment']['RequestedPackageLineItems'][] = $parcel_request;
				}

				// Size
				$request['RequestedShipment']['PackageCount'] = $total_packages;

				$indicia = $this->indicia;
				
				if($indicia == 'AUTOMATIC' && $single_package_weight >= 1)
					$indicia = 'PARCEL_SELECT';
				elseif($indicia == 'AUTOMATIC' && $single_package_weight < 1)
					$indicia = 'PRESORTED_STANDARD';				
				
				
				// Smart post
				if ( 'smartpost' === $request_type ) {
					$request['RequestedShipment']['SmartPostDetail'] = array(
						'Indicia'			  => $indicia,
						'HubId'				=> $this->smartpost_hub,
						'AncillaryEndorsement' => 'ADDRESS_CORRECTION',
						'SpecialServices'	  => ''
					);
					$request['RequestedShipment']['ServiceType'] = 'SMART_POST';

					// Smart post does not support insurance, but is insured up to $100
					if ( $this->insure_contents && round( $total_value ) > 100 ) {
						return false;
					}
				} elseif ( $this->insure_contents ) {
					$request['RequestedShipment']['TotalInsuredValue'] = array(
						'Amount'   => round( $total_value ),
						'Currency' => $this->wf_get_fedex_currency()
					);
				}

				if ( 'freight' === $request_type ) {
					$request['RequestedShipment']['Shipper'] = array(
						'Address'			   => array(
							'StreetLines'		 => array( strtoupper( $this->frt_shipper_street ), strtoupper( $this->freight_shipper_street_2 ) ),
							'City'				=> strtoupper( $this->freight_shipper_city ),
							'StateOrProvinceCode' => strtoupper( $this->origin_state ),
							'PostalCode'		  => strtoupper( $this->origin ),
							'CountryCode'		 => strtoupper( $this->origin_country ),
							'Residential'		 => $this->freight_shipper_residential
						)
					);
					$request['CarrierCodes'] = 'FXFR';
					$request['RequestedShipment']['FreightShipmentDetail'] = array(
						'FedExFreightAccountNumber'			=> strtoupper( $this->freight_number ),
						'FedExFreightBillingContactAndAddress' => array(
							'Address'							 => array(
								'StreetLines'						=> array( strtoupper( $this->freight_bill_street ), strtoupper( $this->freight_billing_street_2 ) ),
								'City'							   => strtoupper( $this->freight_billing_city ),
								'StateOrProvinceCode'				=> strtoupper( $this->freight_billing_state ),
								'PostalCode'						 => strtoupper( $this->freight_billing_postcode ),
								'CountryCode'						=> strtoupper( $this->freight_billing_country )
							)
						),
						'Role'								 => 'SHIPPER',
						'PaymentType'						  => 'PREPAID', 
					);
					foreach ($request['RequestedShipment']['RequestedPackageLineItems'] as $key => $item) {
						if( max(array_map( array($this,'dimensions_in_inches'), array($item['Dimensions']['Length'], $item['Dimensions']['Width'], $item['Dimensions']['Height']) ) )  > 180 ){
							$request['RequestedShipment']['FreightShipmentDetail']['SpecialServicePayments'] = array('SpecialService'=>'EXTREME_LENGTH');
							break;
						}
					} 



					// Format freight class
					$freight_class = $freight_class ? $freight_class : $this->freight_class;
					$freight_class = $freight_class < 100 ?  '0' . $freight_class : $freight_class;
					$freight_class = 'CLASS_' . str_replace( '.', '_', $freight_class );

					$request['RequestedShipment']['FreightShipmentDetail']['LineItems'] = array(
						'FreightClass' => $freight_class,
						'Packaging'	=> 'SKID',
						'Weight'	   => array(
							'Units'	=> $this->labelapi_weight_unit,
							'Value'	=> round( $total_weight, 2 )
						)
					);
					$request['RequestedShipment']['ShippingChargesPayment'] = array(
						'PaymentType' => 'SENDER',
						'Payor' => array(
							'ResponsibleParty' => array(
								'AccountNumber'		   => strtoupper( $this->freight_number ),
								'CountryCode'			 => $this->origin_country,
							)
						)
					);
				} else {
					$core_countries = array('US','CA');
					if ( $this->origin_country !== $package['destination']['country'] || !in_array( $this->origin_country,$core_countries ) ) {
						$request['RequestedShipment']['CustomsClearanceDetail']['DutiesPayment'] = array(
							'PaymentType' => $this->customs_duties_payer,
						);
						if($this->customs_duties_payer!='RECIPIENT'){
							$request['RequestedShipment']['CustomsClearanceDetail']['DutiesPayment']['Payor']['ResponsibleParty'] = array(
								'AccountNumber'		   => strtoupper( $this->account_number ),
								'CountryCode'			 => $this->origin_country,
							);
						}
						

						// Delivery Time is not showing if Commodity details given invalid (Like HST).
						// Commodities node is not mandatory for rate request.
						if( !$this->delivery_time ){
							$request['RequestedShipment']['CustomsClearanceDetail']['Commodities'] = array_values( $commodoties );
						}

						if( !in_array( $this->origin_country, $core_countries ) ){
							$request['RequestedShipment']['CustomsClearanceDetail']['CommercialInvoice'] = array(
								'Purpose' => 'SOLD'
							);
							$request['RequestedShipment']['CustomsClearanceDetail']['CustomsValue'] = array(
								'Currency'	=>  $this->wf_get_fedex_currency(),
								'Amount'	=>  $total_value
							);
						}
					}
				}
				// Add request
				$requests[] = $request;
			}
		}
		return $requests;
	}

	/**
	* return details of FedEx custome field in product page (Eg: Dangerous Goods).
	* Return array of product ids and product option value
	*/
	private function xa_get_custom_product_option_details( $packed_products, $option_mame ){
		$products_with_value = array();
		foreach ( $packed_products as $product ) {
			$option = get_post_meta( $product->get_id() , $option_mame, 1 );
			if( !empty($option) && $option != 'no' ){
				$products_with_value[ $product->get_id() ] = $option;
			}
		}
		return $products_with_value;
	}

	private function dimensions_in_inches($value){
		if( !is_numeric($value) )
			return $value;
		if( $this->dimension_unit == 'in' )
			return $value;
		return $value * 0.393701;
	}

	public function calculate_shipping( $package = array() ) {
		// Clear rates
		$this->found_rates = array();

		// Debugging
		$this->debug( __( 'FEDEX debug mode is on - to hide these messages, turn debug mode off in the settings.', 'wf-shipping-fedex' ) );

		// See if address is residential
		$this->residential_address_validation( $package );
		
		$packages = apply_filters('wf_filter_package_address', array($package) , $this->ship_from_address);
		
		
		// Get requests
		$fedex_packages	=	array();
		$fedex_requests	=	array();
		foreach($packages as $package){
			$fedex_packs	=	$this->get_fedex_packages( $package );
			$fedex_reqs		=	$this->get_fedex_requests( $fedex_packs, $package );
			if(is_array($fedex_packs)){
				$fedex_packages	=	array_merge($fedex_packages,	$fedex_packs);
			}
			if(is_array($fedex_reqs)){
				$fedex_requests	=	array_merge($fedex_requests,	$fedex_reqs);
			}
		}
		$fedex_requests = apply_filters('wf_fedex_calculate_shipping_request',$fedex_requests,$fedex_packages);

		if ( $fedex_requests ) {
			$this->run_package_request( $fedex_requests );
		}

		if ( ! empty( $this->custom_services['SMART_POST']['enabled'] ) && ! empty( $this->smartpost_hub ) && $package['destination']['country'] == 'US' && ( $smartpost_requests = $this->get_fedex_requests( $fedex_packages, $package, 'smartpost' ) ) ) {
			$this->run_package_request( $smartpost_requests );
		}

		if ( $this->freight_enabled && ( $freight_requests = $this->get_fedex_requests( $fedex_packages, $package, 'freight' ) ) ) {
			$this->run_package_request( $freight_requests );
		}

		// Ensure rates were found for all packages
		$packages_to_quote_count = sizeof( $fedex_requests );

		if ( $this->found_rates ) {
			foreach ( $this->found_rates as $key => $value ) {
				if ( $value['packages'] < $packages_to_quote_count ) {
					unset( $this->found_rates[ $key ] );
				}
			}
		}

		$this->add_found_rates();		
	}

	public function wf_add_delivery_time( $label, $method ) {
		if(!$this->delivery_time) {
			return $label;
		}

		if( !is_object($method) ){
			return $label;
		}
		
		$est_delivery = $method->get_meta_data();
		if( !empty($est_delivery['fedex_delivery_time']) && strpos( $label, 'Est delivery' ) == false ){
			$est_delivery_html = "<br /><small>".__('Est delivery: ', 'wf-shipping-fedex'). $est_delivery['fedex_delivery_time'].'</small>';
			$est_delivery_html = apply_filters( 'wf_fedex_estimated_delivery', $est_delivery_html, $est_delivery );
			$label .= $est_delivery_html;
		}
		return $label;
	}

	public function run_package_request( $requests ) {
		try {
			foreach ( $requests as $key => $request ) {
				$this->process_result( $this->get_result( $request ) );
			}
		} catch ( Exception $e ) {
			$this->debug( print_r( $e, true ), 'error' );
			return false;
		}
	}

	private function wf_create_soap_client( $wsdl ){
		if( $this->soap_method=='nusoap' ){
			$soapclient = new nusoap_client( $wsdl, 'wsdl' );
		}else{
			$soapclient = new SoapClient( $wsdl, 
				array(
					'trace' =>	true
				)
			);
		}
		return $soapclient;
	}

	private function get_result( $request ) {
		$client = $this->wf_create_soap_client( plugin_dir_path( dirname( __FILE__ ) ) . 'fedex-wsdl/' . ( $this->production ? 'production' : 'test' ) . '/RateService_v' . $this->rateservice_version. '.wsdl' );

		if( $this->soap_method == 'nusoap' ){
			$result = $client->call( 'getRates', array( 'RateRequest' => $request ) );
			$result = json_decode( json_encode( $result ), false );
		}
		else{
			$result = $client->getRates( $request );
		}
		$this->debug( 'FedEx REQUEST: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;">' . print_r( $request, true ) . '</pre>' );
		$this->debug( 'FedEx RESPONSE: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;">' . print_r( $result, true ) . '</pre>' );

		if ( WF_FEDEX_ADV_DEBUG_MODE == "on" ) { // Test mode is only for development purpose.
			$xml_request 	= $this->soap_method != 'nusoap' ? $client->__getLastRequest() : $client->request();
			$xml_response 	= $this->soap_method != 'nusoap' ? $client->__getLastResponse() : $client->response();
			
			$this->debug( 'FedEx  REQUEST in XML Format: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;">' . print_r( htmlspecialchars( $xml_request ), true ) . "</pre>\n" );
			$this->debug( 'FedEx RESPONSE in XML Format: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;">' . print_r( htmlspecialchars( $xml_response ), true ) . "</pre>\n" );
		}


		wc_enqueue_js( "
			jQuery('a.debug_reveal').on('click', function(){
				jQuery(this).closest('div').find('.debug_info').slideDown();
				jQuery(this).remove();
				return false;
			});
			jQuery('pre.debug_info').hide();
		" );

		return $result;
	}

	private function process_result( $result = '' ) {
		if ( $result && ! empty ( $result->RateReplyDetails ) ) {

			$rate_reply_details = $result->RateReplyDetails;

			// Workaround for when an object is returned instead of array
			if ( is_object( $rate_reply_details ) && isset( $rate_reply_details->ServiceType ) )
				$rate_reply_details = array( $rate_reply_details );

			if ( ! is_array( $rate_reply_details ) )
				return false;

			foreach ( $rate_reply_details as $quote ) {
				
				$is_skip = apply_filters( 'wf_skip_fedex_shipping_method', false, $quote );
				if( $is_skip ){
					continue;
				}
				
				if ( is_array( $quote->RatedShipmentDetails ) ) {

					if ( $this->request_type == "LIST" ) {
						// LIST quotes return both ACCOUNT rates (in RatedShipmentDetails[1])
						// and LIST rates (in RatedShipmentDetails[3])
						foreach ( $quote->RatedShipmentDetails as $i => $d ) {
							if ( strstr( $d->ShipmentRateDetail->RateType, 'PAYOR_LIST' ) ) {
								$details = $quote->RatedShipmentDetails[ $i ];
								break;
							}
						}
					} else {
						// ACCOUNT quotes may return either ACCOUNT rates only OR
						// ACCOUNT rates and LIST rates.
						foreach ( $quote->RatedShipmentDetails as $i => $d ) {
							if ( strstr( $d->ShipmentRateDetail->RateType, 'PAYOR_ACCOUNT' ) ) {
								$details = $quote->RatedShipmentDetails[ $i ];
								break;
							}
						}
					}

				} else {
					$details = $quote->RatedShipmentDetails;
				}

				if ( empty( $details ) )
					continue;

				$rate_name = strval( $this->services[ $quote->ServiceType ] );
				$rate_name_extra = '';
				
				if($this->delivery_time) {
					if( !empty($quote->DeliveryTimestamp) ){
						$delivery_time_details =  strtotime( $quote->DeliveryTimestamp );
					}elseif(array_key_exists('DeliveryDayOfWeek',$quote)) {
						$delivery_time_details = strtotime( 'next'.$quote->DeliveryDayOfWeek );

						/*if( date('d', $delivery_time_details - time() ) < 3 ){ 
							$delivery_time_details = strtotime( $quote->DeliveryDayOfWeek.' next week' );
						}*/

					}elseif(array_key_exists('TransitTime',$quote)) {
						$transit_day = strtotime( $this->transit_time[$quote->TransitTime], strtotime( date('Y-m-d H:i:s') ) );
						$delivery_time_details = $transit_day;
					}
					if( !empty($delivery_time_details) ){
						$this->delivery_time_details = date( apply_filters('wf_estimate_delivery_date_format', 'd-m-Y' ), $delivery_time_details );
					}
				}

				$rate_code = strval( $quote->ServiceType );
				$rate_id   = $this->id . ':' . $rate_code;
				$rate_cost = floatval( $details->ShipmentRateDetail->TotalNetCharge->Amount );
				$rate_cost = $this->convert_to_base_currency($details,$rate_cost);
				$this->prepare_rate( $rate_code, $rate_id, $rate_name, $rate_cost, $rate_name_extra );
			}
		}
	}
	
	private function convert_to_base_currency($details,$rate_cost){
		$converted_rate = $rate_cost;
		if($this->convert_currency_to_base == 'yes'){
			if(property_exists($details->ShipmentRateDetail,'CurrencyExchangeRate')){
				$from_currency = $details->ShipmentRateDetail->CurrencyExchangeRate->FromCurrency;
				$convertion_rate = floatval( $details->ShipmentRateDetail->CurrencyExchangeRate->Rate);
				if( $from_currency == $this->wf_get_fedex_currency() && $convertion_rate > 0 ){
					$converted_rate = $converted_rate/$convertion_rate;
				}			
			}
		}
		return $converted_rate;		
	}

	private function prepare_rate( $rate_code, $rate_id, $rate_name, $rate_cost, $rate_name_extra='' ) {

		// Name adjustment
		if ( ! empty( $this->custom_services[ $rate_code ]['name'] ) ) {
			$rate_name = $this->custom_services[ $rate_code ]['name'] . $rate_name_extra;
		}

		// Cost adjustment %
		if ( ! empty( $this->custom_services[ $rate_code ]['adjustment_percent'] ) ) {
			$rate_cost = $rate_cost + ( $rate_cost * ( floatval( $this->custom_services[ $rate_code ]['adjustment_percent'] ) / 100 ) );
		}
		// Cost adjustment
		if ( ! empty( $this->custom_services[ $rate_code ]['adjustment'] ) ) {
			$rate_cost = $rate_cost + floatval( $this->custom_services[ $rate_code ]['adjustment'] );
		}

		// Enabled check
		if ( isset( $this->custom_services[ $rate_code ] ) && empty( $this->custom_services[ $rate_code ]['enabled'] ) ) {
			return;
		}

		// Merging
		if ( isset( $this->found_rates[ $rate_id ] ) ) {
			$rate_cost = $rate_cost + $this->found_rates[ $rate_id ]['cost'];
			$packages  = 1 + $this->found_rates[ $rate_id ]['packages'];
		} else {
			$packages  = 1;
		}

		// Sort
		if ( isset( $this->custom_services[ $rate_code ]['order'] ) ) {
			$sort = $this->custom_services[ $rate_code ]['order'];
		} else {
			$sort = 999;
		}

		$this->found_rates[ $rate_id ] = array(
			'id'	   => $rate_id,
			'label'	=> $rate_name,
			'cost'	 => $rate_cost,
			'sort'	 => $sort,
			'packages' => $packages,
			'meta_data' => array( 'fedex_delivery_time' => $this->delivery_time_details ),
		);
	}

	public function add_found_rates() {
		if ( $this->found_rates ) {
			
			if( $this->conversion_rate ) {
				foreach ( $this->found_rates as $key => $rate ) {
					$this->found_rates[ $key ][ 'cost' ] = $rate[ 'cost' ] * $this->conversion_rate;
				}
			}

			if ( $this->offer_rates == 'all' ) {

				uasort( $this->found_rates, array( $this, 'sort_rates' ) );

				foreach ( $this->found_rates as $key => $rate ) {
					$this->add_rate( $rate );
				}
			} else {
				$cheapest_rate = '';

				foreach ( $this->found_rates as $key => $rate ) {
					if ( ! $cheapest_rate || $cheapest_rate['cost'] > $rate['cost'] ) {
						$cheapest_rate = $rate;
					}
				}

				$cheapest_rate['label'] = $this->title;

				$this->add_rate( $cheapest_rate );
			}
		}
	}

	public function sort_rates( $a, $b ) {
		if ( $a['sort'] == $b['sort'] ) return 0;
		return ( $a['sort'] < $b['sort'] ) ? -1 : 1;
	}

	private function wf_load_product( $product ){
		if( !$product ){
			return false;
		}
		if( !class_exists('wf_product') ){
			include_once('class-wf-legacy.php');
		}
		if($product instanceof wf_product){
			return $product;
		}
		return ( WC()->version < '2.7.0' ) ? $product : new wf_product( $product );
	}
}
