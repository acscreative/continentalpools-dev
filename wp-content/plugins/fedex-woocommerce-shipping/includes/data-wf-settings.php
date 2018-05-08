<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$freight_classes = include( 'data-wf-freight-classes.php' );
$smartpost_hubs  = include( 'data-wf-smartpost-hubs.php' );
$smartpost_hubs  = array( '' => __( 'N/A', 'wf-shipping-fedex' ) ) + $smartpost_hubs;

$ship_from_address_option = array(
				'origin_address' => __('Origin Address', 'wf-shipping-fedex'),
				'shipping_address' => __('Shipping Address', 'wf-shipping-fedex')
				);
$ship_from_address_options = apply_filters('wf_filter_label_ship_from_address_options', $ship_from_address_option);

$pickup_start_time_options	=	array();
foreach(range(8,18,0.5) as $pickup_start_time){ // Pickup ready time must contain a time between 08:00am and 06:00pm
	$pickup_start_time_options[(string)$pickup_start_time]	=	date("H:i",strtotime(date('Y-m-d'))+3600*$pickup_start_time);
}

$pickup_close_time_options	=	array();
foreach(range(8.5,24,0.5) as $pickup_close_time){ // Pickup ready time must contain a time between 08:00am and 06:00pm
	$pickup_close_time_options[(string)$pickup_close_time]	=	date("H:i",strtotime(date('Y-m-d'))+3600*$pickup_close_time);
}


$wc_countries   = new WC_Countries();
// This function will not support prior to WC 2.2
$country_list   = $wc_countries->get_countries();
global $woocommerce;
array_unshift( $country_list, "" );

$services = include('data-wf-service-codes.php');
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


/**
 * Array of settings
 */
