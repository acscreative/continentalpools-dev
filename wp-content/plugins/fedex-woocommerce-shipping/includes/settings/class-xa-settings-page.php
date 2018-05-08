<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once('class-xa-settings-input-fields.php');

class xa_settings_page extends xa_settings_input_fields
{
	public function __construct(){
		$this->rateservice_version              = 22;
		$this->soap_method = $this->is_soap_available() ? 'soap' : 'nusoap';

		$this->xa_init();
		$this->settings = get_option( 'woocommerce_'.WF_Fedex_ID.'_settings', null );
		if( isset($_POST['xa_fedex_validate_credentials_edit']) ){
			update_option('xa_fedex_shipping_validation_data','');
		}
		if( isset($_POST['xa_fedex_validate_credentials']) ){
			$this->xa_fedex_validate_credentials();
		}
		if( isset($_POST['xa_save_fedex_general_settings']) ){
			$this->xa_save_fedex_general_settings();
		}
		if( isset($_POST['xa_save_fedex_rate_settings']) ){
			$this->xa_save_fedex_rate_settings();
		}
		if( isset($_POST['xa_save_fedex_label_settings']) ){
			$this->xa_save_fedex_label_settings();
		}
		if( isset($_POST['xa_save_fedex_packing_settings']) ){
			$this->xa_save_fedex_packing_settings();
		}
		if( isset($_POST['xa_save_fedex_pickup_settings']) ){
			$this->xa_save_fedex_pickup_settings();
		}
		if( isset($_POST['xa_save_fedex_freight_settings']) ){
			$this->xa_save_fedex_freight_settings();
		}
	}

	private function xa_init(){
		$this->speciality_boxes	 = include( __DIR__ .'/../data-wf-speciality-boxes.php' );
		$this->default_boxes		= include( __DIR__ .'/../data-wf-box-sizes.php' );
		if($this->get_option( 'dimension_weight_unit' ) == 'LBS_IN'){
			$this->dimension_unit	=	'in';
			$this->weight_unit		=	'lbs';
			$this->labelapi_dimension_unit	=	'IN';
			$this->labelapi_weight_unit	=	'LB';
		}else{
			$this->dimension_unit	=	'cm';
			$this->weight_unit		=	'kg';
			$this->labelapi_dimension_unit	=	'CM';
			$this->labelapi_weight_unit	=	'KG';
			$this->default_boxes	= include( __DIR__ .'/../data-wf-box-sizes-cm.php' );
		}
	}

	private function is_soap_available(){
		if( extension_loaded( 'soap' ) ){
			return true;
		}
		return false;
	}

