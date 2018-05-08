<?php
class wf_fedex_woocommerce_shipping_admin{
	
	public function __construct(){
		add_action('init', array($this, 'wf_init'));
		
		if (is_admin()) {
			add_action('add_meta_boxes', array($this, 'wf_add_fedex_metabox'));
		}
		if ( isset( $_GET['wf_fedex_generate_packages'] ) ) {
			add_action('init', array($this, 'wf_fedex_generate_packages'));
		}

		if (isset($_GET['wf_fedex_createshipment'])) {
			add_action('init', array($this, 'wf_fedex_createshipment'));
		}
		
		if (isset($_GET['wf_fedex_additional_label'])) {
			add_action('init', array($this, 'wf_fedex_additional_label'));
		}
		
		if (isset($_GET['wf_fedex_viewlabel'])) {
			add_action('init', array($this, 'wf_fedex_viewlabel'));
		}

		if (isset($_GET['wf_fedex_void_shipment'])) {
			add_action('init', array($this, 'wf_fedex_void_shipment'));
		}
		
		if (isset($_GET['wf_clear_history'])) {
			add_action('init', array($this, 'wf_clear_history'));
		}

		if (isset($_GET['wf_create_return_label'])) {
			add_action('init', array($this, 'wf_create_return_label'));
		}
		
		if (isset($_GET['wf_fedex_viewReturnlabel'])) {
			add_action('init', array($this, 'wf_fedex_viewReturnlabel'));
		}

		add_action( 'wp_ajax_xa_fedex_validate_credential', array($this,'xa_fedex_validate_credentials'), 10, 1 );
		
		add_action('admin_notices',array(new wf_admin_notice, 'throw_notices'));
	}

	public function wf_init(){
		global $woocommerce;
		$this->rateservice_version			  = 22;
		$this->settings 			= get_option( 'woocommerce_'.WF_Fedex_ID.'_settings', null );
		
		$this->weight_dimensions_manual 	= isset($this->settings['manual_wgt_dimensions']) ? $this->settings['manual_wgt_dimensions'] : 'no';
		$this->custom_services 			= isset($this->settings['services']) ? $this->settings['services'] : '';
		$this->image_type 			= isset($this->settings['image_type']) ? $this->settings['image_type'] : '';
		$this->packing_method 			= isset($this->settings[ 'packing_method']) ? $this->settings[ 'packing_method'] : '';
		$this->debug 				= ( $bool = $this->settings[ 'debug' ] ) && $bool == 'yes' ? true : false;
		$this->xa_show_all_shipping_methods	= isset( $this->settings['xa_show_all_shipping_methods'] ) && $this->settings['xa_show_all_shipping_methods'] == 'yes' ? true : false;
		$this->set_origin_country_state();
	}

	private function set_origin_country_state(){
		$origin_country_state 		= isset( $this->settings['origin_country'] ) ? $this->settings['origin_country'] : '';
		if ( strstr( $origin_country_state, ':' ) ) :
			// WF: Following strict php standards.
			$origin_country_state_array 	= explode(':',$origin_country_state);
			$origin_country 		= current($origin_country_state_array);
			$origin_country_state_array 	= explode(':',$origin_country_state);
			$origin_state   		= end($origin_country_state_array);
		else :
			$origin_country = $origin_country_state;
			$origin_state   = '';
		endif;

		$this->origin_country  	= apply_filters( 'woocommerce_fedex_origin_country_code', $origin_country );
		$this->origin_state 	= !empty($origin_state) ? $origin_state : $this->settings[ 'freight_shipper_state' ];
	}