return array(
	'tabs_wrapper'=>array(
		'type'=>'settings_tabs'
	),
	'licence'  => array(
		'type'			=> 'activate_box'
	),


	'title_rate'		   => array(
		'title'		   => __( 'Rate Settings', 'wf-shipping-fedex' ),
		'type'			=> 'title',
		'class'			=> 'fedex_rates_tab',
		'description'	 => __( 'Configure the rate related settings here. You can enable desired FedEx services and other rate options.', 'wf-shipping-fedex' ),
	),
	'enabled'		  => array(
		'title'		   	=> __( 'Realtime Rates', 'wf-shipping-fedex' ),
		'type'			=> 'checkbox',
		'label'			=> __( 'Enable', 'wf-shipping-fedex' ),
		'default'		=> 'no',
		'class'			=>'fedex_rates_tab'
	),
	'title'			=> array(
		'title'		   => __( 'Method Title', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'description'	 => __( 'This controls the title which the user sees during checkout.', 'wf-shipping-fedex' ),
		'default'		 => __( 'FedEx', 'wf-shipping-fedex' ),
		'desc_tip'		=> true,
		'class'			=>'fedex_rates_tab'
	),
	'availability'		=> array(
		'title'		   => __( 'Method Available to', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'default'		 => 'all',
		'class'		   => 'availability wc-enhanced-select fedex_rates_tab',
		'options'		 => array(
			'all'			=> __( 'All Countries', 'wf-shipping-fedex' ),
			'specific'	   => __( 'Specific Countries', 'wf-shipping-fedex' ),
		),
	),
	'countries'		   => array(
		'title'		   => __( 'Specific Countries', 'wf-shipping-fedex' ),
		'type'			=> 'multiselect',
		'class'		   => 'chosen_select fedex_rates_tab',
		'css'			 => 'width: 450px;',
		'default'		 => '',
		'options'		 => $woocommerce->countries->get_allowed_countries(),
	),
	'delivery_time'	  => array(
		'title'		   => __( 'Show Delivery Time', 'wf-shipping-fedex' ),
		'label'		   => __( 'Enable', 'wf-shipping-fedex' ),
		'type'			=> 'checkbox',
		'default'		 => 'no',
		'desc_tip'	=> true,
		'class'			=>'fedex_rates_tab',
		'description'	 => __( 'Enable Show delivery time to show delivery information on the cart/checkout. Applicable for US destinations only.', 'wf-shipping-fedex' )
	),



	'api'					=> array(
		'title'			  => __( 'Generic API Settings', 'wf-shipping-fedex' ),
		'type'			   => 'title',
		'description'		=> __( 'After signup, get a <a href="https://www.fedex.com/wpor/web/jsp/drclinks.jsp?links=wss/develop.html">developer key here</a>. After testing you can get a <a href="https://www.fedex.com/wpor/web/jsp/drclinks.jsp?links=wss/production.html">production key here</a>.', 'wf-shipping-fedex' ),
		'class'			=>'fedex_general_tab',
	),
	'account_number'		   => array(
		'title'		   => __( 'FedEx Account Number', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'description'	 => '',
		'default'		 => '',
		'class'			=>'fedex_general_tab',
	),
	'meter_number'		   => array(
		'title'		   => __( 'Fedex Meter Number', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'description'	 => '',
		'default'		 => '',
		'class'			=>'fedex_general_tab',

	),
	'api_key'		   => array(
		'title'		   => __( 'Web Services Key', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'description'	 => '',
		'default'		 => '',
		'class'			=>'fedex_general_tab',
		'custom_attributes' => array('autocomplete' => 'off'),
	),
	'api_pass'		   => array(
		'title'		   => __( 'Web Services Password', 'wf-shipping-fedex' ),
		'type'			=> 'password',
		'description'	 => '',
		'default'		 => '',
		'class'			=>'fedex_general_tab',
		'custom_attributes' => array('autocomplete' => 'off'),
	),
	'production'	  => array(
		'title'		   => __( 'Production Key', 'wf-shipping-fedex' ),
		'label'		   => __( 'This is a production key', 'wf-shipping-fedex' ),
		'type'			=> 'checkbox',
		'default'		 => 'no',
		'desc_tip'	=> true,
		'class'			=>'fedex_general_tab',
		'description'	 => __( 'If this is a production API key and not a developer key, check this box.', 'wf-shipping-fedex' ),
	),

	'validate_credentials' => array(
		'type'			=> 'validate_button',
	),

	'debug'	  => array(
		'title'		   => __( 'Debug Mode', 'wf-shipping-fedex' ),
		'label'		   => __( 'Enable', 'wf-shipping-fedex' ),
		'type'			=> 'checkbox',
		'default'		 => 'no',
		'desc_tip'	=> true,
		'description'	 => __( 'Enable debug mode to show debugging information on the cart/checkout.', 'wf-shipping-fedex' ),
		'class'			=>'fedex_general_tab',
	),


	'title_label'		   => array(
		'title'		   => __( 'Label Settings', 'wf-shipping-fedex' ),
		'type'			=> 'title',
		'class'			=> 'fedex_label_tab',
		'description'	 => __( 'Configure the label and tracking related settings here.', 'wf-shipping-fedex' ),
	),
	'timezone_offset' => array(
		'title' 		=> __('Time Zone Offset (Minutes)', 'wf-shipping-fedex'),
		'type' 			=> 'text',
		'description' 	=> __('Please enter a value in this field, if you want to change the shipment time while Label Printing. Enter a negetive value to reduce the time.','wf-shipping-fedex'),
		'class'			=>'fedex_label_tab',
		'desc_tip' 		=> true
	),
	'dimension_weight_unit' => array(
			'title'		   => __( 'Dimension/Weight Unit', 'wwf-shipping-fedex' ),
			'label'		   => __( 'This unit will be passed to FedEx.', 'wf-shipping-fedex' ),
			'type'			=> 'select',
			'default'		 => 'LBS_IN',
			'class'		   => 'wc-enhanced-select fedex_general_tab',
			'desc_tip'	=> true,
			'description'	 => 'Product dimensions and weight will be converted to the selected unit and will be passed to FedEx.',
			'options'		 => array(
				'LBS_IN'	=> __( 'Pounds & Inches', 'wf-shipping-fedex'),
				'KG_CM' 	=> __( 'Kilograms & Centimeters', 'wf-shipping-fedex')			
			)
	),
	'residential'	  => array(
		'title'		   => __( 'Residential Delivery', 'wf-shipping-fedex' ),
		'label'		   => __( 'Default to residential delivery.', 'wf-shipping-fedex' ),
		'type'			=> 'checkbox',
		'default'		 => 'no',
		'desc_tip'	=> true,
		'class'		=>'fedex_general_tab',
		'description'	 => __( 'Enables residential flag. If you account has Address Validation enabled, this will be turned off/on automatically.', 'wf-shipping-fedex' ),
	),
	'insure_contents'	  => array(
		'title'	   => __( 'Insurance', 'wf-shipping-fedex' ),
		'label'	   => __( 'Enable Insurance', 'wf-shipping-fedex' ),
		'type'		=> 'checkbox',
		'default'	 => 'yes',
		'class'			=>'fedex_general_tab',
		'desc_tip'	=> true,
		'description' => __( 'Sends the package value to FedEx for insurance.', 'wf-shipping-fedex' ),
	),
	'fedex_one_rate'	  => array(
		'title'	   => __( 'Fedex One', 'wf-shipping-fedex' ),
		'label'	   => sprintf( __( 'Enable %sFedex One Rates%s', 'wf-shipping-fedex' ), '<a href="https://www.fedex.com/us/onerate/" target="_blank">', '</a>' ),
		'type'		=> 'checkbox',
		'class'		=>'fedex_rates_tab',
		'default'	 => 'yes',
		'desc_tip'	=> true,
		'description' => __( 'Fedex One Rates will be offered if the items are packed into a valid Fedex One box, and the origin and destination is the US. For other countries this option will enable FedEx packing. Note: All FedEx boxes are not available for all countries, disable this option or disable different boxes if you are not receiving any shipping services.', 'wf-shipping-fedex' ),
	),
	'request_type'	 => array(
		'title'		   => __( 'Request Type', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'default'		 => 'LIST',
		'class'		   => 'wc-enhanced-select fedex_rates_tab',
		'desc_tip'		=> true,
		'options'		 => array(
			'LIST'		=> __( 'List Rates', 'wf-shipping-fedex' ),
			'ACCOUNT'	 => __( 'Account Rates', 'wf-shipping-fedex' ),
		),
		'description'	 => __( 'Choose whether to return List or Account (discounted) rates from the API.', 'wf-shipping-fedex' )
	),
	'signature_option'	 => array(
		'title'		   => __( 'Delivery Signature', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'default'		 => '',
		'class'		   => 'wc-enhanced-select fedex_general_tab',
		'desc_tip'		=> true,
		'options'		 => array(
			''	   				=> __( '-Select one-', 'wf-shipping-fedex' ),
			'ADULT'	   			=> __( 'Adult', 'wf-shipping-fedex' ),
			'DIRECT'	  			=> __( 'Direct', 'wf-shipping-fedex' ),
			'INDIRECT'	  		=> __( 'Indirect', 'wf-shipping-fedex' ),
			'NO_SIGNATURE_REQUIRED' => __( 'No Signature Required', 'wf-shipping-fedex' ),
			'SERVICE_DEFAULT'	  	=> __( 'Service Default', 'wf-shipping-fedex' ),
		),
		'description'	 => __( 'FedEx Web Services selects the appropriate signature option for your shipping service.', 'wf-shipping-fedex' )
	),
	'smartpost_hub'		   => array(
		'title'		   => __( 'Fedex SmartPost Hub', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'class'		   => 'wc-enhanced-select fedex_general_tab',
		'description'	 => __( 'Only required if using SmartPost.', 'wf-shipping-fedex' ),
		'desc_tip'		=> true,
		'default'		 => '',
		'options'		 => $smartpost_hubs
	),
	'indicia'   => array(
		'title'		   => __( 'Indicia', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'desc_tip'	=> true,
		'description'	 => 'Applicable only for SmartPost. Ex: Parcel Select option requires weight of at-least 1LB. Automatic will choose PRESORTED STANDARD if the weight is less than 1lb and PARCEL SELECT if the weight is more than 1lb',
		'default'		 => 'PARCEL_SELECT',
		'class'		   => 'wc-enhanced-select fedex_general_tab',
		'options'		 => array(
			'MEDIA_MAIL'		 => __( 'MEDIA MAIL', 'wf-shipping-fedex' ),
			'PARCEL_RETURN'	=> __( 'PARCEL RETURN', 'wf-shipping-fedex' ),
			'PARCEL_SELECT'	=> __( 'PARCEL SELECT', 'wf-shipping-fedex' ),
			'PRESORTED_BOUND_PRINTED_MATTER' => __( 'PRESORTED BOUND PRINTED MATTER', 'wf-shipping-fedex' ),
			'PRESORTED_STANDARD' => __( 'PRESORTED STANDARD', 'wf-shipping-fedex' ),
			'AUTOMATIC' => __( 'AUTOMATIC', 'wf-shipping-fedex' )
		),
	),
	'offer_rates'   => array(
		'title'		   => __( 'Offer Rates', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'description'	 => '',
		'default'		 => 'all',
		'class'		   => 'wc-enhanced-select fedex_rates_tab',
		'options'		 => array(
			'all'		 => __( 'Offer the customer all returned rates', 'wf-shipping-fedex' ),
			'cheapest'	=> __( 'Offer the customer the cheapest rate only, anonymously', 'wf-shipping-fedex' ),
		),
	),

	//shipping_customs_duties_payer
	'customs_duties_payer'  => array(
		'title'		   => __( 'Customs Duties Payer', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'desc_tip'	=> true,
		'description'	 => 'Select customs duties payer',
		'default'		 => 'SENDER',
		'class'		   => 'wc-enhanced-select fedex_general_tab',
		'options'		 => array(
			'SENDER' 	  => __( 'Sender', 'wf-shipping-fedex'),
			'RECIPIENT'	  => __( 'Recipient', 'wf-shipping-fedex'),
			'THIRD_PARTY'	  => __( 'Third Party (Broker)', 'wf-shipping-fedex'),
		)				
	),

	'broker_acc_no'		   => array(
		'title'		   => __( 'Broker Account number', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'class'			  => 'broker_grp fedex_general_tab',
		'default'		 => '',
		'desc_tip'	=> true,
		'description'	 => 'Broker account number'			
	),	
	'broker_name'		   => array(
		'title'		   => __( 'Broker name', 'wf-shipping-fedex' ),
		'class'			  => 'broker_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'desc_tip'	=> true,
		'description'	 => 'Broker name'			
	),	
	'broker_company'		   => array(
		'title'		   => __( 'Broker Company name', 'wf-shipping-fedex' ),
		'class'			  => 'broker_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'desc_tip'	=> true,
		'description'	 => 'Broker Company Name'			
	),	
	'broker_phone'		   => array(
		'title'		   => __( 'Broker phone number', 'wf-shipping-fedex' ),
		'class'			  => 'broker_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'desc_tip'	=> true,
		'description'	 => 'Broker phone number'			
	),	
	'broker_email'		   => array(
		'title'		   => __( 'Brocker Email Address', 'wf-shipping-fedex' ),
		'class'			  => 'broker_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'desc_tip'	=> true,
	),	
	'broker_address'		   => array(
		'title'		   => __( 'Broker Address', 'wf-shipping-fedex' ),
		'class'			  => 'broker_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'desc_tip'	=> true,
	),	
	'broker_city'		   => array(
		'title'		   => __( 'Broker City', 'wf-shipping-fedex' ),
		'class'			  => 'broker_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'desc_tip'	=> true,
	),	
	'broker_state'		   => array(
		'title'		   => __( 'Broker State', 'wf-shipping-fedex' ),
		'class'			  => 'broker_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'desc_tip'	=> true,
	),	
	'broker_zipcode'		   => array(
		'title'		   => __( 'Zip Code', 'wf-shipping-fedex' ),
		'class'			  => 'broker_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'desc_tip'	=> true,
	),	
	'broker_country'		   => array(
		'title'		   => __( 'Country Code', 'wf-shipping-fedex' ),
		'class'			  => 'broker_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'desc_tip'	=> true,
	),	


	//shipping_customs_shipment_purpose
	'customs_ship_purpose'   => array(
		'title'		   => __( 'Purpose of Shipment', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'desc_tip'	=> true,
		'description'	 => 'Select purpose of shipment',
		'default'		 => 'SOLD',
		'class'		   => 'wc-enhanced-select fedex_label_tab',
		'options'		 => array(
			'GIFT' 				=> __( 'Gift', 				'wf-shipping-fedex'),
			'NOT_SOLD' 			=> __( 'Not Sold', 			'wf-shipping-fedex'),
			'PERSONAL_EFFECTS' 	=> __( 'Personal effects', 	'wf-shipping-fedex'),
			'REPAIR_AND_RETURN' => __( 'Repair and return', 'wf-shipping-fedex'),
			'SAMPLE' 			=> __( 'Sample', 			'wf-shipping-fedex'),
			'SOLD' 				=> __( 'Sold', 	 			'wf-shipping-fedex'),
		)				
	),
	'email_notification'	  => array(
		'title'		   => __( 'Email Notification', 'wf-shipping-fedex' ),
		'label'		   => __( 'Enable', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'default'		 => '',
		'class'		   => 'wc-enhanced-select fedex_label_tab',
		'options'		  => array(
			''					=> __('None',					'wf-shipping-fedex'),
			'CUSTOMER'			=> __('Customer',			'wf-shipping-fedex'),
			'SHIPPER'			=> __('Shipper',			'wf-shipping-fedex'),
			'BOTH'				=> __('Customer and Shipper',	'wf-shipping-fedex'),
		),
		'desc_tip'	=> true,
		'description'	 => __( 'Select recipients for email notifications regarding the shipment from FedEx', 'wf-shipping-fedex' )
	),

	'title_packaging'		   => array(
		'title'		   => __( 'Packaging Settings', 'wf-shipping-fedex' ),
		'type'			=> 'title',
		'class'			=> 'fedex_packaging_tab',
		'description'	 => __( 'Choose the packing options suitable for your store here.', 'wf-shipping-fedex' ),
	),
	'packing_method'   => array(
		'title'		   => __( 'Parcel Packing Method', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'default'		 => 'weight_based',
		'class'		   => 'packing_method wc-enhanced-select fedex_packaging_tab',
		'options'		 => array(
			'per_item'	   => __( 'Pack items individually', 'wf-shipping-fedex' ),
			'box_packing'	=> __( 'Pack into boxes with weights and dimensions', 'wf-shipping-fedex' ),
			'weight_based'   => __( 'Recommended: Weight based, calculate shipping based on weight', 'wf-shipping-fedex' ),
		),
		'desc_tip'	=> true,
		'description'	 => __( 'Determine how items are packed before being sent to FedEx.', 'wf-shipping-fedex' ),
	),
	'box_max_weight'		   => array(
		'title'		   => __( 'Max Package Weight', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'default'		 => '10',
		'class'		   => 'weight_based_option fedex_packaging_tab',
		'desc_tip'		=> true,
		'description'	 => __( 'Maximum weight allowed for single box.', 'wf-shipping-fedex' ),
	),

	//weight_packing_process
	'weight_pack_process'   => array(
		'title'		   => __( 'Packing Process', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'default'		 => '',
		'class'		   => 'weight_based_option wc-enhanced-select fedex_packaging_tab',
		'options'		 => array(
			'pack_descending'	   => __( 'Pack heavier items first', 'wf-shipping-fedex' ),
			'pack_ascending'		=> __( 'Pack lighter items first.', 'wf-shipping-fedex' ),
			'pack_simple'			=> __( 'Pack purely divided by weight.', 'wf-shipping-fedex' ),
		),
		'desc_tip'	=> true,
		'description'	 => __( 'Select your packing order.', 'wf-shipping-fedex' ),
	),

	'boxes'  => array(
		'type'			=> 'box_packing'
	),
	'enable_speciality_box'	  => array(
		'title'	   => __( 'Include Speciality boxes', 'wf-shipping-fedex' ),
		'label'	   => __( 'Enable', 'wf-shipping-fedex' ),
		'class'		  => 'speciality_box fedex_packaging_tab',
		'type'		=> 'checkbox',
		'default'	 => 'yes',
		'desc_tip'	=> true,
		'description' => __( 'Check this to load Speciality boxes with boxes.', 'wf-shipping-fedex' ),
	),
	'services'  => array(
		'type'			=> 'services'
	),

	'conversion_rate'	 => array(
		'title' 		  => __('Conversion Rate', 'wf-shipping-fedex'),
		'type' 			  => 'text',
		'default'		 => '',
		'class'			=>'fedex_rates_tab',
		'description' 	  => __('Enter the conversion amount in case you have a different currency set up comparing to the currency of origin location. This amount will be multiplied with the shipping rates. Leave it empty if no conversion required.','wf-shipping-fedex'),
		'desc_tip' 		  => true
	),
	'ship_from_address'   => array(
		'title'		   => __( 'Ship From Address Preference', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'class'		   => 'wc-enhanced-select fedex_general_tab',
		'default'		 => 'origin_address',
		'options'		 => $ship_from_address_options,
		'description'	 => __( 'Change the preference of Ship From Address printed on the label. You can make  use of Billing Address from Order admin page, if you ship from a different location other than shipment origin address given below.', 'wf-shipping-fedex' ),
		'desc_tip'		=> true
	),
	'origin'		   => array(
		'title'		   => __( 'Origin Postcode', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'desc_tip'	=> true,
		'class'	=> 'fedex_general_tab',
		'description'	 => __( 'Enter postcode for the <strong>Shipper</strong>.', 'wf-shipping-fedex' ),
		'default'		 => ''
	),
	'shipper_person_name'		   => array(
			'title'		   => __( 'Shipper Person Name', 'wf-shipping-fedex' ),
			'type'			=> 'text',
			'default'		 => '',
			'desc_tip'	=> true,
			'class'	=> 'fedex_general_tab',
			'description'	 => 'Required for label Printing'			
	),	
	'shipper_company_name'		   => array(
			'title'		   => __( 'Shipper Company Name', 'wf-shipping-fedex' ),
			'type'			=> 'text',
			'default'		 => ''	,
			'desc_tip'	=> true,
			'class'	=> 'fedex_general_tab',
			'description'	 => 'Required for label Printing'
	),	
	'shipper_phone_number'		   => array(
			'title'		   => __( 'Shipper Phone Number', 'wf-shipping-fedex' ),
			'type'			=> 'text',
			'default'		 => ''	,
			'desc_tip'	=> true,
			'class'	=> 'fedex_general_tab',
			'description'	 => 'Required for label Printing'
	),
	'shipper_email'		   => array(
			'title'		   => __( 'Shipper Email', 'wf-shipping-fedex' ),
			'type'			=> 'text',
			'default'		 => ''	,
			'desc_tip'	=> true,
			'class'	=> 'fedex_general_tab',
			'description'	 => 'Required for sending email notification'
	),

	//freight_shipper_street
	'frt_shipper_street'		   => array(
		'title'		   => __( 'Shipper Street Address', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'default'		 => '',
		'desc_tip'	=> true,
			'class'	=> 'fedex_general_tab',
		'description'	 => 'Required for label Printing. And should be filled if LTL Freight is enabled.'
	),
	'shipper_street_2'		   => array(
		'title'		   => __( 'Shipper Street Address 2', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'default'		 => '',
		'desc_tip'	=> true,
		'class'	=> 'fedex_general_tab',
		'description'	 => 'Required for label Printing. And should be filled if LTL Freight is enabled.'
	),
	'freight_shipper_city'		   => array(
		'title'		   => __( 'Shipper City', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'default'		 => '',
		'desc_tip'	=> true,
		'class'	=> 'fedex_general_tab',
		'description'	 => 'Required for label Printing. And should be filled if LTL Freight is enabled.'
	),
    'origin_country'    => array(
		'type'                => 'single_select_country',
	),
	'shipper_residential' 	=> array(
		'title'		   => __( 'Shipper Address is Residential', 'wf-shipping-fedex' ),
		'label'		   => __( 'Enable', 'wf-shipping-fedex' ),
		'type'			=> 'checkbox',
		'class'	=> 'fedex_general_tab',
		'default'		 => 'no'
	),	
	'output_format'   => array(
		'title'		   => __( 'Print Label Size', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'desc_tip'	=> true,
		'description'	 => '8.5x11 indicates paper and 4x6 indicates thermal size.',
		'default'		 => 'PAPER_4X6',
		'class'		   => 'wc-enhanced-select fedex_label_tab',
		'options'		 => array(
			'PAPER_4X6' 							  	=> __( 'PAPER_4X6', 						'wf-shipping-fedex'),
			'PAPER_4X8' 							  	=> __( 'PAPER_4X8', 						'wf-shipping-fedex'),
			'PAPER_4X9' 							  	=> __( 'PAPER_4X9', 						'wf-shipping-fedex'),
			//'PAPER_6X4' 							  	=> __( 'PAPER_6X4', 						'wf-shipping-fedex'),
			'PAPER_7X4.75' 						  		=> __( 'PAPER_7X4.75', 					'wf-shipping-fedex'),
			'PAPER_8.5X11_BOTTOM_HALF_LABEL' 		  	=> __( 'PAPER_8.5X11_BOTTOM_HALF_LABEL','wf-shipping-fedex'),
			'PAPER_8.5X11_TOP_HALF_LABEL'			  	=> __( 'PAPER_8.5X11_TOP_HALF_LABEL', 	'wf-shipping-fedex'),
			'PAPER_LETTER' 						  		=> __( 'PAPER_LETTER', 					'wf-shipping-fedex'),
			'STOCK_4X6' 						  		=> __( 'STOCK_4X6 (For Thermal Printer Only)', 					'wf-shipping-fedex'),
			'STOCK_4X6.75_LEADING_DOC_TAB' 				=> __( 'STOCK_4X6.75_LEADING_DOC_TAB (For Thermal Printer Only)', 	'wf-shipping-fedex'),
			'STOCK_4X6.75_TRAILING_DOC_TAB' 			=> __( 'STOCK_4X6.75_TRAILING_DOC_TAB (For Thermal Printer Only)', 'wf-shipping-fedex'),
			'STOCK_4X8' 						  		=> __( 'STOCK_4X8 (For Thermal Printer Only)', 					'wf-shipping-fedex'),
			'STOCK_4X9_LEADING_DOC_TAB' 				=> __( 'STOCK_4X9_LEADING_DOC_TAB (For Thermal Printer Only)', 	'wf-shipping-fedex'),
			'STOCK_4X9_TRAILING_DOC_TAB' 				=> __( 'STOCK_4X9_TRAILING_DOC_TAB (For Thermal Printer Only)', 	'wf-shipping-fedex'),
		)				
	),
	'image_type'   => array(
		'title'		   => __( 'Image Type', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'class'		   => 'wc-enhanced-select fedex_label_tab',
		'desc_tip'	=> true,
		'description'	 => '4x6 output format best fit with type PNG',
		'default'		 => 'pdf',
		'options'		 => array(
			'pdf' 							  	=> __( 'PDF', 						'wf-shipping-fedex'),
			'png' 							  	=> __( 'PNG', 						'wf-shipping-fedex'),
			'dpl' 							  	=> __( 'DPL', 						'wf-shipping-fedex'),
			'epl2' 							  	=> __( 'EPL2', 						'wf-shipping-fedex'),
			'zplii' 							=> __( 'ZPLII', 					'wf-shipping-fedex')
		)				
	),
	'tracking_shipmentid' => array(
			'title'		   => __( 'Tracking PIN', 'wf-shipping-fedex' ),
			'label'		   => __( 'Add Tracking PIN to customer order notes.', 'wf-shipping-fedex' ),
			'type'			=> 'checkbox',
			'default'		 => 'no',
			'class'			=> 'fedex_label_tab',
			'description'	 => '',
		),
	'custom_message'		=> array(
			'title'				=> __( 'Custom Shipment Message', 'wf-shipping-fedex' ),
			'type'				=> 'text',
			'class'			=> 'fedex_label_tab',
			'description'		=> __( 'Define your own shipment message. Use the place holder tags [ID], [SERVICE] and [DATE] for Shipment Id, Shipment Service and Shipment Date respectively. Leave it empty for default message.<br>', 'wf-shipping-fedex' ),
			'css'				=> 'width:900px',
			//'id'				=> WfTrackingUtil::TRACKING_SETTINGS_TAB_KEY.WfTrackingUtil::TRACKING_MESSAGE_KEY,
			'placeholder'		=> 'Your order was shipped on [DATE] via [SERVICE]. To track shipment, please follow the link of shipment ID(s) [ID]',
			'desc_tip'		   => true
		),
	
	'convert_currency' => array(
		'title'		   => __( 'Rates in Base Currency', 'wf-shipping-fedex' ),
		'label'		   => __( 'Convert FedEx returned rates to base currency.', 'wf-shipping-fedex' ),
		'type'			=> 'checkbox',
		'class'			=> 'fedex_rates_tab',
		'default'		 => 'no',
		'desc_tip'		  => true,
		'description'	 => 'Ex: FedEx returned rates in USD and would like to convert to the base currency EUR. Convertion happens only FedEx API provide the exchange rate.'
	),
	'cod_collection_type'   => array(
		'title'		   => __( 'COD Collection Type', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'desc_tip'	=> true,
		'description'	 => 'Identifies the type of funds FedEx should collect upon shipment delivery.',
		'default'		 => 'ANY',
		'class'		   => 'wc-enhanced-select fedex_label_tab',
		'options'		 => array(
			'ANY' 							  	=> __( 'ANY', 						'wf-shipping-fedex'),
			'CASH' 							  	=> __( 'CASH', 						'wf-shipping-fedex'),
			'GUARANTEED_FUNDS'   			  	=> __( 'GUARANTEED_FUNDS',			'wf-shipping-fedex')
			)				
	),


	'freight'		   => array(
		'title'		   => __( 'FedEx LTL Freight Settings', 'wf-shipping-fedex' ),
		'type'			=> 'title',
		'class'			=> 'fedex_freight_tab',
		'description'	 => __( 'If your account supports Freight, we need some additional details to get LTL rates. Note: These rates require the customers CITY so won\'t display until checkout.', 'wf-shipping-fedex' ),
	),
	'freight_enabled'	  => array(
		'title'		   => __( 'FedEx Freight', 'wf-shipping-fedex' ),
		'label'		   => __( 'Enable', 'wf-shipping-fedex' ),
		'type'			=> 'checkbox',
		'class'			=> 'fedex_freight_tab',
		'default'		 => 'no'
	),
	'freight_number' => array(
		'title'	   => __( 'Freight Account Number', 'wf-shipping-fedex' ),
		'type'		=> 'text',
		'class'			=> 'fedex_freight_tab freight_group ',
		'description' => '',
		'default'	 => '',
		'placeholder' => __( 'Defaults to your main account number', 'wf-shipping-fedex' )
	),
	'freight_bill_street'		   => array(
		'title'		   => __( 'Billing Street Address', 'wf-shipping-fedex' ),
		'class'			=> 'fedex_freight_tab freight_group',
		'type'			=> 'text',
		'default'		 => ''
	),
	'billing_street_2'		   => array(
		'title'		   => __( 'Billing Street Address 2', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'class'			=> 'fedex_freight_tab freight_group',
		'default'		 => ''
	),
	'freight_billing_city'		   => array(
		'title'		   => __( 'Billing City', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'class'			=> 'fedex_freight_tab freight_group',
		'default'		 => ''
	),
	'freight_billing_state'		   => array(
		'title'		   => __( 'Billing State Code', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'class'			=> 'fedex_freight_tab freight_group',
		'default'		 => '',
	),
	'billing_postcode'		   => array(
		'title'		   => __( 'Billing ZIP / Postcode', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'class'			=> 'fedex_freight_tab freight_group',
		'default'		 => '',
	),
	'billing_country'		   => array(
		'title'		   => __( 'Billing Country Code', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'class'			=> 'fedex_freight_tab freight_group',
		'default'		 => '',
	),
	
	'freight_class'		   => array(
		'title'		   => __( 'Default Freight Class', 'wf-shipping-fedex' ),
		'desc_tip'	=> true,
		'description'	 => sprintf( __( 'This is the default freight class for shipments. This can be overridden using <a href="%s">shipping classes</a>', 'wf-shipping-fedex' ), admin_url( 'edit-tags.php?taxonomy=product_shipping_class&post_type=product' ) ),
		'type'			=> 'select',
		'default'		 => '50',
		'class'		   => 'wc-enhanced-select fedex_freight_tab freight_group',
		'options'		 => $freight_classes
	),

	'commercial_invoice' => array(
		'title'			=> __( 'Commercial Invoice', 'wf-shipping-fedex' ),
		'label'			=> __( 'Enable', 'wf-shipping-fedex' ),
		'type'			=> 'checkbox',
		'class'			=> 'fedex_label_tab',
		'default'		=> 'no',
		'desc_tip'		=> true,
		'description'	=> 'On enabling this option (which means you have enabled electronic trade documents), the shipment details will be sent electronically and also a copy of this document as commercial invoice will be received as an additional label. Applicable for international shipping only.'
	),	
	'company_logo' => array(
		'title' 		=> __('Company Logo', 'wf-shipping-fedex'),
		'description' 	=> sprintf('<span class="button" id="company_logo_picker">Choose Image</span> <div id="company_logo_result"></div>'),
		'class'			=> 'commercialinvoice-image-uploader fedex_label_tab',
		'type' 			=> 'text',
		'placeholder' 	=> 'Upload an image to set Company Logo on Commercial Invoice'
	),
	'digital_signature' => array(
		'title' 		=> __('Digital Signature', 'wf-shipping-fedex'),
		'description' 	=> sprintf('<span class="button" id="digital_signature_picker">Choose Image</span> <div id="digital_signature_result"></div>'),
		'class'			=> 'commercialinvoice-image-uploader fedex_label_tab',
		'type' 			=> 'text',
		'placeholder' 	=> 'Upload an image to set Digital Signature on Commercial Invoice'
	),

	'default_dom_service' => array(
		'title'		   => __( 'Default service for domestic', 'wf-shipping-fedex' ),
		'description'	 => __( 'Default service for domestic label. This will consider if no FedEx services selected from frond end while placing the order', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'select',
		'default'		 => '',
		'class'		   => 'wc-enhanced-select fedex_label_tab',
		'options'		  => array_merge(array(''=>'Select once'), $dom_services)
	),
	'default_int_service'	=> array(
		'title'		   => __( 'Default service for International', 'wf-shipping-fedex' ),
		'description'	 => __( 'Default service for International label. This will consider if no FedEx services selected from frond end while placing the order', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'select',
		'class'		   => 'wc-enhanced-select fedex_label_tab',
		'default'		 => '',
		'options'		  => array_merge(array(''=>'Select once'), $int_services)
	),

	'charges_payment_type'   => array(
		'title'		   => __( 'Shipping Charges', 'wf-shipping-fedex' ),
		'type'			=> 'select',
		'desc_tip'	=> true,
		'description'	 => 'Choose who is going to pay shipping and customs charges. Please fill Third Party settings below if Third Party is choosen. It will override freight shipement also',
		'default'		 => 'SENDER',
		'class'		   => 'wc-enhanced-select fedex_general_tab',
		'options'		 => array(
			'SENDER' 							  	=> __( 'Sender', 						'wf-shipping-fedex'),
			//'RECIPIENT' 							  	=> __( 'Recipient', 						'wf-shipping-fedex'),
			'THIRD_PARTY' 							  	=> __( 'Third Party', 						'wf-shipping-fedex'),
		)				
	),
	'shipping_payor_acc_no'	=> array(
		'title'		   => __( 'Third party Account Number', 'wf-shipping-fedex' ),
		'class'			  => 'thirdparty_grp',
		'type'			=> 'text',
		'default'		 => '',
		'desc_tip'	=> true,
		'class'			  => 'thirdparty_grp fedex_general_tab',
		'description'	 => 'Third Party Account Number. Required if third party payment selected',
	),
	'shipping_payor_cname'	 => array(
		'title'		   => __( 'Contact Person', 'wf-shipping-fedex' ),
		'class'			  => 'thirdparty_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'description'	 => 'Third Party Payer Contact Person. Required if third party payment selected',
		'desc_tip'		  => true,
	),

	//shipping_payor_company
	'shipp_payor_company'   => array(
		'title'		   => __( 'Company', 'wf-shipping-fedex' ),
		'class'			  => 'thirdparty_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'description'	 => 'Third Party Payer Company. Required if third party payment selected',
		'desc_tip'		  => true,
	),
	'shipping_payor_phone'	 => array(
		'title'		   => __( 'Contact Number', 'wf-shipping-fedex' ),
		'class'			  => 'thirdparty_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'description'	 => 'Third Party Payer Contact Number. Required if third party payment selected',
		'desc_tip'		  => true,
	),
	'shipping_payor_email'	 => array(
		'title'		   => __( 'Contact Email', 'wf-shipping-fedex' ),
		'class'			  => 'thirdparty_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'description'	 => 'Third Party Payer Contact Email. Required if third party payment selected',
		'desc_tip'		  => true,
	),

	//shipping_payor_address1
	'shipp_payor_address1'   => array(
		'title'		   => __( 'Address Line 1', 'wf-shipping-fedex' ),
		'class'			  => 'thirdparty_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'description'	 => 'Third Party Payer Address Line 1. Required if third party payment selected',
		'desc_tip'		  => true,
	),

	//shipping_payor_address2
	'shipp_payor_address2'   => array(
		'title'		   => __( 'Address Line 2', 'wf-shipping-fedex' ),
		'class'			  => 'thirdparty_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'description'	 => 'Third Party Payer Address Line 2. Required if third party payment selected',
		'desc_tip'		  => true,
	),
	'shipping_payor_city'	   => array(
		'title'		   => __( 'City', 'wf-shipping-fedex' ),
		'class'			  => 'thirdparty_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'description'	 => 'Third Party Payer City. Required if third party payment selected',
		'desc_tip'		  => true,
	),
	'shipping_payor_state'	   => array(
		'title'		   => __( 'State Code', 'wf-shipping-fedex' ),
		'class'			  => 'thirdparty_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'description'	 => 'Third Party Payer State Code. Required if third party payment selected',
		'desc_tip'		  => true,
	),

	//shipping_payor_postal_code
	'shipping_payor_zip' => array(
		'title'		   => __( 'Postal Code', 'wf-shipping-fedex' ),
		'class'			  => 'thirdparty_grp fedex_general_tab',
		'type'			=> 'text',
		'default'		 => '',
		'description'	 => 'Third Party Payer Postal Code. Required if third party payment selected',
		'desc_tip'		  => true,
	),

	//shipping_payor_country
	'shipp_payor_country'	=> array(
		'title'		   => __( 'Country', 'wf-shipping-fedex' ),
		'class'			  => 'thirdparty_grp wc-enhanced-select fedex_general_tab',
		'type'			=> 'select',
		'default'		 => '',
		'options'		  => $country_list,
		'description'	 => 'Third Party Payer Country. Required if third party payment selected',
		'desc_tip'		  => true,
	),
	'dry_ice_enabled'	  => array(
		'title'		   => __( 'Ship dry ice', 'wf-shipping-fedex' ),
		'description'	 => __( 'Enable this to activate dry ice option to product level', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'checkbox',
		'class'	=>'fedex_general_tab',
		'default'		 => 'no'
	),


	'title_pickup'		   => array(
		'title'		   => __( 'Pickup Settings', 'wf-shipping-fedex' ),
		'type'			=> 'title',
		'class'			=> 'fedex_pickup_tab',
		'description'	 => __( 'Configure the pickup options here to avail FedEx pickup for your orders', 'wf-shipping-fedex' ),
	),
	'pickup_enabled'	  => array(
		'title'		   => __( 'Enable Pickup', 'wf-shipping-fedex' ),
		'description'	 => __( 'Enable this to setup pickup request', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'checkbox',
		'class'			=> 'fedex_pickup_tab',
		'default'		 => 'no'
	),
	'use_pickup_address'	  => array(
		'title'		   => __( 'Use Different Pickup Address', 'wf-shipping-fedex' ),
		'description'	 => __( 'Check this to set a defferent store address to pick up from', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'checkbox',
		'class'			  => 'wf_fedex_pickup_grp fedex_pickup_tab',
		'default'		 => 'no',
	),
	'pickup_contact_name'		   => array(
		'title'		   => __( 'Contact Person Name', 'wf-shipping-fedex' ),
		'description'	 => __( 'Contact person name', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'text',
		'class'			  => 'wf_fedex_pickup_grp wf_fedex_pickup_address_grp fedex_pickup_tab',
		'default'		 => '',
	),
	'pickup_company_name'		   => array(
		'title'		   => __( 'Pickup Company Name', 'wf-shipping-fedex' ),
		'description'	 => __( 'Name of the company', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'text',
		'class'			  => 'wf_fedex_pickup_grp wf_fedex_pickup_address_grp fedex_pickup_tab',
		'default'		 => '',
	),
	'pickup_phone_number'		   => array(
		'title'		   => __( 'Pickup Phone Number', 'wf-shipping-fedex' ),
		'description'	 => __( 'Contact number', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'text',
		'class'			  => 'wf_fedex_pickup_grp wf_fedex_pickup_address_grp fedex_pickup_tab',
		'default'		 => '',
	),
	'pickup_address_line'		   => array(
		'title'		   => __( 'Pickup Address', 'wf-shipping-fedex' ),
		'description'	 => __( 'Address line', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'text',
		'class'			  => 'wf_fedex_pickup_grp wf_fedex_pickup_address_grp fedex_pickup_tab',
		'default'		 => '',
	),
	'pickup_address_city'		   => array(
		'title'		   => __( 'Pickup City', 'wf-shipping-fedex' ),
		'description'	 => __( 'City', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'text',
		'class'			  => 'wf_fedex_pickup_grp wf_fedex_pickup_address_grp fedex_pickup_tab',
		'default'		 => '',
	),
	'pickup_address_state_code'		   => array(
		'title'		   => __( 'Pickup State Code', 'wf-shipping-fedex' ),
		'description'	 => __( 'State code. Eg: CA', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'text',
		'class'			  => 'wf_fedex_pickup_grp wf_fedex_pickup_address_grp fedex_pickup_tab',
		'default'		 => '',
	),
	'pickup_address_postal_code'		   => array(
		'title'		   => __( 'Pickup Zip Code', 'wf-shipping-fedex' ),
		'description'	 => __( 'Postal code', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'text',
		'class'			  => 'wf_fedex_pickup_grp wf_fedex_pickup_address_grp fedex_pickup_tab',
		'default'		 => '',
	),
	'pickup_address_country_code'		   => array(
		'title'		   => __( 'Pickup Country CPickup Company nameode', 'wf-shipping-fedex' ),
		'description'	 => __( 'Country code Eg: US', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'text',
		'class'			  => 'wf_fedex_pickup_grp wf_fedex_pickup_address_grp fedex_pickup_tab',
		'default'		 => '',
	),
	'pickup_start_time'		   => array(
		'title'		   => __( 'Pickup Start Time', 'wf-shipping-fedex' ),
		'description'	 => __( 'Items will be ready for pickup by this time from shop', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'select',
		'class'			  => 'wf_fedex_pickup_grp wc-enhanced-select fedex_pickup_tab',
		'default'		 => current($pickup_start_time_options),
		'options'		  => $pickup_start_time_options,
	),
	'pickup_close_time'		   => array(
		'title'		   => __( 'Company Close Time', 'wf-shipping-fedex' ),
		'description'	 => __( 'Your shop closing time. It must be greater than company open time', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'select',
		'class'			  => 'wf_fedex_pickup_grp wc-enhanced-select fedex_pickup_tab',
		'default'		 => '18',
		'options'		  => $pickup_close_time_options,
	),
	'pickup_service'		   => array(
		'title'		   => __( 'Pickup Service', 'wf-shipping-fedex' ),
		'description'	 => __( 'Service category for FedEx pickup', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'select',
		'class'			  => 'wf_fedex_pickup_grp wc-enhanced-select fedex_pickup_tab',
		'default'		 => 'FEDEX_NEXT_DAY_EARLY_MORNING',
		'options'		  => array(
			'SAME_DAY'						=>'SAME DAY',
			'SAME_DAY_CITY'					=>'SAME DAY CITY',
			'FEDEX_DISTANCE_DEFERRED'		=>'FEDEX DISTANCE DEFERRED',
			'FEDEX_NEXT_DAY_EARLY_MORNING'	=>'FEDEX NEXT DAY EARLY MORNING',
			'FEDEX_NEXT_DAY_MID_MORNING'	=>'FEDEX NEXT DAY MID MORNING',
			'FEDEX_NEXT_DAY_AFTERNOON'		=>'FEDEX NEXT DAY AFTERNOON',
			'FEDEX_NEXT_DAY_END_OF_DAY'		=>'FEDEX NEXT DAY END OF DAY',
			'FEDEX_NEXT_DAY_FREIGHT'		=>'FEDEX NEXT DAY FREIGHT',
		),
	),

	'exclude_tax'	  => array(
		'title'		   => __( 'Exclude Tax', 'wf-shipping-fedex' ),
		'description'	 => __( 'Taxes will be excluded from product prices while generating label', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'checkbox',
		'class'			=>'fedex_general_tab',
		'default'		 => 'no'
	),
	'min_amount'  => array(
		'title'		   => __( 'Minimum Order Amount', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'placeholder'	=> wc_format_localized_price( 0 ),
		'default'		 => '0',
		'class'			=>'fedex_rates_tab',
		'description'	 => __( 'Users will need to spend this amount to get this shipping available.', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
	),
	'tin_number'  => array(
		'title'		   => __( 'TIN number', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'placeholder'	  => __( 'TIN number', 'wf-shipping-fedex' ),
		'description'	 => __( 'TIN or VAT number .', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'class'			=> 'fedex_label_tab',
	),
	'tin_type'	=> array(
		'title'		   => __( 'TIN type', 'wf-shipping-fedex' ),
		'description'	 => __( 'The category of the taxpayer identification', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'select',
		'default'		 => 'BUSINESS_STATE',
		'class'		   => 'wc-enhanced-select fedex_label_tab',
		'options'		  => array(
			'BUSINESS_STATE'	=>'BUSINESS_STATE',
			'BUSINESS_NATIONAL'	=>'BUSINESS_NATIONAL',
			'BUSINESS_UNION'	=>'BUSINESS_UNION',
			'PERSONAL_NATIONAL'	=>'PERSONAL_NATIONAL',
			'PERSONAL_STATE'	=>'PERSONAL_STATE',
		)
	),
	'frontend_retun_label'	  => array(
		'title'		   => __( 'Enable return label in my account page', 'wf-shipping-fedex' ),
		'description'	 => __( 'By enabling this the customers can generate the return label themself from my account page', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'checkbox',
		'default'		 => 'no',
		'class'			=> 'fedex_label_tab',
	),
	'xa_show_all_shipping_methods' => array(
		'title'		   => __( 'Show All Services In Order Edit Page', 'wf-shipping-fedex' ),
		'label'		   => __( 'Enable', 'wf-shipping-fedex' ),
		'type'			=> 'checkbox',
		'default'		 => 'yes',
		'class'			=> 'fedex_label_tab',
		'description'	 => __( 'Check this option to show all services in create label drop down(FEDEX).', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
	),

	'automate_package_generation'	  => array(
		'title'		   => __( 'Generate Packages Automatically After Order Received', 'wf-shipping-fedex' ),
		'label'			  => __( 'Enable', 'wf-shipping-fedex' ),			
		'description'	 => __( 'This will generate packages automatically after order is received and payment is successful', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'checkbox',
		'default'		 => 'no',
		'class'			=> 'fedex_label_tab',
	),
	'automate_label_generation'	  => array(
		'title'		   => __( 'Generate Shipping Labels Automatically After Order Received', 'wf-shipping-fedex' ),
		'label'			  => __( 'Enable', 'wf-shipping-fedex' ),			
		'description'	 => __( 'This will generate shipping labels automatically after order is received and payment is successful', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'checkbox',
		'class'			=> 'fedex_label_tab',
		'default'		 => 'no'
	),
	'auto_email_label'	  => array(
		'title'		   => __( 'Send label in email to customer after label generation', 'wf-shipping-fedex' ),
		'label'			  => __( 'Enable', 'wf-shipping-fedex' ),			
		'description'	 => __( '', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'checkbox',
		'class'			=> 'fedex_label_tab',
		'default'		 => 'no'
	),
	'allow_label_btn_on_myaccount'	  => array(
		'title'		   => __( 'Allow customer to print label from his myaccount->order page', 'wf-shipping-fedex' ),
		'label'			  => __( 'Enable', 'wf-shipping-fedex' ),			
		'description'	 => __( 'A button will be available for downloading the label and printing', 'wf-shipping-fedex' ),
		'desc_tip'		   => true,
		'type'			=> 'checkbox',
		'class'			=> 'fedex_label_tab',
		'default'		 => 'no'
	),
	'email_content'  => array(
		'title'		   => __( 'Content of Email With Label', 'wf-shipping-fedex' ),
		'type'			=> 'text',
		'placeholder'	=> '',
		'class'			=> 'fedex_label_tab',
		'default'		 => '',
		'desc_tip'		   => true,
	),
	
);