	private function xa_fedex_validate_credentials(){
		$production			= ( isset($_POST['production']) && ($_POST['production'] =='yes') ) ? 'yes' : 'no';
		$account_number		= ( isset($_POST['account_number']) ) ? $_POST['account_number'] : '';
		$meter_number		= ( isset($_POST['meter_number']) ) ? $_POST['meter_number'] : '';
		$api_key			= ( isset($_POST['api_key']) ) ? $_POST['api_key'] : '';
		$api_pass			= ( isset($_POST['api_pass']) ) ? $_POST['api_pass'] : '';
		$this->settings['origin_country']	= ( isset($_POST['origin_country']) ) ? sanitize_text_field($_POST['origin_country']) : '';
		$this->settings['origin'] = ( isset($_POST['origin']) ) ? ($_POST['origin']) : '';

		if ( strstr( $this->settings['origin_country'], ':' ) ) :
			$origin_country_state_array		= explode(':',$this->settings['origin_country']);
			$origin_country					= current($origin_country_state_array);
		else :
			$origin_country					= $this->settings['origin_country'];
		endif;

		$this->settings['production']				= $production;
		$this->settings['account_number']			= $account_number;
		$this->settings['meter_number']				= $meter_number;
		$this->settings['api_key']					= $api_key;
		$this->settings['api_pass']					= $api_pass;

		update_option('woocommerce_'.WF_Fedex_ID.'_settings',$this->settings);

		$request = array(
			'WebAuthenticationDetail' => array(
	            'UserCredential' => array(
                    'Key' => $api_key,
                    'Password' => $api_pass,
                ),
	        ),
    		'ClientDetail' => array(
		        'AccountNumber' => $account_number,
		        'MeterNumber' => $meter_number,
        	),
    		'TransactionDetail' => array(
            	'CustomerTransactionId' =>  '*** WooCommerce Rate Request ***',
        	),
        	'Version' => array(
            	'ServiceId' => 'crs',
            	'Major' => 22,
            	'Intermediate' => 0,
            	'Minor' => 0,
            ),
            'ReturnTransitAndCommit' => 1,
            'RequestedShipment' => array(
            	'EditRequestType' => 1,
            	'PreferredCurrency' => 'USD',
            	'DropoffType' => 'REGULAR_PICKUP',
            	'Shipper' => array(
                    'Address' => array(
                        'PostalCode' => $this->settings['origin'],
                        'CountryCode' => $origin_country,
                    ),
                ),
                'Recipient' => array(
                    'Address' => array(
                        'Residential' => '',
                        'PostalCode' => '90017',
                        'City' => 'LOSE ANGELES',
                        'StateOrProvinceCode' => 'CA',
                        'CountryCode' => 'US',
                    ),
                ),
                'RequestedPackageLineItems' => array(
                    0 => array(
                        'SequenceNumber' => 1,
                        'GroupNumber' => 1,
                        'GroupPackageCount' => 1,
                        'Weight' => array(
                            'Value' => '5.52',
                            'Units' => 'LB',
                        ),
                    ),
                ),
        	),
		);

		$client = $this->wf_create_soap_client( plugin_dir_path( dirname( __FILE__ ) ) . '/../fedex-wsdl/' . ( $production=='yes' ? 'production' : 'test' ) . '/RateService_v' . $this->rateservice_version. '.wsdl' );

		if( $this->soap_method == 'nusoap' ){
			$result = $client->call( 'getRates', array( 'RateRequest' => $request ) );
			$result = json_decode( json_encode( $result ), false );
		}
		else{
			$result = $client->getRates( $request );
		}

		if ( $result && ! empty ( $result->RateReplyDetails ) ) {
			update_option('xa_fedex_shipping_validation_data','done');
			update_option('xa_fedex_validation_error','');
		}elseif( isset($result->HighestSeverity) && $result->HighestSeverity=='ERROR' ){
			$error_message = isset($result->Notifications->Message) ?  $result->Notifications->Message : '';
            update_option('xa_fedex_validation_error','<small style="color:red">'.$error_message.'</small>');
			update_option('xa_fedex_shipping_validation_data','undone');
		}else{
			update_option('xa_fedex_validation_error','<small style="color:red">Not able to validate the Credential</small>');
			update_option('xa_fedex_shipping_validation_data','undone');
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

	private function xa_save_fedex_general_settings(){
		$validate=true; //Remove this onece validate code is done
		if($validate){

			$saved_site_mode		= ( isset($this->settings['production']) && ($this->settings['production'] =='yes') ) ? 'yes' : 'no';
			$saved_account_number	= ( isset($this->settings['account_number']) ) ? $this->settings['account_number'] : '';
			$saved_meter_number		= ( isset($this->settings['meter_number']) ) ? $this->settings['meter_number'] : '';
			$saved_api_key			= ( isset($this->settings['api_key']) ) ? $this->settings['api_key'] : '';
			$saved_api_pass			= ( isset($this->settings['api_pass']) ) ? $this->settings['api_pass'] : '';
			

			$this->settings['production']				= isset($_POST['production']) ? $_POST['production'] : $saved_site_mode;
			$this->settings['account_number']			= ( isset($_POST['account_number'])) ? sanitize_text_field($_POST['account_number']) : $saved_account_number;
			$this->settings['meter_number']				= ( isset($_POST['meter_number'])) ? sanitize_text_field($_POST['meter_number']) : $saved_meter_number;
			$this->settings['api_key']					= ( isset($_POST['api_key'])) ? sanitize_text_field($_POST['api_key']) : $saved_api_key;
			$this->settings['api_pass']					= ( isset($_POST['api_pass'])) ? sanitize_text_field($_POST['api_pass']) : $saved_api_pass;
			
			$this->settings['enabled']					= ( isset($_POST['rates']) ) ? 'yes' : 'no';
			$this->settings['insure_contents']			= ( isset($_POST['insure_contents']) ) ? 'yes' : '';
			$this->settings['debug']					= ( isset($_POST['debug']) ) ? 'yes' : '';
			$this->settings['residential']				= ( isset($_POST['residential']) ) ? 'yes' : '';
			$this->settings['exclude_tax']				= ( isset($_POST['exclude_tax']) ) ? 'yes' : '';
			$this->settings['dry_ice_enabled']			= ( isset($_POST['dry_ice_enabled']) ) ? 'yes' : '';

			$this->settings['dimension_weight_unit']	= ( isset($_POST['dimension_weight_unit']) ) ? $_POST['dimension_weight_unit'] : '';
			$this->settings['indicia']					= ( isset($_POST['indicia']) ) ? $_POST['indicia'] : '';
			
			$this->settings['charges_payment_type']		= ( isset($_POST['charges_payment_type']) ) ? $_POST['charges_payment_type'] : '';
			$this->settings['shipping_payor_acc_no']		= ( isset($_POST['shipping_payor_acc_no']) ) ? $_POST['shipping_payor_acc_no'] : '';
			$this->settings['shipping_payor_cname']		= ( isset($_POST['shipping_payor_cname']) ) ? $_POST['shipping_payor_cname'] : '';
			$this->settings['shipp_payor_company']		= ( isset($_POST['shipp_payor_company']) ) ? $_POST['shipp_payor_company'] : '';
			$this->settings['shipping_payor_phone']		= ( isset($_POST['shipping_payor_phone']) ) ? $_POST['shipping_payor_phone'] : '';
			$this->settings['shipping_payor_email']		= ( isset($_POST['shipping_payor_email']) ) ? $_POST['shipping_payor_email'] : '';
			$this->settings['shipp_payor_address1']		= ( isset($_POST['shipp_payor_address1']) ) ? $_POST['shipp_payor_address1'] : '';
			$this->settings['shipp_payor_address2']		= ( isset($_POST['shipp_payor_address2']) ) ? $_POST['shipp_payor_address2'] : '';
			$this->settings['shipping_payor_city']		= ( isset($_POST['shipping_payor_city']) ) ? $_POST['shipping_payor_city'] : '';
			$this->settings['shipping_payor_state']		= ( isset($_POST['shipping_payor_state']) ) ? $_POST['shipping_payor_state'] : '';
			$this->settings['shipping_payor_zip']		= ( isset($_POST['shipping_payor_zip']) ) ? $_POST['shipping_payor_zip'] : '';
			$this->settings['shipp_payor_country']		= ( isset($_POST['shipp_payor_country']) ) ? $_POST['shipp_payor_country'] : '';
			
			$this->settings['customs_duties_payer']		= ( isset($_POST['customs_duties_payer']) ) ? $_POST['customs_duties_payer'] : '';
			$this->settings['broker_acc_no']			= ( isset($_POST['broker_acc_no']) ) ? $_POST['broker_acc_no'] : '';
			$this->settings['broker_name']				= ( isset($_POST['broker_name']) ) ? $_POST['broker_name'] : '';
			$this->settings['broker_company']			= ( isset($_POST['broker_company']) ) ? $_POST['broker_company'] : '';
			$this->settings['broker_phone']				= ( isset($_POST['broker_phone']) ) ? $_POST['broker_phone'] : '';
			$this->settings['broker_email']				= ( isset($_POST['broker_email']) ) ? $_POST['broker_email'] : '';
			$this->settings['broker_address']			= ( isset($_POST['broker_address']) ) ? $_POST['broker_address'] : '';
			$this->settings['broker_city']				= ( isset($_POST['broker_city']) ) ? $_POST['broker_city'] : '';
			$this->settings['broker_state']				= ( isset($_POST['broker_state']) ) ? $_POST['broker_state'] : '';
			$this->settings['broker_zipcode']			= ( isset($_POST['broker_zipcode']) ) ? $_POST['broker_zipcode'] : '';
			$this->settings['broker_country']			= ( isset($_POST['broker_country']) ) ? $_POST['broker_country'] : '';
			
			$this->settings['shipper_person_name']		= ( isset($_POST['shipper_person_name']) ) ? sanitize_text_field($_POST['shipper_person_name']) : '';
			$this->settings['shipper_company_name']		= ( isset($_POST['shipper_company_name']) ) ? sanitize_text_field($_POST['shipper_company_name']) : '';
			$this->settings['shipper_phone_number']		= ( isset($_POST['shipper_phone_number']) ) ? sanitize_text_field($_POST['shipper_phone_number']) : '';
			$this->settings['shipper_email']			= ( isset($_POST['shipper_email'])) ? sanitize_text_field($_POST['shipper_email']) : '';
			$this->settings['frt_shipper_street']		= ( isset($_POST['frt_shipper_street']) ) ? sanitize_text_field($_POST['frt_shipper_street']) : '';
			$this->settings['shipper_street_2']			= ( isset($_POST['shipper_street_2']) ) ? sanitize_text_field($_POST['shipper_street_2']) : '';
			$this->settings['freight_shipper_city']		= ( isset($_POST['freight_shipper_city']) ) ? sanitize_text_field($_POST['freight_shipper_city']) : '';
			$this->settings['origin_country']			= ( isset($_POST['origin_country']) ) ? sanitize_text_field($_POST['origin_country']) : '';
			$this->settings['origin']					= ( isset($_POST['origin']) ) ? ($_POST['origin']) : '';
			$this->settings['shipper_residential']		= ( isset($_POST['shipper_residential']) ) ? 'yes' : '';
			
			$this->settings['signature_option']			= ( isset($_POST['signature_option']) ) ? $_POST['signature_option'] : '';
			$this->settings['smartpost_hub']			= ( isset($_POST['smartpost_hub']) ) ? $_POST['smartpost_hub'] : '';

			update_option('woocommerce_'.WF_Fedex_ID.'_settings',$this->settings);
		}
	}

	private function xa_save_fedex_rate_settings(){
		$this->settings['delivery_time']			= ( isset($_POST['delivery_time']) ) ? 'yes' : '';
		$this->settings['request_type']				= ( isset($_POST['request_type']) && $_POST['request_type'] == 'yes' ) ? 'ACCOUNT' : 'LIST';
		$this->settings['offer_rates']				= ( isset($_POST['offer_rates']) && $_POST['offer_rates'] == 'yes' ) ? 'cheapest' : 'all';
		$this->settings['fedex_one_rate']			= ( isset($_POST['fedex_one_rate']) ) ? 'yes' : '';
		$this->settings['convert_currency']			= ( isset($_POST['convert_currency']) ) ? 'yes' : '';
		
		$this->settings['title']					= ( isset($_POST['title']) ) ? $_POST['title'] : '';
		$this->settings['availability']				= ( isset($_POST['availability']) && $_POST['availability'] == 'specific' ) ? 'specific' : 'all';
		$this->settings['countries']				= ( isset($_POST['countries']) ) ? $_POST['countries'] : '';
		$this->settings['min_amount']				= ( isset($_POST['min_amount']) ) ? $_POST['min_amount'] : '';
		$this->settings['services']					= $this->validate_services_field();
		$this->settings['conversion_rate'] 			= ( isset($_POST['conversion_rate']) ) ? $_POST['conversion_rate'] : '';

		update_option('woocommerce_'.WF_Fedex_ID.'_settings',$this->settings);
	}

	private function xa_save_fedex_label_settings(){
		$this->settings['frontend_retun_label']				= ( isset($_POST['frontend_retun_label']) ) ? 'yes' : '';
		$this->settings['xa_show_all_shipping_methods']		= ( isset($_POST['xa_show_all_shipping_methods']) ) ? 'yes' : '';
		$this->settings['xa_show_all_shipping_methods']		= ( isset($_POST['xa_show_all_shipping_methods']) ) ? 'yes' : '';
		$this->settings['automate_package_generation']		= ( isset($_POST['automate_package_generation']) ) ? 'yes' : '';
		$this->settings['automate_label_generation']		= ( isset($_POST['automate_label_generation']) ) ? 'yes' : '';
		$this->settings['auto_email_label']					= ( isset($_POST['auto_email_label']) ) ? 'yes' : '';
		$this->settings['allow_label_btn_on_myaccount']		= ( isset($_POST['allow_label_btn_on_myaccount']) ) ? 'yes' : '';
		$this->settings['email_content']					= ( isset($_POST['email_content']) ) ? $_POST['email_content'] : '';

		$this->settings['commercial_invoice']				= ( isset($_POST['commercial_invoice']) ) ? 'yes' : '';
		
		$this->settings['company_logo']						= ( isset($_POST['company_logo']) ) ? $_POST['company_logo'] : '';
		$this->settings['digital_signature']				= ( isset($_POST['digital_signature']) ) ? $_POST['digital_signature'] : '';
		$this->settings['output_format']					= ( isset($_POST['output_format']) ) ? $_POST['output_format'] : '';
		$this->settings['image_type']						= ( isset($_POST['image_type']) ) ? $_POST['image_type'] : '';
		$this->settings['default_dom_service']				= ( isset($_POST['default_dom_service']) ) ? $_POST['default_dom_service'] : '';
		$this->settings['default_int_service']				= ( isset($_POST['default_int_service']) ) ? $_POST['default_int_service'] : '';
		$this->settings['customs_ship_purpose']				= ( isset($_POST['customs_ship_purpose']) ) ? $_POST['customs_ship_purpose'] : '';
		$this->settings['tracking_shipmentid']				= ( isset($_POST['tracking_shipmentid']) ) ? $_POST['tracking_shipmentid'] : '';
		$this->settings['custom_message']					= ( isset($_POST['custom_message']) ) ? $_POST['custom_message'] : '';
		$this->settings['email_notification']				= ( isset($_POST['email_notification']) ) ? $_POST['email_notification'] : '';
		$this->settings['timezone_offset']					= ( isset($_POST['timezone_offset']) ) ? $_POST['timezone_offset'] : '';
		$this->settings['tin_number']						= ( isset($_POST['tin_number']) ) ? $_POST['tin_number'] : '';
		$this->settings['tin_type']							= ( isset($_POST['tin_type']) ) ? $_POST['tin_type'] : '';
		$this->settings['cod_collection_type']				= ( isset($_POST['cod_collection_type']) ) ? $_POST['cod_collection_type'] : '';
			
		update_option('woocommerce_'.WF_Fedex_ID.'_settings',$this->settings);
	}

	private function xa_save_fedex_packing_settings(){
		$this->settings['packing_method']			= isset($_POST['packing_method']) ? $_POST['packing_method'] : '';
		$this->settings['dimension_weight_unit']	= isset($_POST['dimension_weight_unit']) ? $_POST['dimension_weight_unit'] : '';
		$this->settings['box_max_weight']			= isset($_POST['box_max_weight']) ? $_POST['box_max_weight'] : '';
		$this->settings['weight_pack_process']		= isset($_POST['weight_pack_process']) ? $_POST['weight_pack_process'] : '';
		$this->settings['enable_speciality_box']	= isset($_POST['enable_speciality_box']) ? $_POST['enable_speciality_box'] : '';
		
		$this->settings['boxes']					= $this->validate_box_packing_field();
		
		update_option('woocommerce_'.WF_Fedex_ID.'_settings',$this->settings);
	}

	private function xa_save_fedex_pickup_settings(){
		$this->settings['pickup_enabled']				= ( isset($_POST['pickup_enabled']) ) ? 'yes' : '';
		$this->settings['use_pickup_address']			= ( isset($_POST['use_pickup_address']) ) ? 'yes' : '';
		
		$this->settings['pickup_contact_name']			= ( isset($_POST['pickup_contact_name']) ) ? sanitize_text_field($_POST['pickup_contact_name']) : '';
		$this->settings['pickup_company_name']			= ( isset($_POST['pickup_company_name']) ) ? sanitize_text_field($_POST['pickup_company_name']) : '';
		$this->settings['pickup_phone_number']			= ( isset($_POST['pickup_phone_number']) ) ? sanitize_text_field($_POST['pickup_phone_number']) : '';
		$this->settings['pickup_address_line']			= ( isset($_POST['pickup_address_line']) ) ? sanitize_text_field($_POST['pickup_address_line']) : '';
		$this->settings['pickup_address_city']			= ( isset($_POST['pickup_address_city']) ) ? sanitize_text_field($_POST['pickup_address_city']) : '';
		$this->settings['pickup_address_state_code']	= ( isset($_POST['pickup_address_state_code']) ) ? sanitize_text_field($_POST['pickup_address_state_code']) : '';
		$this->settings['pickup_address_postal_code']	= ( isset($_POST['pickup_address_postal_code']) ) ? sanitize_text_field($_POST['pickup_address_postal_code']) : '';
		$this->settings['pickup_address_country_code']	= ( isset($_POST['pickup_address_country_code']) ) ? sanitize_text_field($_POST['pickup_address_country_code']) : '';

		$this->settings['pickup_start_time']			= ( isset($_POST['pickup_start_time']) ) ? $_POST['pickup_start_time'] : '';
		$this->settings['pickup_close_time']			= ( isset($_POST['pickup_close_time']) ) ? $_POST['pickup_close_time'] : '';
		$this->settings['pickup_service']				= ( isset($_POST['pickup_service']) ) ? $_POST['pickup_service'] : '';

		update_option('woocommerce_'.WF_Fedex_ID.'_settings',$this->settings);
	}

	private function xa_save_fedex_freight_settings(){
		$this->settings['freight_enabled']			= ( isset($_POST['freight_enabled']) ) ? 'yes' : '';
		$this->settings['freight_number']			= ( isset($_POST['freight_number']) ) ? sanitize_text_field($_POST['freight_number']) : '';
		$this->settings['freight_bill_street']		= ( isset($_POST['freight_bill_street']) ) ? sanitize_text_field($_POST['freight_bill_street']) : '';
		$this->settings['billing_street_2']			= ( isset($_POST['billing_street_2']) ) ? sanitize_text_field($_POST['billing_street_2']) : '';
		$this->settings['freight_billing_city']		= ( isset($_POST['freight_billing_city']) ) ? sanitize_text_field($_POST['freight_billing_city']) : '';
		$this->settings['freight_billing_state']	= ( isset($_POST['freight_billing_state']) ) ? sanitize_text_field($_POST['freight_billing_state']) : '';
		$this->settings['billing_postcode']			= ( isset($_POST['billing_postcode']) ) ? sanitize_text_field($_POST['billing_postcode']) : '';
		$this->settings['billing_country']			= ( isset($_POST['billing_country']) ) ? sanitize_text_field($_POST['billing_country']) : '';
		$this->settings['freight_class']			= ( isset($_POST['freight_class']) ) ? sanitize_text_field($_POST['freight_class']) : '';
		
		update_option('woocommerce_'.WF_Fedex_ID.'_settings',$this->settings);
	}

	private function validate_services_field() {
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
	
	public function validate_box_packing_field() {
		$box_type			= isset( $_POST['box_type'] ) ? $_POST['box_type'] : array();
		$boxes_name			= isset( $_POST['boxes_name'] ) ? $_POST['boxes_name'] : array();
		$boxes_length		= isset( $_POST['boxes_length'] ) ? $_POST['boxes_length'] : array();
		$boxes_width		= isset( $_POST['boxes_width'] ) ? $_POST['boxes_width'] : array();
		$boxes_height		= isset( $_POST['boxes_height'] ) ? $_POST['boxes_height'] : array();

		$boxes_inner_length	= isset( $_POST['boxes_inner_length'] ) ? $_POST['boxes_inner_length'] : array();
		$boxes_inner_width	= isset( $_POST['boxes_inner_width'] ) ? $_POST['boxes_inner_width'] : array();
		$boxes_inner_height	= isset( $_POST['boxes_inner_height'] ) ? $_POST['boxes_inner_height'] : array();
		
		$boxes_box_weight	= isset( $_POST['boxes_box_weight'] ) ? $_POST['boxes_box_weight'] : array();
		$boxes_max_weight	= isset( $_POST['boxes_max_weight'] ) ? $_POST['boxes_max_weight'] :  array();
		$boxes_enabled		= isset( $_POST['boxes_enabled'] ) ? $_POST['boxes_enabled'] : array();

		$boxes = array();
		if ( ! empty( $boxes_length ) && sizeof( $boxes_length ) > 0 ) {
			for ( $i = 0; $i <= max( array_keys( $boxes_length ) ); $i ++ ) {

				if ( ! isset( $boxes_length[ $i ] ) )
					continue;

				if ( $boxes_length[ $i ] && $boxes_width[ $i ] && $boxes_height[ $i ] ) {

					$boxes[] = array(
						'box_type'	 => isset( $box_type[ $i ] ) ? $box_type[ $i ] : '',
						'name'	  => strval($boxes_name[$i]),
												'length'	 => floatval( $boxes_length[ $i ] ),
						'width'	  => floatval( $boxes_width[ $i ] ),
						'height'	 => floatval( $boxes_height[ $i ] ),

						/* Old version compatibility: If inner dimensions are not provided, assume outer dimensions as inner.*/
						'inner_length'	=> isset( $boxes_inner_length[ $i ] ) ? floatval( $boxes_inner_length[ $i ] ) : floatval( $boxes_length[ $i ] ),
						'inner_width'	=> isset( $boxes_inner_width[ $i ] ) ? floatval( $boxes_inner_width[ $i ] ) : floatval( $boxes_width[ $i ] ), 
						'inner_height'	=> isset( $boxes_inner_height[ $i ] ) ? floatval( $boxes_inner_height[ $i ] ) : floatval( $boxes_height[ $i ] ),
						
						'box_weight' => floatval( $boxes_box_weight[ $i ] ),
						'max_weight' => floatval( $boxes_max_weight[ $i ] ),
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

	public function xa_load_general_settings(){
		ob_start();
		include( 'html-xa-general-settings.php' );
		echo ob_get_clean();
	}

	public function xa_load_rate_settings(){
		ob_start();
		include( 'html-xa-rate-settings.php' );
		echo ob_get_clean();
	}
	
	public function xa_load_label_settings(){
		ob_start();
		include( 'html-xa-labels-settings.php' );
		echo ob_get_clean();
	}

	public function xa_load_packing_settings(){
		ob_start();
		include( 'html-xa-packing-settings.php' );
		echo ob_get_clean();
	}

	public function xa_load_pickup_settings(){
		ob_start();
		include( 'html-xa-pickup-settings.php' );
		echo ob_get_clean();
	}

	public function xa_load_freight_settings(){
		ob_start();
		include( 'html-xa-freight-settings.php' );
		echo ob_get_clean();
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
}