	public function xa_fedex_validate_credentials(){
		$production			= ( isset($_POST['production']) ) ? $_POST['production'] =='true' : false;
		$account_number		= ( isset($_POST['account_number']) ) ? $_POST['account_number'] : '';
		$meter_number		= ( isset($_POST['meter_number']) ) ? $_POST['meter_number'] : '';
		$api_key			= ( isset($_POST['api_key']) ) ? $_POST['api_key'] : '';
		$api_pass			= ( isset($_POST['api_pass']) ) ? $_POST['api_pass'] : '';
		
		$origin_country_state		= ( isset($_POST['origin_country']) ) ? $_POST['origin_country'] : '';
		$origin						= ( isset($_POST['origin']) ) ? $_POST['origin'] : '';

		$origin_country_state_array 	= explode(':',$origin_country_state);
		$origin_country 		= current($origin_country_state_array);

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
						'PostalCode' => $origin,
						'CountryCode' => $origin_country,
					),
				),
				'Recipient' => array(
					'Address' => array(
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

		

		$this->soap_method = $this->is_soap_available() ? 'soap' : 'nusoap';
		if( $this->soap_method == 'nusoap' && !class_exists('nusoap_client') ){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/nusoap/lib/nusoap.php';
		}
		$client = $this->wf_create_soap_client( plugin_dir_path( dirname( __FILE__ ) ) . 'fedex-wsdl/' . ( $production ? 'production' : 'test' ) . '/RateService_v' . $this->rateservice_version. '.wsdl' );

		if( $this->soap_method == 'nusoap' ){
			$response = $client->call( 'getRates', array( 'RateRequest' => $request ) );
			$response = json_decode( json_encode( $response ), false );
		}
		else{
			$response = $client->getRates( $request );
		}
		
		$result = array();
		if ( $response  ) {
			if( isset($response->HighestSeverity) && $response->HighestSeverity === 'ERROR' ){
				$error_message = '';
				if( isset($response->Notifications->Message) ) {
					$result = array(
						'message' 	=> $response->Notifications->Message,
						'success'	=> 'no',
					);
				}elseif( isset($response->Notifications[0]->Message) ) {
					$result = array(
						'message' 	=> $response->Notifications[0]->Message,
						'success'	=> 'no',
					);
				}
			}else{
				$result = array(
					'message' 	=> 'Successfully authenticated, The credentials are valid',
					'success'	=> 'yes',
				);
			}
		}else{
			$result = array(
				'message' 	=> 'An unexpected error occurred. Unable to authenticate',
				'success'	=> 'no',
			);
		}
		wp_die( json_encode($result) );
	}


	public function wf_fedex_viewReturnlabel(){
		$shipmentDetails = explode('|', base64_decode($_GET['wf_fedex_viewReturnlabel']));

		if (count($shipmentDetails) != 2) {
			exit;
		}
		
		$shipmentId			= $shipmentDetails[0]; 
		$post_id			= $shipmentDetails[1]; 
		$shipping_label			= get_post_meta($post_id, 'wf_woo_fedex_returnLabel_'.$shipmentId, true);
		$shipping_label_image_type	= get_post_meta($post_id, 'wf_woo_fedex_returnLabel_image_type_'.$shipmentId, true);
		
		
		if( empty($shipping_label_image_type) ){
			$shipping_label_image_type = $this->image_type;
		}
		header('Content-Type: application/'.$shipping_label_image_type);
		header('Content-disposition: attachment; filename="ShipmentArtifact-' . $shipmentId . '.'.$shipping_label_image_type.'"');
		print(base64_decode($shipping_label)); 
		exit;
	}

	private function is_soap_available(){
		if( extension_loaded( 'soap' ) ){
			return true;
		}
		return false;
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

	public function wf_create_return_label(){

		$user_ok = $this->wf_user_permission();
		if (!$user_ok) 			
			return;

		$return_params = explode('|', base64_decode($_GET['wf_create_return_label']));
		
		if(empty($return_params) || !is_array($return_params) || count($return_params) != 2)
			return;
		
		$shipment_id = $return_params[0]; 
		$order_id =  $return_params[1];


		$this->wf_create_return_shipment( $shipment_id, $order_id );

		if ( $this->debug ) {
		    //dont redirect when debug is printed
		    die();
		}
		else{
		  wp_redirect(admin_url('/post.php?post='.$order_id.'&action=edit'));
		  exit;
		}

	}
	
	public function wf_clear_history(){
		$user_ok = $this->wf_user_permission();
		if (!$user_ok) 			
			return;
			
		$order_id = base64_decode($_GET['wf_clear_history']);
		
		if(empty($order_id))
			return;
		
		$void_shipments = get_post_meta($order_id, 'wf_woo_fedex_shipment_void',false);
		if(empty($void_shipments))
			return;
		
		foreach($void_shipments as $void_shipment_id){
			delete_post_meta($order_id, 'wf_woo_fedex_packageDetails_'.$void_shipment_id);
			delete_post_meta($order_id, 'wf_woo_fedex_shippingLabel_'.$void_shipment_id);
			delete_post_meta($order_id, 'wf_woo_fedex_shipmentId',$void_shipment_id);		
			delete_post_meta($order_id, 'wf_woo_fedex_shipment_void',$void_shipment_id);	
			delete_post_meta($order_id, 'wf_fedex_additional_label_',$void_shipment_id);			
		}
		
		delete_post_meta($order_id, 'wf_woo_fedex_shipment_void_errormessage');		
		delete_post_meta($order_id, 'wf_woo_fedex_service_code');
		delete_post_meta($order_id, 'wf_woo_fedex_shipmentErrorMessage');		
					
        wp_redirect(admin_url('/post.php?post='.$order_id.'&action=edit'));
	    exit;    
	}	
	
	public function wf_fedex_void_shipment(){
		$user_ok = $this->wf_user_permission();
		if (!$user_ok) 			
			return;
			
		$void_params = explode('||', base64_decode($_GET['wf_fedex_void_shipment']));
		
		if(empty($void_params) || !is_array($void_params) || count($void_params) != 2)
			return;
		
		$shipment_id = $void_params[0]; 
		$order_id =  $void_params[1];			
			
			
		if ( ! class_exists( 'wf_fedex_woocommerce_shipping_admin_helper' ) )
			include_once 'class-wf-fedex-woocommerce-shipping-admin-helper.php';
		
		$woofedexwrapper = new wf_fedex_woocommerce_shipping_admin_helper();
		$tracking_completedata = get_post_meta($order_id, 'wf_woo_fedex_tracking_full_details_'.$shipment_id, true);
		if(!empty($tracking_completedata)){
			$woofedexwrapper->void_shipment($order_id,$shipment_id,$tracking_completedata);
		}
		
        if ( $this->debug ) {
            //dont redirect when debug is printed
            die();
		}
        else{
		  wp_redirect(admin_url('/post.php?post='.$order_id.'&action=edit'));
		  exit;
        }
	}
	
	function wf_load_order( $orderId ){
		if( !$orderId ){
			return false;
		}
		if(!class_exists('wf_order')){
			include_once('class-wf-legacy.php');
		}
		return ( WC()->version < '2.7.0' ) ? new WC_Order( $orderId ) : new wf_order( $orderId );    
	}
	
	private function wf_user_permission($auto_generate=null){
		// Check if user has rights to generate invoices
		$current_minute=(integer)date('i');
		if(!empty($auto_generate) && ($auto_generate==md5($current_minute) || $auto_generate==md5($current_minute+1) ))
		{
			return true;
		}
		$current_user = wp_get_current_user();
		$user_ok = false;
		$wf_roles = apply_filters( 'wf_user_permission_roles', array('administrator', 'shop_manager') );

		if ($current_user instanceof WP_User) {
			$role_ok = array_intersect($wf_roles, $current_user->roles);
			if( !empty( $role_ok ) ){
				$user_ok = true;
			}
		}
		return $user_ok;
	}
	
	public function wf_fedex_createshipment(){
		$user_ok = $this->wf_user_permission(isset($_GET['auto_generate'])?$_GET['auto_generate']:null);
		if (!$user_ok) 			
			return;
		
		$order = $this->wf_load_order($_GET['wf_fedex_createshipment']);
		if (!$order) 
			return;
		
		$this->wf_create_shipment($order);

        if ( $this->debug ) {
            //dont redirect when debug is printed
            die();
		}
        else{
		  wp_redirect(admin_url('/post.php?post='.$_GET['wf_fedex_createshipment'].'&action=edit'));
		  exit;
        }
	}
	
	public function wf_fedex_viewlabel(){
		$shipmentDetails = explode('|', base64_decode($_GET['wf_fedex_viewlabel']));

		if (count($shipmentDetails) != 2) {
			exit;
		}
		
		$shipmentId = $shipmentDetails[0]; 
		$post_id = $shipmentDetails[1]; 
		$shipping_label = get_post_meta($post_id, 'wf_woo_fedex_shippingLabel_'.$shipmentId, true);
		$shipping_label_image_type = get_post_meta($post_id, 'wf_woo_fedex_shippingLabel_image_type_'.$shipmentId, true);
		
		
		if( empty($shipping_label_image_type) ){
			$shipping_label_image_type = $this->image_type;
		}
		header('Content-Type: application/'.$shipping_label_image_type);
		header('Content-disposition: attachment; filename="ShipmentArtifact-' . $shipmentId . '.'.$shipping_label_image_type.'"');
		print(base64_decode($shipping_label)); 
		exit;
	}
	
	public function wf_fedex_additional_label(){
		$shipmentDetails = explode('|', base64_decode($_GET['wf_fedex_additional_label']));

		if (count($shipmentDetails) != 3) {
			exit;
		}
		
		$shipmentId = $shipmentDetails[0]; 
		$post_id = $shipmentDetails[1];
		$add_key = $shipmentDetails[2];		
		$additional_labels = get_post_meta($post_id, 'wf_fedex_additional_label_'.$shipmentId, true);
		$additional_label_image_type = get_post_meta($post_id, 'wf_fedex_additional_label_image_type_'.$shipmentId, true);
		
		if( !empty($additional_label_image_type[$add_key])){
			$image_type = $additional_label_image_type[$add_key];
		}else{
			$image_type = $this->image_type;
		}
		if( !empty($additional_labels) && isset($additional_labels[$add_key]) ){
			header('Content-Type: application/'.$image_type);
			header('Content-disposition: attachment; filename="Addition-doc-'. $add_key . '-' . $shipmentId . '.'.$image_type.'"');
			print(base64_decode($additional_labels[$add_key])); 
		}
		exit;		
	}
	
	private function wf_is_service_valid_for_country($order, $service_code, $dest_country=''){
		$uk_domestic_services = array('FEDEX_DISTANCE_DEFERRED', 'FEDEX_NEXT_DAY_EARLY_MORNING', 'FEDEX_NEXT_DAY_MID_MORNING', 'FEDEX_NEXT_DAY_AFTERNOON', 'FEDEX_NEXT_DAY_END_OF_DAY', 'FEDEX_NEXT_DAY_FREIGHT' );
		
		$shipper_country = $this->origin_country;
		$shipping_country = !empty($dest_country) ? $dest_country : $order->shipping_country;
		
		if( 'GB'==$shipper_country && 'GB'==$shipping_country && in_array($service_code,$uk_domestic_services) ){
			return true;
		}
		$exception_list = array('FEDEX_GROUND','FEDEX_FREIGHT_ECONOMY','FEDEX_FREIGHT_PRIORITY');
		$exception_country = array('US','CA');
		if(in_array($shipping_country,$exception_country) && in_array($service_code,$exception_list)){
			return true;
		}
		
		if( $shipping_country == $this->origin_country ){
			return strpos($service_code, 'INTERNATIONAL_') === false;
		}
		else{
			return  strpos($service_code, 'INTERNATIONAL_') !== false;
		}
		return false; 
	}

	private function is_domestic($order){
		return $this->origin_country == $order->shipping_country;
	}

	private function wf_get_shipping_service($order,$retrive_from_order = false, $shipment_id=false){
		
		if($retrive_from_order == true){
			$service_code = get_post_meta($order->id, 'wf_woo_fedex_service_code'.$shipment_id, true);
			if(!empty($service_code)) return $service_code;
		}
		
		if(!empty($_GET['service'])){			
		    $service_arr    =   json_decode(stripslashes(html_entity_decode($_GET["service"])));  
			return $service_arr[0];
		}

		if( $this->is_domestic($order) ){
			if( !empty($this->settings['default_dom_service']) ){
				return $this->settings['default_dom_service'];
			}
		}else{
			if( !empty($this->settings['default_int_service']) ){
				return $this->settings['default_int_service'];
			}
		}

		//TODO: Take the first shipping method. It doesnt work if you have item wise shipping method
		$shipping_methods = $order->get_shipping_methods();
		
		if ( ! $shipping_methods ) {
			return '';
		}
	
		$shipping_method = array_shift($shipping_methods);

		return str_replace(WF_Fedex_ID.':', '', $shipping_method['method_id']);
	}
	
	public function wf_create_shipment($order){		
		if ( ! class_exists( 'wf_fedex_woocommerce_shipping_admin_helper' ) )
			include_once 'class-wf-fedex-woocommerce-shipping-admin-helper.php';
		
		$woofedexwrapper = new wf_fedex_woocommerce_shipping_admin_helper();
		$serviceCode = $this->wf_get_shipping_service($order,false);
		$woofedexwrapper->print_label($order,$serviceCode,$order->id);		
	}
	
	public function wf_create_return_shipment( $shipment_id, $order_id ){		
		if ( ! class_exists( 'wf_fedex_woocommerce_shipping_admin_helper' ) )
			include_once 'class-wf-fedex-woocommerce-shipping-admin-helper.php';
		
		$woofedexwrapper = new wf_fedex_woocommerce_shipping_admin_helper();
		$serviceCode = $this->wf_get_shipping_service( $this->wf_load_order($order_id),false);
		$woofedexwrapper->print_return_label( $shipment_id, $order_id, $serviceCode  );		
	}

	public function wf_add_fedex_metabox(){
		global $post;
		if (!$post) {
			return;
		}
		if ( in_array( $post->post_type, array('shop_order') )) {
			$order = $this->wf_load_order($post->ID);
			if (!$order) 
				return;
			
			add_meta_box('wf_fedex_metabox', __('Fedex', 'wf-shipping-fedex'), array($this, 'wf_fedex_metabox_content'), 'shop_order', 'advanced', 'default');
		}
	}

	public function wf_fedex_generate_packages(){
		if( !$this->wf_user_permission(isset($_GET['auto_generate'])?$_GET['auto_generate']:null)) {
			echo "You don't have admin privileges to view this page.";
			exit;
		}
		
		$post_id	=	base64_decode($_GET['wf_fedex_generate_packages']);
		$order = $this->wf_load_order( $post_id );
		if ( !$order ) return;
		
		if ( ! class_exists( 'wf_fedex_woocommerce_shipping_admin_helper' ) )
			include_once 'class-wf-fedex-woocommerce-shipping-admin-helper.php';
		
		$woofedexwrapper = new wf_fedex_woocommerce_shipping_admin_helper();
		$packages	=	$woofedexwrapper->wf_get_package_from_order($order);
		foreach($packages as $package){
			$package_data[] = $woofedexwrapper->get_fedex_packages($package);
		}
		update_post_meta( $post_id, '_wf_fedex_stored_packages', $package_data );
		do_action( 'wf_after_package_generation', $post_id,$package_data);
		wp_redirect( admin_url( '/post.php?post='.$post_id.'&action=edit') );
		exit;
	}

	public function wf_fedex_metabox_content(){
		global $post;
		
		if (!$post) {
			return;
		}

		$order = $this->wf_load_order($post->ID);
		if (!$order) 
			return;			

		$shipmentIds = get_post_meta($order->id, 'wf_woo_fedex_shipmentId', false);
		$shipment_void_ids = get_post_meta($order->id, 'wf_woo_fedex_shipment_void', false);
		
		$shipmentErrorMessage = get_post_meta($order->id, 'wf_woo_fedex_shipmentErrorMessage',true);
		$shipment_void_error_message = get_post_meta($order->id, 'wf_woo_fedex_shipment_void_errormessage',true);
		
		//Only Display error message if the process is not complete. If the Invoice link available then Error Message is unnecessary
		if(!empty($shipmentErrorMessage))
		{
			echo '<div class="error"><p>' . sprintf( __( 'Fedex Create Shipment Error:%s', 'wf-shipping-fedex' ), $shipmentErrorMessage) . '</p></div>';
		}

		if(!empty($shipment_void_error_message)){
			echo '<div class="error"><p>' . sprintf( __( 'Void Shipment Error:%s', 'wf-shipping-fedex' ), $shipment_void_error_message) . '</p></div>';
		}			
		echo '<ul>';
		if (!empty($shipmentIds)) {
			foreach($shipmentIds as $shipmentId) {
				$selected_sevice = $this->wf_get_shipping_service($order,true,$shipmentId);	
				if(!empty($selected_sevice))
					echo "<li>Shipping Service: <strong>$selected_sevice</strong></li>";		
				
				echo '<li><strong>Shipment #:</strong> '.$shipmentId;
				$usps_trackingid = get_post_meta($order->id, 'wf_woo_fedex_usps_trackingid_'.$shipmentId, true);
				if(!empty($usps_trackingid)){
					echo "<br><strong>USPS Tracking #:</strong> ".$usps_trackingid;
				}
				if((is_array($shipment_void_ids) && in_array($shipmentId,$shipment_void_ids))){
					echo "<br> This shipment $shipmentId is terminated.";
				}
				echo '<hr>';
				$packageDetailForTheshipment = get_post_meta($order->id, 'wf_woo_fedex_packageDetails_'.$shipmentId, true);
				if(!empty($packageDetailForTheshipment)){
					foreach($packageDetailForTheshipment as $dimentionKey => $dimentionValue){
						if($dimentionValue){
							echo '<strong>' . $dimentionKey . ': ' . '</strong>' . $dimentionValue ;
							echo '<br />';
						}						
					}
					echo '<hr>';
				}
				$shipping_label = get_post_meta($post->ID, 'wf_woo_fedex_shippingLabel_'.$shipmentId, true);
				if(!empty($shipping_label)){
					$download_url = admin_url('/post.php?wf_fedex_viewlabel='.base64_encode($shipmentId.'|'.$post->ID));?>
					<a class="button tips" href="<?php echo $download_url; ?>" data-tip="<?php _e('Print Label', 'wf-shipping-fedex'); ?>"><?php _e('Print Label', 'wf-shipping-fedex'); ?></a>
					<?php 
				}				
				$additional_labels = get_post_meta($post->ID, 'wf_fedex_additional_label_'.$shipmentId, true);
				if(!empty($additional_labels) && is_array($additional_labels)){
					foreach($additional_labels as $additional_key => $additional_label){
						$download_add_label_url = admin_url('/post.php?wf_fedex_additional_label='.base64_encode($shipmentId.'|'.$post->ID.'|'.$additional_key));?>
						<a class="button tips" href="<?php echo $download_add_label_url; ?>" data-tip="<?php _e('Additional Label', 'wf-shipping-fedex'); ?>"><?php _e('Additional Label', 'wf-shipping-fedex'); ?></a>
						<?php
					}		
				}
				if((!is_array($shipment_void_ids) || !in_array($shipmentId,$shipment_void_ids))){
					$void_shipment_link = admin_url('/post.php?wf_fedex_void_shipment=' . base64_encode($shipmentId.'||'.$post->ID));?>				
					<a class="button tips" href="<?php echo $void_shipment_link; ?>" data-tip="<?php _e('Void Shipment', 'wf-shipping-fedex'); ?>"><?php _e('Void Shipment', 'wf-shipping-fedex'); ?></a>
					<?php 
				}
				$shipping_return_label = get_post_meta($post->ID, 'wf_woo_fedex_returnLabel_'.$shipmentId, true);
				$return_shipment_id = get_post_meta($post->ID, 'wf_woo_fedex_returnShipmetId', true);
				echo '<hr>';
				if(!empty($shipping_return_label)){
					$download_url = admin_url('/post.php?wf_fedex_viewReturnlabel='.base64_encode($shipmentId.'|'.$post->ID) );
					echo '<li><strong>Return Shipment #:</strong> '.$return_shipment_id.'</li>';?>
					<a class="button tips" href="<?php echo $download_url; ?>" data-tip="<?php _e('Print Return Label', 'wf-shipping-fedex'); ?>"><?php _e('Print Return Label', 'wf-shipping-fedex'); ?></a>
					<?php 
				}else{
					$selected_sevice = $this->wf_get_shipping_service($order);	
					echo '<select class="fedex_return_service select">';
					foreach($this->custom_services as $service_code => $service){
						if($service['enabled'] == true ){
							echo '<option value="'.$service_code.'" ' . selected($selected_sevice,$service_code) . ' >'.$service_code.'</option>';
						}	
					}
					echo'</select>'?>
					<a class="button button-primary fedex_create_return_shipment tips" href="<?php echo admin_url( '/post.php?wf_create_return_label='.base64_encode($shipmentId.'|'.$post->ID) ); ?>" data-tip="<?php _e( 'Generate return label', 'wf-shipping-fedex' ); ?>"><?php _e( 'Generate return label', 'wf-shipping-fedex' ); ?></a><?php
				}
				echo '<hr style="border-color:#0074a2"></li>';
			} ?>		
			<?php 
			if(count($shipmentIds) == count($shipment_void_ids)){
				$clear_history_link = admin_url('/post.php?wf_clear_history=' . base64_encode($post->ID));?>				
					<a class="button button-primary tips" href="<?php echo $clear_history_link; ?>" data-tip="<?php _e('Clear History', 'wf-shipping-fedex'); ?>"><?php _e('Clear History', 'wf-shipping-fedex'); ?></a>
					<?php 
			}					
		}
		else {
			$stored_packages	=	get_post_meta( $post->ID, '_wf_fedex_stored_packages', true );
			if(empty($stored_packages)	&&	!is_array($stored_packages)){
				echo '<strong>'.__( 'Auto generate packages.', 'wf-shipping-fedex' ).'</strong></br>';
			}else{
				$generate_url = admin_url('/post.php?wf_fedex_createshipment='.$post->ID);

				$dimension_unit = strtolower( get_option( 'woocommerce_dimension_unit' ));
				$weight_unit = strtolower(strtolower( get_option('woocommerce_weight_unit') ));

				$dimension_unit = ($dimension_unit=='mm') ? 'cm' : (($dimension_unit=='m') ? 'cm' : $dimension_unit);
				$weight_unit = ($weight_unit=='g') ? 'kg' : (($weight_unit=='oz') ? 'lb' : $weight_unit);
 
				echo '<li>';
					echo '<h4>'.__( 'Package(s)' , 'wf-shipping-fedex').': </h4>';
					echo '<table id="wf_fedex_package_list" class="wf-shipment-package-table">';					
						echo '<tr>';
							echo '<th>'.__('Wt.', 'wf-shipping-fedex').'</br>('.$weight_unit.')</th>';
							echo '<th>'.__('L', 'wf-shipping-fedex').'</br>('.$dimension_unit.')</th>';
							echo '<th>'.__('W', 'wf-shipping-fedex').'</br>('.$dimension_unit.')</th>';
							echo '<th>'.__('H', 'wf-shipping-fedex').'</br>('.$dimension_unit.')</th>';
							// echo '<th>'.__('Insur.', 'wf-shipping-fedex').'</th>';
							echo '<th>';
								echo __('Service', 'wf-shipping-fedex');
								echo '<img class="help_tip" style="float:none;" data-tip="'.__( 'Choose the FedEx service', 'wf-shipping-fedex' ).'" src="'.WC()->plugin_url().'/assets/images/help.png" height="16" width="16" />';
							echo '</th>';
							echo '<th>&nbsp;</th>';
						echo '</tr>';
        				
        				//case of multiple shipping address
        				$multiship = get_post_meta( $order->id, '_multiple_shipping', true);
        				if( $multiship ){
        					$multi_ship_packages  = get_post_meta($post->ID, '_wcms_packages', true);
        				}
						
						foreach($stored_packages as $package_group_key	=>	$package_group){
							if( !is_array($package_group) ){
								$package_group = array();
							}
							foreach($package_group as $stored_package_key	=>	$stored_package){
								$dimensions	=	$this->get_dimension_from_package($stored_package);
								if(is_array($dimensions)){
									?>
									<tr>
										<td><input type="text" id="fedex_manual_weight" name="fedex_manual_weight[]" size="2" value="<?php echo $dimensions['Weight'];?>" /></td>     
										<td><input type="text" id="fedex_manual_length" name="fedex_manual_length[]" size="2" value="<?php echo $dimensions['Length'];?>" /></td>
										<td><input type="text" id="fedex_manual_width" name="fedex_manual_width[]" size="2" value="<?php echo $dimensions['Width'];?>" /></td>
										<td><input type="text" id="fedex_manual_height" name="fedex_manual_height[]" size="2" value="<?php echo $dimensions['Height'];?>" /></td>
										<td><?php
											$package_dest_country = ( isset( $multi_ship_packages[$package_group_key]['destination']['country'] ) ) ? $multi_ship_packages[$package_group_key]['destination']['country'] : false;
											$selected_sevice = $this->wf_get_shipping_service($order);	
											echo 'Choose service:<select class="fedex_manual_service select">';
											if($this->xa_show_all_shipping_methods==true)
											{
											    $services = include('data-wf-service-codes.php');
											    foreach($services as $service_code => $service)
											    {
												    echo '<option value="'.$service_code.'" ' . selected($selected_sevice,$service_code) . ' >'.$service_code.'</option>';
												
											    }
											}
											else
											{   
											    foreach($this->custom_services as $service_code => $service)
											    {
												if($service['enabled'] == true && $this->wf_is_service_valid_for_country($order,$service_code, $package_dest_country) == true)
												{
												    echo '<option value="'.$service_code.'" ' . selected($selected_sevice,$service_code) . ' >'.$service_code.'</option>';
												}
											    }
											}?>
										</td>
										<td>&nbsp;</td>
									</tr>
									<?php
								}
							}
						}
					echo '</table>';
					echo '<a class="wf-action-button wf-add-button" style="font-size: 12px;" id="wf_fedex_add_package">Add Package</a>';
				
				echo '</li>';
				?>
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery('#wf_fedex_add_package').on("click", function(){
							var new_row = '<tr>';
								new_row 	+= '<td><input type="text" id="fedex_manual_weight" name="fedex_manual_weight[]" size="2" value="0"></td>';
								new_row 	+= '<td><input type="text" id="fedex_manual_length" name="fedex_manual_length[]" size="2" value="0"></td>';								
								new_row 	+= '<td><input type="text" id="fedex_manual_width" name="fedex_manual_width[]" size="2" value="0"></td>';
								new_row 	+= '<td><input type="text" id="fedex_manual_height" name="fedex_manual_height[]" size="2" value="0"></td>';
								// new_row 	+= '<td><input type="text" id="fedex_manual_insurance" name="fedex_manual_insurance[]" size="2" value="0"></td>';
								new_row		+= '<td>';
								new_row		+= '	choose service:<select class="fedex_manual_service select">';
								<?php
								if($this->xa_show_all_shipping_methods==true)
											{
											    $services = include('data-wf-service-codes.php');
											    foreach($services as $service_code => $service)
											    {?>
												new_row	+=  '<option value="<?php echo $service_code ?>"><?php echo $service_code ?></option>';
												<?php
											    }
											}
											else
											{   
											   foreach($this->custom_services as $service_code => $service)
											       {
												    if($service['enabled'] == true && $this->wf_is_service_valid_for_country($order,$service_code, $package_dest_country) == true)
												    {
												?>
												    new_row		+= '<option value="<?php echo $service_code?>"><?php echo $service_code ?></option>';
												<?php
												    }
												}
											} ?>
								new_row		+= '</td>';
								new_row 	+= '<td><a class="wf_fedex_package_line_remove">&#x26D4;</a></td>';
							new_row 	+= '</tr>';
							
							jQuery('#wf_fedex_package_list tr:last').after(new_row);
						});
						
						jQuery(document).on('click', '.wf_fedex_package_line_remove', function(){
							jQuery(this).closest('tr').remove();
						});
					});
				</script><?php
				echo '<li><label for="wf_fedex_cod"><input type="checkbox" style="" id="wf_fedex_cod" name="wf_fedex_cod" class="">' . __('Cash On Delivery', 'wf-shipping-fedex') . '</label></li>';
				echo '<li><label for="wf_fedex_sat_delivery"><input type="checkbox" style="" id="wf_fedex_sat_delivery" name="wf_fedex_sat_delivery" class="">' . __('Saturday Delivery', 'wf-shipping-fedex') . '</label></li>';
				?>
				<li>
					<a class="button tips onclickdisable fedex_create_shipment" href="<?php echo $generate_url; ?>" data-tip="<?php _e('Create Shipment', 'wf-shipping-fedex'); ?>"><?php _e('Create Shipment', 'wf-shipping-fedex'); ?></a>
				</li><?php
			} ?>
			<a class="button button-primary tips fedex_generate_packages" href="<?php echo admin_url( '/post.php?wf_fedex_generate_packages='.base64_encode($post->ID) ); ?>" data-tip="<?php _e( 'Generate Packages', 'wf-shipping-fedex' ); ?>"><?php _e( 'Generate Packages', 'wf-shipping-fedex' ); ?></a><hr style="border-color:#0074a2">
			<script type="text/javascript">
				jQuery("a.fedex_generate_packages").on("click", function() {
					location.href = this.href;
				});
			</script>
			<?php
		}
		echo '</ul>';?>
		<script>
		jQuery("a.fedex_create_return_shipment").one("click", function(e) {
			e.preventDefault();
			service = jQuery(this).prev("select").val();
			var manual_service 		=	'[' + JSON.stringify( service ) + ']';
			location.href = this.href + '&service=' +  manual_service;
		});

		jQuery("a.fedex_create_shipment").one("click", function() {
			
			jQuery(this).click(function () { return false; });
				var manual_weight_arr 	= 	jQuery("input[id='fedex_manual_weight']").map(function(){return jQuery(this).val();}).get();
				var manual_weight 		=	JSON.stringify(manual_weight_arr);
				
				var manual_height_arr 	= 	jQuery("input[id='fedex_manual_height']").map(function(){return jQuery(this).val();}).get();
				var manual_height 		=	JSON.stringify(manual_height_arr);
				
				var manual_width_arr 	= 	jQuery("input[id='fedex_manual_width']").map(function(){return jQuery(this).val();}).get();
				var manual_width 		=	JSON.stringify(manual_width_arr);
				
				var manual_length_arr 	= 	jQuery("input[id='fedex_manual_length']").map(function(){return jQuery(this).val();}).get();
				var manual_length 		=	JSON.stringify(manual_length_arr);
				
				// var manual_insurance_arr 	= 	jQuery("input[id='fedex_manual_insurance']").map(function(){return jQuery(this).val();}).get();
				// var manual_insurance 		=	JSON.stringify(manual_insurance_arr);

				var manual_service_arr	=	[];
				jQuery('.fedex_manual_service').each(function(){
					manual_service_arr.push( jQuery(this).val() );
				});
				var manual_service 		=	JSON.stringify(manual_service_arr);
				
			   location.href = this.href + '&weight=' + manual_weight +
				'&length=' + manual_length
				+ '&width=' + manual_width
				+ '&height=' + manual_height
				+ '&cod=' + jQuery('#wf_fedex_cod').is(':checked')
				+ '&sat_delivery=' + jQuery('#wf_fedex_sat_delivery').is(':checked')
				// + '&insurance=' + manual_insurance
				+ '&service=' + manual_service;
			return false;			
		});
		</script>
		<?php
	}	
	public function get_dimension_from_package($package){
		$dimensions	=	array(
			'Length'	=>	'',
			'Width'		=>	'',
			'Height'	=>	'',
			'Weight'	=>	'',
		);
		
		if(!is_array($package)){ // Package is not valid
			return $dimensions;
		}
		if(isset($package['Dimensions'])){
			$dimensions['Length']	=	$package['Dimensions']['Length'];
			$dimensions['Width']	=	$package['Dimensions']['Width'];
			$dimensions['Height']	=	$package['Dimensions']['Height'];
			$dimensions['dim_unit']	=	$package['Dimensions']['Units'];
		}
		
		$dimensions['Weight']	=	$package['Weight']['Value'];
		$dimensions['weight_unit']	=	$package['Weight']['Units'];
		return $dimensions;
	}	
}
new wf_fedex_woocommerce_shipping_admin();
?>
