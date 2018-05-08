<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class wf_fedex_woocommerce_shipping_admin_helper  {
	private $service_code;

	public function __construct() {
		$this->id                                   = WF_Fedex_ID;
		$this->rateservice_version                  = 22;
		$this->ship_service_version                 = 21;
		$this->pickup_service_version               = 15;
		$this->addressvalidationservice_version     = 2;
        $this->tracking_ids                         = '';
		$this->init();
	}

	private function init() {		
		$this->settings = get_option( 'woocommerce_'.WF_Fedex_ID.'_settings', null );
		$this->is_international = false;
		$this->fed_req	=	new	wfFedexRequest();

		$this->soap_method = $this->is_soap_available() ? 'soap' : 'nusoap';
		if( $this->soap_method == 'nusoap' && !class_exists('nusoap_client') ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/nusoap/lib/nusoap.php';
		}
		
		//TODO:
		$this->weight_dimensions_manual = isset($this->settings['manual_wgt_dimensions']) ? $this->settings['manual_wgt_dimensions'] : 'no';
		
		$this->add_trackingpin_shipmentid = $this->settings['tracking_shipmentid'];
		
		
		$this->origin          = str_replace( ' ', '', strtoupper( $this->settings[ 'origin' ] ) ); //Post code


		$this->account_number  = $this->settings[ 'account_number' ];
		$this->meter_number    = $this->settings[ 'meter_number' ];
		$this->smartpost_hub   = $this->settings[ 'smartpost_hub' ];
		
		$this->indicia = isset($this->settings[ 'indicia']) ? $this->settings[ 'indicia'] : 'PARCEL_SELECT';

		$this->api_key         			= $this->settings[ 'api_key' ];
		$this->api_pass        			= $this->settings[ 'api_pass' ];
		$this->ship_from_address 		= isset($this->settings['ship_from_address'])? $this->settings['ship_from_address'] : 'origin_address';
		$this->production      			= ( $bool = $this->settings[ 'production' ] ) && $bool == 'yes' ? true : false;
		$this->debug           			= ( $bool = $this->settings[ 'debug' ] ) && $bool == 'yes' ? true : false;
		$this->insure_contents 			= ( $bool = $this->settings[ 'insure_contents' ] ) && $bool == 'yes' ? true : false;
		$this->insure_contents 			= ($this->ship_from_address == 'origin_address') ? $this->insure_contents : false;
		$this->request_type    			= $this->settings[ 'request_type'];
		
		$this->packing_method 			= $this->settings[ 'packing_method'];
		$this->boxes           			= $this->settings[ 'boxes'];
		$this->custom_services			= $this->settings[ 'services'];
		$this->offer_rates     			= $this->settings[ 'offer_rates'];
		$this->residential     			= ( $bool = $this->settings[ 'residential'] ) && $bool == 'yes' ? true : false;
		$this->freight_enabled 			= ( $bool = $this->settings[ 'freight_enabled'] ) && $bool == 'yes' ? true : false;
		$this->fedex_one_rate  			= ( $bool = $this->settings[ 'fedex_one_rate'] ) && $bool == 'yes' ? true : false;
		$this->fedex_one_rate_package_ids = array(
			'FEDEX_SMALL_BOX',
			'FEDEX_MEDIUM_BOX',
			'FEDEX_LARGE_BOX',
			'FEDEX_EXTRA_LARGE_BOX',
			'FEDEX_PAK',
			'FEDEX_ENVELOPE',
		);
		
		$this->box_max_weight				=	$this->settings[ 'box_max_weight'];
		$this->weight_pack_process			=	$this->settings[ 'weight_pack_process'];
		
		if(isset($this->settings['dimension_weight_unit']) && $this->settings['dimension_weight_unit'] == 'LBS_IN'){
			$this->dimension_unit 			= 	'in';
			$this->weight_unit 				= 	'lbs';
			$this->labelapi_dimension_unit	=	'IN';
			$this->labelapi_weight_unit 	=	'LB';
			$this->default_boxes                    = include( 'data-wf-box-sizes.php' );
		}else{
			$this->dimension_unit 			= 	'cm';
			$this->weight_unit 				= 	'kg';
			$this->labelapi_dimension_unit	=	'CM';
			$this->labelapi_weight_unit 	=	'KG';
			$this->default_boxes                    = include( 'data-wf-box-sizes-cm.php' );
		}
			
		$this->freight_class               = $this->settings[ 'freight_class' ];
		$this->freight_number              = $this->settings[ 'freight_number'];
		$this->freight_bill_street         = $this->settings[ 'freight_bill_street' ];
		$this->freight_billing_street_2    = $this->settings[ 'billing_street_2' ];
		$this->freight_billing_city        = $this->settings[ 'freight_billing_city' ];
		$this->freight_billing_state       = $this->settings[ 'freight_billing_state' ];
		$this->freight_billing_postcode    = $this->settings[ 'billing_postcode' ];
		$this->freight_billing_country     = $this->settings[ 'billing_country' ];
		
		$this->freight_shipper_person_name = $this->settings[ 'shipper_person_name' ];
		$this->freight_shipper_company_name= $this->settings[ 'shipper_company_name' ];
		$this->freight_shipper_phone_number= $this->settings[ 'shipper_phone_number' ];
		
		$this->frt_shipper_street      	   = $this->settings[ 'frt_shipper_street' ];
		$this->freight_shipper_street_2    = $this->settings[ 'shipper_street_2'];
		$this->freight_shipper_city        = $this->settings[ 'freight_shipper_city' ];
		$this->freight_shipper_residential = ( $bool = $this->settings[ 'shipper_residential'] ) && $bool == 'yes' ? true : false;
		$this->freight_class               = str_replace( array( 'CLASS_', '.' ), array( '', '_' ), $this->freight_class );
	
		$this->output_format				= $this->settings['output_format'];
		$this->image_type					= $this->settings['image_type'];
        $this->commercial_invoice 			= (isset($this->settings['commercial_invoice']) && ($this->settings['commercial_invoice'] == 'yes')) ? true : false;
        $this->cod_collection_type 			= isset($this->settings[ 'cod_collection_type']) ? $this->settings[ 'cod_collection_type'] : 'ANY';

		
		$this->charges_payment_type 		= isset ( $this->settings['charges_payment_type'] ) ? $this->settings['charges_payment_type'] : '';
		$this->shipping_payor_acc_no		= isset ( $this->settings['shipping_payor_acc_no'] ) ? $this->settings['shipping_payor_acc_no'] : '';
		$this->shipping_payor_cname			= isset ( $this->settings['shipping_payor_cname'] ) ? $this->settings['shipping_payor_cname'] : '';
		$this->shipp_payor_company		 	= isset ( $this->settings['shipp_payor_company'] ) ? $this->settings['shipp_payor_company'] : '';
		$this->shipping_payor_phone			= isset ( $this->settings['shipping_payor_phone'] ) ? $this->settings['shipping_payor_phone'] : '';
		$this->shipping_payor_email			= isset ( $this->settings['shipping_payor_email'] ) ? $this->settings['shipping_payor_email'] : '';
		$this->shipp_payor_address1		 	= isset ( $this->settings['shipp_payor_address1'] ) ? $this->settings['shipp_payor_address1'] : '';
		$this->shipp_payor_address2		 	= isset ( $this->settings['shipp_payor_address2'] ) ? $this->settings['shipp_payor_address2'] : '';
		$this->shipping_payor_city			= isset ( $this->settings['shipping_payor_city'] ) ? $this->settings['shipping_payor_city'] : '';
		$this->shipping_payor_state			= isset ( $this->settings['shipping_payor_state'] ) ? $this->settings['shipping_payor_state'] : '';
		$this->shipping_payor_zip	 		= isset ( $this->settings['shipping_payor_zip'] ) ? $this->settings['shipping_payor_zip'] : '';
		$this->shipp_payor_country		 	= isset ( $this->settings['shipp_payor_country'] ) ? $this->settings['shipp_payor_country'] : '';
		
		$this->customs_duties_payer 		= isset ( $this->settings['customs_duties_payer'] ) ? $this->settings['customs_duties_payer'] : '';
		$this->customs_ship_purpose 		= isset ( $this->settings['customs_ship_purpose'] ) ? $this->settings['customs_ship_purpose'] : '';
        
        $this->email_notification 	= isset ( $this->settings['email_notification'] ) ? $this->settings['email_notification'] : false;
		$this->shipper_email 		= isset ( $this->settings['shipper_email'] ) ? $this->settings['shipper_email'] : '';
		$this->signature_option 	= isset ( $this->settings['signature_option'] ) ? $this->settings['signature_option'] : '';
		$this->exclude_tax		 	= isset ( $this->settings['exclude_tax'] ) && $this->settings['exclude_tax'] == 'yes' ? true : false;
        $this->timezone_offset 		= !empty($this->settings['timezone_offset']) ? intval($this->settings['timezone_offset']) * 60 : 0;
		$this->is_dry_ice_enabled 	= isset( $this->settings['dry_ice_enabled'] ) && $this->settings['dry_ice_enabled'] == 'yes' ? true : false;
		
		$this->dry_ice_shipment 	= false;
		$this->dry_ice_total_weight = 0;

		$this->broker_acc_no 	= isset( $this->settings['broker_acc_no'] ) ? $this->settings['broker_acc_no'] : '';
		$this->broker_name 		= isset( $this->settings['broker_name'] ) ? $this->settings['broker_name'] : '';
		$this->broker_company	= isset( $this->settings['broker_company'] ) ? $this->settings['broker_company'] : '';
		$this->broker_phone 	= isset( $this->settings['broker_phone'] ) ? $this->settings['broker_phone'] : '';
		$this->broker_email 	= isset( $this->settings['broker_email'] ) ? $this->settings['broker_email'] : '';
		$this->broker_address 	= isset( $this->settings['broker_address'] ) ? $this->settings['broker_address'] : '';
		$this->broker_city 		= isset( $this->settings['broker_city'] ) ? $this->settings['broker_city'] : '';
		$this->broker_state 	= isset( $this->settings['broker_state'] ) ? $this->settings['broker_state'] : '';
		$this->broker_zipcode 	= isset( $this->settings['broker_zipcode'] ) ? $this->settings['broker_zipcode'] : '';
		$this->broker_country 	= isset( $this->settings['broker_country'] ) ? $this->settings['broker_country'] : '';
		
		$this->tin_number 	= isset( $this->settings['tin_number'] ) ? $this->settings['tin_number'] : '';

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
		
		$this->shipmentErrorMessage = '';
	}

	private function set_origin_country_state(){
		$origin_country_state 		= isset( $this->settings['origin_country'] ) ? $this->settings['origin_country'] : '';
		if ( strstr( $origin_country_state, ':' ) ) :
			// WF: Following strict php standards.
			$origin_country_state_array 	= explode(':',$origin_country_state);
			$origin_country 				= current($origin_country_state_array);
			$origin_country_state_array 	= explode(':',$origin_country_state);
			$origin_state   				= end($origin_country_state_array);
		else :
			$origin_country = $origin_country_state;
			$origin_state   = '';
		endif;

		$this->origin_country  	= apply_filters( 'woocommerce_fedex_origin_country_code', $origin_country );
		$this->origin_state 	= !empty($origin_state) ? $origin_state : $this->settings[ 'freight_shipper_state' ];
	}

	private function is_soap_available(){
		if( extension_loaded( 'soap' ) ){
			return true;
		}
		return false;
	}

	public function debug( $message, $type = 'notice' ) {
		if ( $this->debug ) {
			echo( $message);
		}
	}

	public function get_fedex_packages( $package ) {
		switch ( $this->packing_method ) {
			case 'box_packing' :
				return $this->box_shipping( $package );
			break;
			case 'weight_based' :
				return $this->weight_based_shipping( $package );
			break;
			case 'per_item' :
			default :
				return $this->per_item_shipping( $package );
			break;
		}
	}

	public function get_freight_class( $item_data ) {
		if($item_data->variation_id){
			$class	=	get_post_meta( $item_data->variation_id, '_wf_freight_class', true );
		}
		
		if(!$class)
			$class	=	get_post_meta( $item_data->id, '_wf_freight_class', true );
		
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
			$values['data'] = $this->wf_load_product( $this->xa_get_product( $values ) );
			
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
				'GroupNumber'       => $group_id,
				'GroupPackageCount' => 1,
				'Weight' => array(
					'Value' => $this->round_up( wc_get_weight( $values['data']->get_weight(), $this->weight_unit ), 2 ) ,
					'Units' => $this->labelapi_weight_unit
				),
				'packed_products' => array( $values['data'] )
			);

			if ( $values['data']->length && $values['data']->height && $values['data']->width ) {

				$dimensions = array( $values['data']->length, $values['data']->width, $values['data']->height );

				sort( $dimensions );

				$group['Dimensions'] = array(
					'Length' => max( 1, round( wc_get_dimension( $dimensions[2], $this->dimension_unit ), 0 ) ),
					'Width'  => max( 1, round( wc_get_dimension( $dimensions[1], $this->dimension_unit ), 0 ) ),
					'Height' => max( 1, round( wc_get_dimension( $dimensions[0], $this->dimension_unit ), 0 ) ),
					'Units'  => $this->labelapi_dimension_unit
				);
			}

			$group['InsuredValue'] = array(
				'Amount'   => round( $this->get_product_price($values['data']) ),
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
				for($loop = 0; $loop < $values['quantity'];$loop++){
					$to_ship[] = $group;
				}
				$group_id++;
			}
			
		}
		return $to_ship;
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
			$values['data'] = $this->wf_load_product( $this->xa_get_product( $values ) );

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

			//custom_field_index for 'wf-add-more-shipping-fileds-addon' plugin
			$custom_field_index = 1;
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
							$this->get_product_price($values['data']),
							array(
								'data' => $values['data']
							)
						);
					}
	
				} else {
					$this->debug( sprintf( __( 'Product #%s is missing weight or dimensions. Aborting.', 'wf-shipping-fedex' ), $item_id ), 'error' );
					return;
				}
				$custom_field_index++;
				$custom_field = get_post_meta( $values['data']->id, '_weight'.$custom_field_index, true );
			}

		}

		// Pack it
		$boxpack->pack();
		$packages = $boxpack->get_packages();
		$group_id = 1;
		
		$to_ship = array();
		if( !empty($packages) ){
			$to_ship  = array_merge( $to_ship, $this->xa_get_box_packages( $packages, $group_id ) );
			$group_id += count( $to_ship );
		}

		//add pre packed wf_fedex_add_pre_packed_productitem with the packages
		if( !empty($pre_packed_contents) ){
			$prepacked_requests = $this->wf_fedex_add_pre_packed_product( $pre_packed_contents, $group_id );
			$to_ship = array_merge($to_ship, $prepacked_requests);
		}

		return $to_ship;
	}

	private function xa_get_box_packages( $packages, $group_id=1 ){
		$to_ship  = array();
		foreach ( $packages as $package ) {
			$dimensions = array( $package->length, $package->width, $package->height );

			sort( $dimensions );

			$group = array(
				'GroupNumber'       => $group_id,
				'GroupPackageCount' => 1,
				'Weight' => array(
					'Value' => $this->round_up( $package->weight, 2 ) ,
					'Units' => $this->labelapi_weight_unit
				),
				'Dimensions'        => array(
					'Length' => max( 1, round( $dimensions[2], 0 ) ),
					'Width'  => max( 1, round( $dimensions[1], 0 ) ),
					'Height' => max( 1, round( $dimensions[0], 0 ) ),
					'Units'  => $this->labelapi_dimension_unit
				),
				'InsuredValue'      => array(
					'Amount'   => round( $package->value ),
					'Currency' => $this->wf_get_fedex_currency()
				),
				'packed_products' => array(),
				'package_id'      => $package->id
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
		return $to_ship;
	}

	private function xa_get_product($package){
		//Case of Multiple shipping address 
		if( !empty($package['product_id']) ){
			return $package['product_id'];
		}
		return $package['data'];
	}
	
	private function weight_based_shipping( $package ){
		if ( ! class_exists( 'WeightPack' ) ) {
			include_once 'weight_pack/class-wf-weight-packing.php';
		}
		
		$weight_pack=new WeightPack($this->weight_pack_process);
		$weight_pack->set_max_weight($this->box_max_weight);
		foreach ( $package['contents'] as $item_id => $values ) {
			$values['data'] = $this->wf_load_product( $this->xa_get_product( $values ) );
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
			while( $custom_field_index==1 || !empty( $custom_field ) ){
				if($values['data']->get_type()=='simple'){
					$weight = $custom_field_index == 1 ? $values['data']->get_weight() : get_post_meta( $values['data']->id, '_weight'.$custom_field_index, true );
				}

				if( empty($weight) ){
					$weight = $values['data']->get_weight();
				}

				if( !empty($weight) ){
					$weight_pack->add_item( wc_get_weight( $weight, $this->weight_unit ), $values['data'], $values['quantity'] );
				}else{	
					$this->debug( sprintf( __( 'Product #%s is missing weight. Aborting.', 'wf-shipping-fedex' ), $item_id ), 'error' );
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
			
			if(isset($this->order)){
				$order_sub_total	=	$this->order->get_subtotal();
			}
			
			$packages		=	array_merge( $boxes,	$unpacked_items ); // merge items if unpacked are allowed
			$package_count	=	sizeof($packages);
			
			// get all items to pass if item info in box is not distinguished
			$packable_items	=	$weight_pack->get_packable_items();
			$all_items		=	array();
			if(is_array($packable_items)){
				foreach($packable_items as $packable_item){
					$all_items[]	=	$packable_item['data'];
				}
			}
			foreach($packages as $package){
				$insured_value	=	0;
				if(!empty($package['items'])){
					foreach($package['items'] as $item){						
						$insured_value			=	$insured_value+$this->get_product_price($item);
					}
				}else{// If package doesn't have item information then devide order sub total with #no of packages
					if($order_sub_total && $package_count){
						$insured_value	=	$order_sub_total/$package_count;
					}
				}

				$group = array(
					'GroupNumber'       => $group_id,
					'GroupPackageCount' => 1,
					'Weight' => array(
						'Value' => $this->round_up($package['weight']),
						'Units' => $this->labelapi_weight_unit
					),
					'packed_products' => $package['items']?$package['items']:$all_items
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

	private function wf_fedex_add_pre_packed_product( $pre_packed_items, $group_id=1 ){
		 $to_ship  = array();
		 // Get weight of order
		 foreach ( $pre_packed_items as $item_id => $values ) {
			$values['data'] = $this->wf_load_product( $this->xa_get_product( $values ) );
		 	
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
		 		'GroupNumber'       => $group_id,
		 		'GroupPackageCount' => 1,
		 		'Weight' => array(
		 			'Value' => $this->round_up( wc_get_weight( $values['data']->get_weight(), $this->weight_unit ), 2 ) ,
		 			'Units' => $this->labelapi_weight_unit
		 		),
		 		'packed_products' => array( $values['data'] )
		 	);

		 	$dimensions = array( $values['data']->get_length(), $values['data']->get_width(), $values['data']->get_height() );
		 	if ( $dimensions[0] && $dimensions[1] && $dimensions[2] ) {
		 		sort( $dimensions );

		 		$group['Dimensions'] = array(
		 			'Length' => max( 1, round( wc_get_dimension( $dimensions[2], $this->dimension_unit ), 0 ) ),
		 			'Width'  => max( 1, round( wc_get_dimension( $dimensions[1], $this->dimension_unit ), 0 ) ),
		 			'Height' => max( 1, round( wc_get_dimension( $dimensions[0], $this->dimension_unit ), 0 ) ),
		 			'Units'  => $this->labelapi_dimension_unit
		 		);
		 	}

		 	$group['InsuredValue'] = array(
		 		'Amount'   => round( $this->get_product_price($values['data']) ),
		 		'Currency' => $this->wf_get_fedex_currency()
		 	);
		 	

		 	$custom_field_index=1;
		 	$custom_field = '';
		 	
		 	while( $custom_field_index==1 || !empty( $custom_field ) ){
		 		if($values['data']->get_type()=='simple'){
		 			$weight = $custom_field_index == 1 ? $values['data']->get_weight() : get_post_meta( $values['data']->id, '_weight'.$custom_field_index, true );
		 		}
		 			
		 		$length = $custom_field_index == 1 ? $values['data']->get_length() : get_post_meta( $values['data']->id, '_length'.$custom_field_index, true );
		 		$width  = $custom_field_index == 1 ? $values['data']->get_width() : get_post_meta( $values['data']->id, '_width'.$custom_field_index, true );
		 		$height = $custom_field_index == 1 ? $values['data']->get_height() : get_post_meta( $values['data']->id, '_height'.$custom_field_index, true );
		 		$dimensions = array( $length, $width  , $height );

		 		if ( $dimensions[0] && $dimensions[1] && $dimensions[2] ) {
		 			sort( $dimensions );
		 
		 			$group['Dimensions'] = array(
		 				'Length' => max( 1, round( wc_get_dimension( $dimensions[2], $this->dimension_unit ), 0 ) ),
		 				'Width'  => max( 1, round( wc_get_dimension( $dimensions[1], $this->dimension_unit ), 0 ) ),
		 				'Height' => max( 1, round( wc_get_dimension( $dimensions[0], $this->dimension_unit ), 0 ) ),
		 				'Units'  => $this->labelapi_dimension_unit
		 			);
		 			$group['Weight']=array(
						'Value' => $this->round_up( wc_get_weight( !empty($weight) ? $weight : $values['data']->get_weight() , $this->weight_unit ), 2 ),
						'Units' => $this->labelapi_weight_unit
					);
		 		}
		 		$custom_field_index++;
		 		$custom_field = get_post_meta( $values['data']->id, '_weight'.$custom_field_index, true );
		 		for($loop = 0; $loop < $values['quantity'];$loop++){
		 			$to_ship[] = $group;
		 		}
		 		$group_id++;
		 	}
		 	
		 }
		 return $to_ship;
	}

	private function round_up( $value, $precision=2 ) { 
	    $pow = pow ( 10, $precision ); 
	    return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 
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

	public function residential_address_validation( $package ) {
		$residential = $this->residential;

		// Address Validation API only available for production
		if ( $this->production ) {

			// Check if address is residential or commerical
			try {
				$request = array();

				$request['WebAuthenticationDetail'] = array(
					'UserCredential' => array(
						'Key'      => $this->api_key,
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
							'StreetLines' => array( $package['destination']['address_1'], $package['destination']['address_2'] ),
							'PostalCode'  => $package['destination']['postcode'],
						)
					)
				);

				$wsdl_dir = plugin_dir_path( dirname( __FILE__ ) ) . 'fedex-wsdl/production/AddressValidationService_v' . $this->addressvalidationservice_version. '.wsdl';
				$client = $this->wf_create_soap_client( $wsdl_dir );

				if( $this->soap_method == 'nusoap' ){
					$response = $client->call( 'addressValidation', array( 'AddressValidationRequest' => $request ) );
					$response = json_decode( json_encode( $result ), false );
				}else{
					$response = $client->addressValidation( $request );
				}

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
                $this->debug( __( 'SoapFault while residential_address_validation.', 'wf-shipping-fedex' ) );
            }

		}

		$this->residential = apply_filters( 'woocommerce_fedex_address_type', $residential, $package );

		if ( $this->residential == false ) {
			$this->debug( __( 'Business Address', 'wf-shipping-fedex' ) );
		}
	}

	private function get_fedex_common_api_request( $request ) {
		// Prepare Shipping Request for FedEx
		$request['WebAuthenticationDetail'] = array(
			'UserCredential' => array(
				'Key'      => $this->api_key,
				'Password' => $this->api_pass
			)
		);
		$request['ClientDetail'] = array(
			'AccountNumber' => $this->account_number,
			'MeterNumber'   => $this->meter_number
		);
		$request['TransactionDetail'] = array(
			'CustomerTransactionId'     => '*** Express Domestic Shipping Request using PHP ***'
		);
		$request['Version'] = array(
			'ServiceId'              => 'ship',
			'Major'                  => $this->ship_service_version,
			'Intermediate'           => '0',
			'Minor'                  => '0'
		);		
		return $request;
	}
	private function wf_add_tin_number($request, $package){	
		$tintype 	= isset( $this->settings['tin_type'] ) ? $this->settings['tin_type'] : 'BUSINESS_STATE';
		$tin_number = isset($package['origin']['tin_number']) ? $package['origin']['tin_number'] : $this->tin_number;

		if(!empty($tin_number)){
			$request['RequestedShipment']['Shipper']['Tins'] =  array(
				'TinType'	=> $tintype,
				'Number'	=> $tin_number
			);
		}
        return $request;
    }

	private function get_fedex_api_request( $fedex_packages, $package ,$request_type) {
		$request = array();

		$request = $this->get_fedex_common_api_request($request);
		$this->packaging_type = empty($fedex_packages['package_id']) ? 'YOUR_PACKAGING' : $fedex_packages['package_id'];

		//$request['ReturnTransitAndCommit'] = false;
		$request['RequestedShipment']['PreferredCurrency']	= $this->wf_get_fedex_currency();
		$request['RequestedShipment']['DropoffType']		= 'REGULAR_PICKUP';
		$request['RequestedShipment']['ServiceType']		= $this->service_code;
		$request['RequestedShipment']['ShipTimestamp']		= date( 'c', ( current_time('timestamp') + $this->timezone_offset ) );
		$request['RequestedShipment']['PackagingType']		= $this->packaging_type;

        if($this->ship_from_address === 'shipping_address'){
            $from_address =  $this->order_address($package);
            $to_address   =  $this->shop_address( $package );
        }else {
            $from_address =  $this->shop_address( $package );
            $to_address   =  $this->order_address($package);
        }
                
		$request['RequestedShipment']['Shipper'] = $from_address;
		$request = $this->wf_add_tin_number($request, $package);
		
		$this->fed_req->set_package( $package );
		$shipping_charges_payment	=	$this->fed_req->get_shipping_charges_payment( $request_type );		
		$request['RequestedShipment']['ShippingChargesPayment'] = $shipping_charges_payment;
		  
		$request['RequestedShipment']['RateRequestTypes'] = $this->request_type === 'LIST' ? 'LIST' : 'NONE';
		$request['RequestedShipment']['Recipient'] = $to_address;
		if ( 'freight' === $request_type ){
			$request['RequestedShipment']['LabelSpecification'] = array(
				'LabelFormatType' => 'VICS_BILL_OF_LADING',
				'ImageType' => strtoupper($this->image_type),  // valid values DPL, EPL2, PDF, ZPLII and PNG
				'LabelStockType' => $this->output_format
			);
		}
		else{
			$request['RequestedShipment']['LabelSpecification'] = array(
				'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
				'ImageType' => strtoupper($this->image_type),  // valid values DPL, EPL2, PDF, ZPLII and PNG
				'LabelStockType' => $this->output_format
			);
		}		
		return $request;
	}

	private function get_fedex_requests( $fedex_packages, $package, $request_type = '' ) {
		$requests = array();
		global $woocommerce;
		$this->is_international = ($package['destination']['country'] != $this->origin_country ) ? true : false;
		// All reguests for this package get this data
		if ( $fedex_packages ) {
			$total_packages = 0;
			$total_weight   = 0;
			foreach ( $fedex_packages as $key => $parcel ) {
				$total_packages += $parcel['GroupPackageCount'];
				$total_weight   += $parcel['Weight']['Value'] * $parcel['GroupPackageCount'];
			}
			$package_count = 0;
			foreach ( $fedex_packages as $key => $parcel ) {
				$package_request = $this->get_fedex_api_request( $parcel, $package, $request_type );
				$package_count++;
				$parcel_request;
				$single_package_weight = $parcel['Weight']['Value'];
				
				$request        = $package_request;
				if( !empty($parcel['service']) ){
					$request['RequestedShipment']['ServiceType'] = $parcel['service'];
				}
				$parcel_value = $parcel['InsuredValue']['Amount'] * $parcel['GroupPackageCount'];
				
				$request['RequestedShipment']['TotalWeight'] = array(
					'Value' => $total_weight, 
					'Units' => $this->labelapi_weight_unit // valid values LB and KG
				);
				
				$commodoties    = array();
				$freight_class  = '';

				// Store parcels as line items
				$request['RequestedShipment']['RequestedPackageLineItems'] = array();
				
				if($package_count == 1 ) {
					//This function will add all the items in the order to the first package of the order request in order to create commercial invoice as per the api requirement while creating shipment.
					$commodoties = $this->get_package_one_commodoties( $fedex_packages );
					$parcel_request = $parcel;
				} else {
					$parcel_request = $parcel;
					if ( $parcel_request['packed_products'] ) {
						foreach ( $parcel_request['packed_products'] as $product ) {
							
							if ( isset( $commodoties[ $product->id ] ) ) {
								$commodoties[ $product->id ]['Quantity'] ++;
								$commodoties[ $product->id ]['CustomsValue']['Amount'] += round( $this->get_product_price($product) );
								continue;
							}
							$commodoties[ $product->id ] = array(
								'Name'                 => sanitize_title( $product->get_title() ),
								'NumberOfPieces'       => 1,
								'Description'          => sanitize_title( $product->get_title()),
								'CountryOfManufacture' => ( $country = get_post_meta( $product->id, '_wf_manufacture_country', true ) ) ? $country : $this->origin_country,
								'Weight'               => array(
									'Units'            => $this->labelapi_weight_unit,
									'Value'            => round( wc_get_weight( $product->get_weight(), $this->weight_unit ), 2 ) ,
								),
								'Quantity'             => $parcel['GroupPackageCount'],
								'UnitPrice'            => array(
									'Amount'           => round( $this->get_product_price($product) ),
									'Currency'         => $this->wf_get_fedex_currency()
								),
								'CustomsValue'         => array(
									'Amount'           => round( $this->get_product_price($product) ),
									'Currency'         => $this->wf_get_fedex_currency()
								),
								'QuantityUnits' => 'EA'
							);

							$wf_hs_code = get_post_meta($product->id , '_wf_hs_code', 1);
							
							// for backword compatiblity
							if(!$wf_hs_code){
								$product_data = wc_get_product( $product->id  );
								$wf_hs_code = $product_data->get_attribute( 'wf_hs_code' );
							}

							if( !empty($wf_hs_code) ){
								$commodoties[ $product->id ]['HarmonizedCode'] = $wf_hs_code;
							}
						}
					}
				}
				
				if ( 'freight' === $request_type ) {
					// Get the highest freight class for shipment
					if ( isset( $parcel['freight_class'] ) && $parcel['freight_class'] > $freight_class ) {
						$freight_class = $parcel['freight_class'];
					}
				} else {
					// Work out the commodoties for CA shipments
					$special_servicetypes = array();
					
					// Is this valid for a ONE rate? Smart post does not support it
					if ( $this->fedex_one_rate && '' === $request_type && isset($parcel_request['package_id']) && in_array( $parcel_request['package_id'], $this->fedex_one_rate_package_ids ) ) {
						$request['RequestedShipment']['PackagingType'] = $parcel_request['package_id'];
						$this->packaging_type = $parcel_request['package_id'];
						if('US' === $package['destination']['country'] && 'US' === $this->origin_country ){
							$special_servicetypes[] = 'FEDEX_ONE_RATE';
							
						}
					}
					
					if(isset($_GET['cod']) && $_GET['cod'] === 'true'){
						if(isset($this->order)){
							$order_total=$this->order->get_total();
						}
						$special_servicetypes[] = 'COD';
						$request['RequestedShipment']['SpecialServicesRequested']['CodDetail']['CodCollectionAmount']['Currency'] = $this->wf_get_fedex_currency();	
						$request['RequestedShipment']['SpecialServicesRequested']['CodDetail']['CodCollectionAmount']['Amount'] = $order_total?$order_total:$parcel_value;	
						$request['RequestedShipment']['SpecialServicesRequested']['CodDetail']['CollectionType'] =$this->cod_collection_type;							
					}

					//$request['RequestedShipment']['SpecialServicesRequested']['SignatureOptionDetail']['OptionType']='SERVICE_DEFAULT';
					if(isset($_GET['sat_delivery']) && $_GET['sat_delivery'] === 'true'){
						if(isset($this->order)){
							$order_total=$this->order->get_total();
						}
						$special_servicetypes[] = 'SATURDAY_DELIVERY';
					}
					
					$billing_email = $this->order->billing_email;					
					$email_recipients	=	array();					
					switch($this->email_notification){
						case 'CUSTOMER':
							$receipient_customer	= $this->notification_receiver($billing_email,	'RECIPIENT');
							if($receipient_customer){
								$email_recipients[]	=	$receipient_customer;
							}
							break;
							
						case 'SHIPPER':
							$receipient_shipper		= 	$this->notification_receiver($this->shipper_email,	'SHIPPER');
							if($receipient_shipper){
								$email_recipients[]	=	$receipient_shipper;
							}
							break;
							
						case 'BOTH':
							$receipient_customer	= $this->notification_receiver($billing_email,	'RECIPIENT');
							if($receipient_customer){
								$email_recipients[]	=	$receipient_customer;
							}
							$receipient_shipper		= 	$this->notification_receiver($this->shipper_email,	'SHIPPER');
							if($receipient_shipper){
								$email_recipients[]	=	$receipient_shipper;
							}
							break;
							
						default:							
							break;
					}

					if(is_array($email_recipients) && sizeof($email_recipients)>0){
						$special_servicetypes[] = 'EVENT_NOTIFICATION';
						$events_requested	= array(
							'ON_DELIVERY',
							'ON_EXCEPTION',
							'ON_SHIPMENT',
							'ON_TENDER'
						);
						$request['RequestedShipment']['SpecialServicesRequested']['EventNotificationDetail']['EventNotifications']['Role']	= 'SHIPPER';
						$request['RequestedShipment']['SpecialServicesRequested']['EventNotificationDetail']['EventNotifications']['Events']	=  $events_requested;
						$request['RequestedShipment']['SpecialServicesRequested']['EventNotificationDetail']['EventNotifications']['NotificationDetail'] = $email_recipients;
						$request['RequestedShipment']['SpecialServicesRequested']['EventNotificationDetail']['EventNotifications']['FormatSpecification']['NotificationFormatType']	= 'html';
						
					}
					if(!empty($special_servicetypes)){
						$request['RequestedShipment']['SpecialServicesRequested']['SpecialServiceTypes'] = $special_servicetypes;
					}
				}
				
				

				// Remove temp elements
				unset( $parcel_request['freight_class'] );
				unset( $parcel_request['packed_products'] );
				unset( $parcel_request['package_id'] );
				unset( $parcel_request['service'] );

				
				if ( ! $this->insure_contents || 'smartpost' === $request_type ) {
					unset( $parcel_request['InsuredValue'] );
				}				
				if ( 'smartpost' === $request_type ) {
					$request['RequestedShipment']['PackageCount'] = 1;
					$parcel_request = array_merge( array( 'SequenceNumber' => 1 ), $parcel_request );
				
				}else{
					$request['RequestedShipment']['PackageCount'] = $total_packages;
					$parcel_request = array_merge( array( 'SequenceNumber' => $package_count ), $parcel_request );
				}
				if( $this->dry_ice_shipment ){
					$dry_ice = array(
						'DryIceWeight'=> array(
								'Units' => 'KG',
								'Value' => round($this->dry_ice_total_weight, 2)
							),
					);
					$parcel_request = array_merge( array( 'SpecialServicesRequested' => $dry_ice), $parcel_request );
				}
				
				$line_items_special_services	=	array();
				if ( 'smartpost' !== $request_type ){
					if( isset($this->signature_option) && !empty($this->signature_option) ){
						
						$line_items_special_services['SpecialServiceTypes'][]	=	'SIGNATURE_OPTION';
						$line_items_special_services['SignatureOptionDetail']	=	array('OptionType'=>$this->signature_option);
					}
				}
				
				// Dangerous Goods
				$dangerous_goods = $this->xa_get_custom_product_option_details( $parcel['packed_products'], '_dangerous_goods' );
				if( !empty($dangerous_goods) ){
					$line_items_special_services['SpecialServiceTypes'][]	=	'DANGEROUS_GOODS';
					$line_items_special_services['DangerousGoodsDetail']	=	array('Regulation'=>'DOT','Accessibility'=>'INACCESSIBLE');
				}
				
				// Non Standard Products
				$non_standard_product = $this->xa_get_custom_product_option_details( $parcel['packed_products'], '_wf_fedex_non_standard_product' );
				if( !empty($non_standard_product) ){
					$line_items_special_services['SpecialServiceTypes'][] = 'NON_STANDARD_CONTAINER';
				}
				

				if(!empty($line_items_special_services)){
					$parcel_request['SpecialServicesRequested']	=	$line_items_special_services;
				}

				$reff = array();				
				// $reff['CustomerReferences'][] =  array('CustomerReferenceType' => 'P_O_NUMBER', 'Value' => '456' );
				$reff['CustomerReferences'][] =  array('CustomerReferenceType' => 'CUSTOMER_REFERENCE', 'Value' => $this->order->get_order_number() );
				// $reff['CustomerReferences'][] =  array('CustomerReferenceType' => 'DEPARTMENT_NUMBER', 'Value' => 'Bill Duties : '.$this->customs_duties_payer );
				$parcel_request += $reff;				
				
				//Priority boxed no need dimensions
				if( $this->packaging_type != 'YOUR_PACKAGING' ){
					unset( $parcel_request['Dimensions'] );
				}
				
				$request['RequestedShipment']['RequestedPackageLineItems'][] = $parcel_request;				
				

				$indicia = $this->indicia;
				
				if($indicia == 'AUTOMATIC' && $single_package_weight >= 1)
					$indicia = 'PARCEL_SELECT';
				elseif($indicia == 'AUTOMATIC' && $single_package_weight < 1)
					$indicia = 'PRESORTED_STANDARD';				
				
				// Smart post
				if ( 'smartpost' === $request_type ) {
					$request['RequestedShipment']['SmartPostDetail'] = array(
						'Indicia'              => $indicia,
						'HubId'                => $this->smartpost_hub,
						'AncillaryEndorsement' => 'ADDRESS_CORRECTION',
						'SpecialServices'      => ''
					);
					
					// Smart post does not support insurance, but is insured up to $100
					if ( $this->insure_contents && round( $parcel_value ) > 100 ) {
						return false;
					}
				} elseif ( $this->insure_contents ) {
					$request['RequestedShipment']['TotalInsuredValue'] = array(
						'Amount'   => round( $parcel_value ),
						'Currency' => $this->wf_get_fedex_currency()
					);
				}
				
				if ( 'freight' === $request_type ) {
					// $request['CarrierCodes'] = 'FXFR';
					$request['RequestedShipment']['FreightShipmentDetail'] = array(
						'Role'                                 	=> 'SHIPPER',
						// 'PaymentType'                       	=> 'PREPAID',
						'TotalHandlingUnits' 					=> 1,
					);

					//if any of dimension value exceed limit 180, Then special service EXTREME_LENGTH need to fill.
					foreach ($request['RequestedShipment']['RequestedPackageLineItems'] as $key => $item) {
						if( !empty($item['Dimensions']) &&  max(array_map( array($this,'dimensions_in_inches'), array($item['Dimensions']['Length'], $item['Dimensions']['Width'], $item['Dimensions']['Height']) ) )  > 180 ){
							$request['RequestedShipment']['FreightShipmentDetail']['SpecialServicePayments'] = array('SpecialService'=>'EXTREME_LENGTH');
							break;
						}
					} 
					if( $this->fed_req->get_charges_payment_type() == 'SENDER' ){
						$request['RequestedShipment']['FreightShipmentDetail']['FedExFreightAccountNumber'] = strtoupper( $this->freight_number );
						$request['RequestedShipment']['FreightShipmentDetail']['FedExFreightBillingContactAndAddress'] =  array(
							'Address'                             => array(
								'StreetLines'                        => array( strtoupper( $this->freight_bill_street ), strtoupper( $this->freight_billing_street_2 ) ),
								'City'                               => strtoupper( $this->freight_billing_city ),
								'StateOrProvinceCode'                => strtoupper( $this->freight_billing_state ),
								'PostalCode'                         => strtoupper( $this->freight_billing_postcode ),
								'CountryCode'                        => strtoupper( $this->freight_billing_country )
							)
						);
					}else{
						$request['RequestedShipment']['FreightShipmentDetail']['AlternateBilling'] = $this->fed_req->get_alternate_address();
						
						$request['RequestedShipment']['ShippingChargesPayment']['PaymentType'] = 'SENDER';
						$request['RequestedShipment']['ShippingChargesPayment']['Payor']['ResponsibleParty']['AccountNumber'] = $this->shipping_payor_acc_no;

						$request['RequestedShipment']['FreightShipmentDetail']['AlternateBilling']['AccountNumber'] = $this->shipping_payor_acc_no;
						
						$request['RequestedShipment']['LabelSpecification'] = array(
			                'LabelFormatType' => 'FEDEX_FREIGHT_STRAIGHT_BILL_OF_LADING',
			                'ImageType' => 'PDF',
			                'LabelStockType' => 'PAPER_LETTER',
			                'CustomerSpecifiedDetail'=>'',
			            );
					}
					

					// Format freight class
					$freight_class = $freight_class ? $freight_class : $this->freight_class;
					$freight_class = $freight_class < 100 ?  '0' . $freight_class : $freight_class;
					$freight_class = 'CLASS_' . str_replace( '.', '_', $freight_class );

					$request['RequestedShipment']['FreightShipmentDetail']['LineItems'] = array(
						'FreightClass' => $freight_class,
						'Packaging'    => 'SKID',
						'Description' => 'Heavy Stuff',
						'Weight'       => array(
							'Units'    => $this->labelapi_weight_unit,
							'Value'    => round( $total_weight, 2 )
						),
						'Pieces' => 1,
					);
				}
				
				$core_countries = array('US','CA');
				if ($this->origin_country !== $package['destination']['country'] || !in_array($this->origin_country,array('US'))) {
					
					$this->customs_duties_payer			= apply_filters('xa_shipping_duties_payer',$this->customs_duties_payer, $package );
					
					$request['RequestedShipment']['CustomsClearanceDetail']['DutiesPayment'] = array(
						'PaymentType' => $this->customs_duties_payer
					);
					

					// If payor is not a recipient then account details is not needed
					if( $this->customs_duties_payer == 'SENDER' ){
						$request['RequestedShipment']['CustomsClearanceDetail']['DutiesPayment']['Payor']['ResponsibleParty']=array(
							'AccountNumber'           => strtoupper( $this->account_number ),
							'CountryCode'             => $this->origin_country
						);
					}elseif( $this->customs_duties_payer == 'THIRD_PARTY' ){
						$request['RequestedShipment']['CustomsClearanceDetail']['DutiesPayment']['PaymentType'] = 'RECIPIENT';

						$require ['CustomsClearanceDetailBrokers']['AccountNumber'] = $this->broker_acc_no;
						$request['RequestedShipment']['SpecialServicesRequested']['SpecialServiceTypes'][] = 'BROKER_SELECT_OPTION';
						$request['RequestedShipment']['CustomsClearanceDetail']['Brokers']['Type'] = 'IMPORT';

						$request['RequestedShipment']['CustomsClearanceDetail']['Brokers']['Broker']['AccountNumber'] = $this->broker_acc_no;
						$request['RequestedShipment']['CustomsClearanceDetail']['Brokers']['Broker']['Contact']['PersonName'] = $this->broker_name;
						$request['RequestedShipment']['CustomsClearanceDetail']['Brokers']['Broker']['Contact']['CompanyName'] = $this->broker_company;
						$request['RequestedShipment']['CustomsClearanceDetail']['Brokers']['Broker']['Contact']['PhoneNumber'] = $this->broker_phone;
						$request['RequestedShipment']['CustomsClearanceDetail']['Brokers']['Broker']['Contact']['EMailAddress'] = $this->broker_email;
						$request['RequestedShipment']['CustomsClearanceDetail']['Brokers']['Broker']['Address']['StreetLines'] = $this->broker_address;
						$request['RequestedShipment']['CustomsClearanceDetail']['Brokers']['Broker']['Address']['City'] = $this->broker_city;
						$request['RequestedShipment']['CustomsClearanceDetail']['Brokers']['Broker']['Address']['StateOrProvinceCode'] = $this->broker_state;
						$request['RequestedShipment']['CustomsClearanceDetail']['Brokers']['Broker']['Address']['PostalCode'] = $this->broker_zipcode;
						$request['RequestedShipment']['CustomsClearanceDetail']['Brokers']['Broker']['Address']['CountryCode'] = $this->broker_country;
					}


					$request['RequestedShipment']['CustomsClearanceDetail']['CustomsValue'] = array('Amount' => $parcel_value, 'Currency' => $this->wf_get_fedex_currency());	
					$request['RequestedShipment']['CustomsClearanceDetail']['Commodities'] = array_values( $commodoties );
					
					if( !in_array($this->origin_country,$core_countries)){
						$request['RequestedShipment']['CustomsClearanceDetail']['CommercialInvoice'] = array(
							'Purpose' => $this->customs_ship_purpose
						);
					}

					if($this->origin_country=='CA'){ //International shipment from CA other than US
						if(isset($this->order->id)&&$this->order->shipping_country!='US'){
							//$request['RequestedShipment']['CustomsClearanceDetail']['ExportDetail']['ExportComplianceStatement']='NOT_REQUIRED';//'AESX20160102123456';
							$request['RequestedShipment']['CustomsClearanceDetail']['ExportDetail']['B13AFilingOption']='NOT_REQUIRED';
						}
					}
				}

				// Add request				
				$request=apply_filters('wf_fedex_request',$request,$this->order);
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

	private function is_refunded_item( $order, $item_id ){
		$qty = 0;
		foreach ( $order->get_refunds() as $refund ) {
			foreach ( $refund->get_items( $item_type ) as $refunded_item ) {
				if ( isset( $refunded_item['product_id'] ) && $refunded_item['product_id'] == $item_id ) {
					$qty += $refunded_item['qty'];
				}
			}
		}
		return $qty * -1;
	}

	public function wf_get_package_from_order($order){
		$this->order_object = $order;
		$orderItems = $order->get_items();
		foreach($orderItems as $orderItem){
			if( $refd_qty = $this->is_refunded_item($order, $orderItem['product_id']) ){
				if( $orderItem['qty'] - $refd_qty <= 0 ){
					continue;
				}
				else{
					$orderItem['qty'] = $orderItem['qty'] - $refd_qty;
				}
			}
			$product_data   = wc_get_product( $orderItem['variation_id'] ? $orderItem['variation_id'] : $orderItem['product_id'] );
			$items[] = array('data' => $product_data , 'quantity' => $orderItem['qty']);
		}
		$package['contents'] = $items;
		$package['destination']['country'] = $order->shipping_country;
		$package['destination']['first_name'] = $order->shipping_first_name;
		$package['destination']['last_name'] = $order->shipping_last_name;
		$package['destination']['company'] = $order->shipping_company;
		$package['destination']['address_1'] = $order->shipping_address_1;
		$package['destination']['address_2'] = $order->shipping_address_2;
		$package['destination']['city'] = $order->shipping_city;
		$package['destination']['state'] = $order->shipping_state;
		$package['destination']['postcode'] = $order->shipping_postcode;
		$packages = apply_filters( 'wf_filter_label_packages', array($package) , $this->ship_from_address, $order->id); //for multivendor
		return $packages;
	}
	
	public function print_label( $order,$service_code,$order_id ){
		$this->order_object = $order;
		$this->pre_service = '';
		$this->order = $this->wf_load_order($order);
		$this->order_id = $order_id;
		$this->service_code = $service_code;

		$packages = array_values($this->wf_get_package_from_order($order));
        
        $stored_packages    = get_post_meta( $order_id, '_wf_fedex_stored_packages', true );
		$stored_packages 	= $this->manual_packages( $stored_packages );

		foreach($stored_packages as $key => $fedex_package){
			$grouped_packages 	= $this->split_shipment_by_services( $fedex_package, $order );
			foreach ($grouped_packages as $group_name => $package) {
				$this->print_label_processor($package, $packages[$key] );
			}
			if( !empty( $this->shipmentErrorMessage) ){
			    $this->shipmentErrorMessage .= "</br>Some error occured for packages $key: ".$this->shipmentErrorMessage;
			}
		}	
	}

	private function split_shipment_by_services($ship_packages, $order){
		foreach ($ship_packages as $key => &$entry) {
		    $splited_array[$entry['service']][$key] = $entry;
		}
		return $splited_array;
	}
	
	private function get_return_request( $shipment_id, $order_id, $serviceCode ){
		$request	= get_post_meta($order_id, 'wf_woo_fedex_request_'.$shipment_id, true);
		
		$request['RequestedShipment']['ServiceType'] 				= $serviceCode;

		$shipper_address = $request['RequestedShipment']['Shipper'];
		$request['RequestedShipment']['Shipper'] 					= $request['RequestedShipment']['Recipient'];
		$request['RequestedShipment']['Recipient']					= $shipper_address;

		$total_weight = 0;
		foreach ($request['RequestedShipment']['RequestedPackageLineItems'] as $key => $item) {
			$request['RequestedShipment']['RequestedPackageLineItems'][$key]['SequenceNumber'] = 1;
			$request['RequestedShipment']['RequestedPackageLineItems'][$key]['GroupNumber'] = 1;
			$total_weight += $item['Weight']['Value'];
		}
		$request['RequestedShipment']['TotalWeight']['Value']		= $total_weight;


		$request['RequestedShipment']['SpecialServicesRequested']['ReturnShipmentDetail']['ReturnType']	= 'PRINT_RETURN_LABEL';
		// $request['RequestedShipment']['SpecialServicesRequested']['ReturnShipmentDetail']['ReturnEMailDetail']['MerchantPhoneNumber']	= '';
		$request['RequestedShipment']['SpecialServicesRequested']['SpecialServiceTypes'][] = 'RETURN_SHIPMENT';
		
		$request['RequestedShipment']['PackageCount'] 				= 1;
		unset($request['RequestedShipment']['RequestedPackageLineItems']['SequenceNumber'] );

		return $request;
	}

	public function print_return_label( $shipment_id, $order_id, $serviceCode ){
		$this->order_id 	= $order_id;
		$this->shipmentId 	= $shipment_id;

		$request = $this->get_return_request($shipment_id, $order_id, $serviceCode);
		$this->process_result( $this->get_result($request), $request );
	}
	
	public function void_shipment( $order_id , $shipment_id, $tracking_completedata){
		$request = array();
		$this->order_id = $order_id;
		$request = $this->get_fedex_common_api_request($request);
		$request['ShipTimestamp'] = date('c');
		$request['TrackingId'] = $tracking_completedata;
		$request['DeletionControl'] = 'DELETE_ONE_PACKAGE'; // Package/Shipment

		
        try {
			
			$wsdl_dir = plugin_dir_path( dirname( __FILE__ ) ) . 'fedex-wsdl/' . ( $this->production ? 'production' : 'test' ) . '/ShipService_v' . $this->ship_service_version. '.wsdl';
			$client = $this->wf_create_soap_client($wsdl_dir );

			if( $this->soap_method == 'nusoap' ){
				$result = $client->call( 'deleteShipment', array( 'DeleteShipmentRequest' => $request ) );
				$result = json_decode( json_encode( $result ), false );
			}else{
				$result = $client->deleteShipment( $request );
			}
			
        } catch (Exception $e) {
            $this->debug( __( 'SoapFault while void_shipment.', 'wf-shipping-fedex' ) );
        }
		
		$this->debug( 'FedEx REQUEST: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;">' . print_r( $request, true ) . '</pre>' );
		$this->debug( 'FedEx RESPONSE: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;">' . print_r( $result, true ) . '</pre>' );


		if ( WF_FEDEX_ADV_DEBUG_MODE == "on" ) { // Test mode is only for development purpose.
			$xml_request 	= $this->soap_method != 'nusoap' ? $client->__getLastRequest() : $client->request();
			$xml_response 	= $this->soap_method != 'nusoap' ? $client->__getLastResponse() : $client->response();
			
			$this->debug( 'FedEx REQUEST in XML Format: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;overflow: auto;">' . print_r( htmlspecialchars( $xml_request ), true ) . "</pre>\n" );
			$this->debug( 'FedEx RESPONSE in XML Format: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;overflow: auto;">' . print_r( htmlspecialchars( $xml_response ), true ) . "</pre>\n" );
		}

		if ( $result->HighestSeverity != 'FAILURE' && $result->HighestSeverity != 'ERROR') {
			add_post_meta($order_id, 'wf_woo_fedex_shipment_void', $shipment_id, false);					 
		}else{
			$shipment_void_errormessage =  $this->result_notifications($result->Notifications, $error_message='');
			update_post_meta($order_id, 'wf_woo_fedex_shipment_void_errormessage', $shipment_void_errormessage);
		}		
	}
	
	public function print_label_processor( $fedex_packages, $package ) {
		
		$this->master_tracking_id = '';
		
		// Debugging
		$this->debug( __( 'FEDEX debug mode is on - to hide these messages, turn debug mode off in the settings.', 'wf-shipping-fedex' ) );

		// See if address is residential
		$this->residential_address_validation( $package );

		$request_type= '';
		if(! empty( $this->smartpost_hub ) && $package['destination']['country'] == 'US' && $this->service_code == 'SMART_POST'){
			$request_type = 'smartpost';
		}elseif(strpos($this->service_code, 'FREIGHT') !== false){
			$request_type = 'freight';
		}
			
		if($this->validate_package($fedex_packages)){
			$fedex_requests   = $this->get_fedex_requests( $fedex_packages, $package, $request_type);
			if ( $fedex_requests ) {
				$this->run_package_request( $fedex_requests );
			}
			$packages_to_quote_count = sizeof( $fedex_requests );
		}
		update_post_meta($this->order_id, 'wf_woo_fedex_shipmentErrorMessage', $this->shipmentErrorMessage);      
	}

	public function manual_packages($packages){
	    if(!isset($_GET['weight'])){
	        return $packages;
	    }
	    
	    $length_arr     =   json_decode(stripslashes(html_entity_decode($_GET["length"])));
	    $width_arr      =   json_decode(stripslashes(html_entity_decode($_GET["width"])));
	    $height_arr     =   json_decode(stripslashes(html_entity_decode($_GET["height"])));
	    $weight_arr     =   json_decode(stripslashes(html_entity_decode($_GET["weight"])));  
	    $service_arr    =   json_decode(stripslashes(html_entity_decode($_GET["service"])));  

		$no_of_package_entered  =   count($weight_arr);
		$no_of_packages = 0;
		foreach ($packages as $key => $package) {
		    $no_of_packages += count($package);
		}
	    
	    // Populate extra packages, if entered manual values
	    if($no_of_package_entered > $no_of_packages){ 
	        $package_clone  =   current($packages[0]); //get first package to clone default data
	        for($i=$no_of_packages; $i<$no_of_package_entered; $i++){
	            $packages[0][$i]   = $package_clone;
	        }
	    }

	    // Overridding package values
	    $i=0;
	    foreach($packages as $package_key => $stored_package){
	    	foreach($stored_package as $key => $package){
		    	if( !empty($length_arr[$i]) || !empty($width_arr[$i]) || !empty($height_arr[$i]) ){
			        if(isset($length_arr[$i])){// If not available in GET then don't overwrite.
			            $packages[$package_key][$key]['Dimensions']['Length'] =  $length_arr[$i];
			        }
			        if(isset($width_arr[$i])){// If not available in GET then don't overwrite.
			            $packages[$package_key][$key]['Dimensions']['Width']  =  $width_arr[$i];
			        }
			        if(isset($height_arr[$i])){// If not available in GET then don't overwrite.
			            $packages[$package_key][$key]['Dimensions']['Height'] = $height_arr[$i];
			        }
			        $packages[$package_key][$key]['Dimensions']['Units']	= $this->labelapi_dimension_unit;
			    }

			    if( !empty($service_arr[$i]) ){
				    $packages[$package_key][$key]['service']  			= $service_arr[$i];
				}

		        if(isset($weight_arr[$i])){// If not available in GET then don't overwrite.
		            $weight =   $weight_arr[$i];
		            $packages[$package_key][$key]['Weight']['Value']   =   $weight;
		            $packages[$package_key][$key]['Weight']['Units']   =   $this->labelapi_weight_unit;
		        }
		        $i++;
		    }
	    }
	    return $packages;
	}


	public function run_package_request( $requests ) {
		/* try {		 	
		 */	
			//$this->tracking_ids = '';
			$first_package = true;
			foreach ( $requests as $key => $request ) {
				if( $first_package ) {
					if( $this->commercial_invoice && $this->is_international ) {
						$company_logo = !empty($this->settings['company_logo']) ? true : false;
						$digital_signature = !empty($this->settings['digital_signature']) ? true : false;

						$special_servicetypes = !empty($request['RequestedShipment']['SpecialServicesRequested']['SpecialServiceTypes']) ? $request['RequestedShipment']['SpecialServicesRequested']['SpecialServiceTypes'] : array();
						array_unshift( $special_servicetypes, 'ELECTRONIC_TRADE_DOCUMENTS' );
						$request['RequestedShipment']['SpecialServicesRequested']['SpecialServiceTypes'] = $special_servicetypes;
						
						$request['RequestedShipment']['SpecialServicesRequested']['EtdDetail']['RequestedDocumentCopies'] = 'COMMERCIAL_INVOICE';
						$request['RequestedShipment']['ShippingDocumentSpecification']['ShippingDocumentTypes'] = 'COMMERCIAL_INVOICE';
						$request['RequestedShipment']['ShippingDocumentSpecification']['CommercialInvoiceDetail']['Format']['ImageType'] = 'PDF';
						$request['RequestedShipment']['ShippingDocumentSpecification']['CommercialInvoiceDetail']['Format']['StockType'] = 'PAPER_LETTER';
						
						if($company_logo){
							$request['RequestedShipment']['ShippingDocumentSpecification']['CommercialInvoiceDetail']['CustomerImageUsages'][] = array(
								'Type' 	=> 'LETTER_HEAD', 
								'Id' 	=> 'IMAGE_1', 
							);
						}

						if($digital_signature){
							$request['RequestedShipment']['ShippingDocumentSpecification']['CommercialInvoiceDetail']['CustomerImageUsages'][] = array(
								'Type' 	=> 'SIGNATURE',
								'Id' 	=> 'IMAGE_2',
							);
						}
					}
					$this->process_result( $this->get_result( $request ) , $request );
				} else {
					$this->process_result($this->get_result( $request ), $request );
				}
				$first_package =  false;
			}
			if(!empty($this->tracking_ids)){
				// Auto fill tracking info.
				$shipment_id_cs = $this->tracking_ids;
				WfTrackingUtil::update_tracking_data( $this->order_id, $shipment_id_cs, 'fedex', WF_Tracking_Admin_FedEx::SHIPMENT_SOURCE_KEY, WF_Tracking_Admin_FedEx::SHIPMENT_RESULT_KEY );
			}
			
		/*  } catch ( Exception $e ) {
			$this->debug( print_r( $e, true ), 'error' );
			return false;
		} */ 
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

	private function get_result( $request ) {
		if( !empty($this->pre_service) && $this->pre_service !== $request['RequestedShipment']['ServiceType'] ){
			$this->master_tracking_id = ''; 
			$request['RequestedShipment']['PackageCount'] = 1;
		}
		$this->pre_service = $request['RequestedShipment']['ServiceType'];
		if(!empty($this->master_tracking_id))
			$request['RequestedShipment']['MasterTrackingId'] = $this->master_tracking_id;		

        $result = '';
        try {
        	$wsdl_dir =plugin_dir_path( dirname( __FILE__ ) ) . 'fedex-wsdl/' . ( $this->production ? 'production' : 'test' ) . '/ShipService_v' . $this->ship_service_version. '.wsdl';
			$client = $this->wf_create_soap_client( $wsdl_dir );

			if( $this->soap_method == 'nusoap' ){
				$result = $client->call( 'processShipment', array( 'ProcessShipmentRequest' => $request ) );
				$result = json_decode( json_encode( $result ), false );
			}
			else{
				$result = $client->processShipment( $request );
			}

        } catch (Exception $e) {
            $this->debug( __( 'SoapFault while run_package_request.', 'wf-shipping-fedex' ) );
            $this->debug( 'Error Message: '.$e->getMessage() ); 
        }

		$this->debug( 'FedEx REQUEST: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;">' . print_r( $request, true ) . '</pre>' );
		$this->debug( 'FedEx RESPONSE: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;">' . print_r( $result, true ) . '</pre>' );
		
		if ( WF_FEDEX_ADV_DEBUG_MODE == "on" ) { // Test mode is only for development purpose.
			try{
				$xml_request 	= $this->soap_method != 'nusoap' ? $client->__getLastRequest() : $client->request();
				$xml_response 	= $this->soap_method != 'nusoap' ? $client->__getLastResponse() : $client->response();
			}
			catch ( Exception $e){
				echo "Error: ".$e->getMessage() ;
			}
			$this->debug( 'FedEx REQUEST in XML Format: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;overflow: auto;">' . print_r( htmlspecialchars( $xml_request ), true ) . "</pre>\n" );
			$this->debug( 'FedEx RESPONSE in XML Format: <a href="#" class="debug_reveal">Reveal</a><pre class="debug_info" style="background:#EEE;border:1px solid #DDD;padding:5px;overflow: auto;">' . print_r( htmlspecialchars( $xml_response ), true ) . "</pre>\n" );
		}
		return $result;
	}

	private function process_result( $result = '' , $request) {
		if(!$result)
			return false;
		
		if ( $result->HighestSeverity != 'FAILURE' && $result->HighestSeverity != 'ERROR' && ! empty ($result->CompletedShipmentDetail) ) {
			
			if( property_exists($result->CompletedShipmentDetail,'CompletedPackageDetails') ){
				if(is_array($result->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds)){
					foreach($result->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds as $track_ids){
						if($track_ids->TrackingIdType != 'USPS'){
							$shipmentId = $track_ids->TrackingNumber;	
							$tracking_completedata = $track_ids; 		
						}else{
							$usps_shipmentId = $track_ids->TrackingNumber;
						}
					}
				}
				else{
					$shipmentId = $result->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds->TrackingNumber;		
					$tracking_completedata = $result->CompletedShipmentDetail->CompletedPackageDetails->TrackingIds;
				}	
			}
			elseif(property_exists($result->CompletedShipmentDetail,'MasterTrackingId')){
				$shipmentId = $result->CompletedShipmentDetail->MasterTrackingId->TrackingNumber;		
				$tracking_completedata = $result->CompletedShipmentDetail->MasterTrackingId;				
			}			
			
			//if return label
			if( !empty($this->shipmentId) && property_exists($result->CompletedShipmentDetail->CompletedPackageDetails->Label,'ShippingDocumentDisposition') && $result->CompletedShipmentDetail->CompletedPackageDetails->Label->ShippingDocumentDisposition == 'RETURNED'){
				
				$package_shipping_label = $result->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image;
				if(base64_encode(base64_decode($package_shipping_label, true)) === $package_shipping_label){  //For nusoap encoded label response
					$return_label = $package_shipping_label;
				}
				else{
					$return_label = base64_encode($package_shipping_label);
				}
				$returnlabel_type = $result->CompletedShipmentDetail->CompletedPackageDetails->Label->ImageType; //Shipment ImageType

				add_post_meta($this->order_id, 'wf_woo_fedex_returnShipmetId', $shipmentId, true);
				add_post_meta($this->order_id, 'wf_woo_fedex_returnLabel_'.$this->shipmentId, $return_label, true);
				if( !empty($shippinglabel_type) ){
					 add_post_meta($this->order_id, 'wf_woo_fedex_returnLabel_image_type_'.$this->shipmentId, $returnlabel_type, true);
				}
				$shipping_label = get_post_meta($this->order_id, 'wf_woo_fedex_returnLabel_'.$this->shipmentId, true);
				return;				
			}
			
			if( !empty($result->CompletedShipmentDetail->MasterTrackingId) && empty($this->master_tracking_id) )
				$this->master_tracking_id = $result->CompletedShipmentDetail->MasterTrackingId;
			
			$addittional_label = array();
			$addittional_label_type = array();
			if(property_exists($result->CompletedShipmentDetail,'CompletedPackageDetails')){
				$package_shipping_label=$result->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image;
				if(base64_encode(base64_decode($package_shipping_label, true)) === $package_shipping_label){  //For nusoap encoded label response
					$shippingLabel = $package_shipping_label;
				}
				else{
					$shippingLabel = base64_encode($package_shipping_label);
				}
				$shippinglabel_type = $result->CompletedShipmentDetail->CompletedPackageDetails->Label->ImageType; //Shipment ImageType
				
				if(property_exists($result->CompletedShipmentDetail->CompletedPackageDetails,'PackageDocuments')){
					$package_documents = $result->CompletedShipmentDetail->CompletedPackageDetails->PackageDocuments;
					if(is_array($package_documents)){
						foreach($package_documents as $document_key=>$package_document){
							$package_additional_label = $package_document->Parts->Image;
							if(base64_encode(base64_decode($package_additional_label, true)) === $package_additional_label){
								$addittional_label[$document_key] = $package_additional_label;
							}else{
								$addittional_label[$document_key] = base64_encode($package_additional_label);
							}
							$addittional_label_type[$document_key] = $package_document->ImageType;
						}
					}
				}
				
				if(property_exists($result->CompletedShipmentDetail,'ShipmentDocuments')){
					$commercial_invoice_label=$result->CompletedShipmentDetail->ShipmentDocuments->Parts->Image;
					if(base64_encode(base64_decode($commercial_invoice_label, true)) === $commercial_invoice_label){
						$addittional_label['Commercial Invoice'] = $commercial_invoice_label;
					}else{
						$addittional_label['Commercial Invoice'] = base64_encode($commercial_invoice_label);
					}
					$addittional_label_type['Commercial Invoice'] = $result->CompletedShipmentDetail->ShipmentDocuments->ImageType;
				}
			} 
			elseif(property_exists($result->CompletedShipmentDetail,'ShipmentDocuments')){ 
				//As per the documentation. This case will never occure. 
				$shipment_document_label = $result->CompletedShipmentDetail->ShipmentDocuments->Parts->Image;
				if(base64_encode(base64_decode($shipment_document_label, true)) === $shipment_document_label){
					$shippingLabel = $shipment_document_label;
				}
				else{
					$shippingLabel = base64_encode($shipment_document_label);
				}
				$shippinglabel_type = $result->CompletedShipmentDetail->ShipmentDocuments->ImageType;
			}
			
			if(!empty($shippingLabel) && property_exists($result->CompletedShipmentDetail,'AssociatedShipments')){
				$associated_documents = $result->CompletedShipmentDetail->AssociatedShipments->Label;
				if(!empty($associated_documents)){
					
						$associated_shipment_label = $associated_documents->Parts->Image;
						if(base64_encode(base64_decode($associated_shipment_label, true)) === $associated_shipment_label){
							$addittional_label['AssociatedLabel'] = $associated_shipment_label;
						}
						else{
							$addittional_label['AssociatedLabel'] = base64_encode($associated_shipment_label);
						}
						$addittional_label_type['AssociatedLabel'] = $associated_documents->ImageType;
				}
			}
			
			 if(!empty($shipmentId) && !empty($shippingLabel)){
				add_post_meta($this->order_id, 'wf_woo_fedex_shipmentId', $shipmentId, false);
				add_post_meta($this->order_id, 'wf_woo_fedex_shippingLabel_'.$shipmentId, $shippingLabel, true);
				add_post_meta($this->order_id, 'wf_woo_fedex_packageDetails_'.$shipmentId, $this->wf_get_parcel_details($request) , true);
				add_post_meta($this->order_id, 'wf_woo_fedex_request_'.$shipmentId, $request , true);

				if( !empty($shippinglabel_type) ){
					 add_post_meta($this->order_id, 'wf_woo_fedex_shippingLabel_image_type_'.$shipmentId, $shippinglabel_type, true);
				}
				
				if(isset($tracking_completedata)){
					add_post_meta($this->order_id, 'wf_woo_fedex_tracking_full_details_'.$shipmentId, $tracking_completedata, true);
				}			
					
				if( !empty($request['RequestedShipment']['ServiceType']) ){
					add_post_meta($this->order_id, 'wf_woo_fedex_service_code'.$shipmentId, $request['RequestedShipment']['ServiceType'], true);
				}
				
				if(!empty($usps_shipmentId)){
					add_post_meta($this->order_id, 'wf_woo_fedex_usps_trackingid_'.$shipmentId, $usps_shipmentId, true);
				}

				if($this->add_trackingpin_shipmentid == 'yes' && !empty($shipmentId)){
					//$this->order->add_order_note( sprintf( __( 'Fedex Tracking-pin #: %s.', 'wf-shipping-fedex' ), $shipmentId) , true);
					$this->tracking_ids = $this->tracking_ids . $shipmentId . ',';			
				}
				
				if($this->add_trackingpin_shipmentid == 'yes' && !empty($usps_shipmentId)){
					//$this->order->add_order_note( sprintf( __( 'Fedex Smart Post USPS Tracking-pin #: %s.', 'wf-shipping-fedex' ), $usps_shipmentId) , true);
				}
				
				if(!empty($addittional_label)){
					add_post_meta($this->order_id, 'wf_fedex_additional_label_'.$shipmentId, $addittional_label, true);	
					if(!empty($addittional_label_type)){
						add_post_meta($this->order_id, 'wf_fedex_additional_label_image_type_'.$shipmentId, $addittional_label_type, true);		
					}	
				}							
			} 
			do_action('wf_label_generated_successfully',$shipmentId,$shippingLabel,$this->order_id);
		}else{
			$this->shipmentErrorMessage .=  $this->result_notifications($result->Notifications, $error_message='');
		}
	}
	
	private function wf_get_parcel_details($request){
		 $weight = '';
		 $height = '';
		 $width = '';
		 $length = '';
		 if(isset($request['RequestedShipment']['RequestedPackageLineItems'][0])){
			$line = $request['RequestedShipment']['RequestedPackageLineItems'][0];
			if(isset($line['Weight'])){
				$weight = $line['Weight']['Value'] . ' ' . $line['Weight']['Units'];			
			}
			if(isset($line['Dimensions'])){
				$height = $line['Dimensions']['Height'] . ' ' . $line['Dimensions']['Units'];	
				$width = $line['Dimensions']['Width'] . ' ' . $line['Dimensions']['Units'];	
				$length = $line['Dimensions']['Length'] . ' ' . $line['Dimensions']['Units'];					
			}			
		 }		 
		 return array('Weight' => $weight, 'Height' => $height, 'Width' => $width, 'Length' => $length);
	}
	
	 private function result_notifications( $notes, $error_message = '' ){
        $error_message = '';

        if( is_object( $notes )  ) {
           // TODO: Not fair to use foreach across an object. We need to re-write this code.
           foreach( $notes as $noteKey => $note ) {
               if( is_string( $note ) ){
                   $error_message .=  $noteKey . ': ' . $note . "<br />";
               }
               else{
                   $error_message .=  $this->result_notifications( $note, $error_message );
               }
           }
        }
       
        return $error_message;
    }
	
	private function validate_package($packages){
		if( !$packages ){
			return false;
		}

		$package_valid=true;
		$unpacked_items=array();
		$msg='';
		if($this->packing_method	!=	'box_packing'){// Only box packing is needed to check products now 
			return true;
		}
		foreach($packages as $package){
			if(!isset($package['packed_products'])||empty($package['packed_products'])){
				$package_valid=false;
				$unpacked_items[]=$package;
			}			
		}
		if(!$package_valid&&!empty($unpacked_items)){
			$msg=' Following product dimensions cannot be packed. Please configure correct box dimenions, Or set Individually/Weight based  as parcel packing method.</br>';
			foreach($unpacked_items as $unpacked_item){
				$dim=$unpacked_item['Dimensions']['Length'].'X'.$unpacked_item['Dimensions']['Width'].'X'.$unpacked_item['Dimensions']['Height'].' '.$unpacked_item['Dimensions']['Units'];
				$weight=$unpacked_item['Weight']['Value'].' '.$unpacked_item['Weight']['Units'];
				$msg.=sprintf('Dimenstions: %1$s Weight: %2$s</br>',$dim,$weight);				
			}
		}
		if($msg){
			$this->debug('<br>'.$msg);
			$this->shipmentErrorMessage=__($msg);
		}		
		return $package_valid;
	}
	
	//function to get shipper address for api request
	private function shop_address( $package = '' ){	
		$from_address = array(
			'name' 		=> $this->freight_shipper_person_name,
			'company' 	=> $this->freight_shipper_company_name,
			'phone' 	=> $this->freight_shipper_phone_number,
			'address_1' => $this->frt_shipper_street,
			'address_2' => $this->freight_shipper_street_2,
			'city' 		=> $this->freight_shipper_city,
			'state' 	=> $this->origin_state,
			'country' 	=> $this->origin_country,
			'postcode' 	=> $this->origin,
		);

		//Filter for origin address switcher plugin.
        $from_address =  apply_filters( 'wf_filter_label_from_address', $from_address , $package );

		// Only first 30 characters get printed on Label.
        if( strlen($from_address['address_1']) > 30 ){
        	$address_1 = substr( $from_address['address_1'], 0, strpos( wordwrap($from_address['address_1'], 30), "\n") ); //Get first 30 char from $address_1
        	$address_2 = str_replace($address_1, '', $from_address['address_1']) . ' ' . $from_address['address_2']; //Take remains of $address_1 + $address_2
        }else{
        	$address_1 = $from_address['address_1'];
        	$address_2 = $from_address['address_2'];
        }

		$request = array(
			'Contact'=>array(
				'PersonName' 	=> $from_address['name'],
				'CompanyName' 	=> $from_address['company'],
				'PhoneNumber' 	=> $from_address['phone']
			),
			'Address'               => array(
				'StreetLines'         => array( strtoupper( $address_1 ), strtoupper( $address_2 ) ),
				'City'                => strtoupper( $from_address['city'] ),
				'StateOrProvinceCode' => strtoupper( $from_address['state'] ),
				'PostalCode'          => strtoupper( $from_address['postcode'] ),
				'CountryCode'         => strtoupper( $from_address['country'] ),
				'Residential'         => $this->freight_shipper_residential
			)
		);
		return $request;
	}
	
	//function to get recipient address for api request
	private function order_address($package) {

		// Only first 30 characters get printed on Label.
		if( strlen($package['destination']['address_1']) > 30 ){
			$address_1 = substr( $package['destination']['address_1'], 0, strpos( wordwrap($package['destination']['address_1'], 30), "\n") ); //Get first 30 char from $address_1
			$address_2 = str_replace($address_1, '', $package['destination']['address_1']) . ' ' . $package['destination']['address_2']; //Take remains of $address_1 + $address_2
		}else{
			$address_1 = $package['destination']['address_1'];
			$address_2 = $package['destination']['address_2'];
		}

		$addr = array(
			'Contact' => array(
				'PersonName' => $package['destination']['first_name'] . ' ' . $package['destination']['last_name'],
				'CompanyName' => $package['destination']['company'],
				'PhoneNumber' => $this->order->billing_phone
			),
			'Address' => array(
				'StreetLines'         =>  array( $address_1, $address_2),
				'Residential'         => $this->residential,
				'PostalCode'          => str_replace( ' ', '', strtoupper( $package['destination']['postcode'] ) ),
				'City'                => strtoupper( $package['destination']['city'] ),
				'StateOrProvinceCode' => strlen( $package['destination']['state'] ) == 2 ? strtoupper( $package['destination']['state'] ) : '',
				'CountryCode'         => $package['destination']['country']
			)
		);
		return $addr;
	}
	
	private function manual_dimensions( $package ) {
		$group  = array();
		if ( empty($_GET['weight'] ) ) {
			$this->debug( sprintf( __( '<br> Package weight is missing. Aborting.', 'wf-shipping-fedex' ) ), 'error' );
			return;
		}

		$total_price = 0;
		$packed_products = array();
		foreach ( $package['contents'] as $item_no => $item) {
			$total_price += ( $this->get_product_price( $item['data'] ) * $item['quantity'] );
			$packed_products[] = $item['data'];
		}
		$group =array(
			array(
				'GroupNumber'       => 1,
				'GroupPackageCount' => 1,
				'Weight' => array(
					'Value' => $_GET['weight'],
					'Units' => $this->labelapi_weight_unit
				),
				'packed_products' => $packed_products,
				'Dimensions' => array(
					'Length' => $_GET['length'],
					'Width'  => $_GET['width'],
					'Height' => $_GET['height'],
					'Units'  => $this->labelapi_dimension_unit
				),
				'InsuredValue' => array(
					'Amount'   => round( $total_price ),
					'Currency' => $this->wf_get_fedex_currency()
				)
			)
		);
		return $group;
	}
	
	function get_package_one_commodoties($fedex_packages)
	{	
		foreach ( $fedex_packages as $key => $parcel ) {
			if ( $parcel['packed_products'] ) {
				foreach ( $parcel['packed_products'] as $product ) {
					if ( isset( $commodoties[ $product->id ] ) ) {
						$commodoties[ $product->id ]['Quantity'] ++;
						$commodoties[ $product->id ]['CustomsValue']['Amount'] += round( $this->get_product_price($product) );
						continue;
					}
					$commodoties[ $product->id ] = array(
						'Name'                 => sanitize_title( $product->get_title() ),
						'NumberOfPieces'       => 1,
						'Description'          => sanitize_title( $product->get_title()),
						'CountryOfManufacture' => ( $country = get_post_meta( $product->id, '_wf_manufacture_country', true ) ) ? $country : $this->origin_country,
						'Weight'               => array(
							'Units'            => $this->labelapi_weight_unit,
							'Value'            => round( wc_get_weight( $product->get_weight(), $this->weight_unit ), 2 ) ,
						),
						'Quantity'             => $parcel['GroupPackageCount'],
						'UnitPrice'            => array(
							'Amount'           => round( $this->get_product_price($product) ),
							'Currency'         => $this->wf_get_fedex_currency()
						),
						'CustomsValue'         => array(
							'Amount'           => round( $this->get_product_price($product) ),
							'Currency'         => $this->wf_get_fedex_currency()
						),
						'QuantityUnits' => 'EA'
					);


					$wf_hs_code = get_post_meta( $product->id, '_wf_hs_code', 1); //this works for variable product also
					
					// for backword compatiblity
					if(!$wf_hs_code){
						$product_data   = wc_get_product( $product->id  );
						$wf_hs_code = $product_data->get_attribute( 'wf_hs_code' );
					}
					
					if( !empty($wf_hs_code) ){
						$commodoties[ $product->id ]['HarmonizedCode'] = $wf_hs_code;
					}

					$is_dry_ice_product = get_post_meta($product->id , '_wf_dry_ice', 1);
					if( $this->is_dry_ice_enabled && $is_dry_ice_product=='yes' ){
						$this->dry_ice_total_weight += wc_get_weight( $product->get_weight(), 'kg' );

						$this->dry_ice_shipment = true;
					}
				}
			}
		}
		return $commodoties;
	}
	
	function notification_receiver($email, $recipient_type = 'RECIPIENT'){
		if( !isset($email) || empty($email)){
			return false;
		}
		
		$recipient_email = array(
			'NotificationType'	=> 'EMAIL',
			'EmailDetail'=>array( 
				'EmailAddress'	=> $email
			),
			'Localization'=> array(
				'LanguageCode'	=> 'EN'
			),
		);
		return $recipient_email;
	}
	
	public function request_pickup($order_ids = array()){		
		if(!is_array($order_ids))
			return false;

		// pickup settings		
		$pickup_enabled				= ( $bool = $this->settings[ 'pickup_enabled'] ) && $bool == 'yes' ? true : false;
		$use_pickup_address	= ( $bool = $this->settings[ 'use_pickup_address'] ) && $bool == 'yes' ? true : false;
		$pickup_start_time    		= $this->settings[ 'pickup_start_time' ] ? $this->settings[ 'pickup_start_time' ] : 8; // Pickup min start time 8 am
		$pickup_close_time    		= $this->settings[ 'pickup_close_time' ] ? $this->settings[ 'pickup_close_time' ] : 18;
		$pickup_service	    		= $this->settings[ 'pickup_service' ] ? $this->settings[ 'pickup_service' ] : 'FEDEX_NEXT_DAY_EARLY_MORNING';
		
		$master_order_id	=	current($order_ids);
		$pickup_packages	=	array();
		$package_count		=	0;
		$total_weight		=	0;
		
		foreach($order_ids as $order_id){
			$order = 	$this->wf_load_order($order_id);
			if (!$order) 
				continue;
			$this->order 		= 	$order;
			$this->order_id 	= 	$order_id;
			$packages			=	$this->wf_get_package_from_order($order);
			foreach($packages as $package){
				$fedex_packages   = $this->get_fedex_packages( $package);
				if(is_array($fedex_packages)){
					$package_count	=	$package_count	+	count($fedex_packages);
					foreach($fedex_packages	as $fedex_package){
						if(isset($fedex_package['Weight']['Value'])){
							$total_weight	=	$total_weight	+	$fedex_package['Weight']['Value'];
						}
					}
				}
			}
		}
		if($this->ship_from_address === 'shipping_address'){
			$origin_address =  $this->order_address( $package );
		}else {
			$origin_address =  $this->shop_address( $package );
		}
		$request = array();
		$request['WebAuthenticationDetail'] = array(
			'UserCredential' => array(
				'Key'      => $this->api_key,
				'Password' => $this->api_pass
			)
		);
		$request['ClientDetail'] = array(
			'AccountNumber' => $this->account_number,
			'MeterNumber'   => $this->meter_number
		);
		$request['TransactionDetail'] = array( 'CustomerTransactionId' => ' *** Pickup Request v3 from WooCommerce ***' );
		$request['Version'] = array( 'ServiceId' => 'disp', 'Major' => 3, 'Intermediate' => '0', 'Minor' => '0' );
		$request['AssociatedAccountNumber']	=	array(
			'Type'			=>	'FEDEX_EXPRESS',
			'AccountNumber'	=>	$this->account_number,
		);
		
		$ready_date	=	date('Y-m-d');
		
		$pickup_add_days=	(strpos($pickup_service,'NEXT_DAY') !== false)  ? 1 : 0; 		
		$pickup_ready_timestamp	=	strtotime($ready_date) + $pickup_start_time*3600 + $pickup_add_days*24*3600;
		
		$pickup_close_timestamp	= strtotime(date('Y-m-d')) + $pickup_close_time*3600;// for closing we need only time, so date is irrelavant
		
		if( $use_pickup_address ){
			$pickup_address = array(
				'Contact'			=>	array(
					'PersonName'		=>	!empty($this->settings[ 'pickup_contact_name' ]) ? $this->settings[ 'pickup_contact_name' ] : '',
					'CompanyName'		=>	!empty($this->settings[ 'pickup_company_name' ]) ? $this->settings[ 'pickup_company_name' ] : '',
					'PhoneNumber'		=>	!empty($this->settings[ 'pickup_phone_number' ]) ? $this->settings[ 'pickup_phone_number' ] : '',
				),
				'Address'		=>	array(
					'StreetLines'			=>	!empty($this->settings[ 'pickup_address_line' ]) ? $this->settings[ 'pickup_address_line' ] : '',
					'City'					=>	!empty($this->settings[ 'pickup_address_city' ]) ? $this->settings[ 'pickup_address_city' ] : '',
					'StateOrProvinceCode'	=>	!empty($this->settings[ 'pickup_address_state_code' ]) ? $this->settings[ 'pickup_address_state_code' ] : '',
					'PostalCode'			=>	!empty($this->settings[ 'pickup_address_postal_code' ]) ? $this->settings[ 'pickup_address_postal_code' ] : '',
					'CountryCode'			=>	!empty($this->settings[ 'pickup_address_country_code' ]) ? $this->settings[ 'pickup_address_country_code' ] : '',
				)
			);
		}else{
			$pickup_address = array(
				'Contact'			=>	array(
					'PersonName'		=>	$origin_address['Contact']['PersonName'],
					'CompanyName'		=>	$origin_address['Contact']['CompanyName'],
					'PhoneNumber'		=>	$origin_address['Contact']['PhoneNumber'],
				),
				'Address'		=>	array(
					'StreetLines'			=>	$origin_address['Address']['StreetLines'][0],
					'City'					=>	$origin_address['Address']['City'],
					'StateOrProvinceCode'	=>	$origin_address['Address']['StateOrProvinceCode'],
					'PostalCode'			=>	$origin_address['Address']['PostalCode'],
					'CountryCode'			=>	$origin_address['Address']['CountryCode']
				)
			);
		}
		$request['OriginDetail']	=	array(
			'UseAccountAddress'	=>	0,
			'PickupLocation'	=>	$pickup_address,
			'ReadyTimestamp'	=>	date("Y-m-d\TH:i:s",$pickup_ready_timestamp),
			'CompanyCloseTime'	=>	date("H:i:s",$pickup_close_timestamp),
		);
		$request['PickupServiceCategory']	=	$pickup_service;
		$request['CarrierCode']				=	'FDXE';
		$request['PackageCount']			=	$package_count;
		$request['TotaWeight']				=	array(
			'Units'	=>	$this->labelapi_weight_unit,
			'Value'	=>	$total_weight
		);
		//$request['CountryRelationship']		=	'DOMESTIC';
		$this->debug( 'FedEx PICKUP REQUEST: <pre>'.print_r($request,true).'</pre>');
		$response	=	$this->run_pickup_request($request);
		$this->debug( 'FedEx PICKUP RESPONSE: <pre>'.print_r($response,true).'</pre>');
		return $this->process_pickup_response($response, array('OrderId'=>$master_order_id,'ScheduledDate'=>date("Y-m-d",$pickup_ready_timestamp)));
	}
	
	public function run_pickup_request($request){
		try {
			$wsdl_dir = plugin_dir_path( dirname( __FILE__ ) ) . 'fedex-wsdl/' . ( $this->production ? 'production' : 'test' ) . '/PickupService_v' . $this->pickup_service_version. '.wsdl';
			$client = $this->wf_create_soap_client( $wsdl_dir );

			if( $this->soap_method == 'nusoap' ){
				$result = $client->call( 'createPickup', array( 'CreatePickupRequest' => $request ) );
				$result = json_decode( json_encode( $result ), false );
			}
			else{
				$result = $client->createPickup($request);			
			}

		}catch(Exception $e){
			$result	=	array(
				'error'		=>	1,
				'message'	=>	$e->getMessage(),
			);
		}
		return $result;
	}
	
	public function process_pickup_response($response, $info = array()){
		$return	=	array(
			'error'		=>	0,
			'message'	=>	'',
		);
		if(!isset($response->Notifications->Code)){
			$return['error']	=	1;
			$return['message']	=	'Unexpected error';
		}else if($response->Notifications->Code	!=	'0000'){
			$return['error']	=	1;
			$return['message']	=	$response->Notifications->Message;
		}
		else{
			if($response->PickupConfirmationNumber)
				$return['data']['PickupConfirmationNumber']	=	$response->PickupConfirmationNumber;
				$return['data']['Location']					=	$response->Location;
				if(is_array($info)){
					foreach($info as $param	=>	$value){
						$return['data'][$param]	=	$value;
					}
				}
		}		
		return $return;
	}
	
	public function pickup_cancel($order, $order_id, $pickup_details = array()){
		$this->order 		= 	$order;
		$this->order_id 	= 	$order_id;
		$pickup_service	    = $this->settings[ 'pickup_service' ]?$this->settings[ 'pickup_service' ]:'FEDEX_NEXT_DAY_EARLY_MORNING';
		
		if(!$pickup_details['pickup_confirmation_number']){
			return array(
				'error'		=>	1,
				'message'	=>	'Pickup request not found',
			);
		}
		
		$request = array();
		$request['WebAuthenticationDetail'] = array(
			'UserCredential' => array(
				'Key'      => $this->api_key,
				'Password' => $this->api_pass
			)
		);
		$request['ClientDetail'] = array(
			'AccountNumber' => $this->account_number,
			'MeterNumber'   => $this->meter_number
		);
		$request['TransactionDetail'] = array( 'CustomerTransactionId' => 'CancelPickupRequest_v9' );
		$request['Version'] = array( 'ServiceId' => 'disp', 'Major' => 3, 'Intermediate' => '0', 'Minor' => '0' );
		$request['AssociatedAccountNumber']	=	array(
			'Type'			=>	'FEDEX_EXPRESS',
			'AccountNumber'	=>	$this->account_number,
		);
		
		
		$request['PickupServiceCategory']	=	$pickup_service;
		$request['CarrierCode']				=	'FDXE';
		$request['PickupConfirmationNumber']=	$pickup_details['pickup_confirmation_number'];
		$request['Location']				=	$pickup_details['pickup_location'];
		$request['ScheduledDate']			=	$pickup_details['pickup_scheduled_date'];
		
		$this->debug( 'FedEx CANCEL PICKUP REQUEST: <pre>'.print_r($request,true).'</pre>');
		$response	=	$this->run_pickup_cancel($request);
		$this->debug( 'FedEx CANCEL PICKUP RESPONSE: <pre>'.print_r($response,true).'</pre>');
		return $this->process_pickup_cancel($response);
	}
	public function run_pickup_cancel($request){
		try {
			$wsdl_dir = plugin_dir_path( dirname( __FILE__ ) ) . 'fedex-wsdl/' . ( $this->production ? 'production' : 'test' ) . '/PickupService_v' . $this->pickup_service_version. '.wsdl';
			$client = $this->wf_create_soap_client( $wsdl_dir );
			
			if( $this->soap_method == 'nusoap' ){
				$result = $client->call( 'cancelPickup', array( 'CancelPickupRequest' => $request ) );
				$result = json_decode( json_encode( $result ), false );
			}
			else{
				$result = $client->cancelPickup($request);		
			}
		}catch(Exception $e){
			$result	=	array(
				'error'		=>	1,
				'message'	=>	$e->getMessage(),
			);
		}
		return $result;
	}
	public function process_pickup_cancel($response, $info = array()){
		$return	=	array(
			'error'		=>	0,
			'message'	=>	'',
		);
		if(!isset($response->Notifications->Code)){
			$return['error']	=	1;
			$return['message']	=	$response['message'];
		}else if($response->Notifications->Code	!=	'0000'){
			$return['error']	=	1;
			$return['message']	=	$response->Notifications->Message;
		}
		else{
			$return['message']	=	$response->Notifications->Message;
		}		
		return $return;
	}
	private function wf_load_order($orderId){
		if( !$orderId ){
			return false;
		}
		if(!class_exists('wf_order')){
			include_once('class-wf-legacy.php');
		}
		return ( WC()->version < '2.7.0' ) ? new WC_Order( $orderId ) : new wf_order( $orderId );   
	}
	public function get_product_price($product){
		$product = $this->wf_load_product($product);
		if($this->exclude_tax){
			return apply_filters( 'xa_order_product_price', ( ( WC()->version < '2.7.0' ) ? $product->get_price_excluding_tax() : wc_get_price_excluding_tax( $product ) ), $product, $this->order_object ) ;
		}else{
			return apply_filters( 'xa_order_product_price', $product->get_price(), $product, $this->order_object ) ;
		}
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